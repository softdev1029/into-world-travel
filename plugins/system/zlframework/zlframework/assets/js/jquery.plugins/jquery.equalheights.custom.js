/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

!function(i){i.fn.equalChildHeights=function(h){return i(this).each(function(){var h=0;i(this).children().css({"min-height":0}),i(this).children().each(function(t){i(this).height()>h&&(h=i(this).height())}),i(this).children().css({"min-height":h})}),this},i.fn.equalChildOuterHeights=function(h){return i(this).each(function(){i(this).children().css({"min-height":0});var h=0;i(this).children().each(function(t){i(this).outerHeight()>h&&(h=i(this).outerHeight())}),i(this).children().each(function(){var t=i(this).outerHeight()-i(this).height();i(this).css({"min-height":h-t})})}),this},i.fn.matchHeightsAs=function(h){var t=h.height();return i(this).each(function(){i(this).children().css({"min-height":t})}),this},i.fn.equalWidths=function(h){return i(this).each(function(){var h=0;i(this).children().each(function(t){i(this).width()>h&&(h=i(this).width())}),i.browser.msie&&6==i.browser.version&&i(this).children().css({width:h}),i(this).children().css({"min-width":h})}),this}}(jQuery);