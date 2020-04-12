<?php

if ($_SERVER['REQUEST_METHOD'] = 'POST' && !empty($_FILES['img']))
{
	
	// make sure file is an image.
	// if add to this list, be sure to implement logic in the switch before conversion to progressive jpeg
	$accepted_mimetypes = ['jpeg', 'png', 'gif'];
	//check mime type
	$full_mimetype = mime_content_type($_FILES['img']['tmp_name']);
	$sub_mimetype_idx = strrpos($full_mimetype, '/');
	$mimetype = $sub_mimetype_idx === false
		? ''
		: substr($full_mimetype, $sub_mimetype_idx+1);
	if(!in_array($mimetype, $accepted_mimetypes)){
		http_resonse_code(415);// 'Unsupported media type' Error code
		echo "Error - '$mimetype' is not an allowed image format (try: "
			. implode(', ', $accepted_mimetypes)."). Work was not added.";
		exit();
	}
	
	
	// insert into database before saving the image so we can save the image with the ID
	$query = 'INSERT INTO images (`title`, `size`, `media`, `price`, `show_price`, `available`, `description`, `narrative`, `tags`) VALUES (:title, :size, :price, :show_price, :available, :description, :narrative, :tags)';
	require_once "../../utils/sanitize.php";
	$values = array(
		'title'=>trim($_POST['title']),
		'size'=>trim($_POST['size']),
		'media'=>trim($_POST['media']),
		'price'=>(float)$_POST['price'],
		'show_price'=>sanitize\checkbox_to_bool($_POST['show_price']??'no'),
		'available'=>sanitize\checkbox_to_bool($_POST['available']??'no'),
		'description'=>trim($_POST['description']),
		'narrative'=>trim($_POST['narrative']),
		'tags'=>trim($_POST['tags'])
	);
	require_once "../../databases/query.php";
	database\query($query, $values);
	$id = database\query('SELECT LAST_INSERT_ID()', null, true)[0];
	
	
	
	// save various versions of the file.
	$file_name_title_portion = sanitize\filename('.' . $_POST['title'] . '.jpg');
	$file_id = $id;
	$file_name = $file_id . $file_name_title_portion;
	
	require_once '../../utils/filesystem.php';
	
	// the raw upload
	$target_raw = filesystem\get_safe_dir('./full_images/').$file_name;
	if(file_exists($target_raw)){
		//backup the old file
		$backup_start = explode('.', $target_raw);
		$backup_ext = '.'.array_pop($backup_name);
		$backup_start = implode('.', $backup_name).'.old';
		$backup_id = 1;
		$backup_name = $backup_start . $backup_id . $backup_ext;
		//find an appropriate filename to save to
		while(file_exists($backup_name)){
			$backup_id += 1;
			$backup_name = $backup_start . $backup_id . $backup_ext;
		}
		rename($target_raw, $backup_name);
	}
	//save the new file
	move_uploaded_file($_FILES['img']['tmp_name'], $target_raw);
	
	//convert to progressive JPEG for files that will be served to the public
	//load image into memory
	switch($mimetype){
		case 'jpeg':
			$image = imagecreatefromjpeg($target_raw);
			break;
		case 'png':
			$image = imagecreatefrompng($target_raw);
			break;
		case 'gif':
			$image = imagecreatefromgif($target_raw);
		default:
			//may break (throw an error or superbly fail) or may be fine
			$image = imagecreatefromstring(file_get_contents($target_raw));
			break;
	}
	imageinterlace($image, true);
	
	// a thumbnail
	$target_thumb = filesystem\get_safe_dir('../images/thumbs/').$file_id;
	//420px width, low quality jpeg
	$thumb_width = 400;
	$thumb_jpeg_quality = 65; //Percentage. For comparison, default is 75.
	$thumb = imagescale($image, $thumb_width);
	imagejpeg($thumb, $target_thumb, $thumb_jpeg_quality);
	imagedestroy($thumb);
	
	// the big image to display
	// save big image by file_name, not id, so scrapers have a tiny bit harder time.
	$target_big = filesystem\get_safe_dir('../images/big/').$file_name;
	//1024px max side length, high quality jpeg
	$bigimg_jpeg_quality = 75;
	$bigimg_new_max_size = 1024;
	list($img_w, $img_h) = array(imagesx($image), imagesy($image));
	$biggest_side = max($img_w, $img_h);
	$bigimg_new_max_size = min($bigimg_new_max_size, $biggest_side);
	$bigimg_scale_factor = $bigimg_new_max_size / $biggest_side;
	$new_w = $img_w * $bigimg_scale_factor;
	$new_h = $img_h * $bigimg_scale_factor;
	$bigimg = imagescale($image, $new_W, $new_h);
	imagedestroy($image);
	//Add copyright transparent splash
	$stamp_alpha = 5; //percent (0-100), lower for more transparent copyright
	$stamp_font = 2;
	$stamp_scale = 0.7;
	$stamp = imagecreatetruecolor(128,16);
	//get the main color
	require_once '../../utils/get_color.php';
	$rgb = explode(',', image\mainColor($bigimg));
	$stamp_color = imagecolorallocate($stamp, hexdec($rgb[0]), hexdec($rgb[1]), hexdec($rgb[2]));
	//create the copyright message and resize it
	imagestring($stamp, $stamp_font, 0, 0, '(c)tonyaramseyart.com', $stamp_color);
	$sstamp = imagescale($stamp, imagesx($bigimg) * $stamp_scale);
	imagedestroy($stamp);
	//put copyright message on the image
	imagecopymerge($bigimg, $sstamp,
		imagesx($bigimg) * (1-$stamp_scale)/2, (imagesy($bigimg)/2) - (imagesy($sstamp)/2),
		0, 0, imagesx($sstamp), imagesy($sstamp),
		$stamp_alpha);
	imagedestroy($stamp);
	// save the copyrighted big image!
	imagejpeg($bigimg, $target_big, $bigimg_jpeg_quality);
	imagedestroy($bigimg);
	
	exit(); //no need to render whole thing, just tell them submission is good.
}



include_once '../../templates/common.php';

template\header('+ Work - Tonya Ramsey Art');
template\start_content('Yay!!! New Art!!!');

?>


<!-- upload form -->
<!-- source https://www.sitepoint.com/tracking-upload-progress-with-php-and-javascript/ -->
<link rel="stylesheet" type="text/css" href="upload.css">
<link rel="stylesheet" type="text/css" href="forms.css">

<div id="bar_blank">
	<div id="bar_color"></div>
</div>
<div id="status"></div>

<form id="progressForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" target='hidden_upload_iframe'>
	
	<div class='form-group'>
		
		<label>Title
			<input type='text' name='title' maxlength='255' required>
		</label>
		
		<label>Size
			<input type='text' name='size' maxlength='255'>
		</label>
		
		<label>Media
			<input type='text' name='media' maxlength='255'>
		</label>
		
		<label class='switch'>Show price?
			<input type='checkbox' name='show_price'>
			<span class='slider round'></span>
		</label>
		
		<label>Price
			<input type='text' name='price' maxlength='10'> $
		</label>
		
		<label class='switch'>Available
			<input type='checkbox' name='available'>
			<span class='slider round'></span>
		</label>
		
		<label>Description <small>(your thoughts)</small>
			<textarea name='description' maxlength='65535' rows='5'></textarea>
		</label>
		
		<label>Narrative <small>(for visually impared)</small>
			<textarea name='narrative' maxlength='65535' rows='5'></textarea>
		</label>
		
		<label>Tags <small>(for custom searches - no need to repeat title/media/description/narrative details)</small>
			<textarea name='tags' maxlength='255' placeholder='comma separated tags' rows='3'></textarea>
		</label>
		
	</div>
	
	<div class='form-group'>
		<input type="hidden"
			name="<?php echo ini_get('session.upload_progress.name'); ?>"
			value="work_image" >
		<label>
			<input type="file" name="img">
			Select image to upload
		</label>
	</div>
	
	<input type="submit" value="Post this thing!">

</form>

<iframe id="hidden_upload_iframe" name="hidden_upload_iframe" src="about:blank"></iframe>
<script type="text/javascript" src="upload.js"></script>
<!-- /upload form -->


<?php
template\end_content();
template\footer();
?>