<?php

namespace database;

const VISITORTABLE = 'visitors';
const 

$credentials = parse_ini_file("../private/database.ini");
$servername = $credentials['servername'];
$username = $credentials['username'];
$password = $credentials['password'];
$dbname = $credentials['dbname'];