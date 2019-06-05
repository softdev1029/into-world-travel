<?php
/**
 * @package RSForm! Pro
 * @copyright (C) 2007-2015 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// Setup the modal
if ($modal) {
	JHtml::_('behavior.modal', 'a.feedback-modal');
}
?>

	<?php echo JHtml::_('link', JRoute::_($form_url), $text, $attribs); ?>
