<?php
namespace images;

require_once 'utils/sanitize.php';

function thumb_source($title){
	return \sanitize\filename($title) . '-thumb.jpg';
}

function full_source($title){
	return \sanitize\filename($title) . '.jpg';
}

