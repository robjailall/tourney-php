<?php
session_start();
include("database.php");
include 'functions.php';
validatecookie();

$brackets = "SELECT person, email, id, paid FROM `brackets`";
$brackets = mysql_query($brackets,$db);

$meta = "SELECT email, name, mail,cut FROM `meta` WHERE id=1";
$meta = mysql_query($meta,$db); //grabs administrator's email
$meta = mysql_fetch_array($meta);
$adminEmail = $meta['email'];

$subject = "March Madness Has Begun";

while ($row = mysql_fetch_array($brackets, MYSQL_ASSOC)) {

	$userEmail = $row['email'];
	// prepare administrator email body text
	$body = "The NCAA basketball tournament has begun.  Thank you for taking part in this year's pool.";
    $link = $tourneyURL . "view.php?id=" . $row['id'];
    $body .= "  You can view your bracket or print it out at " . $link;
    $body .= " and you can watch the standings update as the tourney progresses at " . $tourneyURL . "choose.php\n";
	if ($row['paid'] < 1) {
		$body .= "\n\nNOTE:\nThis bracket has not been paid for.  Please pay " . $meta[name] . " as soon as possible.  Your bracket will not show up in the standings until payment is received.";
	}

	/*echo $userEmail;
	echo "\n\n";
	echo $subject;
	echo "\n\n";
	echo $body;
	echo "\n\n";*/
	mail($userEmail, $subject, $body, "From: $adminEmail");

	}
	
	//redirects to a confirmation notice
	$_SESSION['success'] = "Emails have been sent";
	header('location:../index.php');
	exit();
	
	?>