<?php

namespace database;

$opts = parse_ini_file('db.ini');

function connect(){
	static $conn = null;
	if($conn==null){
		$conn = new \PDO('mysql:host='.$opts['host'].';dbname='.$opts['database'],
		    $opts['user'], $opts['password']);
	}
	return $conn;
}