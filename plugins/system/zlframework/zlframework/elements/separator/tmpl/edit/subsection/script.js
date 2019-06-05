/**
 * @package     ZOOlanders
 * @version     3.3.27
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

!function(t){var e=function(){};e.prototype=t.extend(e.prototype,{name:"ZOOtoolsSeparatorSection",options:{title:"",folding:0},initialize:function(e,o){this.options=t.extend({},this.options,o);var n=this,i=t('<div class="zl-separator-section zl-bootstrap" />');title=t("<h3>"+n.options.title+"</h3>"),title.appendTo(i),e.parent().before(i).remove(),t(document).ready(function(){var e=i.nextAll(".zl-separator-section").first(),o=i.nextUntil(e);if(2==n.options.folding&&o.hide(),n.options.folding)var a=2==n.options.folding?"open":"close",p=t('<a class="btn btn-small fold" href="#"><i class="icon-eye-'+a+'"></i></a>').appendTo(i).on("click",function(t){t.preventDefault(),o.toggle(),p.find("i").toggleClass("icon-eye-open icon-eye-close")})})},exFunc:function(){}}),t.fn[e.prototype.name]=function(){var o=arguments,n=o[0]?o[0]:null;return this.each(function(){var i=t(this);if(e.prototype[n]&&i.data(e.prototype.name)&&"initialize"!=n)i.data(e.prototype.name)[n].apply(i.data(e.prototype.name),Array.prototype.slice.call(o,1));else if(!n||t.isPlainObject(n)){var a=new e;e.prototype.initialize&&a.initialize.apply(a,t.merge([i],o)),i.data(e.prototype.name,a)}else t.error("Method "+n+" does not exist on jQuery."+e.name)})}}(jQuery);