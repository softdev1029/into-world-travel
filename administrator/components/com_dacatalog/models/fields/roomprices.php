<?php
defined('JPATH_BASE') or die;

class JFormFieldRoomprices extends JFormField
{
	protected $type = 'Roomprices';

	protected function getInput()
	{
		$this->value = json_decode($this->value);

		JFactory::getDocument()->addScriptDeclaration('
			var roomPriceQty = 1;
			jQuery(document).ready(function () {
				checkButtons();

				jQuery(".js-items").on("click", ".js-add", function() {
					roomPriceQty++;
					var dateFrom = jQuery(this).parent().find(".js-date-from").attr("id");
					var dateTo = jQuery(this).parent().find(".js-date-to").attr("id");
					var item = "<div class=\"js-item\">" + jQuery(this).parent().html() + "</div>";

					item = item.replace(new RegExp(dateFrom, "g"), "dateFrom_" + roomPriceQty);
					item = item.replace(new RegExp(dateTo, "g"), "dateTo_" + roomPriceQty);

					jQuery(item).appendTo(".js-items");
					checkButtons();

					Calendar.setup({
						inputField: "dateFrom_" + roomPriceQty,
						ifFormat: "%Y-%m-%d",
						button: "dateFrom_" + roomPriceQty + "_img",
						align: "Tl",
						singleClick: true,
						firstDay: 1
					});

					Calendar.setup({
						inputField: "dateTo_" + roomPriceQty,
						ifFormat: "%Y-%m-%d",
						button: "dateTo_" + roomPriceQty + "_img",
						align: "Tl",
						singleClick: true,
						firstDay: 1
					});
				});

				jQuery(".js-items").on("click", ".js-remove", function() {
					jQuery(this).parent().remove();
					checkButtons();
				});
			});

			function checkButtons() {
				jQuery(".js-item").each(function(i) {
					if(jQuery(".js-item").length == 1) {
						jQuery(this).find(".js-remove").hide();
					} else {
						jQuery(this).find(".js-remove").show();
					}

					if(i == (jQuery(".js-item").length - 1)) {
						jQuery(this).find(".js-add").show();
					} else {
						jQuery(this).find(".js-add").hide();
					}
            	});
			}
		');
		JFactory::getDocument()->addStyleDeclaration('
			.js-item {margin-top: 10px;}
			.js-item:first-child {margin-top: 0;}
		');

		$html = array();
		$html[] = '<div class="js-items">';

		if($this->value) {
			for( $i= 0 ; $i < count($this->value->dateFrom) ; $i++ ) {
				$html[] = '<div class="js-item">';
				$html[] = JHTML::_('calendar', $this->value->dateFrom[$i], $this->name.'[dateFrom][]', $id='dateFrom_'.$i, $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-from"');
				$html[] = JHTML::_('calendar', $this->value->dateTo[$i], $this->name.'[dateTo][]', $id='dateTo_'.$i, $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-to"');
				if(!$this->getAttribute("noprice"))
					$html[] = '<input type="text" name="'.$this->name.'[price][]" value="'.$this->value->price[$i].'">';
				$html[] = '<input type="button" class="btn js-remove" value="-">';
				$html[] = '<input type="button" class="btn js-add" value="+">';
				$html[] = '</div>';
			}
		} else {
			$html[] = '<div class="js-item">';
			$html[] = JHTML::_('calendar', $value = '', $this->name.'[dateFrom][]', $id='dateFrom_1', $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-from"');
			$html[] = JHTML::_('calendar', $value = '', $this->name.'[dateTo][]', $id='dateTo_1', $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-to"');
			if(!$this->getAttribute("noprice"))
				$html[] = '<input type="text" name="'.$this->name.'[price][]" value="">';
			$html[] = '<input type="button" class="btn js-remove" value="-">';
			$html[] = '<input type="button" class="btn js-add" value="+">';
			$html[] = '</div>';
		}

		$html[] = '</div>';

		return implode("\n", $html);
	}
}
