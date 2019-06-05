<?php
/**
 * Tag Meta Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package TagMeta
 * @copyright Copyright 2009 - 2011
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @link http://www.selfget.com
 * @version 1.9.0
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

/**
 * Tag Meta Controller Rule
 *
 * @package TagMeta
 *
 */
class TagMetaControllerRule extends JControllerForm
{
  public function save($key = null, $urlVar = null)
  {
    // Check for request forgeries
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    // Fill the form data with checkbox values
    $data = $this->input->post->get('jform', array(), 'array');
    $data['url'] = array_key_exists('url', $data) ? trim($data['url']) : '.';
    $data = $this->input->post->set('jform', $data);

    return parent::save($key, $urlVar);
  }

}
