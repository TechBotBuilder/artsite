<?php
//image grid template

namespace template;

/*
 @param $images: array of image data.
 	each image should have keys `id`, `title`, ... to fill
 	the thumbnail/full image template.
 @param $style: 'thumbnail' or 'full'
*/
function image_grid(array $images, $style = 'thumbnail'){

$style = strtolower($style);//lowercase for 'if' comparison
if($style == 'thumbnail'){
	require_once "tile.php";
	$single_img_template = '\template\tile';
	
} elseif ($style == 'full') {
	require_once "full_image.php";
	$single_img_template = '\template\full_image';
	
}else{
	echo '<div class="error">Unsupported image grid style {'.$style.'}</div>';
	return false;
}

# we know which template to use for each image, display the grid!
echo '<div class="grid">';
foreach ($images as $id => $data) {
	//TODO $single_img_template($id, $data['title'], ...);
}
echo '</div>';

}