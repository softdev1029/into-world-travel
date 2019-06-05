/*global jConfirm,jAlert, initlocationmap*/
"use strict";
var html = '', book = '';
function send(action, data, callback) {
    var wait = jWait(Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_PLEASE_WHAIT'), false, true);
    data.lang = window.currentLanguage;

    jQuery.post(window.connectorPathURL + 'connector.php?action=' + action, data, function (resp) {
        if (!resp.error) {
            callback(resp);
        } else {
            jAlert(resp.msg);
        }
    }, 'json')
        .always(function () {
            wait.dialog('hide');
        });
}

function getObjects() {
    if (!jQuery('#objects').length) {
        return;
    }
    send('list', {user_id: jQuery('#user_id').val()}, function (resp) {
        if (!resp.error) {
            jQuery('#objects').find('tbody').empty();
            resp.data.forEach(function (object) {
                jQuery('#objects').find('tbody')
                    .append(
                        '<tr>\
                            <td>' +  object.title + '</td>\
                            <td>\
                                <a href="javascript:void(0)" onclick="deleteObject(' + object.id + ')">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DELETE') + '</a>\
                                <a href="javascript:void(0)" onclick="editObject(' + object.id + ')">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_EDIT') + '</a>\
                                <a href="' + object.link + '" target="_blank">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_VIEW') + '</a>\
                            </td>\
                        </tr>'
                    );
            });
        } else {
            jAlert(resp.msg);
        }
    });
}

jQuery(getObjects);

function deleteObject(id) {
    jConfirm(Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ARE_YOU_SHURE'), function () {
        send('delete', {id: id}, function (resp) {
            if (!resp.error) {
                getObjects();
            } else {
                jAlert(resp.msg);
            }
        });
    });
}
function saveHtml() {
    if (!html) {
        html = jQuery('#objectappenddialog')[0].outerHTML;
        jQuery('#objectappenddialog').remove();
    }
}
function addObject(idata, resp) {
    saveHtml();
    var form = jQuery(html),
        buttons,
        dialog,
        editor,
        timerworker,
        addTimeEditor = function (date, time, value) {
            var res = jQuery('<div class="yma_link">\
                    <span>' + value + '</span>\
                    <div class="value_popap">\
                        <div class="input-append">\
                            <input value="' + value + '" class="span2 valuepicker" type="text">\
                            <button type="button" class="btn applay">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_APPLAY') + '</button>\
                        </div>\
                    </div>\
                </div');

            res.on('click', function (e) {
                res.find('.value_popap').addClass('active');
                res.find('input').focus().select();
                e.stopPropagation();
            });

            res.find('.value_popap').on('click', function (e) {
                e.stopPropagation();
            });

            res.find('button').on('click', function (e) {
                var val = res.find('input').val();
                res.find('.value_popap').removeClass('active');
                timerworker.updateTime(date, time, time, val);
                res.find('span').text(val);
            });

            return res;
        },
        addTime = function (date, time, price, $daterow) {
            var $tr = jQuery(
                    '<tr data-time="' + time + '">\
                        <td>' + time + '</td>\
                        <td> <span></span> ' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_CURRENCY') + '</td>\
                        <td>\
                            <a class="remove_link" href="javascript:void(0)">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DELETE') + '</a>\
                        </td>\
                    </tr>'
                ),
                dt1 = Date.parseDate(time, 'H:i'),
                crnt;
            $tr.find('span').append(addTimeEditor(date, time, price || 0));
            $daterow.find('.table_times>tbody>tr').each(function () {
                var dt = Date.parseDate(jQuery(this).data('time'), 'H:i');
                if (dt1 > dt) {
                    crnt = jQuery(this);
                }
            });
            if (crnt) {
                crnt.after($tr);
            } else {
                $daterow.find('.table_times>tbody').prepend($tr);
            }
            $tr.find('.remove_link').on('click', function () {
                timerworker.removeTime(date, time);
            });
        },
        addDay = function (date) {
            var $tr = jQuery(
                    '<tr data-date="' + date + '">\
                        <td>' + date + '</td>\
                        <td>\
                            <a class="timer_add_time" href="javascript:void(0)">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADD_TIME') + '</a>\
                            <div class="time_popap">\
                                <div class="input-append">\
                                    <input class="span2 timepicker" type="text">\
                                    <button type="button" class="btn addtime">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADD') + '</button>\
                                </div>\
                            </div>\
                            <a class="remove_link" href="javascript:void(0)">' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DELETE') + '</a>\
                            <table class="table_times table table-stripped table-hover table-bordered">\
                                <thead>\
                                    <tr>\
                                        <th>' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TIME') + '</th>\
                                        <th>' + Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_OBJECT_PRICE') + '</th>\
                                        <th></th>\
                                    </tr>\
                                </thead>\
                                <tbody>\
                                </tbody>\
                            </table>\
                        </td>\
                    </tr>'
                ),
                crnt,
                dt1;

            $tr.on('click', function () {
                 $tr.find('.time_popap,.value_popap')
                    .removeClass('active');
            });
            
            $tr.find('.timer_add_time').on('click', function (e) {
                $tr.find('.time_popap').toggleClass('active');
                e.stopPropagation();
            });

            $tr.find('.time_popap').on('click', function (e) {
                e.stopPropagation();
            });

            $tr.find('.timepicker').datetimepicker({
                datepicker: false,
                lang: 'ru',
                format: 'H:i',
                step: 60
            });

            $tr.find('.addtime').on('click', function (e) {
                if ($tr.find('.timepicker').val()) {
                    timerworker.addTime(date, $tr.find('.timepicker').val(), jQuery.trim(form.find('#object_price').val()));
                    $tr.find('.timepicker').val('');
                    $tr.find('.time_popap').removeClass('active');
                } else {
                    $tr.find('.timepicker').focus();
                }
                e.stopPropagation();
            });

            $tr.find('.remove_link').on('click', function () {
                timerworker.removeDate(date);
            });

            dt1 = Date.parseDate(date, 'd.m.Y');
            form.find('.table_days>tbody>tr').each(function () {
                var dt = Date.parseDate(jQuery(this).data('date'), 'd.m.Y');
                if (dt1 > dt) {
                    crnt = jQuery(this);
                }
            });
            if (crnt) {
                crnt.after($tr);
            } else {
                form.find('.table_days>tbody').prepend($tr);
            }
        },
        TimerWorker = function (form, object) {
            var datetimes = {};
            this.setTimes = function (times) {
                var keys = Object.keys(times),
                    i,
                    ad = jQuery.proxy(function (time) {
                        this.addTime(keys[i], time.time, time.price);
                    }, this);
                datetimes = {};
                form.find('.table_days>tbody').empty();

                for (i = 0; i < keys.length; i += 1) {
                    this.addDate(keys[i]);
                    times[keys[i]].forEach(ad);
                }
            };
            this.updateTime = function (date, time, newtime, price) {
                var data;
                datetimes[date].forEach(function (item) {
                    if (item.time === time) {
                        data = item;
                    }
                });
                if (data !== undefined) {
                    data.time = newtime;
                    data.price = price;
                }
            }
            this.addTime = function (date, time, price) {
                var data;
                datetimes[date].forEach(function (item) {
                    if (item.time === time) {
                        data = item;
                    }
                });
                if (data === undefined) {
                    data = {
                        time: time,
                        price: price
                    };
                    datetimes[date].push(data);
                    addTime(date, time, price, form.find('tr[data-date="' + date + '"]'));
                }
            };
            this.addDate = function (date) {
                if (datetimes[date] === undefined) {
                    datetimes[date] = [];
                    addDay(date);
                }
            };
            this.removeDate = function (date) {
                delete datetimes[date];
                form.find('tr[data-date="' + date + '"]').remove();
            };
            this.removeTime = function (date, time) {
                datetimes[date].splice(datetimes[date].indexOf(time), 1);
                form.find('tr[data-date="' + date + '"]')
                    .find('tr[data-time="' + time + '"]').remove();
            };
            this.isSelected = function () {
                var keys = Object.keys(datetimes), i;
                for (i = 0; i < keys.length; i += 1) {
                    if (datetimes[keys[i]].length) {
                        return true;
                    }
                }
                return false;
            };
            this.getTimes = function () {
                return datetimes;
            };
        },

        imageGenerate = function (url, baseurl) {
            var html = '<div class="image_box">\
                <img src="' + baseurl + url + '" alt="">\
                <input type="hidden" value="' + encodeURIComponent(url) + '"/>\
                <a onclick="this.parentNode.parentNode.removeChild(this.parentNode)" href="javascript:void(0)" class="close-btn">&times;</a>\
             </div>';
            return html;
        },

        getText = function (html) {
            var div = document.createElement('div');
            div.innerHTML = html;
            return div.innerText;
        },
        error = function (id) {
            form.find('#' + id).parent()
                .addClass('error');
            if (form.find('#' + id).is(':visible')) {
                form.find('#' + id)
                    .focus();
            }
            return false;
        },
        sendData = function () {
            form.find('.error')
                .removeClass('error');

            var data = {
                    action: 'save',
                    id: form.find('#object_id').val(),
                    title: form.find('#object_title').val(),
                    description: form.find('#object_description').val(),
                    placecount: jQuery.trim(form.find('#object_placecount').val()),
                    price: jQuery.trim(form.find('#object_price').val()),
                    location: form.find('.location').val(),
                    times: timerworker.getTimes(),
                    user_id: parseInt(form.find('#user_id').val() || 0, 10),
                    periods: (function () {
                        var ret = [];
                        form.find('.yma_periods_time input:checked').each(function(){
                            ret.push(this.value);
                        });
                        return ret;
                    }()),
                    type: form.find('#types').val(),
                    time_variant: form.find('#time_variant').length ? form.find('#time_variant').val() : null,
                    categories: form.find('#categories').val(),
                    tags: form.find('#tags').val(),
                    images: []
                };

            if (data.title.length < 3) {
                return error('object_title');
            }

            if (getText(data.description).length < 3) {
                error('object_description');
                editor.$editor.focus();
                return false;
            }

            form.find('.images input').each(function () {
                data.images.push(this.value);
            });

            if (!data.images.length) {
                return error('images');
            }

            if (!data.price.length || !data.price.match(/^[0-9\.\,]+$/)) {
                return error('object_price');
            }
            if (!data.placecount.length || !data.placecount.match(/^[0-9\.\,]+$/)) {
                return error('object_placecount');
            }
            
            if ((!form.find('#time_variant').length || parseInt(form.find('#time_variant').val(), 10) === 1) && form.find('.yma_periods').length) { 
                if(!form.find('.yma_periods_time input:checked').length) {
                    return error('periods');
                }
            }
            if ((!form.find('#time_variant').length || parseInt(form.find('#time_variant').val(), 10) === 0) && !timerworker.isSelected()) {
                return error('timer');
            }
            
            if (!data.categories || !data.categories.length) {
                return error('categories');
            }

            send('save', data, function (resp) {
                if (!resp.error) {
                    dialog.dialog('hide');
                    getObjects();
                } else {
                    jAlert(resp.msg);
                }
            });

            return false;
        };

    timerworker = new TimerWorker(form, idata && idata.id);

    buttons = {};

    if (idata !== undefined) {
        form.find('#types').val(idata.params.type);
        form.find('#user_id').val(idata.create_by);
        form.find('#object_title').val(idata.title);
        form.find('#object_description').val(idata.description);
        form.find('#object_id').val(idata.id);
        form.find('#object_price').val(idata.params.price);
        form.find('#time_variant').val(idata.params.time_variant !== undefined ? idata.params.time_variant : 1);
        form.find('#tags').val(idata.tags);
        form.find('#object_placecount').val(idata.params.placecount);
        form.find('.location').val(JSON.stringify({
            lat: parseFloat(idata.lat),
            lan: parseFloat(idata.lan),
            zoom: parseInt(idata.zoom, 10)
        }));
        form.find('.images').empty().hide();

        if (idata.params.images && idata.params.images.length) {
            idata.params.images.forEach(function (image) {
                form.find('.images').show().append(imageGenerate(image, resp.baseurl));
            });
        }

        if (idata.times) {
            timerworker.setTimes(idata.times);
        }
        if (idata.periods) {
            form.find('.yma_periods_time input').prop('checked', false);
            idata.periods.forEach(function (period) {
                var i,j;
                for (i = 1; i <= 7; i += 1) {
                    if (period['day' + i]) {
                        for (j = +period.period_start; j < +period.period_end; j += 1) {
                            form.find('.yma_periods_time' + i + '_' + j).prop('checked', true);
                        }
                    }
                }
            });
        }

        if (idata.categories) {
            form.find('#categories').val(idata.categories);
        }
        buttons[Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_SAVE')] = sendData;
    } else {
        buttons[Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADD')] = sendData;
    }

    buttons[Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_CANCEL')] = true;

    dialog = form.dialog({
        title: idata !== undefined ? Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_EDIT_OBJECT') : Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ADDING_OBJECT'),
        buttons: buttons
    });

    form.find('.timer_add_day').on('click', function () {
        form.find('.timer_popap').toggleClass('active');
    });
    
    form.find('.addday').on('click', function () {
        if (form.find('.datepicker').val()) {
            timerworker.addDate(form.find('.datepicker').val());
            form.find('.datepicker').val('');
            form.find('.timer_popap').removeClass('active');
        } else {
            form.find('.datepicker').focus();
        }
    });

    form.find('.datepicker').datetimepicker({
        timepicker: false,
        format: 'd.m.Y',
        lang: 'ru'
    });
    
    form.find('#tags')
        .chosen({placeholder_text_multiple: Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_TAGS_SELECT')});
        
    form.find('#categories')
        .chosen({placeholder_text_multiple: Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_CATEGORIES_SELECT')});
    
    editor = new Jodit('#object_description', {
        minHeight: 50,
        uploader: {
            url : window.connectorPathURL + 'assets/jodit-connector/index.php?action=upload'
        },
        buttons: ['bold', 'italic', 'table', 'image', {
            icon : 'hr',
            tooltip: Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_INSERT_DEVIDER'),
            exec: function () {
                if (!this.$editor.find('hr#system-readmore').length) {
                    this.selection.insertHTML('<hr id="system-readmore"/>');
                } else {
                    jAlert(Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_DEVIDER_ALREADY_EXISTS'));
                }
            }
        }],
    })


    form.find('#time_variant')
        .on('change', function () {
            form.find('#time_variant0,#time_variant1').hide();
            form.find('#time_variant' + this.value).show();
        })
        .trigger('change');
        
    editor.uploader.bind(jQuery('#uploaderbox'), function (data) {
        if (data.files) {
            data.files.forEach(function (image) {
                form.find('.images').show().append(imageGenerate(image, data.baseurl));
            });
        }
    });
    
    initlocationmap();
    initPeriods(form);
}

function initPeriods(form) {
    form.find('.yma_periods_select_all').on('change', function () {
        var main = this;
        form.find('.yma_periods input').not(this).each(function(){
            this.checked = main.checked;
        });
    });
    form.find('.yma_periods_select_all_of_day input').on('change', function () {
        var main = this;
        jQuery(this).closest('tr').find('.yma_periods_time input').each(function () {
            this.checked = main.checked;
        });
    });
    form.find('.yma_periods_select_all_of_time_full input').on('change', function () {
        var main = this, index = +this.value;
        form.find('tr td:nth-child(' + (index + 2) + ') input').each(function () {
            this.checked = main.checked;
        });
    });
    var start = false, startvalue;
    form.find('.yma_periods_time input')
        .on('mousedown', function () {
            start = true;
            startvalue = this.value;
        })
        .on('mouseenter', function () {
            if (start) {
                var val = this.value.split('-'),
                    j, i, dx, dy,
                    val2 = startvalue.split('-');
                form.find('.selected,.unselected').removeClass('selected unselected');

                val[0] = +val[0];
                val[1] = +val[1];
                val2[0] = +val2[0];
                val2[1] = +val2[1];
                dx = ((val[0] > val2[0]) ? -1 : 1);
                dy = ((val[1] > val2[1]) ? -1 : 1);
 
                for (i = val[0]; (i <= val2[0] && dx == 1) || (i >= val2[0] && dx != 1); i = i + dx) {
                    for (j = val[1]; (j <= val2[1] && dy == 1) || (j >= val2[1] && dy != 1); j = j + dy) {
                        form.find('.yma_periods_time' + i + '_' + j).each(function () {
                            jQuery(this).addClass(this.checked ? 'unselected' : 'selected');
                        })
                    }
                };
                
            }
        })
    jQuery(window)
        .on('mouseup', function () {
            if (start === true) {
                start = false;
                form.find('.selected,.unselected').each(function () {
                    this.checked = jQuery(this).hasClass('selected');
                    jQuery(this).removeClass('selected unselected');
                });
            }
        });
}


function editObject(id) {
    send('edit', {id: id}, function (resp) {
        if (!resp.error) {
            addObject(resp.data, resp);
        } else {
            jAlert(resp.msg);
        }
    });
}

function deleteBook(object_id, date, time) {
    jConfirm(Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_ARE_YOU_SHURE'), function () {
        send('deletebook', {object_id: object_id, date: date, time: time}, function (resp) {
            if (!resp.error) {
                location.reload();
            } else {
                jAlert(resp.msg);
            }
        });
    });
}
function bookDialog(id, object_id, date, time) {
    if (!book) {
        book = jQuery('.book_dialog')[0].outerHTML;
        jQuery('.book_dialog').remove();
    }
    var form = jQuery(book),
        error = function (id) {
            form.find('#' + id).closest('.control-group')
                .addClass('error');
            if (form.find('#' + id).is(':visible')) {
                form.find('#' + id)
                    .focus();
            }
            return false;
        },
        sendData = function () {
            form.find('.error')
                .removeClass('error');
            var data = {
                email: form.find('#inputEmail').val(),
                phone: form.find('#inputPhone').val(),
                comment: form.find('#inputComment').val(),
                id: id,
                object_id: object_id,
                date: date,
                time: time
            };
            if (!data.email || !/^[^@]+@[^@]+\.[^@]+$/.test(data.email)) {
                return error('inputEmail');
            }
            if (!data.phone || !/^(\+)?[0-9\-\(\)\s]+$/.test(data.phone)) {
                return error('inputPhone');
            }
            send('book', data, function (resp) {
                jAlert(resp.msg, function () {
                    location.reload();
                });
            });
        },
        buttons = {};

    form
        .find('#id').val(id);

    buttons[Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOK')] = sendData;
    buttons[Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_CANCEL')] = true;
    
    form.dialog({
        title: Joomla.JText._('PLG_SYSTEM_YANDEX_MAPS_ARENDATOR_BOOKING_OBJECT'),
        buttons: buttons
    });
}