<?php
defined('JPATH_BASE') or die;

class JFormFieldHotels extends JFormField
{
	protected $type = 'Hotels';

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
					var hotelId = jQuery(this).parent().find(".js-select").attr("id");
					var item = "<div class=\"js-item\">" + jQuery(this).parent().html() + "</div>";

					item = item.replace(new RegExp(dateFrom, "g"), "dateFrom_" + roomPriceQty);
					item = item.replace(new RegExp(dateTo, "g"), "dateTo_" + roomPriceQty);
					item = item.replace(new RegExp(hotelId, "g"), "hotelId_" + roomPriceQty);

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

					jQuery("#hotelId_" + roomPriceQty).next().remove();
					jQuery("#hotelId_" + roomPriceQty).chosen({"disable_search_threshold":10,"search_contains":true,"allow_single_deselect":true,"placeholder_text_multiple":"\u0412\u0432\u0435\u0434\u0438\u0442\u0435 \u0438\u043b\u0438 \u0432\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u043d\u0435\u0441\u043a\u043e\u043b\u044c\u043a\u043e \u0432\u0430\u0440\u0438\u0430\u043d\u0442\u043e\u0432","placeholder_text_single":"\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435","no_results_text":"\u0420\u0435\u0437\u0443\u043b\u044c\u0442\u0430\u0442\u044b \u043d\u0435 \u0441\u043e\u0432\u043f\u0430\u0434\u0430\u044e\u0442"});
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

		$db =& JFactory::getDBO();
		$query = "SELECT i.*, CONCAT(id, '. ', city, ' ', title, ' - ', roomTitle) AS title FROM #__dacatalog_hotels AS i WHERE i.published = 1";
		$db->setQuery( $query );
		$hotels = $db->loadObjectList();

		$html = array();
		$html[] = '<div class="js-items">';

		if($this->value) {
			for( $i= 0 ; $i < count($this->value->dateFrom) ; $i++ ) {
				$html[] = '<div class="js-item">';
				$html[] = JHTML::_("select.genericlist", $hotels, $this->name.'[hotelId][]', 'class="js-select"', $key= 'id', $text='title', $this->value->hotelId[$i], 'hotelId_'.$i);
				$html[] = JHTML::_('calendar', $this->value->dateFrom[$i], $this->name.'[dateFrom][]', $id='dateFrom_'.($i + 1), $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-from"');
				$html[] = JHTML::_('calendar', $this->value->dateTo[$i], $this->name.'[dateTo][]', $id='dateTo_'.($i + 1), $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-to"');
				$html[] = '<input type="button" class="btn js-remove" value="-">';
				$html[] = '<input type="button" class="btn js-add" value="+">';
				$html[] = '</div>';
			}
		} else {
			$html[] = '<div class="js-item">';
			$html[] = JHTML::_("select.genericlist", $hotels, $this->name.'[hotelId][]', 'class="js-select"', $key= 'id', $text='title', 'hotelId_1');
			$html[] = JHTML::_('calendar', $value = '', $this->name.'[dateFrom][]', $id='dateFrom_1', $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-from"');
			$html[] = JHTML::_('calendar', $value = '', $this->name.'[dateTo][]', $id='dateTo_1', $format = '%Y-%m-%d', $attribs = 'class="input-small js-date-to"');
			$html[] = '<input type="button" class="btn js-remove" value="-">';
			$html[] = '<input type="button" class="btn js-add" value="+">';
			$html[] = '</div>';
		}

		$html[] = '</div>';

		return implode("\n", $html);
	}
}
