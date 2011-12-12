<?/* Connection vars here for example only. Consider a more secure method. */
	require_once('config/config.php');
		
	$return_arr = array();

	/* If connection to database, run sql statement. */
		$fetch = mysql_query("SELECT * FROM websites where title like '%" . mysql_real_escape_string($_GET['term']) . "%'"); 

		/* Retrieve and store in array the results of the query.*/
	while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
		$row_array['id'] = $row['id'];
		$row_array['label'] = $row['title'];
		$row_array['url'] = $row['url'];
	  array_push($return_arr,$row_array);
	}

	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);
?>
