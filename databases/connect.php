<?php

namespace database;

echo "enter connect";
$opts = parse_ini_file('db.ini');
var_dump($opts);
function connect(){
	echo "connect called";
	static $conn = null;
	if($conn==null){
		$conn = new \PDO('mysql:host='.$opts['host'].';dbname='.$opts['database'],
		    $opts['user'], $opts['password']);
	}
	return $conn;
}