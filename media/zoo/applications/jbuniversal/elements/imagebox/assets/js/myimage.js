/**
 * Created by Сергей on 06.05.2015.
 */
/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */
afterOptionsAdded = function(opt) {
    jQuery(function (e) {
        var t = location.href.match(/^(.+)administrator\/index\.php.*/i)[1];
        var elem;
        if (typeof opt == 'undefined') {
            elem = e("input.image-select");
        } else {
            elem = opt.find("input.image-select");
        }
        elem.each(function (i) {
            if (typeof opt != 'undefined') {
                i = opt.parent().find('li').length - 1;
            }
            var n = e(this),
                a = "image-select-" + i,
                r = e('<button type="button">').text("Select Image").insertAfter(n),
                o = e("<span>").addClass("image-cancel").insertAfter(n),
                s = e("<div>").addClass("image-preview").insertAfter(r);
            n.attr("id", a), n.val() && e("<img>").attr("src", t + n.val()).appendTo(s), o.click(function () {
                n.val(""), s.empty()
            }), r.click(function (e) {
                e.preventDefault(), SqueezeBox.fromElement(this, {
                    handler: "iframe",
                    url: "index.php?option=com_media&view=images&tmpl=component&e_name=" + a,
                    size: {
                        x: 800,
                        y: 500
                    }
                })
            })
        }), e.isFunction(window.jInsertEditorText) && (window.insertTextOld = window.jInsertEditorText), window.jInsertEditorText = function (i, n) {
            if (n.match(/^image-select-/)) {
                var a = e("#" + n),
                    r = i.match(/src="([^\"]*)"/)[1],
                    o = a.parent().find("div.image-preview").html(i),
                    s = o.find("img");
                s.attr("src", t + r), a.val(r)
            } else e.isFunction(window.insertTextOld) && window.insertTextOld(i, n)
        }
    });
}
afterOptionsAdded();