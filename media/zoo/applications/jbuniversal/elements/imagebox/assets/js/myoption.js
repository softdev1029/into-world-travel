/**
 * Created by Сергей on 06.05.2015.
 */
/* Copyright (C) YOOtheme GmbH, http://www.gnu.org/licenses/gpl.html GNU/GPL */ ! function(t) {
    var e = function() {};
    t.extend(e.prototype, {
        name: "MyElementSelect",
        options: {
            element: null,
            variable: null,
            url: ""
        },
        initialize: function(e, i) {
            this.options = t.extend({}, this.options, i);
            var n = this;
            this.element = e, this.list = e.children("ul"), this.hidden = this.list.find("li.hidden").detach(), e.delegate("div.delete", "click", function() {
                t(this).parent("li").slideUp(400, function() {
                    t(this).remove(), n.orderOptions()
                })
            }).delegate("div.name-input input", "blur", function() {
                var e = t(this).closest("li"),
                    i = e.find("div.panel input:text");
                if ("" != t(this).val() && "" == i.val()) {
                    var a = "";
                    n.getAlias(t(this).val(), function(t) {
                        a = t ? t : "42", i.val(a), e.find("a.trigger").text(a)
                    })
                }
            }).delegate("div.panel input:text", "keydown", function(e) {
                e.stopPropagation(), 13 == e.which && n.setOptionValue(t(this).closest("li")), 27 == e.which && n.removeOptionPanel(t(this).closest("li"))
            }).delegate("input.accept", "click", function() {
                n.setOptionValue(t(this).closest("li"))
            }).delegate("a.cancel", "click", function() {
                n.removeOptionPanel(t(this).closest("li"))
            }).delegate("a.trigger", "click", function() {
                t(this).hide().closest("li").find("div.panel").addClass("active").find("input:text").focus()
            }).find("div.add").bind("click", function() {
                var opt = n.hidden.clone().removeClass("hidden")
                    opt.appendTo(n.list).slideDown(200).effect("highlight", {}, 1e3).find("input:first").focus(), n.orderOptions()
                if (typeof window['afterOptionsAdded'] == 'function') afterOptionsAdded(opt);
            }), this.list.sortable({
                handle: "div.sort-handle",
                containment: this.list.parent().parent(),
                placeholder: "dragging",
                axis: "y",
                opacity: 1,
                revert: 75,
                delay: 100,
                tolerance: "pointer",
                zIndex: 99,
                start: function(t, e) {
                    e.placeholder.height(e.helper.height()), n.list.sortable("refreshPositions")
                },
                stop: function() {
                    n.orderOptions()
                }
            })
        },
        setOptionValue: function(t) {
            var e = this,
                i = t.find("div.panel input:text"),
                n = i.val();
            "" == n && (n = t.find("div.name-input input").val()), this.getAlias(n, function(a) {
                n = a ? a : "42", i.val(n), t.find("a.trigger").text(n), e.removeOptionPanel(t)
            })
        },
        removeOptionPanel: function(t) {
            t.find("div.panel input:text").val(t.find("a.trigger").show().text()), t.find("div.panel").removeClass("active")
        },
        orderOptions: function() {
            var e = /^(\S+\[option\])\[\d+\](\[(name|image)\]|\[value\])$/;
            this.list.children("li").each(function(i) {
                t(this).find("input").each(function() {
                    t(this).attr("name") && t(this).attr("name", t(this).attr("name").replace(e, "$1[" + i + "]$2"))
                })
            })
        },
        getAlias: function(e, i) {
            t.getJSON(this.options.url, {
                name: e
            }, function(t) {
                i(t)
            })
        }
    }), t.fn[e.prototype.name] = function() {
        var i = arguments,
            n = i[0] ? i[0] : null;
        return this.each(function() {
            var a = t(this);
            if (e.prototype[n] && a.data(e.prototype.name) && "initialize" != n) a.data(e.prototype.name)[n].apply(a.data(e.prototype.name), Array.prototype.slice.call(i, 1));
            else if (!n || t.isPlainObject(n)) {
                var l = new e;
                e.prototype.initialize && l.initialize.apply(l, t.merge([a], i)), a.data(e.prototype.name, l)
            } else t.error("Method " + n + " does not exist on jQuery." + e.name)
        })
    }
}(jQuery);