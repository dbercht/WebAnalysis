<?php 
	require_once('config/config.php'); 
	session_start();
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];

	//Redirecting if user is not logged in	
	if(!$username && !$password){
		header('Location: index.php');
	}

	require_once('functions.php');

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
	<?php echo "Welcome ".$username." (<a href=logout.php>Logout</a>)";?>
	<div id='websites'>
		
		<div id="category-form" title="Create new category">
			<form action="category.php" method='put'>
				<p>Suggested categories:
					<select id="suggested_categories">
						<?php the_suggested_categories() ?>
					</select>
				</p> 				
				<p>Category Title: <input type="text" size="30" name="title" id="category_title" /></p>
				
				<p><input type="hidden" size="30" name="act" value="create" /></p>
				<p><input type="hidden" size="30" name="request" value="js" /></p>
			</form>
			

		</div>

		<div id="website-form" title="Add a website">
			<form action="websites.php" method='put'>
				<p><label for='website_title'>Website title: </label><input type="text" size="30" name="website_title" id="website_title" />
				<input type="hidden" id="website_id" name="website_id" />
			<p><label for='website_url'>Website url: </label><input type="text" size="30" name="website_url" id="website_url" /></p>
				<p><input type="hidden" size="30" name="act" value="create_or_add" /></p>
				<p><input type="hidden" size="30" name="request" value="js" /></p>

			</form>
		</div>
		<a href="category.php?request=html" id="add-a-category">Add a category</a>
		<a href="category.php?request=html" id="add-a-website">Add a website</a>
		<div id="user_bin">
			<div id="tabs" class='website_drop' >
				<ul>
					<?php
						$categories = fetch_user_categories();
					?>			 
				</ul>
			</div>
			<div id="website_trash">		
				<p>Trash website</p>
			</div>

		</div>
		<div id="website_list" class="selectable">
			<h2>Popular websites</h2>
			<?php fetch_popular_websites(10) ?>
		</div>
	</div>

</body>

</html> 
