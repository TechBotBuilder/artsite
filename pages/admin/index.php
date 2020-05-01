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
	<li><a href="/events.php?edit">Edit existing events</a></li>
</div>

<div>
	<h3>Blogs</h3>
	<li><a href="new_blog.php">Make a new post</a></li>
	<li><a href="/blog.php?edit">Edit existing blogs</a></li>
</div>

<div>
	<h3>Traffic <small>(<a href='traffic.php'>see detailed</a>)</small></h3>
	<div id="traffic-container">
		<canvas id="traffic-display"></canvas>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

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

function sum_out(data){
	let result = {};
	for(let page of Object.keys(data)){
		for(let bucket of Object.keys(data[page])){
			if(!result.hasOwnProperty(bucket)){result[bucket] = 0;}
			result[bucket] += data[page][bucket];
		}
	}
	return result;
}

function daily_data_to_array(data){
	let result = [];
	const last_week = new Date();
	last_week.setDate(last_week.getDate()-6);//start last week
	
	let day_i = new Date(last_week);
	for(let day of Object.keys(data).sort()){
		let ymwd = day.split(" ");
		ymwd[1] -= 1;//php 1's, js 0's.
		let target_date = new Date(day_i);
			target_date.setFullYear(ymwd[0], ymwd[1], ymwd[3]);
		if(last_week <= target_date){
			while(day_i < target_date){
				result.push(0);
				day_i.setDate(day_i.getDate()+1);
			}
			result.push(data[day]);
			day_i.setDate(day_i.getDate()+1);
		}
	}
	
	while(result.length < 7){
		result.push(0);
	}
	
	return result;
}

function loadTrafficOverview(){
	fetch('/admin/traffic_data.php?start=last%20week&bucket=day', {credentials: 'same-origin'})
		.then((response) => {
			console.log(response);
			return response.json();
		})
		.then((data) => {
			console.log(data);
			
			var ctx = document.getElementById('traffic-display');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: daysOfWeekTodayLast(),
					datasets: [{
						label: 'General Page Views',
						data: daily_data_to_array(sum_out(data['general']))
					},
					{
						label: 'Content Page Views',
						data: daily_data_to_array(sum_out(data['content']))
					}]
				},
				options: {
					scales: {
						xAxes: [{ stacked: true }],
						yAxes: [{ stacked: true }]
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
template\end_content();
template\footer(array_rand($encouragement));
?>