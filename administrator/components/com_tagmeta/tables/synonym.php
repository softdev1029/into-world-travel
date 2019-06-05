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
* Tag Meta Synonym Table class
*
* @package TagMeta
*
*/
class TagMetaTableSynonym extends JTable
{
 function __construct(& $db) {
  parent::__construct('#__tagmeta_synonyms', 'id', $db);
 }

}
