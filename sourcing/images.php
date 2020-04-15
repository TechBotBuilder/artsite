<?php
namespace images;

require_once 'utils/sanitize.php';

function get_base_name($id, $title){                  
	$file_name_title_portion = sanitize\filename('.' . $title. '.jpg');
	$file_name = $id . $file_name_title_portion;
	return  $file_name;
}

function full_source($id, $title){
	return '/images/big/' . get_base_name($id, $title);
}

function thumb_source($id, $title){
	return '/images/thumbs/' . get_base_name($id, $title);
}
