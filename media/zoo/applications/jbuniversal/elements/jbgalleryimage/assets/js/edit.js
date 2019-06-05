(function($){

    var methods = {
        init : function(options) {

            var settings = $.extend( {
                'uploadId': '',
                'url' : '',
                'maxNumberOfFiles' : '',
                'previewMaxWidth' : 175,
                'previewMaxHeight' : 110,
                'maxFileSize' : '',
                'imageMaxWidth' : '',
                'imageMaxHeight': '',
                'deleteType' : 'simple',
                'userId' : 'quest'
            }, options);

            //Add Image From Server Start

            var url = location.href.match(/^(.+)administrator\/index\.php.*/i)[1];

            $selectButton = $('.' + options.uploadId + ' .fl-upload-from-server button');

            $selectButton.click(function (event) {
                event.preventDefault();

                SqueezeBox.fromElement(this, {
                    handler: "iframe",
                    url    : "index.php?option=com_media&view=images&tmpl=component&e_name=" + options.uploadId,
                    size   : {x: 850, y: 500}
                });
            });

            if ($.isFunction(window.jInsertEditorText)) {
                window.insertTextOldJBImageGallery = window.jInsertEditorText;
            }

            window.jInsertEditorText = function (c, a) {
                if (a == options.uploadId) {
                    var flgalleryimageSubmission = $('.' + a + '.fl-galleryimage-submission');
                    var count = $('.' + a + ' .fl-files li').length;
                    var imagesCount = parseInt(flgalleryimageSubmission.attr('fl-galleryimage-images'));
                    var extraSettings = methods.extraSettings(a, imagesCount);
                    var value = c.match(/src="([^\"]*)"/)[1];
                    var html = '<li class="fl-sort-images well well-small text-left">' +
                        '<div class="fl-galleryimage-thumb text-success text-left media">' +
                            '<div class="pull-left">' +
                                '<img class="media-object img-rounded" style="max-width:' + options.previewMaxWidth + 'px; max-height:' + options.previewMaxHeight + 'px" src="' + url + value + '">' +
                            '</div>' +
                            '<div class="media-body">' +
                                '<h3 class="media-heading"><i class="fl-galleryimage-load-icon icon-ok"></i>' + value.substr(value.lastIndexOf("/")+1) + '</h3>' +
                                extraSettings +
                                '<span type="button" class="fl-button-sort btn btn-info btn-mini"><i class="icon-move"></i></span>' +
                                '<span type="button" class="fl-button-delete-simple btn btn-danger btn-mini"><i class="icon-remove"></i></span>' +
                                '<input type="text" name="elements[' + a + '][' + imagesCount + '][file]" value="' + value + '" style="display:none;">' +
                            '</div>' +
                        '</div>' +
                    '</li>';

                    imagesCount++;
                    flgalleryimageSubmission.attr('fl-galleryimage-images', imagesCount);

                    $('.' + a + ' .fl-files').append(html);

                } else {
                    $.isFunction(window.insertTextOldJBImageGallery) && window.insertTextOldJBImageGallery(c, a);
                }
            };

            //Add Image From Server End
            
            var fileupload = function() {
                $('.' + options.uploadId + '-galleryimage-fileupload').fileupload({
                    dropZone: $('.' + options.uploadId + ' .galleryimage-dropzone'),
                    url: options.url,
                    dataType: 'json',
                    autoUpload: true,
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                    maxFileSize: options.maxFileSize,
                    maxNumberOfFiles: options.maxNumberOfFiles,
                    getNumberOfFiles: function () {
                        return $('.' + options.uploadId + ' .fl-files .fl-sort-images').length - 1;
                    },
                    disableImageResize: /Android(?!.*Chrome)|Opera/
                        .test(window.navigator && navigator.userAgent),
                    previewMaxWidth: options.previewMaxWidth,
                    previewMaxHeight: options.previewMaxHeight,
                    previewCrop: true,
                    imageMaxWidth: options.imageMaxWidth,
                    imageMaxHeight: options.imageMaxHeight,
                    formData: {id: options.userId, elementId: options.uploadId}
                }).on('fileuploadadd', function (e, data) {
                    data.context = $('<li class="fl-sort-images well well-small text-left"/>').appendTo($(this).parents('.fl-galleryimage').find('.fl-files'));
                    $.each(data.files, function (index, file) {
                        var node = $('<div class="media"/>')
                                .append($('<div class="media-body"/>')
                                .append($('<h3 class="media-heading"/>').html('<i class="fl-galleryimage-load-icon icon-refresh"></i> ' + file.name)));
                        node.appendTo(data.context);
                    });
                }).on('fileuploadprocessalways', function (e, data) {
                    var index = data.index,
                        file = data.files[index],
                        node = $(data.context.children()[index]);

                    if (file.preview) {
                        var canvas = data.files[0].preview;
                        var newImg = $('<img class="media-object img-rounded"/>').attr('src', canvas.toDataURL()).css({"max-width": options.previewMaxWidth + "px", "max-height": options.previewMaxHeight + "px"});
                        var imgWrap = $('<div class="pull-left"/>');
                        imgWrap = imgWrap.prepend(newImg);
                        node.prepend(imgWrap);
                    }
                    if (file.error) {
                        $(this).parents('.fl-galleryimage').find('.fl-alert').removeClass('hidden').append('<p style="font-size:smaller; word-wrap:break-word;">Файл <b>' + file.name + '</b> не загружен. Причина: ' + file.error + '.</p>');
                        node.closest('.fl-sort-images').remove();
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    $(this).parents('.fl-galleryimage').find('.progress').removeClass('hidden').find('.bar').css(
                        'width',
                        progress + '%'
                    );
                    
                }).on('fileuploaddone', function (e, data) {
                    var flgalleryimageSubmission = $('.' + options.uploadId + '.fl-galleryimage-submission');
                    $.each(data.result[options.uploadId + '-files'], function (index, file) {
                        if (file.url) {

                            var url = file.url;
                            url = url.replace(location.protocol + '//' + location.host + '/', '').replace('//', '/');

                            var count = $('.' + options.uploadId + ' .fl-files li').length;
    
                            var imagesCount = parseInt(flgalleryimageSubmission.attr('fl-galleryimage-images'));

                            var link = $('<div class="fl-galleryimage-thumb text-success text-left media"/>');

                            var extraSettings = methods.extraSettings(options.uploadId, imagesCount);

                            $(data.context.children()[index])
                                .wrap(link)
                                .find('.media-body')
                                .append('<span class="fl-button-sort btn btn-info btn-mini"><i class="icon-move"></i></span><span data-url="' + file.deleteUrl + '" class="fl-button-delete-' + options.deleteType + ' btn btn-danger btn-mini"><i class="icon-remove"></i></span><input style="display:none;" class="hidden" name="elements[' + options.uploadId + '][' + imagesCount + '][file]" type="text" value="' + url + '">' + extraSettings)
                                .find('.fl-galleryimage-load-icon').removeClass('icon-refresh')
                                .addClass('icon-ok');

                            imagesCount++;
                            flgalleryimageSubmission.attr('fl-galleryimage-images', imagesCount);

                        } else if (file.error) {
                            $(this).parents('.fl-galleryimage').find('.fl-alert').removeClass('uk-hidden').append('<p style="font-size:smaller; word-wrap:break-word;">Файл <b>' + file.name + '</b> не загружен. Причина: ' + file.error + '.</p>');
                        }
                    });
                }).on('fileuploadfail', function (e, data) {
                    $.each(data.files, function (index) {
                        $(this).parents('.fl-galleryimage').find('.fl-alert').removeClass('hidden').append('<p style="font-size:smaller; word-wrap:break-word;">Файл <b>' + file.name + '</b> не загружен.</p>');
                    });
                }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
            }

            return this.each(fileupload);
        },
        delete : function(options) {
            var settings = $.extend( {
                'url': '',
                'uploadId': '',
                'methodType': 'DELETE',
                'userId' : ''
            }, options);

            return this.each(function() {
                $.ajax({
                    type: options.methodType,
                    url: options.url + '&id=' + options.userId + '&elementId=' + options.uploadId,
                    success: function(data){
                        methods.updateImageCount(options.uploadId);
                    }
                });

            });
        },
        updateImageCount : function(uploadId) {
            var imagesCount = $('.' + uploadId + ' .fl-sort-images').length;
            $('.' + uploadId + '.fl-galleryimage-submission').attr('fl-galleryimage-images', imagesCount)
            if (imagesCount == 0) {
                $('.' + uploadId + ' .progress').addClass('hidden');
            }
        },
        extraSettings : function(uploadId, imagesCount) {
            var extraSettings = '<div class="btn-group" style="margin-top:15px;">' +
                '<button type="button" class="btn btn-small" data-toggle="collapse" data-target="#' + uploadId + '-title-' + imagesCount + '">Название</button>' +
                '<button type="button" class="btn btn-small" data-toggle="collapse" data-target="#' + uploadId + '-link-' + imagesCount + '">Ссылка</button>' +
            '</div>' +
            '<div id="' + uploadId + '-title-' + imagesCount + '" class="collapse out" style="margin-top:15px;">' +
                '<div class="row">' +
                    '<input style="width:300px;" type="text" name="elements[' + uploadId + '][' + imagesCount + '][title]" value="" class="uk-form-small" size="60" maxlength="255" title="Название" placeholder="Название">' +
                '</div>' +
            '</div>' +
            '<div id="' + uploadId + '-link-' + imagesCount + '" class="collapse out">' +
                '<div class="row">' +
                    '<input style="width:300px;" type="text" name="elements[' + uploadId + '][' + imagesCount + '][link]" value="" class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Ссылка" placeholder="Ссылка">' +
                '</div>' +
                '<div class="row">' +
                    '<input style="width:300px;" type="text" name="elements[' + uploadId + '][' + imagesCount + '][rel]" value="" class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Rel" placeholder="Rel">' +
                '</div>' +
                '<div class="row">В новом окне ' +
                    '<div class="controls">' +
                        '<label for="elements[' + uploadId + '][' + imagesCount + '][target]0" id="elements[' + uploadId + '][' + imagesCount + '][target]0-lbl" class="radio">' +
                            '<input type="radio" name="elements[' + uploadId + '][' + imagesCount + '][target]" id="elements[' + uploadId + '][' + imagesCount + '][target]0" value="0" checked="checked" 0="">Нет' +
                        '</label>' +
                        '<label for="elements[' + uploadId + '][' + imagesCount + '][target]1" id="elements[' + uploadId + '][' + imagesCount + '][target]1-lbl" class="radio">' +
                            '<input type="radio" name="elements[' + uploadId + '][' + imagesCount + '][target]" id="elements[' + uploadId + '][' + imagesCount + '][target]1" value="1" 0="">Да' +
                        '</label>' +
                    '</div>' +
                '</div>' +
            '</div>';

            return extraSettings;
        }
    };

    $.fn.jbGalleryImageUploadEdit = function(method) {
        
        if ( methods[method] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error('Метод с именем ' +  method + ' не существует для jbGalleryImageUploadEdit');
        } 
    };

})(jQuery);