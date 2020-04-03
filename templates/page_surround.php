<?php
//page boundaries, eg
//header and footer

namespace template;

require_once "../utils/sanitize.php";
require_once "social_buttons.php";
require_once "nav_links.php";


/*
@param $browser_title: what to display in the tab of the user's browser
*/
function header($browser_title, $seo_description=''){
	$seo_description = \sanitize\html_attr($seo_description);
	?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $browser_title ?></title>
	<?php if($seo_description) echo '<meta name="description" content="'.$seo_description.'">'; ?>
	<link rel="stylesheet" href="/styles/normalize.css">
	<link rel="stylesheet" href="/styles/71836-styles.css">
	<link rel="stylesheet" href="/styles/layout_style.css">
	<link rel="stylesheet" href="/styles/color_style.css">
</head>
<body>
	<div class="overlay">
	<div class="nav-wrapper">
		<div class="close"><div class="circle"><i class="fa fa-close"></i></div></div>
		<nav class="mobile-nav">
		<?php nav_links($mobile=true); ?>
		</nav>
		<?php social_buttons(); ?>
		<p class="faso-contact-tagline"></p>
	</div>
	</div>
	
	<header class="header faso-header">
	<div class="row eyebrow">
		<div class="col-1-2">
			<div class="contact-tagline faso-contact-tagline"></div>
		</div>
		<div class="col-1-2">
			<?php social_buttons(); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-1-1 text-center">
		<div class="site-title faso-nav-heading"><a href="//www.tonyaramseyart.com/">Tonya Ramsey Fine Art</a></div>
		<nav class="main-nav faso-nav">
		<div class="hamburger"><i class="fa fa-bars"></i></div>
		<?php nav_links($mobile=false); ?>
		</nav>
		</div>
	</div>
	</header>
	<div class="content" style="padding-top: 150px;">

<?php
	//TODO move the styles to css

}//end of header();


/*
@param $html_insert: string of text or HTML to be put at bottom of page.
*/
function footer($html_insert=''){

echo '<footer class="footer faso-footer">';

if($html_insert){
	echo '<div class="callout gradient-bg">
		<div class="row">
			<div class="col-1-1 text-center">';
	echo $html_insert;
	echo '</div>
		</div>
	</div>';
}

echo '<div class="sub-footer">
	<div class="col-1-2 text-left-center">
		<div class="myic faso-myic"><a href="javascript:void(window.open(\'https://data.fineartstudioonline.com/follow/?admin_id=71836\',\'Get New Art Alerts\',\'status=1,toolbar=0,scrollbars=1,locationbar=0,menubar=0,resizable=1,width=640,height=480,left=256,top=192\').focus())" title="Get an automated email alert when Tonya Ramsey posts new art, Courtesy InformedCollector"><i class="fa fa-envelope"></i> &nbsp;Get New Art Alerts</a></div>
	</div>
	<div class="col-1-2 text-right-center">
		<span class="copyright">Artwork &copy; Tonya Ramsey '.date('Y').'. Remember to credit or link when you share.</span>
	</div>
</div>';

echo '</div>
</body>
';
}
