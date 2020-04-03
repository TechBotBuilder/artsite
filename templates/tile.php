<?php

namespace template;

require_once '../sourcing/images.php';
require_once '../utils/sanitize.php';

function tile($title, $medium, $size, $alt, $sold){
	$alt = \sanitize\htmlattr($alt);
	$tileid = 'tile-'+\sanitize\htmlid($title);
	echo "
<div class='tile' id='".$tileid."'>

	<img class='tile-thumb' src='".\images\thumb_source($title)."' alt='".$alt."'>
	
	<h2 class='tile-title'>".$title."</h2>
	
	<p class='tile-medium'>".$medium."</p>";
	
	if($sold) echo "<p class='tile-sold'>Sold</p>";
	echo "
	
</div>
";
}

