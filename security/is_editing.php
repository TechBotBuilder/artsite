<?php
//check if user is editing this page.

namespace security;

function is_editing() : boolean {
	require_once "is_admin.php";
	return isset($_GET['edit']) && $_GET['edit']=='true' && is_admin();
}

?>