<?php

//run a SQL query against the database.

namespace database;
require_once "connect.php";


function query($sql, $data = array()){
    $conn = connect();
    $conn->prepare($sql);
    $conn->execute($data);
    return $conn->fetchAll(\PDO::FETCH_ASSOC);
}