<?php 
		require_once('config/config.php');
		require_once('functions.php');
 ?>

<?php
	//error_reporting(-1);

	//Fetching user information
	session_start();
	
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];

	$act = $_REQUEST['act'];

	//Website functions

	//Function adds a website to the user category by category_id and website_id
	function add_website_to_user_category(){
		global $username;
		global $password;
		global $_REQUEST;
		
		if(check_logged_in($username, $password)){

			$category_id = $_REQUEST['category_id'];
			$website_id = $_REQUEST['website_id'];
			$query = "SELECT * FROM categories WHERE (id = '$category_id' AND username = '$username')";
			$is_user_category = mysql_query($query);
			if(mysql_num_rows($is_user_category) == 1)
			{
				$existing_rows = mysql_query("SELECT * FROM categories_websites WHERE (category_id = '$category_id' AND website_id = '$website_id')");
				if(mysql_num_rows($existing_rows) == 0){
					$insert = mysql_query("INSERT INTO categories_websites (category_id, website_id) VALUES ('$category_id', '$website_id')");
					if(!$insert){	
						return false;
					}else{
					}
				}
				//If JS request, don't redirect, else go to user-home
				if($_REQUEST['request']=='js'){
					echo fetch_websites_by_category_id($category_id);
				}else{
					header("Location: user-home.php");				
			}

			}
		}
	}



	//Function removes a website to the user category by category_id and website_id
	function remove_website_from_user_category(){

		global $username;
		global $password;
		global $_REQUEST;
		check_logged_in($username, $password);

		$category_id = $_REQUEST['category_id'];
		$website_id = $_REQUEST['website_id'];
		$query = "DELETE FROM categories_websites WHERE category_id = '$category_id' AND website_id = '$website_id'";
		$delete = mysql_query($query);
		if(!$delete){	
			return false;
		}
		//If JS request, don't redirect, else go to user-home
		if($_REQUEST['request']=='js'){
			echo fetch_websites_by_category_id($category_id);
		}else{
			header("Location: user-home.php");				
		}
	}
	//Form to add a website to a category, soon to be obsolete
	function add_website_to_category_form(){	
		global $username;

		//Querying all category names and ids		
		$query = "SELECT title, id FROM categories WHERE username = '".$username."'ORDER BY title ASC LIMIT 0 , 30";
		$categories = mysql_query($query);
		//Creating select options for category
		$categories_select = "";
		while($row = mysql_fetch_assoc($categories)){
			$categories_select .=  "<option value='".$row['id']."'>".$row['title']."</option>";
		}

		//Querying all website names and ids		
		$query = "SELECT title, id FROM websites ORDER BY title ASC";
		$websites = mysql_query($query);
		//Creating select options for category
		$websites_select = "";
		while($row = mysql_fetch_assoc($websites)){
			$websites_select .=  "<option value='".$row['id']."'>".$row['title']."</option>";
		}


		//Upper half of form
		$upper_form = 
			'<form action="websites.php" method="put">
			<p>Category: 
			<select name="category_id">'.$categories_select.'</select>		
			</p>
			<p>Website: 
			<select name="website_id">'.$websites_select.'</select>		
			</p>
			<p><input type="hidden" size="30" name="act" value="add_website" /></p>
			<p><input type="submit" value="Send it!"></p>
			</form>';

		echo $upper_form;
	}

	//HTML page with form to add website to a category
	function add_category_to_website_page(){
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
			<head>
				<title>New Website</title>
			</head>

			<body>'.
					add_website_to_category_form().
		'
			</body>
		</html>
		';
	}
?>


<?
	if($act == "search"){
		search_websites_by_title($_GET['website_title']);
	}
	elseif($act == "add_website"){
		if(!isset($_REQUEST['website_id'])){
			$_REQUEST['website_id'] = create_website(mysql_real_escape_string($_REQUEST['website_title']), mysql_real_escape_string($_REQUEST['website_url']));
		}

		add_website_to_user_category();
		if ($_GET['request'] == "js") {
			return;
		}
	}elseif($act == "remove_website"){
		remove_website_from_user_category();
		if ($_GET['request'] == "js") {
			return;
		}
	}else{
		if ($_GET['request']){
			if ($_GET['request'] == "html") {
				add_category_to_website_page();
			}if ($_GET['request'] == "js") {
					$websites = fetch_websites_by_category();		
			}
		}
	}
?>
