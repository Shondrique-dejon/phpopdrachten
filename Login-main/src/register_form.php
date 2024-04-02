<?php
// Register_Form.php

require __DIR__ . '/../vendor/autoload.php';

use Login\classes\User;

if (isset($_POST['register-btn']))
{
	$user = new User();

	$user->username = $_POST['username'];
	$user->SetPassword($_POST['password']);
	$user->email = $_POST['email'];
	$user->setRole();

	$errors = $user->ValidateRegistration();

	if (count($errors) == 0)
	{
		$errors = $user->RegisterUser();
	}
	
	if (count($errors) > 0)
	{
		$message = implode ("\n", $errors);
		
		echo 
		"<script>alert('" . $message . "')</script>
		<script>window.location = 'Register_Form.php'</script>";
	} 
	else 
	{
		echo 
		"<script>alert('" . "User registered" . "')</script>
		<script>window.location = 'Login_Form.
		php'</script>";
	}
}
?>
<html>
	<body>
		<h1>Registration</h1>
		<form action="" method="POST">	
			<hr>
			<br>
			<div>
				<input type="text"  name="username" placeholder="Username"/>
			</div>
			<br>
			<div >
				<input type="password"  name="password" placeholder="Password"/>
			</div>
			<br>
			<div >
				<input type="text"  name="email" placeholder="Email"/>
			</div>
			<br>
			<div>
				<button type="submit" name="register-btn">Register</button>
			</div>
			<br>
			<div>
				<a href="Login_Form.php">Log in</a>
			</div>
			<br>
			<div>
				<a href="Index.php">Home</a>
			</div>
		</form>
	</body>
</html>