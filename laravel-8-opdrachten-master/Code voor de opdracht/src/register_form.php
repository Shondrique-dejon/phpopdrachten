<?php
//require_once 'classes/user.php';
require_once "../vendor/autoload.php";
use Login\classes\User;
// Is de register button aangeklikt?
if(isset($_POST['register-btn'])){
	require_once('classes/user.php');
	$user = new User();

	$user->username = $_POST['username'];
	$user->SetPassword($_POST['password']);


	// Validatie gegevens
	// Hoe???
	$errors = $user->ValidateUser();
	if(empty($errors)){
		// Register user
		$registrationErrors = $user->RegisterUser();
	}
	
	if(!empty($errors)){
		$message = implode("\\n", $errors);
		
		echo "
		<script>alert('" . $message . "')</script>
		<script>window.location = 'register_form.php'</script>";
	
	} else {
		echo "
			<script>alert('" . "User registerd" . "')</script>
			<script>window.location = 'login_form.php'</script>";
			exit();
	}

}
?>

<!DOCTYPE html>
<html lang="en">

<body>
	

		<h3>PHP - PDO Login and Registration</h3>
		<hr/>

			<form action="" method="POST">	
				<h4>Register here...</h4>
				<hr>
				
				<div>
					<label>Username</label>
					<input type="text"  name="username" />
				</div>
				<div >
					<label>Password</label>
					<input type="password"  name="password" />
				</div>
				<br />
				<div>
					<button type="submit" name="register-btn">Register</button>
				</div>
				<a href="index.php">Home</a>
			</form>


</body>
</html>