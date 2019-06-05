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
jimport('joomla.application.component.modeladmin');

class TagMetaModelSynonym extends JModelAdmin
{
  /**
   * Returns a reference to the a Table object, always creating it
   *
   * @param  type  The table type to instantiate
   * @param  string  A prefix for the table class name. Optional
   * @param  array  Configuration array for model. Optional
   * @return  JTable  A database object
   */
  public function getTable($type = 'Synonym', $prefix = 'TagMetaTable', $config = array())
  {
    return JTable::getInstance($type, $prefix, $config);
  }

  /**
   * Method to get the record form
   *
   * @param  array  $data    Data for the form
   * @param  boolean  $loadData  True if the form is to load its own data (default case), false if not
   * @return  mixed  A JForm object on success, false on failure
   */
  public function getForm($data = array(), $loadData = true)
  {
    // Get the form
    $form = $this->loadForm('com_tagmeta.client', 'synonym', array('control' => 'jform', 'load_data' => $loadData));
    if (empty($form)) {
      return false;
    }

    return $form;
  }

  /**
   * Method to get the data that should be injected in the form
   *
   * @return  mixed  The data for the form
   */
  protected function loadFormData()
  {
    // Check the session for previously entered form data
    $data = JFactory::getApplication()->getUserState('com_tagmeta.edit.synonym.data', array());

    if (empty($data)) {
      $data = $this->getItem();
    }

    return $data;
  }

  /**
   * Prepare and sanitise the table data prior to saving
   *
   * @param  JTable  A JTable object
   */
  protected function prepareTable($table)
  {
    if (JFactory::getApplication()->input->get('task') == 'save2copy')
    {
      $table->keywords = JText::_('COM_TAGMETA_COPY_OF') . $table->keywords;
    }
    parent::prepareTable($table);
  }

  /**
   * Method to reset hits and last visit for all items
   *
   * @access  public
   * @return  boolean  True on success
   */
  public function resetstats()
  {
    $user = JFactory::getUser();

    $db = $this->getDbo();
    $query = 'UPDATE #__tagmeta_synonyms'
        . ' SET hits = 0, last_visit = \'0000-00-00 00:00:00\''
        . ' WHERE ( checked_out = 0 OR ( checked_out = ' . (int) $user->get('id') . ' ) )'
    ;
    $db->setQuery( $query );
    if(!$db->query()) {
      $this->setError($db->getErrorMsg());
      return false;
    }

    return true;
  }

}
