<?php
ini_set('memory_limit', '100M');
//require_once 'intranet/util/config.php';


//die(BASEIMG.$_REQUEST['img']);
$pathImg = 'http://uniten2015.dev/files/';
// $pathImg = '/home/unitenso/public_html/files/';
$tipo = getimagesize($pathImg.$_REQUEST['img'],$info);


$width = $_REQUEST['w'];
$height = $_REQUEST['h'];



if($tipo[2] == '2'){
//if(no_exploit($_REQUEST['ext']) == "jpg" || no_exploit($_REQUEST['ext']) == "JPG" || no_exploit($_REQUEST['extensao']) == "jpeg" || no_exploit($_REQUEST['extensao']) == "JPEG"){
		header("Content-type: image/jpeg"); 
		$im = $pathImg.$_REQUEST['img'];

					list($width_orig, $height_orig) = getimagesize($im);

					//$width = 100;
					//$height = 100;
					
					if ($width_orig < $width) {
						$width = $width_orig; } else { $width = $_REQUEST['w']; }

					if ($height_orig < $height) {
						$height = $height_orig; } else { $height = $_REQUEST['h']; }

					if ($width && ($width_orig < $height_orig)) {
					   $width = ($height / $height_orig) * $width_orig;
					} else {
					   $height = ($width / $width_orig) * $height_orig;
					}

					$image_p = imagecreatetruecolor($width, $height);
					$im = imagecreatefromjpeg($im);
					imagecopyresampled($image_p, $im, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		imagejpeg($image_p,'',95);
		imagedestroy($image_p);
		imagedestroy($im);
}

else if($tipo[2] == '1'){
//else if(no_exploit($_REQUEST['ext']) == "gif" || no_exploit($_REQUEST['ext']) == "GIF"){
		header("Content-type: image/gif"); 
		$im = $pathImg.$_REQUEST['img'];

					list($width_orig, $height_orig) = getimagesize($im);

					//$width = 100;
					//$height = 100;
					
					if ($width_orig < $width) {
						$width = $width_orig; } else { $width = $_REQUEST['h']; }

					if ($height_orig < $height) {
						$height = $height_orig; } else { $height = $_REQUEST['h']; }

					if ($width && ($width_orig < $height_orig)) {
					   $width = ($height / $height_orig) * $width_orig;
					} else {
					   $height = ($width / $width_orig) * $height_orig;
					}

					$image_p = imagecreatetruecolor($width, $height);
					$im = imagecreatefromgif($im);
					imagecopyresampled($image_p, $im, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		imagegif($image_p,'',95);
		imagedestroy($image_p);
		imagedestroy($im);
}
?>