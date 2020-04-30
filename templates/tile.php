<?php

namespace template;

require_once 'sourcing/images.php';
require_once 'utils/sanitize.php';

function tile($img){
	$alt = $img['description'];
	$id = $img['file'];
	$title = $img['title'];
	$media = $img['media'];
	$size = $img['size'];
	$sold = !$img['available'];
	$alt = \sanitize\html_attr($alt);
	$tileid = 'tile-'.\sanitize\html_id($id);
	echo "
<div class='tile' id='".$tileid." '>

	<img class='tile-thumb' src='".\images\thumb_source($id, $title)."' alt='".$alt."'>
	
	<div class='tile-details'>
		<h2 class='tile-title'>".$title."</h2>
		<p class='tile-media'>".$media."</p>
		<p class='tile-size'>".$size."</p>";
		if($sold) echo "<p class='tile-sold'>Sold</p>";
	echo "</div>";
	
	if($sold) echo "<div class='tile-sold-icon'></div>";
	echo "
	
</div>
";
}

