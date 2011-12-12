<?php
	session_start();
	//This function will destroy your session
	session_destroy();
	header("Location: index.php");

?> 
