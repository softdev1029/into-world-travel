<?php
/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier - Weeblr llc - 2018
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.14.0.3812
 * @date		2018-05-16
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


class TableExtension extends JTable
{
  var $id;
  var $file;
  var $title;
  var $filters;
  var $params;

  /**
   * Constructor
   *
   * @param object Database connector object
   */
  function TableExtension(& $db) {
  }

  function store( $updateNulls = false ) {

  }

}
