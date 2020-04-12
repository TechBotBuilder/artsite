<?php

include_once 'templates/common.php';

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
	<li><a href="new_work.php">Add a new painting</a></li>
	<li><a href="/works.php?edit">Edit existing work</a></li>
</div>

<div>
	<h3>Events</h3>
	<li><a href="new_event.php">Add a new event</a></li>
	<li><a href="events.php?edit">Edit existing events</a></li>
</div>

<div>
	<h3>Blogs</h3>
	<li><a href="new_blog.php">Make a new post</a></li>
	<li><a href="blog.php?edit">Edit existing blogs</a></li>
</div>

<div>
	<h3>Traffic <small>(<a href='traffic.php'>see detailed</a>)</small></h3>
	<div id="traffic-container">
		<canvas id="traffic-display"></canvas>
	</div>
</div>

<script>
window.onload = loadTrafficOverview;

function daysOfWeekTodayLast(){
	let days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	let today = (new Date()).getDay();
	for(let i=0; i<=today /*also move today to the end*/; i++){
		days.push(days.shift());
	}
	return days;
}

function loadTrafficOverview(){
	fetch('./traffic_data.php?what=views&when=', {credentials: 'same-origin'})
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			console.log(data);
			
			const pastweek_views = data.views;
			var ctx = document.getElementById('traffic-display').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: daysOfWeekTodayLast(),
					datasets: [{
						label: '# of views',
						data: pastweek_views,
						borderWidth: 1,
						xAxisID: 'Date',
						yAxisID: 'Views'
					}]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			})
		})
		.catch((error)=>{
			let errMsg = document.createElement('p');
			errMsg.classList.add('error');
			errMsg.innerHTML = error;
			document.getElementById('traffic-container').appendChild(errMsg);
		})
}
</script>


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