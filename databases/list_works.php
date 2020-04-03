<?php
//list_works.php
//list used by database for images pages


//database/query  look up MySQL select a range of primary keys
//
namespace database;
echo "list_works.php";
require_once "query.php";
echo "get results";
$get_resultsSQL = "SELECT file FROM images LIMIT 0, 20;";
echo "calling query";
$results = query($get_resultsSQL);
var_dump($results);
