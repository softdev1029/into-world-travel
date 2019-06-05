<?php
defined('_JEXEC') or die;

class DacatalogModelImages extends JModelLegacy
{
	public function setImage($image, $path, $sizes = array() )
	{
		if(!$image['name']) return false;

		if(!JFolder::exists($path)) {
			JFolder::create($path);
		}

		$img = md5(microtime(true).mt_rand(100000000, 999999999)).".".JFile::getExt($image['name']);

		// Копируем оригинал
		$originalImg = $path.$img;
		JFile::copy($image['tmp_name'], $originalImg);

		// Копируем уменьшеную копию
		$image = new JImage( $originalImg );
		$image->createThumbs( $sizes, JImage::CROP_RESIZE, $path );

		return $img;
	}

	public function deleteImage($img)
	{
		//JFile::delete(JPATH_SITE.$img);
	}
}
