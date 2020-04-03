<?php
//templates that should go around the main stuff on the page.
namespace template;

/*content start template
@param $page_title: what to show as the title on the page.
	if empty, no page title section will be added to the document.
*/
function start_content($page_title){

	if($page_title) {
	?>
	
	<div class="page-title gradient-bg">
		<div class="row">
			<div class="col-1-1">
				<h1><?= $page_title ?></h1>
			</div>
		</div>
	</div>
	
	<?php
	}//end $page_title optional content
	
	echo '<div class="row">';

}//end content_start();


//content end template
// use at end of main content on the page, but before using the footer
function end_content(){
	
	echo '</div>
	</div>';
	
}
