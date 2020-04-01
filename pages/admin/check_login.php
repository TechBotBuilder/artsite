<?php

/*
Guard against unwanted access to administrator pages.

Check user's credentials. If not admin, send them to admin login page.

This file is run prior to every request to something in the admin folder. (see the .htaccess)
*/

require_once "../../utils/user.php";

if(user\is_admin()){
	//they are admin. okay, don't bother them
}else{
	//they aren't logged in as admin. Sendem packin'!
	
	header('Location: /admin/login.php');//redirect them
	exit();// securely exit so no data is accidentally sent
}




?>