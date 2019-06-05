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

defined('JPATH_BASE') or die;

/**
 * Tag Meta HTML class
 *
 * @package TagMeta
 *
 */
abstract class JHtmlTagMeta
{
  /**
   * Display supported macros in a table
   *
   * @return  string  The HTML table of supported macros
   */
  public static function macros()
  {
    $macros = file_get_contents(JPATH_COMPONENT.'/helpers/html/macros.txt');
    return $macros;
  }

}
