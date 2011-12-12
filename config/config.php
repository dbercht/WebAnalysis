<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<?php
	//Defining __ROOT__ variable
	define('__ROOT__', dirname(dirname(__FILE__)));

	//Loading variables
	require_once(__ROOT__. '/config/variables.php'); 

	$db_con=mysql_connect($db_host,$username,$password);
	if (!$db_con)
	{
	  die('Could not connect: ' . mysql_error());
	}
	
	//Select database
	$db_found=mysql_select_db($db_name, $db_con);
	if (!$db_found) {
		print "Database NOT Found";
		print "<br />";

	}
?>
