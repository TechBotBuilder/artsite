<?php
//verify user credentials and start session

namespace security;

/*
* Returns true if login succeeded,
* 	false if login failed (incorrect username/password, some other error)
*/
function login($username, $password) : \boolean {
	require_once 'session_manager.php';
	SecureSession::sessionStart();
	
	require_once "admin_util.php";
	$admin = new Admin;
	
	if($username == $admin->getUsername() && $admin->checkPassword($password))
	{
		$_SESSION['user'] = $admin->getUsername();
		$_SESSION['admin'] = true;
		return true;
	}else{
		//note: Leave it up to the caller to throttle/captcha logins.
		return false;
	}
}