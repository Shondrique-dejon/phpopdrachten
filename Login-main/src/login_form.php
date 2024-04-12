<?php
// Login_Form.php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Login\classes\User;

if (isset($_POST['login-btn']))
{
	$user = new User();

	$user->username = $_POST['username'];
	$user->SetPassword($_POST['password']);

	$errors = $user->ValidateLogin();

	if (count($errors) == 0)
	{
		if ($user->LoginUser())
		{
			header("Location: Index.php");
			exit();
		} 
		else
		{
			array_push($errors, "Log in failed");
		}
	}
	
	$message = implode ("\n", $errors);

	echo 
	"<script>alert('" . $message . "')</script>
	<script>window.location = 'Login_Form.php'</script>";
}
?>
<html>
	<body>
		<h1>Log in</h1>
	    <form action="" method="POST">	
			<hr>
			<br>
			<div>
				<input type="text"  name="username" placeholder="Username"/>
			</div>
			<br>
			<div>
				<input type="password"  name="password" placeholder="Password"/>
			</div>
			<br>
			<div>
				<button type="submit" name="login-btn">Log in</button>
		    </div>
			<br>
		    <div>
				<a href="Register_Form.php">Registration</a>
		    </div>
			<br>
			<div>
				<a href="Index.php">Home</a>
			</div>
		</form>	
	</body>
</html>