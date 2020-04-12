<?php

session_start();

$key = ini_get('session.upload_progress.prefix') . 'img';
if(!empty($_SESSION[$key])) {
	$current = $_SESSION[$key]['bytes_processed'];
	$total = $_SESSION[$key]['context_length'];
	echo $current < total ? ceil($current / $total * 100) : 100;
}else{
	echo 100;
}