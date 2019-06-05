<?php
/**
 * Tag Meta Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package TagMeta
 * @copyright Copyright 2009 - 2017
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link http://www.selfget.com
 * @version 1.9.0
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class TagMetaModelSynonyms extends JModelList
{
  public function __construct($config = array())
  {
    if (empty($config['filter_fields'])) {
      $config['filter_fields'] = array(
        'id', 's.id',
        'keywords', 's.keywords',
        'synonyms', 's.synonyms',
        'weight', 's.weight',
        'comment', 's.comment',
        'hits', 's.hits',
        'last_visit', 's.last_visit',
        'ordering', 's.ordering',
        'published', 's.published',
        'checked_out', 's.checked_out',
        'checked_out', 's.checked_out_time'
      );
    }

    parent::__construct($config);
  }

  /**
   * Method to auto-populate the model state
   *
   * Note. Calling getState in this method will result in recursion
   */
  protected function populateState($ordering = null, $direction = null)
  {
    $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
    // Convert search to lower case
    $search = JString::strtolower($search);
    $this->setState('filter.search', $search);

    $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '');
    $this->setState('filter.state', $state);

    // Load the parameters.
    $params = JComponentHelper::getParams('com_tagmeta');
    $this->setState('params', $params);

    // List state information.
    parent::populateState('s.ordering', 'asc');
  }

  /**
   * Method to build an SQL query to load the list data
   *
   * @return string An SQL query
   */
  protected function getListQuery()
  {
    // Create a new query object
    $db = $this->getDbo();
    $query = $db->getQuery(true);
    // Select required fields
    $query->select(
      $this->getState(
        'list.select',
        's.id, s.keywords, s.synonyms, s.weight, s.comment, s.hits, s.last_visit, s.ordering, s.published, s.checked_out, s.checked_out_time'
      )
    );

    // From the table
    $query->from('#__tagmeta_synonyms AS s');

    // Join over the users for the checked out user
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id = s.checked_out');

    // Filter by state
    $state = $this->getState('filter.state');
    if (is_numeric($state)) {
      $query->where('(s.published = '.(int) $state.')');
    } else if ($state === '') {
      $query->where('(s.published IN (0, 1))'); // By default only published and unpublished
    }

    // Filter by search
    $search = $this->getState('filter.search');
    if (!empty($search)) {
      $query->where('(LOWER(s.keywords) LIKE '.$db->Quote('%'.$db->escape($search, true).'%').'OR LOWER(a.synonyms) LIKE '.$db->Quote('%'.$db->escape($search, true).'%').')'); // Search in keywords and synonyms only
    }

    // Add the list ordering clause
    $orderCol = $this->state->get('list.ordering', 's.ordering');
    $orderDirn = $this->state->get('list.direction', 'asc');
    $query->order($db->escape($orderCol.' '.$orderDirn));

    return $query;
  }

}
?>
