/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

!function(t){var i=function(){};t.extend(i.prototype,{name:"ZLdialog",initialize:function(i,e,o){this.options=t.extend({width:"300",height:"200",title:"Dialog"},e),this.wrapper=t('<div><span class="zl-loaderhoriz" /></div>').insertAfter(i);var a=this,n=a.wrapper.dialog(t.extend({autoOpen:!1,resizable:!1,width:a.options.width,height:a.options.height,dialogClass:"zldialog",open:function(){n.position({of:p,my:"left top",at:"right bottom"})},dragStop:function(i,e){t(".qtip").qtip("reposition")},close:function(i,e){t(".qtip").qtip("hide")}},a.options)).dialog("widget"),p=t('<span title="'+a.options.title+'" class="zl-btn-dialog" />').insertAfter(i).bind("click",function(){a.wrapper.dialog(a.wrapper.dialog("isOpen")?"close":"open"),t(this).data("initialized")||o(a),t(this).data("initialized",!0)});t("html").bind("mousedown",function(i){a.wrapper.dialog("isOpen")&&!p.is(i.target)&&!n.find(i.target).length&&!t(i.target).closest(".qtip").length&&a.wrapper.dialog("close")})},loaded:function(){this.wrapper.find(".zl-loaderhoriz").remove()},close:function(){this.wrapper.dialog("close")}}),t.fn[i.prototype.name]=function(){var e=arguments,o=e[0]?e[0]:null;return this.each(function(){var a=t(this);if(i.prototype[o]&&a.data(i.prototype.name)&&"initialize"!=o)a.data(i.prototype.name)[o].apply(a.data(i.prototype.name),Array.prototype.slice.call(e,1));else if(!o||t.isPlainObject(o)){var n=new i;i.prototype.initialize&&n.initialize.apply(n,t.merge([a],e)),a.data(i.prototype.name,n)}else t.error("Method "+o+" does not exist on jQuery."+i.name)})}}(jQuery);