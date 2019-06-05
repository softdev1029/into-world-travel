/**
 * @package   FL Gallery Image Element for Zoo
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

 (function($){

    var methods = {
        init : function(options) {

            var settings = $.extend( {
                'uploadId': '',
                'url' : '',
                'maxNumberOfFiles' : '',
                'previewMaxWidth' : '',
                'previewMaxHeight' : '',
                'maxFileSize' : '',
                'imageMaxWidth' : '',
                'imageMaxHeight': '',
                'deleteType' : 'simple',
                'userId' : 'quest',
                'trusted_mode' : 0
            }, options);
            
            var fileupload = function() {
                $('.' + options.uploadId + '-galleryimage-fileupload').fileupload({
                    dropZone: $('.' + options.uploadId + ' .galleryimage-dropzone'),
                    url: options.url,
                    dataType: 'json',
                    autoUpload: true,
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                    maxFileSize: options.maxFileSize,
                    loadImageMaxFileSize: options.maxFileSize,
                    maxChunkSize: 4000000,
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
                    $('.fl-remove').remove(); //хак для UIkit
                    data.context = $('<li class="fl-sort-images uk-text-center"/>').appendTo($(this).parents('.fl-galleryimage').find('.fl-files'));
                    $.each(data.files, function (index, file) {
                        var node = $('<div class="uk-panel uk-panel-box" />')
                                .append($('<div class="uk-panel-body"/>')
                                .append($('<p class="uk-text-small uk-text-truncate uk-margin-small-top uk-margin-small-bottom"/>').html('<i class="fl-galleryimage-load-icon uk-icon-spinner uk-icon-spin"></i> ' + file.name)));
                        node.appendTo(data.context);
                    });
                }).on('fileuploadprocessalways', function (e, data) {
                    var index = data.index,
                        file = data.files[index],
                        node = $(data.context.children()[index]);

                    if (file.preview) {
                        var canvas = data.files[0].preview;
                        var newImg = $('<img/>').attr('src', canvas.toDataURL()).css({"max-width": options.previewMaxWidth + "px", "max-height": options.previewMaxHeight + "px"});
                        var imgWrap = $('<div class="uk-panel-teaser"/>');
                        imgWrap = imgWrap.prepend(newImg);
                        node.prepend(imgWrap);
                    }
                    if (file.error) {
                        $(this).parents('.fl-galleryimage').find('.fl-alert').removeClass('uk-hidden').append('<p class="uk-text-small uk-text-break">Файл <b>' + file.name + '</b> не загружен. Причина: ' + file.error + '.</p>');
                        node.closest('.fl-sort-images').remove();
                    }
                    if (index + 1 === data.files.length) {
                        data.context.find('button')
                            .text('Upload')
                            .prop('disabled', !!data.files.error);
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    $(this).parents('.fl-galleryimage').find('.uk-progress').removeClass('uk-hidden').find('.uk-progress-bar').css(
                        'width',
                        progress + '%'
                    );

                    if (progress != 100) {
                        $('#fl-submit-button').prop('disabled', true);
                    } else {
                        $('#fl-submit-button').prop('disabled', false);
                    }
                    
                }).on('fileuploaddone', function (e, data) {
                    var flgalleryimageSubmission = $('.' + options.uploadId + '.fl-galleryimage-submission');
                    $.each(data.result[options.uploadId + '-files'], function (index, file) {
                        if (file.url) {

                            var url = file.url;
                            url = url.replace(location.protocol + '//' + location.host + '/', '').replace('//', '/');

                            var extraSettings = '';

                            var count = $('.' + options.uploadId + ' .fl-files li').length;
    
                            var imagesCount = parseInt(flgalleryimageSubmission.attr('fl-galleryimage-images'));

                            var link = $('<div class="fl-galleryimage-thumb uk-text-center">');

                            if (options.trusted_mode) {
                                extraSettings = '<div class="uk-button-group uk-margin-small-top uk-display-block">' +
                                        '<a class="uk-button uk-button-mini" data-uk-toggle="{target:\'#' + options.uploadId + '-title-' + imagesCount + '\'}">Название</a>' +
                                        '<a class="uk-button uk-button-mini" data-uk-toggle="{target:\'#' + options.uploadId + '-link-' + imagesCount + '\'}">Ссылка</a>' +
                                    '</div>' +
                                    '<div id="' + options.uploadId + '-title-' + imagesCount + '" class="uk-hidden">' +
                                        '<div class="uk-margin-small-top">' +
                                            '<input type="text" name="elements[' + options.uploadId + '][' + imagesCount + '][title]" value="" class="uk-form-small" size="60" maxlength="255" title="Название" placeholder="Название">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div id="' + options.uploadId + '-link-' + imagesCount + '" class="uk-hidden">' +
                                        '<div class="uk-margin-small-top">' +
                                            '<input type="text" name="elements[' + options.uploadId + '][' + imagesCount + '][link]" value="" class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Ссылка" placeholder="Ссылка">' +
                                        '</div>' +
                                        '<div class="uk-margin-small-top">' +
                                            '<input type="text" name="elements[' + options.uploadId + '][' + imagesCount + '][rel]" value="" class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Rel" placeholder="Rel">' +
                                        '</div>' +
                                        '<div class="uk-margin-small-top uk-text-small">В новом окне ' +
                                            '<div class="controls">' +
                                                '<label for="elements[' + options.uploadId + '][' + imagesCount + '][target]0" id="elements[' + options.uploadId + '][' + imagesCount + '][target]0-lbl" class="radio">' +
                                                    '<input type="radio" name="elements[' + options.uploadId + '][' + imagesCount + '][target]" id="elements[' + options.uploadId + '][' + imagesCount + '][target]0" value="0" checked="checked" 0="">Нет' +
                                                '</label>' +
                                                '<label for="elements[' + options.uploadId + '][' + imagesCount + '][target]1" id="elements[' + options.uploadId + '][' + imagesCount + '][target]1-lbl" class="radio">' +
                                                    '<input type="radio" name="elements[' + options.uploadId + '][' + imagesCount + '][target]" id="elements[' + options.uploadId + '][' + imagesCount + '][target]1" value="1" 0="">Да' +
                                                '</label>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';
                            };

                            $(data.context.children()[index])
                                .wrap(link)
                                .find('.uk-panel-body')
                                .addClass('uk-text-success')
                                .append('<a data-url="' + file.deleteUrl + '" class="fl-button-delete-' + options.deleteType + ' uk-text-small">Удалить</a><input class="uk-hidden" name="elements[' + options.uploadId + '][' + imagesCount + '][file]" type="text" value="' + url + '">' + extraSettings)
                                .find('.fl-galleryimage-load-icon').removeClass('uk-icon-spinner uk-icon-spin')
                                .addClass('uk-icon-check-circle-o');

                            imagesCount++;
                            flgalleryimageSubmission.attr('fl-galleryimage-images', imagesCount);

                        } else if (file.error) {
                            $(this).parents('.fl-galleryimage').find('.fl-alert').removeClass('uk-hidden').append('<p class="uk-text-small uk-text-break">Файл <b>' + file.name + '</b> не загружен. Причина: ' + file.error + '.</p>');
                        }
                    });
                }).on('fileuploadfail', function (e, data) {
                    $.each(data.files, function (index) {
                        $(this).parents('.fl-galleryimage').find('.fl-alert').removeClass('uk-hidden').append('<p class="uk-text-small uk-text-break">Файл <b>' + file.name + '</b> не загружен.</p>');
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
            //$('.' + uploadId + '.fl-galleryimage-submission').attr('fl-galleryimage-images', imagesCount)
            if (imagesCount == 0) {
                $('.' + uploadId + ' .uk-progress').addClass('uk-hidden');
            }
        }
    };

    $.fn.jbGalleryImageUpload = function(method) {
        
        if ( methods[method] ) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error('Метод с именем ' +  method + ' не существует для jbGalleryImageUpload');
        } 
    };

})(jQuery);