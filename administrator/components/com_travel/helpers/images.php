<?php
class IMG {
    
function greate_Image_en
 ($width_m,
  $height_m,
  $width_s,
  $height_s,
  $max_size,
  $nm, 
  $path, 
  $files="foto", 
  $arr = false, 
  $n = 0)
{  	
 
  if (!is_dir($path))
  {
    mkdir($path);
  }
  
 
$params = JComponentHelper::getParams('com_travel');
$image = null;
$image_icon = null;
$upload = array();
$namer=null;
$err = array();

 if (!$arr) {
$fileI = $_FILES[$files];
$fsize =  $fileI['size'];
$fnameT =  $fileI['tmp_name'];
$Fname =  $fileI['name'];
}

else {$fileI = $_FILES[$files];

$fsize =  $fileI['size'][$n];
$fnameT =  $fileI['tmp_name'][$n];
$Fname =  $fileI['name'][$n];
}
 
 
 if ( $fsize  <= $max_size)
 {
$info = @getimagesize($fnameT);
 if (preg_match('{image/(.*)}is', $info['mime'], $p))
  {
$uploaddir = $path;
$secret=rand(1000,9000);
$nam=$Fname;
$ext = strrchr($nam, ".");

$namer=travelHelper::getAliasName((substr($nam,0,strlen($nam)-4)));

$namer=$secret.$namer.$ext;
$uploadfile = $uploaddir.$namer;
if (move_uploaded_file($fnameT, $uploadfile))
{$sop =1;
$real_path = realpath($path.$namer);
   $file = $real_path;
   chmod($file, 0777);
}
else { $err[] = "При передачи изображения вы потерпели неудачу.";}
}
else  $err[] = "Файл не изображение";
}
else $err[] = "Размер изображения больше $max_size кб.";

 

         if ((count($err)==0)){
       IMG::resize_image($path.$namer, $path."m_".$namer, $width_m,$height_m, 100,null,null);
       
      
       IMG::resiz ($path.$namer,$path.$namer,$width_s,$height_s,$width_s,$path."s_".$namer);
         
      // ShopHelper::resiz ($path.$namer,$path.$namer,359,225,359,$path."m_".$namer);
       
      // $a = ShopHelper::whiteG($path."s_".$namer,JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS."b.png");
      // if ($a) $fi = 'a.png'; else $fi = 'b.png';
      
       $img = $params->get('water',null);
       if ($img)
       IMG::AddWatermark($path.$namer,JPATH_SITE.DS."images".DS.$img, $path.$namer);
      
        
       if ($img)
       IMG::AddWatermark($path."m_".$namer,JPATH_SITE.DS."images".DS.$img,$path."m_".$namer);
     // if ($img)
       //IMG::AddWatermark($path."s_".$namer,JPATH_SITE.DS."images".DS.$img,$path."s_".$namer);
      // $a = ShopHelper::whiteG($path."r_".$namer,JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS."b.png");
      // if ($a) $fi = 'a.png'; else $fi = 'b.png';
      // ShopHelper::AddWatermark($path."r_".$namer, JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS.$fi, $path."r_".$namer);
      
      
      /* $a = ShopHelper::whiteG($path."m_".$namer,JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS."b.png");
       if ($a) $fi = 'a.png'; else $fi = 'b.png'; 
       ShopHelper::AddWatermark($path."m_".$namer, JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS.$fi, $path."m_".$namer);
       
       
        $a = ShopHelper::whiteG($path.$namer,JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS."b.png");
       if ($a)
       $fi = 'a.png';
       else
       $fi = 'b.png';
       ShopHelper::AddWatermark($path.$namer, JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS.$fi, $path.$namer);
       */
       // ShopHelper::resizeImg($path.$namer, $path.$namer, $width_m,$height_m, $path."m_".$namer, $params->get('water',null), $params->get('alpha',50));
       //ShopHelper::resizeImg($path.$namer,$path.$namer,$width_s,$height_s,$path."s_".$namer);
        }
$mas=array();
$mas['filename']=$namer;
$mas['err']=$err;
return  $mas;
}

function AddWatermark( $src, $watermark, $dest, $x=0, $y=0, $quality=100, $toscreen=0) { 
 
 
   $imgInfo = getimagesize($src);
   $format = strtolower(substr($imgInfo['mime'], strpos($imgInfo['mime'], '/')+1));
 
                    if (!file_exists($src) || !file_exists($watermark)) return false; 
 
                    $srcSize = getimagesize($src);
                    $watermarkSize = getimagesize($watermark); 
 
                    if (($srcSize === false)||($watermarkSize === false)) return false; 
 
                    // Определяем исходный формат по MIME-информации, предоставленной
                    // функцией getimagesize, и выбираем соответствующую формату
                    // imagecreatefrom-функцию.
                    $srcFormat = strtolower(substr($srcSize['mime'], strpos($srcSize['mime'], '/')+1));
                    $srcIcFunc = "imagecreatefrom" . $srcFormat;
                    if (!function_exists($srcIcFunc)) die('Critical error: GD lib not found!'); 
 
                    $watermarkFormat = strtolower(substr($watermarkSize['mime'], strpos($watermarkSize['mime'], '/')+1));
                    $watermarkIcFunc = "imagecreatefrom" . $watermarkFormat;
                    if (!function_exists($watermarkIcFunc)) die('Critical error: GD lib not found!'); 
 
                    $isrc = $srcIcFunc($src);
                    $iwatermark = $watermarkIcFunc($watermark);
                    $idest = imagecreatetruecolor($srcSize[0], $srcSize[1]);
                    
                    
                    if ($format == 'png'){
    	imagealphablending($idest, false);
		imagesavealpha($idest, true);
		}
                    
                    imagecopyresampled($idest, $isrc, 0,0,0, 0, $srcSize[0], $srcSize[1], $srcSize[0], $srcSize[1]); 
 
                    $watermark_width = $watermarkSize[0];
                    $watermark_height = $watermarkSize[1];
                    
                    //$dest_x = $srcSize[0]/2 - $watermark_width/2; // правый
                    //$dest_y = ($srcSize[1]/2) - ($watermark_height/2); // нижний угол изображения
                    
                    $dest_x = $srcSize[0] - $watermark_width - 10+$x; // правый
                    $dest_y = $srcSize[1] - $watermark_height - 10+$y; // н
                    
            
                    
                    imagecopy($idest, $iwatermark,$dest_x, $dest_y,0,0, $watermark_width, $watermark_height); 
 
                    if ($toscreen) {
                        header('Content-Type: image/jpeg');
                        imagejpeg($idest);
                        imagedestroy($isrc);
                        imagedestroy($iwatermark);
                        imagedestroy($idest);
                    } else {
                       
                       if ($format == 'png')
                        imagepng($idest, $dest); 
                        else     
                        imagejpeg($idest, $dest, $quality);
                        imagedestroy($isrc);
                        imagedestroy($iwatermark);
                        imagedestroy($idest);
                   
                   
                    }
                    return true;
}  
function resize_image2($pathSrc, $pathOut, $maxWidth=100, $maxHeight=100, $imgQuality=100, $water1=null, $alpha = 50)
{
       if (!is_file($pathSrc)) {
        return false;
    }

   $imgInfo = getimagesize($pathSrc);
   $format = strtolower(substr($imgInfo['mime'], strpos($imgInfo['mime'], '/')+1));




    $iwidth = $imgInfo[0];
    $iheight = $imgInfo[1];

if ($iwidth<$maxWidth) $maxWidth=$iwidth;
if ($iheight<$maxHeight) $maxHeight=$iheight;


    if ($iwidth > $iheight) {
        $width  = $maxWidth;
        $height = $maxWidth * $iheight / $iwidth;
    } else {
        $width  = $maxHeight * $iwidth / $iheight;
        $height = $maxHeight;
    }

    if ($imSrc = @imagecreatefromstring(file_get_contents($pathSrc))) {
        $imOut = imagecreatetruecolor($width, $height);

if ($format == 'png'){
    	imagealphablending($imOut, false);
		imagesavealpha($imOut, true);
		}

        imagecopyresampled($imOut, $imSrc, 0, 0, 0, 0, $width, $height, $iwidth, $iheight);

    } else {
        return false;
    }



    //ЕСли png
if ($format == 'png'){
 $trans = imagecolorat($dest,0,0);
 imagepng($imOut,$pathOut);
		}
		else
		 imagejpeg($imOut, $pathOut, $imgQuality);


 
     


}
function resize_image($pathSrc, $pathOut, $maxWidth=100, $maxHeight=100, $imgQuality=80, $water1=null, $alpha = 50)
{
       if (!is_file($pathSrc)) {
        return false;
    }
    
    
   $src = $pathSrc; 
   $crop = true; 
   $zoom = false;   
   
   
   $size = getimagesize($src);
   $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));

// создаём исходное изображение на основе
// исходного файла и опеределяем его размеры
   if ($format == 'jpg' || $format == 'jpeg') $src = imagecreatefromjpeg($src);
   if ($format == 'gif') $src = imagecreatefromgif($src);
   if ($format == 'png') $src = imagecreatefrompng($src);
   
   
   
   
   
   $srcWidth = imagesx($src); 
   $srcHeight = imagesy($src); 
       
   $k = $crop ? min($srcHeight/$maxHeight, $srcWidth/$maxWidth) : max($srcHeight/$maxHeight, $srcWidth/$maxWidth); 
   $k = (!$zoom && $k < 1) ? 1 : $k; 
   
   
   $xDiff = (($srcWidth/$k) - $maxWidth > 0) ? (($srcWidth/$k) - $maxWidth) : 0;
    
   $yDiff = (($srcHeight/$k) - $maxHeight > 0) ? (($srcHeight/$k) - $maxHeight): 0; 
   $dst = imagecreatetruecolor($srcWidth/$k-$xDiff, $srcHeight/$k-$yDiff); 
   
   if ($format == 'png'){
    	imagealphablending($dst, false);
		imagesavealpha($dst, true);
		}
   
   
   imagecopyresampled($dst, $src, 0, 0, $xDiff/2*$k, $yDiff/2*$k, $srcWidth/$k-$xDiff, $srcHeight/$k-$yDiff, $srcWidth-$xDiff*$k, $srcHeight-$yDiff*$k);  


 
 if ($format == 'png')

 imagepng($dst, $pathOut);
 else
imagejpeg($dst, $pathOut, $imgQuality);
 
/*
   $imgInfo = getimagesize($pathSrc);
   $format = strtolower(substr($imgInfo['mime'], strpos($imgInfo['mime'], '/')+1));




    $iwidth = $imgInfo[0];
    $iheight = $imgInfo[1];

if ($iwidth<$maxWidth) $maxWidth=$iwidth;
if ($iheight<$maxHeight) $maxHeight=$iheight;


    if ($iwidth > $iheight) {
        $width  = $maxWidth;
        $height = $maxWidth * $iheight / $iwidth;
    } else {
        $width  = $maxHeight * $iwidth / $iheight;
        $height = $maxHeight;
    }

    if ($imSrc = @imagecreatefromstring(file_get_contents($pathSrc))) {
        $imOut = imagecreatetruecolor($width, $height);

if ($format == 'png'){
    	imagealphablending($imOtu, false);
		imagesavealpha($imOut, true);
		}

        imagecopyresampled($imOut, $imSrc, 0, 0, 0, 0, $width, $height, $iwidth, $iheight);

    } else {
        return false;
    }



    //ЕСли png
if ($format == 'png'){
 $trans = imagecolorat($dest,0,0);
 imagepng($imOut,$pathOut);
		}
		else
		 

*/



  // if (!empty($water1))
  //ShopHelper::water_adds(JPATH_SITE.DS.'images'.DS.$water1,$pathOut, $alpha);


}
	
 function resiz ($f,$src,$w,$h,$q,$src1) {
// f - имя файла 
// q - качество сжатия 
// src - исходное изображение 
// dest - результирующее изображение 
// w - ширниа изображения 
// ratio - коэффициент пропорциональности 



   $size = getimagesize($f);
   $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));

// создаём исходное изображение на основе
// исходного файла и опеределяем его размеры
   if ($format == 'jpg' || $format == 'jpeg') $im = imagecreatefromjpeg($src);
   if ($format == 'gif') $im = imagecreatefromgif($src);
   if ($format == 'png') $im = imagecreatefrompng($src);

$w_src = imagesx($im); 
$h_src = imagesy($im);

if ($w_src != $w) 
 {

         // создаём пустую квадратную картинку 
         // важно именно truecolor!, иначе будем иметь 8-битный результат 
         $dest = imagecreatetruecolor($w,$h);



if ($format == 'png'){
    	imagealphablending($dest, false);
		imagesavealpha($dest, true);
		}
         // вырезаем квадратную серединку по x, если фото горизонтальное 
         if ($w_src>$h_src) 
         imagecopyresampled($dest, $im, 0, 0,
         round((max($w_src,$h_src)-min($w_src,$h_src))/2), 0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

         // вырезаем квадратную верхушку по y,
         // если фото вертикальное (хотя можно тоже серединку)
         if ($w_src<$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
                          min($w_src,$h_src), min($w_src,$h_src)); 

         // квадратная картинка масштабируется без вырезок 
         if ($w_src==$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);

        //imagefilter($dest);
            
 } else {
 
         // создаём пустую квадратную картинку 
         // важно именно truecolor!, иначе будем иметь 8-битный результат 
         $dest = imagecreatetruecolor($w,$h);
         
         
         if ($format == 'png'){
      imagealphablending($dest, false);
		imagesavealpha($dest, true);
		}
         imagecopyresized($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);

         imagefilter($dest, 3);
         
    }
     // вывод картинки и очистка памяти

//

//ЕСли png
if ($format == 'png'){

 imagepng($dest,$src1);
		}
		else
		imagejpeg($dest,$src1,$q);


//ShopHelper::water_adds(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS."a.png",$src1, 100);
//ShopHelper::AddWatermark($src1, JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_shop'.DS.'assets'.DS.'images'.DS."b.png", $src1);
    imagedestroy($dest);


} 

	function deleteImages ($filename, $put = null)
	{					
	   if (!$put)
	   $put = JPATH_SITE."/components/com_gaz/images/items/";
	if (JFile::exists($put.'m_'.$filename))	{JFile::delete($put.'m_'.$filename);}
    if (JFile::exists($put.'s_'.$filename))	{JFile::delete($put.'s_'.$filename);}
    if (JFile::exists($put.$filename))	{JFile::delete($put.$filename);}
	}  	

}
?>