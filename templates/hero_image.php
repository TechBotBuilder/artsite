<?php

require_once '../sourcing/images.php';
require_once '../utils/sanitize.php';

function hero_image($title, $alt){
	$alt = sanitize\html_attr($alt);
	$title = sanitize\html_attr($title);
	echo "
<div class='hero'>

	<img class='hero-image' src='".images\full_source($title)."' alt='".$alt."' title=".$title.">
	
</div>
";
}

