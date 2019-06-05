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

	<?php if(!JRequest::getVar('tmpl')) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render(); ?>
	</div>
	<?php endif; ?>
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
						<?php echo JHTML::_('grid.sort', 'JGLOBAL_TITLE', 'i.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'JCATEGORY', 'i.catid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'flight', 'i.flightId', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'hotel', 'i.hotelId', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'excursion', 'i.excursionId', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'train', 'i.trainId', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap">
						<?php echo JHTML::_('grid.sort', 'visa', 'i.visaId', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'price', 'i.price', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'currency', 'i.currency', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'tax', 'i.tax', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'commission', 'i.commission', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'discount', 'i.discount', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
					<th class="center nowrap" width="5">
						<?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'i.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
					</th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="12">
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
						<td class="no-text">
							<?php echo $checked; ?>
						</td>
						<td class="no-text">
							<input type="hidden" name="id<?php echo $i; ?>" value="<?php echo $row->id; ?>">
							<?php echo $row->id; ?>
						</td>
						<td class="nowrap no-text">
							<a href="index.php?option=com_dacatalog&view=<?php echo JRequest::getVar( 'view' ); ?>&layout=add&id=<?php echo $row->id; ?>" rel="<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
							<?php if($row->alias) : ?>
								<br><span class="small break-word">(<span>Алиас</span>: <?php echo $row->alias; ?>)</span>
							<?php endif; ?>
						</td>
						<td class="nowrap">
							<a href="index.php?option=com_categories&task=category.edit&id=<?php echo $row->catid; ?>&extension=com_dacatalog"><?php echo $row->category; ?></a>
						</td>
						<td class="">
							<?php foreach($row->flights AS $flight) : ?>
								<a href="index.php?option=com_dacatalog&view=flights&layout=add&id=<?php echo $flight->id; ?>">
									<?php echo $flight->title; ?>
								</a>
								<br>
							<?php endforeach; ?>
						</td>
						<td class="">
							<?php foreach($row->hotels AS $hotel) : ?>
								<a href="index.php?option=com_dacatalog&view=hotels&layout=add&id=<?php echo $hotel->id; ?>">
									<?php echo $hotel->id; ?>. <?php echo $hotel->city; ?> <?php echo $hotel->title; ?> - <?php echo $hotel->roomTitle; ?>
								</a>
								<br>
							<?php endforeach; ?>
						</td>
						<td class="">
							<?php foreach($row->excursions AS $excursion) : ?>
								<a href="index.php?option=com_dacatalog&view=excursions&layout=add&id=<?php echo $excursion->id; ?>">
									<?php echo $excursion->title; ?>
								</a>
								<br>
							<?php endforeach; ?>
						</td>
						<td class="">
							<?php foreach($row->trains AS $train) : ?>
								<a href="index.php?option=com_dacatalog&view=trains&layout=add&id=<?php echo $train->id; ?>">
									<?php echo $train->id; ?>. <?php echo $train->date; ?> <?php echo $train->cityFrom; ?> - <?php echo $train->cityTo; ?>
								</a>
								<br>
							<?php endforeach; ?>
						</td>
						<td class="nowrap">
							<?php foreach($row->visa AS $visa) : ?>
								<a href="index.php?option=com_dacatalog&view=visa&layout=add&id=<?php echo $visa->id; ?>">
									<?php echo $visa->title; ?>
								</a>
								<br>
							<?php endforeach; ?>
						</td>
						<td class="nowrap center">
							<input type="text" name="price[<?php echo $row->id; ?>]" value="<?php echo $row->price; ?>" class="input-small ajax-save">
						</td>
						<td class="nowrap">
							<?php echo $row->currency; ?>
						</td>
						<td class="nowrap center">
							<input type="text" name="tax[<?php echo $row->id; ?>]" value="<?php echo $row->tax; ?>" class="input-small ajax-save">
						</td>
						<td class="nowrap center no-text">
							<input type="text" name="commission[<?php echo $row->id; ?>]" value="<?php echo $row->commission; ?>" class="input-small ajax-save">
						</td>
						<td class="nowrap center no-text">
							<input type="text" name="discount[<?php echo $row->id; ?>]" value="<?php echo $row->discount; ?>" class="input-small ajax-save">
						</td>
						<td class="nowrap center no-text">
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
	<?php if(JRequest::getVar('tmpl')) : ?>
	<input type="hidden" name="tmpl" value="<?php echo JRequest::getVar('tmpl'); ?>" />
	<?php endif; ?>

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

		<?php if(JRequest::getVar('tmpl')) : ?>
		jQuery('table.table tbody td').each(function() {
			if(!jQuery(this).hasClass('no-text')) {
				jQuery(this).html(jQuery(this).text());
			}
		});

		jQuery('table.table tbody a').click(function () {
			var id = jQuery(this).attr('rel');
			if(id) {
				parent.inserPriceTour( jQuery(this).attr('rel') );
				return false;
			}
		});
		<?php endif; ?>
	});
</script>