/**
 * @package         Regular Labs Library
 * @version         17.1.26563
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

(function($) {
	"use strict";

	$(document).ready(function() {
		$('.rl_multiselect').each(function() {
			var controls  = $(this).find('div.rl_multiselect-controls');
			var list      = $(this).find('ul.rl_multiselect-ul');
			var menu      = $(this).find('div.rl_multiselect-menu-block').html();
			var maxheight = list.css('max-height');

			list.find('li').each(function() {
				var $li  = $(this);
				var $div = $li.find('div.rl_multiselect-item:first');

				// Add icons
				$li.prepend('<span class="pull-left icon-"></span>');

				// Append clearfix
				$div.after('<div class="clearfix"></div>');

				if ($li.find('ul.rl_multiselect-sub').length) {
					// Add classes to Expand/Collapse icons
					$li.find('span.icon-').addClass('rl_multiselect-toggle icon-minus');

					// Append drop down menu in nodes
					$div.find('label:first').after(menu);

					if (!$li.find('ul.rl_multiselect-sub ul.rl_multiselect-sub').length) {
						$li.find('div.rl_multiselect-menu-expand').remove();
					}
				}
			});

			// Takes care of the Expand/Collapse of a node
			list.find('span.rl_multiselect-toggle').click(function() {
				var $icon = $(this);

				// Take care of parent UL
				if ($icon.parent().find('ul.rl_multiselect-sub').is(':visible')) {
					$icon.removeClass('icon-minus').addClass('icon-plus');
					$icon.parent().find('ul.rl_multiselect-sub').hide();
					$icon.parent().find('ul.rl_multiselect-sub span.rl_multiselect-toggle').removeClass('icon-minus').addClass('icon-plus');
				} else {
					$icon.removeClass('icon-plus').addClass('icon-minus');
					$icon.parent().find('ul.rl_multiselect-sub').show();
					$icon.parent().find('ul.rl_multiselect-sub span.rl_multiselect-toggle').removeClass('icon-plus').addClass('icon-minus');
				}
			});

			// Takes care of the filtering
			controls.find('input.rl_multiselect-filter').keyup(function() {
				var $text = $(this).val().toLowerCase();
				list.find('li').each(function() {
					var $li = $(this);
					if ($li.text().toLowerCase().indexOf($text) == -1) {
						$li.hide();
					} else {
						$li.show();
					}
				});
			});

			// Checks all checkboxes in the list
			controls.find('a.rl_multiselect-checkall').click(function() {
				list.find('input').prop('checked', true);
			});

			// Unchecks all checkboxes in the list
			controls.find('a.rl_multiselect-uncheckall').click(function() {
				list.find('input').prop('checked', false);
			});

			// Toggles all checkboxes in the list
			controls.find('a.rl_multiselect-toggleall').click(function() {
				list.find('input').each(function() {
					var $input = $(this);
					if ($input.prop('checked')) {
						$input.prop('checked', false);
					} else {
						$input.prop('checked', true);
					}
				});
			});

			// Expands all sub-items in the list
			controls.find('a.rl_multiselect-expandall').click(function() {
				list.find('ul.rl_multiselect-sub').show();
				list.find('span.rl_multiselect-toggle').removeClass('icon-plus').addClass('icon-minus');
			});

			// Hides all sub-items in the list
			controls.find('a.rl_multiselect-collapseall').click(function() {
				list.find('ul.rl_multiselect-sub').hide();
				list.find('span.rl_multiselect-toggle').removeClass('icon-minus').addClass('icon-plus');
			});

			// Shows all selected items in the list
			controls.find('a.rl_multiselect-showall').click(function() {
				list.find('li').show();
			});

			// Shows all selected items in the list
			controls.find('a.rl_multiselect-showselected').click(function() {
				list.find('li').each(function() {
					var $li   = $(this);
					var $hide = true;
					$li.find('input').each(function() {
						if ($(this).prop('checked')) {
							$hide = false;
							return false;
						}
					});

					if ($hide) {
						$li.hide();
						return;
					}

					$li.show();
				});
			});

			// Maximizes the list
			controls.find('a.rl_multiselect-maximize').click(function() {
				list.css('max-height', '');
				controls.find('a.rl_multiselect-maximize').hide();
				controls.find('a.rl_multiselect-minimize').show();
			});

			// Minimizes the list
			controls.find('a.rl_multiselect-minimize').click(function() {
				list.css('max-height', maxheight);
				controls.find('a.rl_multiselect-minimize').hide();
				controls.find('a.rl_multiselect-maximize').show();
			});

		});

		// Take care of children check/uncheck all
		$('div.rl_multiselect a.checkall').click(function() {
			$(this).parent().parent().parent().parent().parent().parent().find('ul.rl_multiselect-sub input').prop('checked', true);
		});
		$('div.rl_multiselect a.uncheckall').click(function() {
			$(this).parent().parent().parent().parent().parent().parent().find('ul.rl_multiselect-sub input').prop('checked', false);
		});

		// Take care of children toggle all
		$('div.rl_multiselect a.expandall').click(function() {
			var $parent = $(this).parent().parent().parent().parent().parent().parent().parent();
			$parent.find('ul.rl_multiselect-sub').show();
			$parent.find('ul.rl_multiselect-sub span.rl_multiselect-toggle').removeClass('icon-plus').addClass('icon-minus');
		});
		$('div.rl_multiselect a.collapseall').click(function() {
			var $parent = $(this).parent().parent().parent().parent().parent().parent().parent();
			$parent.find('li ul.rl_multiselect-sub').hide();
			$parent.find('li span.rl_multiselect-toggle').removeClass('icon-minus').addClass('icon-plus');
		});
		$('div.rl_multiselect-item.hidechildren').click(function() {
			var $parent = $(this).parent();

			$(this).find('input').each(function() {
				var $sub   = $parent.find('ul.rl_multiselect-sub').first();
				var $input = $(this);
				if ($input.prop('checked')) {
					$parent.find('span.rl_multiselect-toggle, div.rl_multiselect-menu').css('visibility', 'hidden');
					if (!$sub.parent().hasClass('hidelist')) {
						$sub.wrap('<div style="display:none;" class="hidelist"></div>');
					}
				} else {
					$parent.find('span.rl_multiselect-toggle, div.rl_multiselect-menu').css('visibility', 'visible');
					if ($sub.parent().hasClass('hidelist')) {
						$sub.unwrap();
					}
				}
			});
		});
	});
})(jQuery);
