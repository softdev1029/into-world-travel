/**
 * @package     ZOOlanders
 * @version     3.3.15
 * @author      ZOOlanders - http://zoolanders.com
 * @license     GNU General Public License v2 or later
 */

!function(t,e,o){"use strict";o.ready(function(){o.notify.message.defaults.pos="top-center"}),e.component("zoolandersAdmin",{init:function(){var e=this;t("#toolbar-edit button, #toolbar-delete button").prop("disabled",!0),e.initListToggle()},initListToggle:function(){var e=this.find('input[name^="cid"]');this.on("change",".tm-check-all",function(){var o=this.checked;e.each(function(e,n){n.checked=o,o&&t('input[name="boxchecked"]').val(o?1:0)}),o?(t("#toolbar-delete button").prop("disabled",!1),t("#toolbar-edit button").prop("disabled",!0)):t("#toolbar-edit button, #toolbar-delete button").prop("disabled",!0)}),e.on("change",function(o){var n=t('input[name^="cid"]:checked');t(".tm-check-all",this.element)[0].checked="",n.length>0?(t("#toolbar-edit button, #toolbar-delete button").prop("disabled",!1),t('input[name="boxchecked"]').val(1),t('input[name^="cid"]:checked',this.element).length==e.length&&(t(".tm-check-all",this.element)[0].checked=n)):(t("#toolbar-edit button, #toolbar-delete button").prop("disabled",!0),t('input[name="boxchecked"]').val(0)),n.length>1&&t("#toolbar-edit button").prop("disabled",!0)})}}),t(document).ready(function(){e.zoolandersAdmin(t("#adminForm"))})}(jQuery,zlux,UIkit);