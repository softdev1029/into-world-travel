/**
 * @package     ZOOlanders
 * @version     3.3.15
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

!function(e,n,t){"use strict";n.plugin("zoolandersOverlay",{init:function(e){var n=this;n.options=e},cover:function(){var n=this;n.element.addClass("uk-overlay");var t=e('<figcaption class="zx-overlay uk-overlay-panel uk-overlay-background uk-text-center"><div class="zx-overlay-inner"><span class="uk-icon-spin uk-icon-spinner"></span><div class="zx-overlay-text">'+n.options.content+"</div></div></figcaption>");n.element.append(t);var a=e(".zx-overlay-inner:first",n.element),i=a.height();a.css("marginTop",(e(window).height()-i)/2-100+"px")},uncover:function(){var n=this,t=e(".zx-overlay",n.element);t.animate({opacity:0},500,function(){n.element.removeClass("uk-overlay"),t.detach()})},setContent:function(n){var t=this,a=e(".zx-overlay .zx-overlay-text",t.element);a&&a.html(n)}})}(jQuery,zlux,UIkit);