<?php
session_start();
include("admin/database.php");
include("admin/functions.php");


$tiebreaker = $_POST['tiebreaker'];
$bracketname = $_POST['bracketname'];  
$person = $_POST['name'];
$email = $_POST['e-mail']; 
//$submitpassword = htmlentities($_POST['password']); 

$meta = "SELECT * FROM `meta` WHERE id=1";
$meta = mysql_query($meta,$db); //grabs administrator's email
$meta = mysql_fetch_array($meta);

/////////////////////// print ////////////////////////////

if(isset($_POST['print']))
{
	include('bracket_view_module.php');
	
	$seedMap = getSeedMap($db);	

	$startIdx = 1;
	
	if( $meta['sweet16Competition'] == true )
	{
		$master_query = "SELECT * FROM `master` WHERE `id`=2"; //select winners
		$master_data = mysql_query($master_query,$db);
		$winners = mysql_fetch_array($master_data);
		
		for( $i=1; $i < 49; $i++ )
		{
			$picks[$i] = $seedMap[$winners[$i]].". ".$winners[$i];
		}
	
		$startIdx = 49;
	}
	
	for( $i=$startIdx ; $i < 64; $i++ )
	{
		$picks[$i.""] = $seedMap[$_POST["game".$i]].". ".$_POST["game".$i];
	}
	
	$picks['name'] = stripslashes($bracketname);
	$picks['tiebreaker'] = $tiebreaker;
	
	
	$team_query = "SELECT * FROM `master` WHERE `id`=1"; //select teams
	$team_data = mysql_query($team_query,$db);
	$team_data = mysql_fetch_array($team_data);
	
		
	for( $i= 1; $i<65; $i++ )
	{
		$team_data[$i] = $seedMap[$team_data[$i]].". ".$team_data[$i];
	}
?>

<link rel="stylesheet" href="images/print.css" type="text/css" />

<?php

	viewBracket( $meta, $picks, $team_data, $rank, $score_data, $best_data );
	exit();
}
unset($_SESSION['print']);
/////////////////////////////////////////////////////////

$subject = "Brackets";
$adminEmail = $meta['email'];

//$query = "SELECT * FROM `users` where UPPER(`email`) = '".strtoupper($email)."' LIMIT 1";
//$result = mysql_query($query,$db);

//clean input
$i = 0;
while($_POST[$i] != NULL) {
	$_POST[$i] = Trim(stripslashes($_POST[$i])); 
	++$i;
}

/*
$numberleft = 99;
$validemail = false;
$row = mysql_fetch_array($result);
$validemail = true;
$numberleft = $row["numberleft"];
$numbertotal = $row["numbertotal"];
$username = $row["name"];
$useremail = $row["email"];
*/

/* must comment this out because sending an error causes you to lose the post data, meaning that the user would ahve to fill out the whole form again
if ($numberleft < 1) {
	$_SESSION['errors'] = "You have already entered a bracket or brackets.  You must pay to enter additional brackets.";
	header('Location:submit.php');
	exit();
}*/

// validate fields
/*
must comment this out because sending an error causes you to lose the post data, meaning that the user would ahve to fill out the whole form again
$allFieldsFilled = true;
$missedField = "";

for( $i = 0; $i < 64; $i++ )
{
	if( $_POST["game".$i] == "" )
	{
		$allFieldsFilled = false;
		$missedField = "game".$i;
		break;
	}
}

if( !allFieldsFilled )
{
	$_SESSION['errors'] = "<p>A winner for ALL games must be selected. You missed one.</p>";
	header('Location:submit.php');
	exit();
}*/

if($tiebreaker != NULL && is_numeric($tiebreaker) && $person != NULL && $email != NULL)  //validates that the form was submitted to prevent spamming
{
	$body = "Your bracket has been successfully submitted.";
	$_SESSION['success'] = "<p>".$body."</p>";
}
else
{
	$body = "Your bracket has been submitted with some sort of error. Saving it anyway. Contact <a href='mailto:".$meta['email']."'>".$meta['email']."</a> about a fix.";
	$_SESSION['errors'] = "<p>".$body."</p>";
}	

$paid = 0;
if( $meta['cost'] == 0 )
{
   $paid = 2; // if the cost to enter is zero, exempt every bracket on entry.
}

/*
if ($validemail == false)
{
	// create new user 
	$query = "INSERT INTO `users` (`name`,`email`,`paid`,`numbertotal`,`numberleft`) VALUES ('$person','$email','0','1','0')";
	mysql_query($query) or die(mysql_error()); //inserts entry into the dataase
	$username = $person;
	$useremail = $email;
}
else
{
	// check number of paid submissions left
	$numbertotal++;
	$numberleft = $numberleft-1;
	if( $numberleft >= 0 )
	{
		$paid = 1;
	}
		
	// update user table
	$query = "UPDATE `users` SET `numberleft` = '$numberleft', `numbertotal` = '$numbertotal' WHERE UPPER(`email`) = '".strtoupper($useremail)."'";
	mysql_query($query) or die(mysql_error()); //inserts entry into the database
}
*/

// submit bracket
$query = "INSERT INTO `brackets` (`person`,`name`,`email`,`tiebreaker`,`paid`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`,`13`,`14`,`15`,`16`,`17`,`18`,`19`,`20`,`21`,`22`,`23`,`24`,`25`,`26`,`27`,`28`,`29`,`30`,`31`,`32`,`33`,`34`,`35`,`36`,`37`,`38`,`39`,`40`,`41`,`42`,`43`,`44`,`45`,`46`,`47`,`48`,`49`,`50`,`51`,`52`,`53`,`54`,`55`,`56`,`57`,`58`,`59`,`60`,`61`,`62`,`63`) VALUES (";
$query .= "'".mysql_real_escape_string($person)."',";
$query .= "'".mysql_real_escape_string($bracketname)."',";
$query .= "'".mysql_real_escape_string($email)."',";
$query .= "'".mysql_real_escape_string($tiebreaker)."',";
$query .= "'".mysql_real_escape_string($paid)."',";

$startIdx = 1;

if( $meta['sweet16Competition'] == true )
{
	$master_query = "SELECT * FROM `master` WHERE `id`=2"; //select winners
	$master_data = mysql_query($master_query,$db);
	$winners = mysql_fetch_array($master_data);
	
	for( $i=1; $i < 49; $i++ )
	{
		$query .= "'".$winners[$i]."',";
	}

	$startIdx = 49;
}

for( $i=$startIdx; $i < 63; $i++ )
{
	$query .= "'".mysql_real_escape_string($_POST["game".$i])."',";
}

$query .= "'".mysql_real_escape_string($_POST["game63"])."'";
$query .= ")";


mysql_query($query) or die(mysql_error()); //inserts entry into the database

if($meta['mail']==1)
{ //if mail is configured
	
	// prepare administrator email body text
	$body .= "Name: ";
	$body .= $person;
	$body .= "\n";
	$body .= "Bracket Name: ";
	$body .= $bracketname;
	$body .= "\n";
	$body .= "Entrant's Email: ";
	$body .= $email;
	$body .= "\n";
	$body .= "Tiebreaker (# of points in the championship): ";
	$body .= $tiebreaker;
	$body .= "\n";
	for($i=1;$i<=63;++$i) {
		$body .= "Game $i: ";
		$body .= $_POST["game$i"];
		$body .= "\n";
	}

	
	// send email to admin
	mail($adminEmail, $subject, "A bracket has been submitted to your pool.  This email should serve as a backup copy in the event that something happens to your database.\n\n".$body, "From: $email");
	// send confirmation to the entrant
	mail($email, "I have received your bracket","This is an automated email.  If you receive this, I have your submission.  Thanks for playing! -$meta[name]\n\n".$body, "From: $adminEmail");
}
//redirects to a confirmation notice
header('Location:index.php');
exit();

/*

This is being handled in java script
must comment this out because sending an error causes you to lose the post data, meaning that the user would ahve to fill out the whole form again

else if(!is_numeric($tiebreaker)) {
	$_SESSION['errors'] .= "<p>The tiebreaker must be a number.</p>";
	//header('Location:submit.php?'.$postString);
	header('Location:submit.php', TRUE, 307);
	//header( $postString );
	exit();
}
else {

	$_SESSION['errors'] .= "<p>You must enter your name, e-mail address, and a tiebreaker.</p>";

	header('Location:submit.php');
	header( $postString );
	exit();
}
*/

?>
