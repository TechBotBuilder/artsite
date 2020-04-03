<?php

namespace database;

echo "enter connect";


function connect(){
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
	echo "connect called";
	$opts = parse_ini_file('db.ini');
	echo "options connect to database ".$opts["host"];
	//static $conn = null;
	//if($conn==null){
    try{
		$conn = new \PDO('mysql:host=' . $opts['host'] . ';dbname=' . $opts['database'],
		    $opts['user'], $opts['password']);
    }catch(PDOException $e){
    	echo 'error' . $e->getMessage();
        die('failed to open connection to database');
    }
	//}
	echo "returning a successful connection";
	return $conn;
}