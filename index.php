<?php
//This will start a session
session_start();


$requestURI = explode(‘/’, $_SERVER[‘REQUEST_URI’]);

$username = $_SESSION['username'];
$password = $_SESSION['password'];

//Check do we have username and password
if(!(!$username && !$password)){
//	header('Location: user-home.php');
	header('Location: '.$username);
}else{
}

?> 

<?php require_once('config/config.php'); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title></title>

<LINK REL=StyleSheet HREF="/public/css/custom-theme/jquery-ui-1.8.16.custom.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/public/css/application.css" TYPE="text/css">

<script type="text/javascript" src="/public/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/public/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/public/js/index.js"></script>
	
	<script>
	
	jQuery(document).ready(function() {
		
		jQuery(document).index();

	});
</script>
</head>

	<body>
		<?php echo "Welcome Guest! <br> <a href=login.php>Login</a> | <a href=register.php>Register</a>"; ?>
		<div id="websites">
			<div class="index_form">
				<form action='login.php?act=login' method='post'> 

							Login:					
				<table>
						<tr>
							<td>Username</td><td><input type='text' name='username' size='30'></td>
						</tr>
						<tr>
							<td>Password</td><td><input type='password' name='password' size='30'></td>
						</tr>
						<tr>	
							<td></td><td><input type='submit' value='Login' class="button"></td>
						</tr>
					</table>
				</form>
			</div>
			<div class="index_form">
				<form action='register.php?act=register' method='post'>
				Register					
				<table>
						<tr>
							<td>
								Username
							<td>
								<input type='text' name='username' size='30'>
							</td>
						</tr>
						<tr>
							<td>
								Email
							</td>
							<td>
								 <input type='text' name='email' size='30'>
							</td>
					</tr>
						<tr>
							<td>
								Password
							</td>
							<td>
								<input type='password' name='password' size='30'>
							</td>
						</tr>
						<tr>
							<td>
								Confirm your password
							</td>
							<td>
							 	<input type='password' name='password_conf' size='30'><br>
							</td>
							<input type='hidden' name='date' value='$date'>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<input type='submit' value='Register' class="button">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>

</html> 

