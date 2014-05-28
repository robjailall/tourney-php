<?php
session_start();

include("admin/database.php");

$db = mysql_connect($host, $user, $pass) 
	or die(mysql_error());

mysql_select_db($database,$db) 
	or die(mysql_error());

$_SESSION['admin'] = true;
		header("Location: admin/index.php"); 

// Comment out for now. protect by htaccess in the mean time
/*
$username = mysql_query("SELECT * FROM meta");

if( $username['name'] != $_POST["password"] )
{	
	// Retrieve all the data from the "example" table
	$result = mysql_query("SELECT * FROM passwords where label ='admin_password'")
	or die(mysql_error());  
	
	// store the record of the "example" table into $row
	$row = mysql_fetch_array( $result );
	// Print out the contents of the entry 
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	
		echo md5($_POST["password"]);
		echo  $row["value"];
		if ((md5($_POST["password"]) == $row["value"]) && ($row["label"] == "admin_password"))
		{
			$_SESSION['admin'] = true;
			header("Location: admin/index.php"); 
			exit();
		}
		
		if ((md5($_POST["password"]) == $row["value"]) && ($row["label"] == "general_user_password"))
		{
			$_SESSION['admin'] = true;
			header("Location: index.php"); 
			exit();
		}
	
	}
}
else
{
	//header("Location: login.html");
}*/

?>
