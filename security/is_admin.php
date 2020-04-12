<?php

namespace security;
/*
Checks if current user is logged in as admin
*/

function is_admin() : bool {
	require_once "session_manager.php";
	SecureSession::sessionStart();
	return isset($_SESSION['admin']) && $_SESSION['admin']==true;
}

?>