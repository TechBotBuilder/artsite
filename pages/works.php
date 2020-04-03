<?php

# get the page
$this_page = 1;//default page
//check if the user requested a different pageworks?page=...
if(isset($_GET['page'])){
	$user_page_num = $_GET['page']; //get ... part of url  tonyaramseyart.com/
	if(is_integer($user_page_num)) { //verify user entered 1,2,... not insanity
		$this_page = int($user_page_num);
		if ($this_page<=0) $this_page=1;
	}
}
//note we could do other things than pages.
// Perhaps page by month+year, if many spread to multiple pages within that month+year, or if few fill in with previous month.
// Perhaps page starting from a certain image, so results are bookmarkable, and it's not as complicated as the month option.
//But we arent' implementing either yet.


# get the images for this page
//TODO database call
$images = [];
$num_pages = 0;//TODO populate based on DB call results.


# layout on the page
require_once "../templates/common.php";

$title = "Portfolio of Works";
template\header("Tonya Ramsey - ".$title);

template\start_content($title);

require_once "../databases/list_works.php";

require_once "../templates/image_grid.php";
template\image_grid($images);

require_once "../templates/pagination.php";
template\pagination($num_pages, $this_page);

template\end_content();
template\footer();




?>