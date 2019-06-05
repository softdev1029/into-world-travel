<?php
defined('_JEXEC') or die('Restricted access');

JToolBarHelper::addNew('add');
JToolBarHelper::publishList($this->controller.'.publish');
JToolBarHelper::unpublishList($this->controller.'.unpublish');
JToolBarHelper::custom($this->controller.'.save2copy', 'save-copy', '', 'JTOOLBAR_SAVE_AS_COPY', true);
JToolBarHelper::title(  JText::_('dacatalog').' :: '.mb_strtolower(JText::_(JRequest::getVar( 'view' )), 'utf-8') );

JToolBarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', $this->controller.'.delete');
?>

<form action="index.php?option=<?php echo JRequest::getVar( 'option' ); ?>&view=<?php echo JRequest::getVar( 'view' ); ?>" method="post" name="adminForm" id="adminForm">

	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render(); ?>
	</div>
	<div id="j-main-container" class="span10">
		<div id="tablecell">
			<?php
			// Search tools bar
			echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('filterButton' => false)));
			?>
			<table class="table table-striped">
				<thead>
				<tr valign="top">
					<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
					</th>
					<th width="5" class="nowrap">
						<?php echo JHTML::_('grid.sort', 'ID', 'i.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'date', 'i.date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'cityFrom', 'i.cityFrom', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'cityTo', 'i.cityTo', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'number', 'i.number', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'price', 'i.price', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'currency', 'i.currency', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="center nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'i.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="11">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php
				$k = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++)
				{
					$row = &$this->items[$i];
					$checked 	= JHTML::_('grid.checkedout',  $row, $i );
					$published 	= JHTML::_('grid.published', $row, $i, 'tick.png', 'publish_x.png', $this->controller.'.' );
					$ordering	= (@$this->lists['order'] == 'i.ordering');
					?>
					<tr class="<?php echo "row$k"; ?> <?php if($_SESSION['da-id'] == $row->id) echo 'green'; ?>">
						<td>
							<?php echo $checked; ?>
						</td>
						<td>
							<input type="hidden" name="id<?php echo $i; ?>" value="<?php echo $row->id; ?>">
							<?php echo $row->id; ?>
						</td>
						<td class="nowrap">
							<a href="index.php?option=com_dacatalog&view=<?php echo JRequest::getVar( 'view' ); ?>&layout=add&id=<?php echo $row->id; ?>"><?php echo $row->date; ?></a>
							<?php if($row->alias) : ?>
								<br><span class="small break-word">(<span>Алиас</span>: <?php echo $row->alias; ?>)</span>
							<?php endif; ?>
						</td>
						<td class="nowrap">
							<?php echo $row->cityFrom; ?>
						</td>
						<td class="nowrap">
							<?php echo $row->cityTo; ?>
						</td>
						<td class="nowrap">
							<?php echo $row->number; ?>
						</td>
						<td class="nowrap center">
							<input type="text" name="price[<?php echo $row->id; ?>]" value="<?php echo $row->price; ?>" class="input-small ajax-save">
						</td>
						<td class="nowrap">
							<?php echo $row->currency; ?>
						</td>
						<td class="nowrap center">
							<?php echo $published; ?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

	<input type="hidden" name="option" value="<?php echo JRequest::getVar( 'option' ); ?>" /><br>
	<input type="hidden" name="view" value="<?php echo JRequest::getVar( 'view' ); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="total_on_page" value="<?php echo $this->total; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

<style>
	.js-stools-field-filter:first-child, .js-stools-field-filter:last-child {vertical-align: super;}
	body tr.green td {background-color:#c4fac5 !important;}
</style>

<script type="text/javascript">
	jQuery(document).ready(function (){
		jQuery('.js-stools-field-filter input[type="submit"]').removeClass('active');

		jQuery('.ajax-save').change(function () {
			jQuery.ajax({
				url:     jQuery('#adminForm').attr('action') + "&task=<?php echo $this->controller; ?>.ajaxSave",
				type:     "POST",
				dataType: "text",
				data: jQuery(this).serialize()
			});
		});
	});
</script>