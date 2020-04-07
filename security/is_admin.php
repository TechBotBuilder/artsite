<?php

namespace security;
/*
Checks if current user is logged in as admin
*/

function is_admin() : boolean {
	return isset($_SESSION['user']) && $_SESSION['user']=='admin';
}

?>