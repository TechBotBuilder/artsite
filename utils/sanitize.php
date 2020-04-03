<?php

namespace sanitize;

/*
sanitize.php

Makes the website hiccup-free

useful when combining things, like putting quotes into html attributes.

use in another file:
	require_once '../utils/sanitize.php';
	$src = sanitize\filename('My file name.jpg');
*/


/*
into an html text-y attribute
eg putting information into an image's 'alt' attribute
*/
function html_attr($text){
	return \addslashes($text);
}

/*
into an html id-like attribute
eg putting info into a paragraphs 'class' or 'id'
*/
function html_id($text){
	//keep letters, numbers, dashes, and underscores
	return \mb_ereg_replace("(^\w\d\-_)", '', $text);
}

/*
into a URL/filename
eg converting an image title into its URL/filename
*/
function filename($name){
	//replace spaces with underscores
	$name = \preg_replace("(\s)", "_", $name);
	//keeps letters, numbers, dashes, underscores, and dots
	$name = \mb_ereg_replace("(^\w\d\-_.)", '', $name);
	//get rid of .., ..., etc, since they can be used to do bad things
	$name = \mb_ereg_replace("([\.]{2,})", '', $name);
	return $name;
}