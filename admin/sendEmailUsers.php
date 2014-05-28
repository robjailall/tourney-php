<?php

	include("database.php");
	include("functions.php");
 
	$subject = trim($_POST['subject']);
	$body = $_POST['body'];
	
	// Check for missing text
	if (strlen($subject) < 2) {
		$error['subject'] = "Please enter a subject.";	
	}
	
	if (strlen($body) < 3) {
		$error['body'] = "Please add content to body of email.";
	}

	// If there are no errors, then send emails to the users
	if (!$error) {
		
		$meta = "SELECT * FROM `meta` WHERE id=1";
		$meta = mysql_query($meta,$db); //grabs administrator's email
		$meta = mysql_fetch_array($meta);
		$adminEmail = $meta['email'];
		$adminName = $meta['name'];	

		$users = "SELECT DISTINCT `email` FROM `brackets`";
		$users = mysql_query($users,$db); //grabs users' email
		

		$userCount = 0;
		while($eachuser = mysql_fetch_array($users)){
			mail($eachuser['email'], stripslashes($subject), stripslashes($body), "From: $adminEmail");
		}
		
		echo "<li class='success'> Email sent.</li>";
		
	} # end if there are errors, display them
	else {

		$response = (isset($error['subject'])) ? "<li>" . $error['subject'] . "</li> \n" : null;
		$response .= (isset($error['body'])) ? "<li>" . $error['body'] . "</li> \n" : null;
		
		echo $response;
	} 

?>
