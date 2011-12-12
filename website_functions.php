<?php

	//Standard link for each
	function show_website($row){
		if (preg_match('http\/\/^/', $row['url'])){
			$url = $row['url'];
		}else{
				$url = 'http://'.$row['url'];
		
		}
//		echo "<li class='website_drag' id=".$row['id']."><a>".$row['title']."</a></li>";
				echo "<li class='website_drag ui-draggable ui-state-default ui-selectee' id=".$row['id']." ><a href='".$url."'>".$row['title']."</a></li>";

	}

	function create_website($title, $url){		
			$insert = mysql_query("INSERT INTO websites (title, url) VALUES ('$title', '$url')");
			if($insert){
				$id = mysql_query("SELECT id FROM websites WHERE title = '".$title."' LIMIT 1");
				$row = mysql_fetch_assoc($id);				
				return $row['id'];
			}
	}

	//Fetch x amount of most popular websites
	function fetch_popular_websites($number_of_websites){
		$query = "SELECT websites.*, COUNT( * ) AS number_of_hits
		FROM websites, categories_websites
		WHERE websites.id = website_id
		GROUP BY website_id
		ORDER BY number_of_hits DESC
		LIMIT ".$number_of_websites;

		$websites = mysql_query($query);
		echo "<ul class='selectable'>";
		while ($row = mysql_fetch_assoc($websites)) {
			echo show_website($row);
		}
		echo "</ul>";
	}

	//Function to fetch all the websites registered
	function the_websites(){
		$query = "SELECT * FROM websites";
		$websites = mysql_query($query);
		echo "<ul>";
		while ($row = mysql_fetch_assoc($websites)) {
						echo show_website($row);
		}
		echo "</ul>";
	}
	
	//Website fetches all websites in a given category, provided by category_id
	function fetch_websites_by_category(){
		global $_SESSION;
		global $_REQUEST;

		$username = $_SESSION['username'];
		$category_id = $_REQUEST['category_id'];		
		fetch_websites_by_category_id($category_id);
		
		return true;
	}

	function fetch_websites_by_category_id($category_id){
		$sql = "SELECT *\n"
				. "FROM websites\n"
				. "WHERE ID\n"
				. "IN (\n"
				. "\n"
				. "SELECT website_id\n"
				. "FROM categories_websites\n"
				. "WHERE category_id =".mysql_real_escape_string($category_id).")\n";

			$websites = mysql_query($sql);

			echo "<ol class='selectable' class='ui-selectable'>";

			while ($row = mysql_fetch_assoc($websites)) {
				echo show_website($row);
			}

			echo "</ol>";
	}

function search_websites_by_title($website_title){
		$sql = "SELECT *\n"
				. "FROM websites\n"
				. "WHERE title \n"
				. "= \n"
				. " '".mysql_real_escape_string($website_title)."' LIMIT 1";

			$websiteb = mysql_query($sql);

		$return_arr = array();

		/* Retrieve and store in array the results of the query.*/
//		while ($row = mysql_fetch_array($websiteb)) {//
//			$row_array['id'] = $row['id'];
//			$row_array['label'] = $row['title'];
//			$row_array['url'] = $row['url'];
//			array_push($return_arr,$row_array);
//		}

			$row = mysql_fetch_array($websiteb);
	
		if($row){
				echo json_encode($row);
			}else{
				return false;
			}
	}


?>
