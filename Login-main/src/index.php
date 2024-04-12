<?php
// Index.php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Login\classes\User;

$user = new User();

if (isset($_GET['logout']) && $_GET['logout'] == 'true') 
{
	$user->Logout();

	header('Location: Index.php');
	exit();
}

if (!$user->IsLoggedin())
{
	echo "<h1>Home</h1>";
	echo "<hr>";
	echo "<br>";
	echo "Log in or register to continue.";
	echo "<br><br>";
	echo '<a href="Login_Form.php">Log in</a>';
	echo "<br><br>";
	echo '<a href="Register_Form.php">Registration</a>';
}
else
{
	$username = $_SESSION['username'];

	$user->GetUser($username);
	
	echo "<h1>Welcome</h1>";
	echo "<hr>";
	$user->ShowUser();
	echo "<br>";
	echo '<a href = "?logout=true">Log out</a>';
}	