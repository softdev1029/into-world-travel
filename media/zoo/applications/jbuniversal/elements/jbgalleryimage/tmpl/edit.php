<?php
/**
 * @package   FL Gallery Image Element for Zoo
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$params = $this->config;
$user = JFactory::getUser();
$userId = ($this->getItem()->created_by) ? $this->getItem()->created_by : $user->id;

$deleteOption = $params->get('delete_type', 'simple');

?>
<div class="row <?php echo $this->identifier; ?> fl-galleryimage-submission" fl-galleryimage-images="<?php echo count($images); ?>">

    <div class="fl-galleryimage uk-grid">
        <div class="uk-width-1-1">
            <div class="upload">          
                <div id="fl-galleryimage-dropzone" class="galleryimage-dropzone well text-center">
                    <i class="icon-upload text-large"></i> Перетащите изображения сюда или <div class="fl-file text-error">выберите<input class="<?php echo $this->identifier; ?>-galleryimage-fileupload" type="file" name="<?php echo $this->identifier; ?>-files[]" multiple></div>
                </div>
            </div>
            <div class="fl-upload-from-server clearfix">          
                <button type="button" class="btn btn-small"><i class="icon-plus"></i> Выбрать с сервера</button>
            </div>
            <div class="fl-alert alert alert-danger hidden"><span title="Спрятать предупреждение" class="alert-close close"></span></div>
            <ul class="fl-files media-list">
                <?php
                    if ($images) {
                        foreach ($images as $key => $image) {
                            if ($this->isFileExists($image['file'])) {
                                $img = $this->app->zoo->resizeImage($this->app->path->path('root:' . $image['file']), $params->get('thumb_width', 300), $params->get('thumb_height'));
                                $img = $this->app->path->relative($img);
                                $imageName = JFile::getName($image['file']);

                                // Set Delete Type For Uploaded From Server Images
                                $deleteType = $params->get('delete_type', 'simple');
                                if (strpos($image['file'], $params->get('upload_directory')) === false) {
                                    $deleteType = 'simple';
                                }

                                ?>

                                <li class="fl-sort-images well well-small text-left clearfix">
                                    <div class="fl-galleryimage-thumb text-success text-left media">
                                        <div class="pull-left">
                                            <img class="media-object img-rounded" src="/<?php echo $img; ?>">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="media-heading"><i class="fl-galleryimage-load-icon icon-ok"></i> <?php echo $imageName; ?></h3>
                                            <div class="btn-group" style="margin-top:15px;">
                                                <button type="button" class="btn btn-small" data-toggle="collapse" data-target="#<?php echo $this->identifier.'-title-'.$key; ?>">Название</button>
                                                <button type="button" class="btn btn-small" data-toggle="collapse" data-target="#<?php echo $this->identifier.'-link-'.$key; ?>">Ссылка</button>
                                            </div>
                                            <div id="<?php echo $this->identifier.'-title-'.$key; ?>" class="collapse <?php echo ($image['title']) ? 'in' : 'out'?>" style="margin-top:15px;">
                                                <div class="row">
                                                    <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('title', $key), $image['title'], 'style="width:300px;" class="uk-form-small" size="60" maxlength="255" title="Название" placeholder="Название"'); ?>
                                                </div>
                                            </div>
                                            <div id="<?php echo $this->identifier.'-link-'.$key; ?>" class="collapse <?php echo ($image['link']) ? 'in' : 'out'?>">
                                                <div class="row">
                                                    <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('link', $key), $image['link'], 'style="width:300px;" class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Ссылка" placeholder="Ссылка"'); ?>
                                                </div>
                                                <div class="row">
                                                    <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('rel', $key), $image['rel'], 'style="width:300px;" class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Rel" placeholder="Rel"'); ?>
                                                </div>
                                                <div class="row">
                                                    В новом окне <?php echo $this->app->html->_('select.booleanlist', $this->getGalleryImageControlName('target', $key), $image['target'], $image['target']); ?>
                                                </div>
                                            </div>
                                            <span class="fl-button-sort btn btn-info btn-mini"><i class="icon-move"></i></span>
                                            <span class="fl-button-delete-<?php echo $deleteType; ?> btn btn-danger btn-mini" data-url="<?php echo JURI::root();?>media/zoo/applications/jbuniversal/elements/jbgalleryimage/upload/index.php?<? echo $this->identifier; ?>-file=<?php echo urlencode($imageName); ?>"><i class="icon-remove"></i></span>
                                            <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('file', $key), $image['file'], 'style="display:none;"'); ?>
                                        </div>
                                    </div>
                                </li>
                            <?php }
                        }
                    }
                ?>

            </ul> 
            <div class="progress hidden">
                <div class="bar"></div>
            </div>     
        </div>
    </div>
</div>

<script>
    (function($){
        $(".<?php echo $this->identifier; ?> .fl-files").sortable({
            cursor: "move",
            helper: "clone",
            tolerance: "pointer",
            handle: ".fl-button-sort"
        });

        $('.<?php echo $this->identifier; ?>-galleryimage-fileupload').jbGalleryImageUploadEdit({
            'uploadId': '<?php echo $this->identifier; ?>',
            'url' : '<?php echo JURI::root(); ?>media/zoo/applications/jbuniversal/elements/jbgalleryimage/upload/index.php',
            'maxNumberOfFiles' : <?php echo $params->get('max_number') ? $params->get('max_number') : 100; ?>,
            'previewMaxWidth' : <?php echo $params->get('thumb_width') ? $params->get('thumb_width') : 175; ?>,
            'previewMaxHeight' : <?php echo $params->get('thumb_height') ? $params->get('thumb_height') : 110; ?>,
            'maxFileSize' : <?php echo $params->get('max_upload_size') ? $params->get('max_upload_size')*1000 : 10000000 ?>,
            'imageMaxWidth' : <?php echo $params->get('max_width') ? $params->get('max_width') : 5000000; ?>,
            'imageMaxHeight': <?php echo $params->get('max_height')? $params->get('max_height') : 5000000; ?>,
            'deleteType' : '<?php echo $deleteOption; ?>',
            'userId' : '<?php echo $userId; ?>',
        }); 

        $(document).on('click', '.<?php echo $this->identifier; ?> .fl-galleryimage .fl-button-delete-full', function () {
            if (confirm('Изображение будет удалено с сервера. Вы уверены, что хотите удалить изображение?')) {
                $(this).jbGalleryImageUploadEdit('delete', {
                    'url' : $(this).data('url'),
                    'uploadId': '<?php echo $this->identifier; ?>',
                    'methodType': 'DELETE',
                    'userId' : '<?php echo $userId; ?>'
                })
                $(this).parents('.fl-sort-images').remove();
            };
        })

        $(document).on('click', '.<?php echo $this->identifier; ?> .fl-galleryimage .fl-button-delete-simple', function () {
            $(this).parents('.fl-sort-images').remove();
            $(this).jbGalleryImageUploadEdit('updateImageCount', '<?php echo $this->identifier; ?>');
        })

        $(document).on('click', '.<?php echo $this->identifier; ?> .alert .close', function () {
            $(this).parent().addClass('hidden').find('p').remove();
        })
    })(jQuery);
</script>