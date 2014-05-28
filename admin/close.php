<?php

include("database.php");

	//close bracket entry
	$query = "UPDATE `meta` SET `closed`=1";
	mysql_query($query) or die(mysql_error()); //updates database

   header( 'Location: index.php' );
?>