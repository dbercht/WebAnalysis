<?php
	require('config/config.php');
	session_start();
	$act = $_REQUEST['act'];

	//This displays your login form
	function index(){
		global $act;
		echo "<form action='?act=login' method='post'>" 
		."Username: <input type='text' name='username' size='30'><br>"
		."Password: <input type='password' name='password' size='30'><br>"
		."<input type='submit' value='Login'>"
		."</form>"; 

	}

	//This function will find and checks if your data is correct
	function login(){
		global $act;

		//Collect your info from login form
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];

		//Find if entered data is correct
		$result = mysql_query("SELECT * FROM users WHERE username='$username' AND password='".md5($password)."'");
		$row = mysql_fetch_array($result);
	
		$id = $row['id'];

		$select_user = mysql_query("SELECT * FROM users WHERE id='$id'");
		$row2 = mysql_fetch_array($select_user);
		$user = $row2['username'];
		if($username != $user){
			//die("Username is wrong! ");
		}


		$pass_check = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id'");
		$row3 = mysql_fetch_array($pass_check);
		$email = $row3['email'];
		$select_pass = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id' AND email='$email'");
		$row4 = mysql_fetch_array($select_pass);
		$real_password = $row4['password'];

		if(md5($password) != $real_password){
		die("Your password is wrong!");
		}

		//Now if everything is correct let's finish his/her/its login

		$_SESSION["username"] = $username;
		$_SESSION["password"] = md5($password);

			header('Location: index.php');

	}

	switch($act){

	default;
		index();
	break;

	case "login";
		login();
	break;

	}
?> 
