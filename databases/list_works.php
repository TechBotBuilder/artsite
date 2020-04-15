<?php
//list_works.php
//list used by database for images pages


//database/query  look up MySQL select a range of primary keys
//
namespace database;

function list_works(){

	require_once "query.php";
	$get_resultsSQL = "SELECT * FROM images;";
	$results = query($get_resultsSQL);

	return ($results);
}
