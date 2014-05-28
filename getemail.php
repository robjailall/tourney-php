<?php
session_start();
include("admin/database.php");

$type = $_GET['type'];
if($type == 'logout') {
	setcookie("useremail", "", mktime(12,0,0,1, 1, 1970), "/"); 
}
else
{
	$postemail = strip_tags($_POST['useremail']);
	$getuser = "SELECT email FROM `brackets` WHERE email='$postemail'";
	$result = mysql_query($getuser,$db);
	if ((mysql_num_rows($result) > 0)) {
		$_SESSION['useremail'] = $postemail;
		setcookie("useremail", strip_tags($_POST['useremail']), time()+60*60*24*30, "/");
	}
}
header("Location: index.php"); 

?>
