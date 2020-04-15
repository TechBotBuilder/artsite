<?php

namespace template;

require_once 'sourcing/images.php';
require_once 'utils/sanitize.php';

function tile($img){
	$alt = $img['description'];
	$id = $img['file'];
	$title = $img['title'];
	$medim = $img['medium'];
	$sold = !$img['available'];
	$alt = \sanitize\html_attr($alt);
	$tileid = 'tile-'+\sanitize\html_id($title);
	echo "
<div class='tile' id='".$tileid." '>

	<img class='tile-thumb' src='".\images\thumb_source($id, $title)."' alt='".$alt."'>
	
	<h2 class='tile-title'>".$title."</h2>
	
	<p class='tile-medium'>".$medium."</p>";
	
	if($sold) echo "<p class='tile-sold'>Sold</p>";
	echo "
	
</div>
";
}

