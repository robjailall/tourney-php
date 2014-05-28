<?php
session_start();
include("database.php");
include 'functions.php';
validatecookie();

$meta = "SELECT email, name, mail,cut FROM `meta` WHERE id=1";
$meta = mysql_query($meta,$db); //grabs administrator's email
$meta = mysql_fetch_array($meta);

$subject = "Basketball Tournament Pool Submission Code";
$adminEmail = $meta['email'];

//clean input
$i = 0;
while($_POST[$i] != NULL) {
	$_POST[$i] = Trim(stripslashes($_POST[$i])); 
	++$i;
}

	$userName = $_POST['name']; 
	$userEmail = $_POST['email']; 

    //Add user to paid list
	$query = "INSERT INTO `users` (`name`,`email`) VALUES ('$userName','$userEmail')";
	mysql_query($query) or die(mysql_error()); //inserts entry into the dataase

	// prepare administrator email body text
	$body = "Your submission code is: ";
	$emailstr = strval(md5($userEmail));
	$body .= substr($emailstr,12,1);
	$body .= substr($emailstr,3,1);
	$body .= substr($emailstr,19,1);
	$body .= substr($emailstr,5,1);
	$body .= substr($emailstr,15,1);
    $body .= substr($emailstr,8,1);

	mail($userEmail, $subject, $body, "From: $adminEmail");

	//redirects to a confirmation notice
	$_SESSION['success'] = "Submission code has been sent.";
	header('location:../index.php');
	exit();
	
	?>