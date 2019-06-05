<?php
/**
 * @package   FL Gallery Image Element for Zoo
 * @author    Дмитрий Васюков http://fictionlabs.ru
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class ElementJBImage
 */
class ElementJBGalleryImage extends Element implements iSubmittable
{
    /**
     * @var JBImageHelper
     */
    protected $_jbimagegallery = null;

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_jbimagegallery = $this->app->jbimage;
    }

    /**
     * Checks if the repeatables element's value is set.
     * @param array $params render parameter
     * @return bool true, on success
     */
    public function hasValue($params = array())
    {  
        $data = $this->data();
        $defaultImage = $this->getDefaultImage($params);

        $check = !empty($data);

        if (!$check && !$defaultImage) {
            return false;
        }

        return true;
    }

    /**
     * Get elements search data.
     * @return string Search data
     */
    public function getSearchData()
    {   
        $data = $this->data();
        $file = $this->get('images', 0);
        $check = !empty($data) || !empty($file);

        if ($check) {
            return "__IMAGES_EXISTS__";
        } else {
            return "__IMAGES_NO_EXISTS__";
        }
    }

    public function getGalleryImageControlName($name, $index = 0)
    {
        return "elements[{$this->identifier}][{$index}][{$name}]";
    }

    /**
     * Renders the element.
     * @param array $params render parameter
     * @return null|string HTML
     */
    public function renderFile ($params = array(), $image = array())
    {
        //init params
        $params = $this->app->data->create($params);

        // init vars
        $title  = $image['title'];
        $width  = (int)$params->get('width', 0);
        $height = (int)$params->get('height', 0);
        $alt    = $title = empty($title) ? $this->getItem()->name : $title;
        $url    = $imagePopup = $appendClass = $target = $rel = '';

        // get image
        if ($this->isFileExists($image['file'])) {
            $img = $this->_jbimagegallery->resize($image['file'], $width, $height);
        } else {
            $img = $this->getDefaultImage($params);
        }

        // select render template
        $template = $params->get('template', 'default');

        if ($template == 'link') {
            $url    = $image['link'];
            $rel    = $image['rel'];
            $target = (int)$image['target'] ? '_blank' : false;

        } elseif ($template == 'itemlink') {
            if ($this->getItem()->getState()) {
                $url   = $this->app->jbrouter->externalItem($this->_item);
                $title = empty($title) ? $this->getItem()->name : $title;
            }

        } elseif ($template == 'popup') {

            $appendClass = 'jbimage-gallery';
            if ((int)$params->get('group_popup', 1)) {
                $rel = 'jbimage-gallery-' . $this->getItem()->id;
            }

            $target = '_blank';

            $widthPopup  = (int)$params->get('width_popup');
            $heightPopup = (int)$params->get('height_popup');

            if ($img) {
                $url = $this->_jbimagegallery->getUrl($image['file']);
                if ($widthPopup || $heightPopup) {
                    $newImg = $this->_jbimagegallery->resize($img->orig, $widthPopup, $heightPopup);
                    $url    = $newImg->url;
                }
            }
        }

        // render layout
        if ($img && $layout = $this->getLayout('jbimage-' . $template . '.php')) {

            $unique = $params->get('_layout') . '_' . $this->_item->id . '_' . $this->identifier;

            return $this->renderLayout($layout, array(
                    'imageAttrs' => $this->_buildAttrs(array(
                        'class'         => 'jbimage ' . $unique,
                        'alt'           => $alt,
                        'title'         => $title,
                        'src'           => $img->url,
                        'width'         => $img->width,
                        'height'        => $img->height,
                        'data-template' => $template
                    )),
                    'linkAttrs'  => $this->_buildAttrs(array(
                        'class'  => 'jbimage-link ' . $appendClass . ' ' . $unique,
                        'title'  => $title,
                        'href'   => $url,
                        'rel'    => $rel,
                        'target' => $target,
                        'id'     => uniqid('jbimage-link-')
                    )),
                    'link'       => $url,
                    'image'      => $img
                )
            );
        }

        return null;
    }

    /**
     * @param array $attrs
     * @return string
     */
    public function _buildAttrs(array $attrs)
    {
        return $this->app->jbhtml->buildAttrs($attrs);
    }

    /**
     * Render
     * @param array $params
     */
    public function render($params = array())
    {   
        $result = array();
        $params = $this->app->data->create($params);

        $images = $this->get('images', 0);

        $images = !empty($images) ? $images : $this->data();

        //For default image
        if (empty($images)) {
            $images = array();
            $images[0] = null;
        }

        switch ($params->get('display', 'all')) {
            case 'first':
                $result[] = $this->renderFile($params, $images[0]);
                break;
            case 'all_without_first':
                array_shift($images);
                foreach ($images as $image) {
                    $result[] = $this->renderFile($params, $image);
                }
                break;
            case 'all':
            default:
                foreach ($images as $image) {
                    $result[] = $this->renderFile($params, $image);
                }
                break;
        }

        return $this->app->element->applySeparators($params->get('separated_by'), $result);
    }

    /**
     * Renders the edit form field.
     * @return string HTML
     */
    public function edit()
    {      
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/load-image.all.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/canvas-to-blob.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.iframe-transport.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload-process.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload-image.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload-validate.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/edit.js');
        $this->app->document->addStylesheet('elements:jbgalleryimage/assets/css/edit.css');

        $images = $this->get('images', 0);

        if (empty($images)) {
            $images = $this->data();
        }

        if ($layout = $this->getLayout('edit.php')) {
            return $this->renderLayout($layout,
                compact('images')
            );
        }

        return null;
    }

    /*
        Function: bindData
            Set data through data array.

        Parameters:
            $data - array

        Returns:
            Void
    */
    public function bindData($data = array()) {
        if (!empty($data)) {
            $data = array_values($data);
        }

        parent::bindData($data);
    }

    /**
     * Renders the element in submission.
     * @param array $params submission parameters
     * @return null|string|void
     */
    public function renderSubmission($params = array())
    {   
        // init vars
        $trusted_mode = $params->get('trusted_mode');

        $this->app->jbsession->set($this->identifier, null, 'jbgalleryimage_validate');

        $this->app->document->addScript('elements:jbgalleryimage/assets/js/load-image.all.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/canvas-to-blob.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.iframe-transport.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload-process.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload-image.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jquery.fileupload-validate.min.js');
        $this->app->document->addScript('elements:jbgalleryimage/assets/js/jbgalleryimage-upload.min.js');

        $images = $this->get('images', 0);

        if (empty($images)) {
            $images = $this->data();
        }

        if ($layout = $this->getLayout('submission.php')) {
            return $this->renderLayout($layout,
                compact('images', 'trusted_mode')
            );
        }

        return null;
    }

    /**
     * Validates the submitted element
     * @param AppData $value  value
     * @param AppData $params submission parameters
     * @return array
     * @throws AppValidatorException
     */
    public function validateSubmission($value, $params)
    {   
        $result = array();
        $trusted_mode = $params->get('trusted_mode');

        foreach ($value as $key => $single_value) {
            try {

                $result[$key]['file'] = $this->app->validator->create('string', array('required' => true))->clean($single_value['file']);
                if ($trusted_mode) {
                    $result[$key]['title']  = $this->app->validator->create('string', array('required' => false))->clean($single_value['title']);
                    $result[$key]['link']   = $this->app->validator->create('url', array('required' => false), array('required' => 'Please enter an URL.'))->clean($single_value['link']);
                    $result[$key]['target'] = $this->app->validator->create('', array('required' => false))->clean($single_value['target']);
                    $result[$key]['rel']    = $this->app->validator->create('string', array('required' => false))->clean($single_value['rel']);
                }

            } catch (AppValidatorException $e) {

                if ($e->getCode() != AppValidator::ERROR_CODE_REQUIRED) {
                    throw $e;
                }
            }
        }

        if ($params->get('required') && !count($result)) {
            if (isset($e)) {
                throw $e;
            }
            throw new AppValidatorException('This field is required');
        }
        return $result;
    }

    /**
     * Get upload image path
     * @return string
     */
    protected function getUploadImagePath()
    {   
        $item = $this->getItem();
        $uploadByUser    = (int)$this->config->get('upload_by_user', 0);
        $uploadByDate    = (int)$this->config->get('upload_by_date', 0);
        $uploadDirectory = trim(trim($this->config->get('upload_directory', 'images/zoo/uploads/')), '\/');

        if ($uploadByUser) {
            if ($item->id) {
                $user_id = ($item->created_by) ? $item->created_by : 'quest';
            } else {
                $user = JFactory::getUser();
                $user_id = $user->id;
            }
            $uploadDirectory .= '/'.$user_id;

            return JPath::clean($uploadDirectory);
        } 

        if ($uploadByDate) {
            $uploadDirectory .= '/'.date("d-m-Y");
            return JPath::clean($uploadDirectory);
        }

        return JPath::clean($uploadDirectory);
    }

    /**
     * Get uploaded file path 
     * @return string
     */

    protected function getUploadedFilePath($userfile)
    {
        $basePath = JPATH_ROOT . '/' . $this->getUploadImagePath() . '/';
        $file     = $basePath . $userfile;

        return JPath::clean($this->app->path->relative($file));
    }

    /**
     * Get default image
     * @param JSONData $params
     * @return null|object
     */
    protected function getDefaultImage($params)
    {
        $params = $this->app->data->create($params);

        // init vars
        $width         = (int)$params->get('width', 0);
        $height        = (int)$params->get('height', 0);
        $defaultImage  = $this->config->get('default_image');
        $defaultEnable = (int)$this->config->get('default_enable', 0);

        $result = null;

        if ($defaultEnable && $defaultImage) {

            if (strpos($defaultImage, 'http') !== false) {

                return (object)array(
                    'width'   => $width,
                    'height'  => $height,
                    'path'    => $defaultImage,
                    'orig'    => $defaultImage,
                    'origUrl' => $defaultImage,
                    'url'     => $defaultImage,
                    'rel'     => $defaultImage,
                );

            } else {
                return $this->_jbimagegallery->resize($defaultImage, $width, $height);
            }
        }

        return null;
    }

    /**
     * Is file exists
     *
     * @param string $imagePath
     *
     * @return bool
     */
    protected function isFileExists($imagePath)
    {
        if (strpos($imagePath, 'http') !== false) {
            return true;

        } else if (JFile::exists($imagePath) || JFile::exists(JPATH_ROOT . '/' . $imagePath)) {
            return true;
        }

        return false;
    }

    /**
     * Trigger on item delete
     */
    public function triggerItemDeleted()
    {
        $removeWithItem = (int)$this->config->get('remove_with_item');
        if (!$removeWithItem) {
            return null;
        }

        $result = array();
        $images = $this->data();

        foreach ($images as $key => $image) {
            $result[] = $this->deleteFile($image['file']);

        }

        return $result;
    }

    /**
     * Each image delete
     */
    protected function deleteFile($file) {
        if (JFile::exists(JPATH_ROOT . '/' . $file)) {
            return JFile::delete(JPATH_ROOT . '/' . $file);
        }
        return null;
    }
}