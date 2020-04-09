<?php

include_once '../../templates/common.php';

template\header('Workbench - Tonya Ramsey Art');
template\start_content('The Workbench');

?>
<!--
TODO
paintings overview
blogs overview
traffic overview

each:
 - further breakdowns on own page

-->

<div>
	<h3>Works</h3>
	<li><a href="new_work.php">Add new</a></li>
	<li><a href="/works.php?edit">Edit existing</a></li>
</div>

<div>
	<h3>Blogs</h3>
	<li><a href="new_blog.php">Add new</a></li>
	<li><a href="blog.php?edit">Edit existing</a></li>
</div>

<div>
	<h3>Traffic <small>(<a href='traffic.php'>see detailed</a>)</small></h3>
	<?php
	//TODO traffic graph generator? Current month?
	//fetch summary data via ajax or inject into document here.
	?>
</div>

<?php
$encouragement = [
'You are the artist',
'Good work',
'Happiness',
'Take deep breaths',
'You are good',
];
template\end_content(array_rand($encouragement));
template\footer();
?>