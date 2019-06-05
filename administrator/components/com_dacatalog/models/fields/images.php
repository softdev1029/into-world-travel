<?php
defined('JPATH_BASE') or die;

class JFormFieldImages extends JFormField
{
	protected $type = 'Images';

	protected function getInput()
	{
		if(!JFactory::getApplication()->input->get("isJFormFieldImages")) {
			JHtml::_('jquery.ui', array('core', 'sortable'));

			$script = ' jQuery(document).ready(function () {
				jQuery( ".delete" ).click(function () {
					jQuery(this).parent().remove();
				});

				jQuery(".sortable").sortable();
			});';

			JFactory::getDocument()->addScriptDeclaration( $script );
			JFactory::getDocument()->addStyleDeclaration( "
				ul.fotoDelete {list-style-type: none; margin: 0;}
				ul.fotoDelete li {position: relative; float: left;}
				ul.fotoDelete li img {cursor: move;}
				a.delete {position:absolute; right:10px; top:10px; cursor:pointer; color:red;}
				.images_titles {position: absolute;bottom: 10px;left: 10px;}
			" );

			JFactory::getApplication()->input->set("isJFormFieldImages", true);
		}

		$html = array();
		$html[] = '<input type="file" name="'.$this->name.'_add[]"  accept="image/*" multiple="true">';
		$html[] = '<input type="hidden" name="'.$this->name.'_sizes" value="'.$this->getAttribute("sizes").'">';
		$html[] = '<input type="hidden" name="'.$this->name.'_path" value="'.$this->getAttribute("path").'">';

		if($images = json_decode($this->value, true)) {
			if($this->getAttribute("title")) {
				$titles = json_decode($this->form->getValue($this->name.'_titles'), true);
			}


			$html[] = '<ul class="fotoDelete sortable">';
			foreach($images AS $i => $img) {
				$html[] = '<li>';
					$html[] = '<a class="delete"><span class="icon-cancel"></span></a>';
					$html[] = '<img src="'.$this->getAttribute("path").$this->getSmall($img).'">';
					$html[] = '<input type="hidden" name="'.$this->name.'[]" value="'.$img.'">';
					if($this->getAttribute("title"))
						$html[] = '<input class="images_titles" type="text" name="'.$this->name.'_titles[]" value="'.$titles[$i].'">';
				$html[] = '</li>';
			}
			$html[] = '</ul>';
		}

		return implode("\n", $html);
	}

	private function getSmall($img)
	{
		jimport('joomla.filesystem.file');

		if($this->getAttribute("sizes")) {
			$sizes = explode(" ", $this->getAttribute("sizes"));
			$size = $sizes[count($sizes) - 1];

			$thumb = JFile::stripExt($img)."_".$size.".".JFile::getExt($img);
			if(JFile::exists($this->getAttribute("path").$thumb))
				$img = $thumb;
		}

		return $img;
	}
}
