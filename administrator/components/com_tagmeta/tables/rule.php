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
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
* Tag Meta Rule Table class
*
* @package TagMeta
*
*/
class TagMetaTableRule extends JTable
{
 function __construct(& $db) {
  parent::__construct('#__tagmeta_rules', 'id', $db);
 }

 function check() {
  /** check for unique url */
  $query = 'SELECT id FROM #__tagmeta_rules WHERE url = '.$this->_db->Quote($this->url);
  $this->_db->setQuery($query);

  $xid = intval($this->_db->loadResult());
  if ($xid && $xid != intval($this->id)) {
   $this->setError(JText::_('COM_TAGMETA_WARNING_DUPLICATED_URL'));
   return false;
  }
  return true;
 }

}
