
<?php
 require_once('config/config.php'); 
 require('functions.php'); 
?>

<?php

	//Fetching user information
	session_start();
	
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];

	$category_template;

	$act = $_REQUEST['act'];

	$category_insert_error = 'false';

	//Redirecting if user is not logged in	
	if(!$username && !$password){
		header('Location: index.php');
	}


	function add_category(){
		global $category_insert_error, $category_template;
		global $username;
		$title = $_REQUEST['title'];
		$existing_rows = mysql_query("SELECT * FROM categories WHERE (title = '$title' AND username = '$username')");
		if(mysql_num_rows($existing_rows) == 0){
			if(ctype_alnum($title)){
				$insert = mysql_query("INSERT INTO categories (title, username) VALUES ('$title', '$username')");
				if($insert){
					if ($_REQUEST['request'] == "js"){
						$number_of_tabs = mysql_query("SELECT id FROM categories WHERE username = '$username' ORDER BY id DESC LIMIT 1");
						$last_cat = mysql_fetch_assoc($number_of_tabs);
						$id = $last_cat['id'];
						echo "websites.php?request=js&username=".$username."&category_id=".$id;
						return;
					}else{
						header("Location: user-home.php");				
					}
				}
			}
			else{				
				$category_insert_error = "Error adding category. Make sure the category contains only alphanumeric characters.";
			}
		}else{
			$category_insert_error = "Category taken. Please type a new one.";
		}
	}

	

?>
<?
		if($act == "create"){
			add_category();
			if ($_REQUEST['request'] == "js"){
				return;
			}else{
				category_form();
			}
		}
	 if ($_GET['request']){
		if ($_GET['request'] == "html") { ?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html>
				<head>
					<title>New Category</title>
				</head>

				<body>
					<?php 
						category_form();	
					?>

				</body>
			</html>
		<?php	
		}
	}else{
	}
?>
