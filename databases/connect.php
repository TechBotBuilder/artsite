<?php

namespace database;

$opts = parse_ini_file('db.ini');

function connect(){
	static $conn = null;
	if(null($conn) || $conn->
}