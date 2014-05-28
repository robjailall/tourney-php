<?php
	include("admin/database.php");
	//include("admin/functions.php");

	$specialChars = array('*',';','char(','=','javascript','JavaScript', '%', '&#','<','>','char(39)');

	$from = addslashes(str_replace($specialChars,"",strip_tags($_POST['from']))); 
	$comment = addslashes(str_replace($specialChars,"",strip_tags($_POST['comment']))); 
	$bracket = $_POST['id']; 
	
	/* table structure asks that subject be not null, so insert a string w a space. */
	$query = "INSERT INTO `comments` (`bracket`,`from`,`content`, `subject`) VALUES ('$bracket','$from','$comment', ' ')"; 

	mysql_query($query,$db) or die(mysql_error()); 
	
	header('location: view.php?id=' . $bracket."#comment"); ?>
?>
