<?php

namespace database;

echo "enter connect";
$opts = parse_ini_file('db.ini');
var_dump($opts);
function connect(){
	echo "connect called";
	//static $conn = null;
	//if($conn==null){
    try{
		$conn = new \PDO('mysql:host=' . $opts['host'] . ';dbname=' . $opts['database'],
		    $opts['user'], $opts['password']);
    }catch($e){
    	echo 'error' . $e->getMessage();
    }
	//}
	echo "returning a successful connection";
	return $conn;
}