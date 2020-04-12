<?php
//login.php
//allows you to log in!

if($_SERVER['REQUEST_METHOD']=='POST'
	&& isset($_POST['username'])
	&& isset($_POST['password'])
	){
	//activate user session
	require_once '../security/login.php';
	$login_success = security\login(trim($_POST['username']), trim($_POST['password']));
	
	if($login_success){
		header('Location: /admin/index.php');
		exit();
	}//otherwise we put a login-failed message in the page body.
}

include_once '../templates/common.php';

template\header('Login: Tonya Ramsey Art');
template\start_content('Log In');

?>

<?php 
if( isset($login_success) && !$login_success ): //bad login block
?>
	<div class="error">
		<p>Username or password is incorrect. Please try again.</p>
	</div>
<?php
endif;//end bad login block
?>

<form method="post">
	<label> User Name 
			<input type="text" name="username">
	</label>
	
	<label> Password
			<input type="text" name="password">
	</label>
	
	<div class='form-group form-submit'>
		<input type='submit' value='Log In'>
	</div>
</form>


<?php
template\end_content();
template\footer();
?>