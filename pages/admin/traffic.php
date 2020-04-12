<?php
//graphic traffic

include_once '../../templates/common.php';

template\header('Traffic - Tonya Ramsey Art');
template\start_content('Traffic to tonyaramseyart.com');

?>

<!-- overall views line graph -->
<div id="views-container">
	<canvas id="viewsGraph"></canvas>
</div>

<!-- Most viewed of each content type -->
<div id="most-viewed">
	
</div>

<!-- Twitter integration - recent mentions of the site/user -->
<div id="twitter-mentions">
	
</div>

<!-- fetch graph data -->
<script>
function updateGraph(since, til){
	fetch('./traffic_data.php?')
}
</script>

<?php
template\end_content();
template\footer();
?>