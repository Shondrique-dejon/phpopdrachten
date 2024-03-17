<?php
	
	// Is de login button aangeklikt?
	if(isset($_POST['login-btn']) ){

		require_once('classes/user.php');
		$user = new User();

		$user->username = $_POST['username'];
		$user->SetPassword($_POST['password']);

		$user->ShowUser();

		// Validatie gegevens
		$errors = $user->ValidateUser();

		// Indien geen fouten dan inloggen
		if(count($errors)== 0){
			//Inlogen
			if ($user->LoginUser()){
				echo "Login ok";
				// Ga naar pagina??
				header("location: index.php");
			} else
			{
				array_push($errors, "Login mislukt");
				echo "Login NOT ok";
			}
		}

		if(count($errors) > 0){
			$message = "";
			foreach ($errors as $error) {
				$message .= $error . "\\n";
			}
			
			echo "
			<script>alert('" . $message . "')</script>
			<script>window.location = 'login_form.php'</script>";
		
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	</head>
<body>

	<h3>PHP - PDO Login and Registration</h3>
	<hr/>
	
	<form action="" method="POST">	
		<h4>Login here...</h4>
		<hr>
		
		<label>Username</label>
		<input type="text" name="username" />
		<br>
		<label>Password</label>
		<input type="password" name="password" />
		<br>
		<button type="submit" name="login-btn">Login</button>
		<br>
		<a href="register_form.php">Registration</a>
	</form>
		
</body>
</html>