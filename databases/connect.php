<?php

namespace database;



function connect(){
	$opts = parse_ini_file('db.ini');
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
	return $conn;
}