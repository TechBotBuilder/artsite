<?php
namespace images;

require_once '../utils/sanitize.php';

function thumb_source($title){
	return \sanitize\file($title) . '-thumb.jpg';
}

function full_source($title){
	return \sanitize\file($title) . '.jpg';
}

