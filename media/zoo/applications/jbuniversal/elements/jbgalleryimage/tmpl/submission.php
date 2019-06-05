<?php
/**
 * @package   FL Gallery Image Element for Zoo
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$params = $this->config;
$item = $this->getItem();

if ($item->id) {
    $user_id = $item->created_by;
} else {
    $user = JFactory::getUser();
    if (!$user->guest) {
        $user_id = $user->id;
    } else {
        $user_id = 'quest';
    }
}

$deleteOption = $params->get('delete_type', 'simple');

?>
<div class="<?php echo $this->identifier; ?> fl-galleryimage-submission" fl-galleryimage-images="<?php echo count($images); ?>">

    <div class="fl-galleryimage uk-grid">
        <div class="uk-width-1-1" data-uk-observe data-uk-margin="{cls:'uk-margin-top'}">
            <div class="upload">
                <div id="fl-galleryimage-dropzone" class="uk-placeholder uk-text-center galleryimage-dropzone">
                    <i class="uk-icon-cloud-upload uk-icon-medium uk-margin-small-right"></i> Перетащите изображения сюда или <a class="uk-form-file">выберите <input class="<?php echo $this->identifier; ?>-galleryimage-fileupload" type="file" name="<?php echo $this->identifier; ?>-files[]" multiple></a>
                </div>
            </div>
            <div class="fl-alert uk-alert uk-alert-danger uk-hidden"><span title="Спрятать предупреждение" class="uk-alert-close uk-close"></span></div>

            <ul class="fl-files uk-grid uk-grid-small uk-grid-width-large-1-5 uk-grid-width-small-1-3 uk-sortable <?php echo !empty($images) ? 'uk-margin-top' : ''; ?>" data-uk-grid-margin data-uk-sortable data-uk-grid-match="{target:'.uk-panel'}">
                <!-- Хак для UIkit Start -->
                <?php echo (count($images)) ? '' : '<li class="fl-remove"></li>'; ?>
                <!-- Хак для UIkit End -->
                <?php
                    if ($images) {
                        $userId = $item->created_by;
                        foreach ($images as $key => $image) {
                            if ($this->isFileExists($image['file'])) {
                                $img = $this->app->zoo->resizeImage($this->app->path->path('root:' . $image['file']), $params['thumb_width'], $params['thumb_height']);
                                $img = $this->app->path->relative($img);
                                $imageName = JFile::getName($image['file']); 

                                $deleteType = $params->get('delete_type', 'simple');
                                if (strpos($image['file'], $params->get('upload_directory')) === false) {
                                    $deleteType = 'simple';
                                }
                                ?>

                                <li class="fl-sort-images">
                                    <div class="fl-galleryimage-thumb uk-panel uk-panel-box uk-text-success uk-text-center">
                                        <div class="uk-panel-teaser"><img src="/<?php echo $img; ?>"></div>
                                        <div class="uk-panel-body">
                                            <p class="uk-text-small uk-text-truncate uk-margin-small-top uk-margin-small-bottom"><i class="fl-galleryimage-load-icon uk-icon-check-circle-o"></i> <?php echo $imageName; ?></p>
                                            <a data-url="<?php echo JURI::root();?>media/zoo/applications/jbuniversal/elements/jbgalleryimage/upload/index.php?<?php echo $this->identifier; ?>-file=<?php echo urlencode($imageName); ?>" class="fl-button-delete-<?php echo $deleteType; ?> uk-text-small">Удалить</a>
                                            <?php echo  $this->app->html->_('control.text', $this->getGalleryImageControlName('file', $key), $image['file'], 'class="uk-hidden hidden"');; ?>

                                            <?php if ($trusted_mode) : ?>
                                                <div class="uk-button-group uk-margin-small-top uk-display-block">
                                                    <a class="uk-button uk-button-mini" data-uk-toggle="{target:'#<?php echo $this->identifier.'-title-'.$key; ?>'}">Название</a>
                                                    <a class="uk-button uk-button-mini" data-uk-toggle="{target:'#<?php echo $this->identifier.'-link-'.$key; ?>'}">Ссылка</a>
                                                </div>
                                                <div id="<?php echo $this->identifier.'-title-'.$key; ?>" class="uk-hidden">
                                                    <div class="uk-margin-small-top">
                                                        <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('title', $key), $image['title'], 'class="uk-form-small" size="60" maxlength="255" title="Название" placeholder="Название"'); ?>
                                                    </div>
                                                </div>
                                                <div id="<?php echo $this->identifier.'-link-'.$key; ?>" class="uk-hidden">
                                                    <div class="uk-margin-small-top">
                                                        <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('link', $key), $image['link'], 'class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Ссылка" placeholder="Ссылка"'); ?>
                                                    </div>
                                                    <div class="uk-margin-small-top">
                                                        <?php echo $this->app->html->_('control.text', $this->getGalleryImageControlName('rel', $key), $image['rel'], 'class="uk-form-small uk-margin-small-top" size="60" maxlength="255" title="Rel" placeholder="Rel"'); ?>
                                                    </div>
                                                    <div class="uk-margin-small-top uk-text-small">
                                                        В новом окне <?php echo $this->app->html->_('select.booleanlist', $this->getGalleryImageControlName('target', $key), $image['target'], $image['target']); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php }
                        }
                    }
                ?>
            </ul>
            <div class="uk-progress uk-progress-mini uk-margin-top uk-hidden">
                <div class="uk-progress-bar"></div>
            </div>     
        </div>
    </div>
</div>

<script>
    (function($){
        $(".<?php echo $this->identifier; ?> .fl-files").sortable({
            cursor: "move",
            helper: "original",
            tolerance: "pointer",
        });

        $('.<?php echo $this->identifier; ?>-galleryimage-fileupload').jbGalleryImageUpload({
            'uploadId': '<?php echo $this->identifier; ?>',
            'url' : '<?php echo JURI::root(); ?>media/zoo/applications/jbuniversal/elements/jbgalleryimage/upload/index.php',
            'maxNumberOfFiles' : <?php echo $params->get('max_number') ? $params->get('max_number') : 100; ?>,
            'previewMaxWidth' : <?php echo $params->get('thumb_width') ? $params->get('thumb_width') : 175; ?>,
            'previewMaxHeight' : <?php echo $params->get('thumb_height') ? $params->get('thumb_height') : 110; ?>,
            'maxFileSize' : <?php echo $params->get('max_upload_size') ? $params->get('max_upload_size')*1000 : 10000000 ?>,
            'imageMaxWidth' : <?php echo $params->get('max_width') ? $params->get('max_width') : 5000000; ?>,
            'imageMaxHeight': <?php echo $params->get('max_height')? $params->get('max_height') : 5000000; ?>,
            'deleteType' : '<?php echo $deleteOption; ?>',
            'userId' : '<?php echo $user_id; ?>',
            'trusted_mode' : '<?php echo $trusted_mode; ?>',
        }); 

        $(document).on('click', '.<?php echo $this->identifier; ?> .fl-galleryimage .fl-button-delete-full', function () {
            if (confirm('Изображение будет удалено с сервера. Вы уверены, что хотите удалить изображение?')) {
                $(this).parents('.fl-sort-images').remove();
                $(this).jbGalleryImageUpload('delete', {
                    'url' : $(this).data('url'),
                    'uploadId': '<?php echo $this->identifier; ?>',
                    'methodType': 'DELETE',
                    'userId' : '<?php echo $user_id; ?>'
                })
            };
        })

        $(document).on('click', '.<?php echo $this->identifier; ?> .fl-galleryimage .fl-button-delete-simple', function () {
            $(this).parents('.fl-sort-images').remove();
            $(this).jbGalleryImageUpload('updateImageCount', '<?php echo $this->identifier; ?>');
        })

        $(document).on('click', '.<?php echo $this->identifier; ?> .fl-alert .uk-close', function () {
            $(this).parent().addClass('uk-hidden').find('p').remove();
        })
    })(jQuery);
</script>