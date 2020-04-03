<?php

namespace database;

echo "enter connect";
$opts = parse_ini_file('db.ini');
echo "options connect to database ".$opts["host"];
function connect(){
	ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
	echo "connect called";
	//static $conn = null;
	//if($conn==null){
    try{
		$conn = new \PDO('mysql:host=' . $opts['host'],
		    $opts['user'], $opts['password']);
		$conn->prepare('use ' . $opts['database'] . ';' );
    }catch(PDOException $e){
    	echo 'error' . $e->getMessage();
    }
	//}
	echo "returning a successful connection";
	return $conn;
}