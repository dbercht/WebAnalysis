<?php
	//Function to fetch all the websites registered

	$suggested_categories = array("", "Sports", "Business", "Social Media", "Shopping", "News");

	function the_suggested_categories(){
		global $suggested_categories;

		$count = count($suggested_categories);
		for ($i = 0; $i < $count; $i++){
			echo "<option value='".$suggested_categories[$i]."'>".$suggested_categories[$i]."</option>";
		}
	}

	function category_form(){
		global $category_insert_error;

		echo '<form action="category.php" method="put">';
		if($category_insert_error != 'false'){
			echo '<p>'.$category_insert_error.'</p>';
		}		
		echo '<p>Category Title: <input type="text" size="30" name="title" /></p>
			<p><input type="hidden" size="30" name="act" value="create" /></p>
			<p><input type="submit" value="Send it!"></p>
			</form>';
	}

	//Function will rthe vategories associated by the logged in user
	function fetch_user_categories(){
		global $_SESSION;
		$username = $_SESSION['username'];

		fetch_user_categories_by_username($username);

	}
	//Function will rthe vategories associated by the logged in user
	function fetch_user_categories_by_username($username){
		$query = "SELECT * FROM categories WHERE username = '".$username."' ORDER BY id LIMIT 0 , 30";
		$categories = mysql_query($query);
		while ($row = mysql_fetch_assoc($categories)) {
						echo "<li id=".$row['id']." ><a href='websites.php?request=js&username=".$username."&category_id=".$row['id']."'>".$row['title']."</a></li>";
				}

	}

?>
