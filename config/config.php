<?php
	$host="localhost";
	$username="root";
	$password="";
	$db="db";
	mysql_connect($host,$username,$password);
	mysql_select_db($db);
	
	require_once "sql/gbook.php";
	require_once "sql/user.php";
	require_once "sql/group_user.php";
?>
