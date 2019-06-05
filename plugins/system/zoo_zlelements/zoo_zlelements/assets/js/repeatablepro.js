/**
 * @package     ZL Elements
 * @version     3.3.0
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

!function(e){var t=function(){};e.extend(t.prototype,{name:"ElementRepeatablePro",options:{url:null,msgEditElement:null,msgDeleteElement:null,msgSortElement:null,tinymceUrl:null},initialize:function(t,n){this.options=e.extend({},this.options,n);var a=this,l=t.find("ul.repeatable-list.main"),i=l.find("li.repeatable-element.main"),o=i.length,s=e("<span>").appendTo(t.find(".add.main"));i.each(function(){a.attachButtons(e(this)),a.applySubRepeatable(e(this))}),l.delegate("span.btn-sort","mousedown",function(){l.find(".more-options.show-advanced").removeClass("show-advanced"),e(this).closest("li.repeatable-element").find(".content-row").hide()}).delegate("span.btn-delete","click",function(){e(this).closest("li.repeatable-element").first().fadeOut(200,function(){e(this).remove()})}).delegate(".preview","click",function(){e(this).closest("li.repeatable-element").find(".content-row").first().toggle()}).sortable({handle:"span.btn-sort.main",placeholder:"repeatable-element main dragging",axis:"y",opacity:1,delay:100,cursorAt:{top:16},revert:1,tolerance:"pointer",containment:"parent",scroll:!1,start:function(e,t){t.placeholder.height(t.item.height()-2),t.placeholder.width(t.item.find("div.repeatable-content").width()-2)}}),t.find("div.add.main a").bind("click",function(){s.addClass("zl-loader"),e.post(a.options.url,{method:"getrepeatable","args[0]":"_edit","args[1]":o++,"args[2]":!0},function(t){var n=e("<li>").addClass("repeatable-element main").html(t);a.attachButtons(n),n.appendTo(l),n.find("input, textarea").each(function(){e(this).val()&&e(this).val("")}),s.removeClass("zl-loader"),a.applySubRepeatable(n),n.ElementTinyMce({tinymceUrl:a.options.tinymceUrl})})})},attachButtons:function(t){var n=(t.children().wrapAll(e("<div>").addClass("repeatable-content")),e("<span>").addClass("tools").appendTo(t.find(".resume-row.main")));e("<span>").addClass("btn-delete main").attr("title",this.options.msgDeleteElement).appendTo(n),e("<span>").addClass("btn-sort main").attr("title",this.options.msgSortElement).appendTo(n)},applySubRepeatable:function(e){e.find(".sub-repeat-elements").ElementSubRepeatable({url:this.options.url,msgDeleteElement:this.options.msgDeleteElement,msgSortElement:this.options.msgSortElement,tinymceUrl:this.options.tinymceUrl})}}),e.fn[t.prototype.name]=function(){var n=arguments,a=n[0]?n[0]:null;return this.each(function(){var l=e(this);if(t.prototype[a]&&l.data(t.prototype.name)&&"initialize"!=a)l.data(t.prototype.name)[a].apply(l.data(t.prototype.name),Array.prototype.slice.call(n,1));else if(!a||e.isPlainObject(a)){var i=new t;t.prototype.initialize&&i.initialize.apply(i,e.merge([l],n)),l.data(t.prototype.name,i)}else e.error("Method "+a+" does not exist on jQuery."+t.name)})}}(jQuery),function(e){var t=function(){};e.extend(t.prototype,{name:"ElementSubRepeatable",options:{url:null,msgEditElement:null,msgDeleteElement:null,msgSortElement:null,tinymceUrl:null},initialize:function(t,n){this.options=e.extend({},this.options,n);var a=this,l=t.find("ul.sub-repeatable-list"),i=t.data("index"),o=t.data("name"),s=l.find("li.repeatable-element.sub"),r=s.length,p=e("<span>").appendTo(t.find("div.add.sub"));s.each(function(){a.attachButtons(e(this))}),l.sortable({handle:"span.btn-sort.sub",placeholder:"repeatable-element sub dragging",axis:"y",opacity:1,delay:100,cursorAt:{top:16},revert:1,tolerance:"pointer",containment:"parent",scroll:!1,start:function(e,t){t.placeholder.height(t.item.height()-2),t.placeholder.width(t.item.find("div.repeatable-content").width()-2)}}),t.find("div.add.sub a").bind("click",function(){var t=e(this).data("layout");p.addClass("zl-loader"),e.post(a.options.url,{method:"getsubrepeatable","args[0]":t,"args[1]":o,"args[2]":i,"args[3]":r++},function(t){var n=e("<li>").addClass("repeatable-element sub").html(t);a.attachButtons(n),n.appendTo(l),p.removeClass("zl-loader"),n.ElementTinyMce({tinymceUrl:a.options.tinymceUrl})})})},attachButtons:function(t){var n=(t.children().wrapAll(e("<div>").addClass("sub-repeatable-content")),e("<span>").addClass("tools").appendTo(t.find(".resume-row")));e("<span>").addClass("btn-delete sub").attr("title",this.options.msgDeleteElement).appendTo(n),e("<span>").addClass("btn-sort sub").attr("title",this.options.msgSortElement).appendTo(n)}}),e.fn[t.prototype.name]=function(){var n=arguments,a=n[0]?n[0]:null;return this.each(function(){var l=e(this);if(t.prototype[a]&&l.data(t.prototype.name)&&"initialize"!=a)l.data(t.prototype.name)[a].apply(l.data(t.prototype.name),Array.prototype.slice.call(n,1));else if(!a||e.isPlainObject(a)){var i=new t;t.prototype.initialize&&i.initialize.apply(i,e.merge([l],n)),l.data(t.prototype.name,i)}else e.error("Method "+a+" does not exist on jQuery."+t.name)})}}(jQuery);