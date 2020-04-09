<?php

//run a SQL query against the database.

namespace database;

require_once "connect.php";


function query($sql, $data = array()){
    $conn = connect();
	$statement=$conn->prepare($sql);
	if($data)
	    $statement->execute($data);
	else
		$statement->execute();
	//$statement = $conn->query($sql);
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
}