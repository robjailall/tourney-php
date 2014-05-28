<?php
include 'functions.php';
validatecookie();
include("database.php");


function update_paid($paiddata, $key)
{
    global $db;
		$query = "UPDATE brackets SET paid='$paiddata' WHERE id=$key";
		mysql_query($query,$db);
}

if (get_magic_quotes_gpc())
{
	$_POST['title'] = stripslashes($_POST['title']);
	$_POST['subtitle'] = stripslashes($_POST['subtitle']);
	$_POST['content'] = stripslashes($_POST['content']);  
	$_POST['rules'] = stripslashes($_POST['rules']);
}
$_POST['title'] = mysql_real_escape_string($_POST['title']);
$_POST['subtitle'] = mysql_real_escape_string($_POST['subtitle']);
$_POST['content'] = mysql_real_escape_string($_POST['content']);  
$_POST['rules'] = mysql_real_escape_string($_POST['rules']);

if($_GET['action'] == "post")
{
	$query = "INSERT INTO `blog` (title,subtitle,content) VALUES ('$_POST[title]','$_POST[subtitle]','$_POST[content]')";
	mysql_query($query,$db);
}

else if($_GET['action'] == "delete")
{
	$query = "DELETE FROM `blog` WHERE id='$_POST[post]'";
	mysql_query($query,$db);
}

else if($_GET['action'] == "rules")
{
	$query = "UPDATE `meta` SET `rules`='$_POST[rules]' WHERE id=1";
	mysql_query($query,$db);
}
else if($_GET['action'] == "paid")
{
  array_walk($_POST, 'update_paid');
}

header( 'Location: index.php' );

?>
