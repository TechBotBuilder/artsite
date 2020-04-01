<?php

if($_SERVER['POST'] && $password = $_SERVER['POST']['password']) {
	echo password_hash($password);
}

else{
?>

<form method="post">
	<label>Password to generate hash for:
		<input type="password" name="password" id="password">
	</label>
	<input type="submit" value="Generate pwhash!">
</form>

<?php
}