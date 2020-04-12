<?php

namespace database;



function connect(){
	static $conn = null;
	if($conn==null){
		$opts = parse_ini_file('db.ini');
		try{
			$conn = new \PDO('mysql:host=' . $opts['host'] . ';dbname=' . $opts['database'],
				$opts['user'], $opts['password']);
		}catch(PDOException $e){
			echo 'error' . $e->getMessage();
			die('failed to open connection to database');
		}
	}
	return $conn;
}
