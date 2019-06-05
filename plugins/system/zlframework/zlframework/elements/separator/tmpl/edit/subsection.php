<?php
/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

defined('_JEXEC') or die('Restricted access');

// load assets
$this->app->document->addStylesheet('elements:separator/tmpl/edit/subsection/style.css');
$this->app->document->addScript('elements:separator/tmpl/edit/subsection/script.min.js');

// init vars
$title = $this->config->get('name', '');

?>

<div id="<?php echo $this->identifier; ?>">

	<script type="text/javascript">
		jQuery(function($) {
			$("#<?php echo $this->identifier; ?>").ZOOtoolsSeparatorSubsection({
				title: '<?php echo $title; ?>'
			});
		});
	</script>

</div>
