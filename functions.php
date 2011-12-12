<?php
	require('website_functions.php');
	require('category_functions.php');

	error_reporting(0);

	function check_logged_in($username, $password){	//Redirecting if user is not logged in	

		if(!$username || !$password){
			//header('Location: index.php');
			return false;
		}

		return true;
	}

	function is_user($username){
		return $_SESSION['username'] == $username;
	}
	
	function log_out_bar(){
		if(isset($_SESSION['username'])){
			echo "Welcome ".$_SESSION['username']." (<a href=logout.php>Logout</a>)";
		}else{
			echo "<a href=login.php>Login</a> | <a href=register.php>Register</a>";
		}
	}

?>
