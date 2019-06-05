<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::_('behavior.tabstate');
JHtml::_('formbehavior.chosen', 'select');

JLoader::register('DacatalogHelper', JPATH_COMPONENT . '/helpers/dacatalog.php');
JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
JForm::addFieldPath(JPATH_COMPONENT . '/models/fields');

$controller = JControllerLegacy::getInstance('Dacatalog');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
