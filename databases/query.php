<?php

//run a SQL query against the database.

namespace database;
echo "enter query.php";

require_once "connect.php";


function query($sql, $data = array()){
	echo "running query on ".$sql." with data: "; var_dump($data);
    $conn = connect();
    echo "about to prepare sql";
    $conn->prepare($sql);
    echo "about to execute sql";
    $conn->execute($data);
    echo "returning sql query";
    return $conn->fetchAll(\PDO::FETCH_ASSOC);
}