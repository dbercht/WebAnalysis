<?php 
	require_once('config/config.php'); 
	session_start();
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];

	$requestURI = explode('/', $_SERVER['REQUEST_URI']);
	$username = $requestURI[1];
	
/**
	//Redirecting if user is not logged in	
	if(!$username && !$password){
		header('Location: index.php');
	}
**/
	require('functions.php');

?>

<?php
	if(is_user($username)){
		require('user-home.php'); 
	}else{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<LINK REL=StyleSheet HREF="/public/css/custom-theme/jquery-ui-1.8.16.custom.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/public/css/application.css" TYPE="text/css">
<script type="text/javascript" src="/public/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/public/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/public/js/user-home.js"></script>
	<script>
	
	jQuery(document).ready(function() {
		
		jQuery(document).userHome();

	});


	</script>
<title></title>
</head>

<body>
<br />
	<?php 
		echo log_out_bar();
	?>
	<div id='websites'>
		<div id="tabs" class='website_drop' >
			<ul>
				<?php
					$categories = fetch_user_categories_by_username($username);
				?>			 
			</ul>

		</div>
		<div id="website_list" class="selectable">
			<h2>Popular websites</h2>
			<?php fetch_popular_websites(10) ?>
		</div>
	</div>
</body>

</html> 
<?php } ?>
