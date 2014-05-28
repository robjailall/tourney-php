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
	$userNumber = $_POST['number']; 

    //Add user to paid list
	$checkpaid = "SELECT * FROM `users` WHERE email='$userEmail'";
	$checkpaid = mysql_query($checkpaid,$db); //grabs administrator's email
	$checkpaidarray = mysql_fetch_array($checkpaid);
	
	if (mysql_num_rows($checkpaid) < 1) {
		$query = "INSERT INTO `users` (`name`,`email`,`numbertotal`,`numberleft`) VALUES ('$userName','$userEmail','$userNumber','$userNumber')";
		mysql_query($query) or die(mysql_error()); //inserts entry into the dataase
		}
	else {
		$numtotal = $checkpaidarray['numbertotal'] + $userNumber;
		$query = "UPDATE `users` SET `numbertotal` = '$numtotal' WHERE email='$userEmail'";
		mysql_query($query) or die(mysql_error()); //inserts entry into the dataase
	}
		

	// prepare administrator email body text
	$paid = 5*$userNumber;
	$body = "Thank you for paying.  You paid $";
	$body .= $paid ;
	$body .= " which allows you to submit ";
	$body .= $userNumber;
	$body .= " bracket(s).";

	mail($userEmail, $subject, $body, "From: $adminEmail");

	//redirects to a confirmation notice
	$_SESSION['success'] = "Submission code has been sent.";
	header('location:../index.php');
	exit();

	?>