<?php

//run a SQL query against the database.

namespace database;

require_once "connect.php";


function query($sql, $data = array(), $single_value=false){
    $conn = connect();
	$statement=$conn->prepare($sql);
	if($data)
	    $statement->execute($data);
	else
		$statement->execute();
	//$statement = $conn->query($sql);
	if($single_value)
		return $statement->fetch(\PDO::FETCH_ASSOC);
	else
	    return $statement->fetchAll(\PDO::FETCH_ASSOC);
}