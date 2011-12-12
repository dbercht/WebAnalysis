<?php
	require('config/config.php');
$act = $_REQUEST['act'];

//This function will display the registration form
function register_form(){

$date = date('D, M, Y');
echo "<form action='?act=register' method='post'>"
."Username: <input type='text' name='username' size='30'><br>"
."Email: <input type='text' name='email' size='30'><br>"
."Password: <input type='password' name='password' size='30'><br>"
."Confirm your password: <input type='password' name='password_conf' size='30'><br>"
."<input type='hidden' name='date' value='$date'>"
."<input type='submit' value='Register'>"
."</form>";

}

//This function will register users data
function register(){


//Collecting info
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$pass_conf = $_REQUEST['password_conf'];
$email = $_REQUEST['email'];
$date = $_REQUEST['date'];
$act = $_REQUEST['act'];

//Here we will check do we have all inputs filled

if(empty($username)){
die("Please enter your username!<br>");
}

if(empty($password)){
die("Please enter your password!<br>");
}

if(empty($pass_conf)){
die("Please confirm your password!<br>");
}

if(empty($email)){
die("Please enter your email!");
}

//Let's check if this username is already in use

$user_check = mysql_query("SELECT username FROM users WHERE username='$username'");
$do_user_check = mysql_num_rows($user_check);

//Now if email is already in use

$email_check = mysql_query("SELECT email FROM users WHERE email='$email'");
$do_email_check = mysql_num_rows($email_check);

//Now display errors

if(($do_user_check > 0)|(!ctype_alnum($username))){
die("Username is already in use!<br>");
}

if($do_email_check > 0){
die("Email is already in use!");
}

//Now let's check does passwords match

if($password != $pass_conf){
die("Passwords don't match!");
}


//If everything is okay let's register this user

$insert = mysql_query("INSERT INTO users (username, password, email) VALUES ('$username', '".md5($password)."', '$email')");
if(!$insert){	
die("There's little problem: ".mysql_error());
}
header("Location: index.php");
//echo $username.", you are now registered. Thank you!<br><a href=login.php>Login</a> | <a href=index.php>Index</a>";

}

switch($act){

default;
register_form();
break;

case "register";
register();
break;

}

?> 
