<?php

namespace template;

function pagination($last_page_num, $current_page_num) {
	echo '<div class="paginator">';
	echo '	<p>TODO paginator template.</p>';
	echo '	<p>Page '.$current_page_num.' of '.$last_page_num.'</p>';
	echo '</div>';
}