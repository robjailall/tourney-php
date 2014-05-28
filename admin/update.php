<?php
include 'functions.php';
validatecookie();
include("database.php");


if($_GET['id'] == 0) { //master bracket

  // create an empty array to use for array composition so all members are always set.
  for( $i=1; $i<=64; $i++ ) {
    $p[$i]="";
  }
  $_POST = $_POST + $p;

// Check the status of the magic quotes. If active, we should strip the
// slashes so the mysqli_real_escape_string call is not corrupted.
if(get_magic_quotes_gpc())
{
    $_POST = array_map('stripslashes', $_POST);
}

// Escapes special characters in the input for use in SQL statements
$_POST = array_map('mysql_real_escape_string', $_POST);


	/***************UPDATE WINNERS************/
	$win = "SELECT * FROM `master` WHERE id=2";
	$win = mysql_query($win,$db);
	if(!(@mysql_fetch_array($win))) {//if the row has not yet been filled, insert it
		$query = "INSERT INTO `master` (`id`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`,`13`,`14`,`15`,`16`,`17`,`18`,`19`,`20`,`21`,`22`,`23`,`24`,`25`,`26`,`27`,`28`,`29`,`30`,`31`,`32`,`33`,`34`,`35`,`36`,`37`,`38`,`39`,`40`,`41`,`42`,`43`,`44`,`45`,`46`,`47`,`48`,`49`,`50`,`51`,`52`,`53`,`54`,`55`,`56`,`57`,`58`,`59`,`60`,`61`,`62`,`63`) VALUES (2,'$_POST[1]','$_POST[2]','$_POST[3]','$_POST[4]','$_POST[5]','$_POST[6]','$_POST[7]','$_POST[8]','$_POST[9]','$_POST[10]','$_POST[11]','$_POST[12]','$_POST[13]','$_POST[14]','$_POST[15]','$_POST[16]','$_POST[17]','$_POST[18]','$_POST[19]','$_POST[20]','$_POST[21]','$_POST[22]','$_POST[23]','$_POST[24]','$_POST[25]','$_POST[26]','$_POST[27]','$_POST[28]','$_POST[29]','$_POST[30]','$_POST[31]','$_POST[32]','$_POST[33]','$_POST[34]','$_POST[35]','$_POST[36]','$_POST[37]','$_POST[38]','$_POST[39]','$_POST[40]','$_POST[41]','$_POST[42]','$_POST[43]','$_POST[44]','$_POST[45]','$_POST[46]','$_POST[47]','$_POST[48]','$_POST[49]','$_POST[50]','$_POST[51]','$_POST[52]','$_POST[53]','$_POST[54]','$_POST[55]','$_POST[56]','$_POST[57]','$_POST[58]','$_POST[59]','$_POST[60]','$_POST[61]','$_POST[62]','$_POST[63]')";
		mysql_query($query) or die(mysql_error()); //inserts entry into the database
	}
	else { //if the row has been filled, update it
		$query = "UPDATE `master` SET `1`='$_POST[1]',`2`='$_POST[2]',`3`='$_POST[3]',`4`='$_POST[4]',`5`='$_POST[5]',`6`='$_POST[6]',`7`='$_POST[7]',`8`='$_POST[8]',`9`='$_POST[9]',`10`='$_POST[10]',`11`='$_POST[11]',`12`='$_POST[12]',`13`='$_POST[13]',`14`='$_POST[14]',`15`='$_POST[15]',`16`='$_POST[16]',`17`='$_POST[17]',`18`='$_POST[18]',`19`='$_POST[19]',`20`='$_POST[20]',`21`='$_POST[21]',`22`='$_POST[22]',`23`='$_POST[23]',`24`='$_POST[24]',`25`='$_POST[25]',`26`='$_POST[26]',`27`='$_POST[27]',`28`='$_POST[28]',`29`='$_POST[29]',`30`='$_POST[30]',`31`='$_POST[31]',`32`='$_POST[32]',`33`='$_POST[33]',`34`='$_POST[34]',`35`='$_POST[35]',`36`='$_POST[36]',`37`='$_POST[37]',`38`='$_POST[38]',`39`='$_POST[39]',`40`='$_POST[40]',`41`='$_POST[41]',`42`='$_POST[42]',`43`='$_POST[43]',`44`='$_POST[44]',`45`='$_POST[45]',`46`='$_POST[46]',`47`='$_POST[47]',`48`='$_POST[48]',`49`='$_POST[49]',`50`='$_POST[50]',`51`='$_POST[51]',`52`='$_POST[52]',`53`='$_POST[53]',`54`='$_POST[54]',`55`='$_POST[55]',`56`='$_POST[56]',`57`='$_POST[57]',`58`='$_POST[58]',`59`='$_POST[59]',`60`='$_POST[60]',`61`='$_POST[61]',`62`='$_POST[62]',`63`='$_POST[63]' WHERE `id`=2";
		mysql_query($query) or die(mysql_error()); //updates database
	}
	
	// Eliminate conflicting endgames
	$updatePossibleScoresQuery = "UPDATE `end_games` SET `eliminated`=false";
	mysql_query($updatePossibleScoresQuery) or die(mysql_error()); //update end_games;
	

	$firstUpdate = true;
			
	for( $i=49; $i<64; $i++ )
	{
		if( $_POST[$i] != NULL )
		{
			if( !$firstUpdate )
			{
				$finishedGamesCondition .= " OR ";
			}
			
			$firstUpdate = false;
			$finishedGamesCondition .= "`".$i."` != '".$_POST[$i]."'";
			
		}
	}
	
	$query = "UPDATE `end_games` SET `eliminated` = true WHERE ".$finishedGamesCondition;

	mysql_query($query,$db);
	

	
	$updateStatus= "UPDATE possible_scores p, end_games e SET p.eliminated = e.eliminated WHERE e.id = p.outcome_id and `type`='path_to_victory'";
	mysql_query($updateStatus,$db);
	
	$updateStatus= "UPDATE possible_scores_eliminated p, end_games e SET p.eliminated = e.eliminated WHERE e.id = p.outcome_id and `type`='path_to_victory'";
	mysql_query($updateStatus,$db);
	
	$updateStatus= "INSERT into possible_scores_eliminated SELECT * from possible_scores p WHERE p.eliminated = true and `type`='path_to_victory'";
	mysql_query($updateStatus,$db);
	
	$updateStatus= "INSERT into possible_scores SELECT * from possible_scores_eliminated p WHERE p.eliminated = false and `type`='path_to_victory'";
	mysql_query($updateStatus,$db);
	
	$updateStatus= "DELETE from possible_scores WHERE eliminated = true and `type`='path_to_victory'";
	mysql_query($updateStatus,$db);
	
	$updateStatus= "DELETE from possible_scores_eliminated WHERE eliminated = false and `type`='path_to_victory'";
	mysql_query($updateStatus,$db);

	//starts sweet 16 if necessary
	$sweet16 = true;
	for($i=33;$i<=48;++$i) {
		if( $_POST[$i]=="" ) {
			$sweet16 = false;
			break;
		}
	}
	
	$pastSweet16 = false;
	for($i=49;$i<=63;++$i) {
		if( $_POST[$i]!="" ) {
			$pastSweet16 = true;
			break;
		}
	}
	
	$query = "SELECT * FROM `meta` WHERE `id`=1";
	$meta = mysql_query($query,$db);
	$meta = mysql_fetch_array($meta);

	//close bracket entry & update sweet16 status.
	if( $meta['sweet16Competition'] == false )
	{	
		if($sweet16 == true) {
			$query = "UPDATE `meta` SET `closed`=1, `sweet16`=1 WHERE `id`=1";
			mysql_query($query) or die(mysql_error());
		}
		else { // prev problems may have accidentally set this, so we're updating this for them.
			$query = "UPDATE `meta` SET `closed`=1, `sweet16`=0 WHERE `id`=1";
			mysql_query($query) or die(mysql_error());
		}
 	}
 	else
 	{
 		if($pastSweet16 == true) {
			$query = "UPDATE `meta` SET `closed`=1, `sweet16`=1 WHERE `id`=1";
			mysql_query($query) or die(mysql_error());
		}
		else { // prev problems may have accidentally set this, so we're updating this for them.
			$query = "UPDATE `meta` SET `closed`=0, `sweet16`=1 WHERE `id`=1";
			mysql_query($query) or die(mysql_error());
		}
 	}


	/***************UPDATE LOSERS************/
	$teams = "SELECT * FROM `master` WHERE `id`=1"; //select teams
	$teams = mysql_query($teams,$db);
	$teams = mysql_fetch_array($teams);

	$childGraph = array();
	$childCounter = 0;

	// build a child graph for parents
	for( $i=33; $i < 64; $i++ )
	{
		$childGraph[$i][0] = ++$childCounter;
		$childGraph[$i][1] = ++$childCounter;
	}

	$losers = $p;

	// for all first round games
	$j=1;
	for($i=1;$i<=32; ++$i) {
		// if there has been a winner
		if($_POST[$i] != NULL)
		{

			// If the first team in this game the winner
			if( $teams[$j] == $_POST[$i] ) {
				// then the next team must be the loser
				$losers[$i] = $teams[$j+1];
			}
			else {
				// else the first team must be the loser
				$losers[$i] = $teams[$j];
			}
		}
		$j += 2;
	}

	// for the rest of the rounds
	for($i=33;$i<64; ++$i) {
		// if there has been a winner
		if($_POST[$i] != NULL)
		{
			// If the winner is the first child
			if( $_POST[ $childGraph[$i][0] ] == $_POST[$i] ) {
				// then the loser must be the second winning child
				$losers[$i] = $_POST[ $childGraph[$i][1] ];
			}
			else {
				// else the loser must be the first winning child
				$losers[$i] = $_POST[ $childGraph[$i][0] ];
			}
		}
	}


	$lose = "SELECT * FROM `master` WHERE id=3";
	$lose = mysql_query($lose,$db);
	if(!(@mysql_fetch_array($lose))) {//if the row has not yet been filled, insert it
		$query = "INSERT INTO `master` (`id`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`,`13`,`14`,`15`,`16`,`17`,`18`,`19`,`20`,`21`,`22`,`23`,`24`,`25`,`26`,`27`,`28`,`29`,`30`,`31`,`32`,`33`,`34`,`35`,`36`,`37`,`38`,`39`,`40`,`41`,`42`,`43`,`44`,`45`,`46`,`47`,`48`,`49`,`50`,`51`,`52`,`53`,`54`,`55`,`56`,`57`,`58`,`59`,`60`,`61`,`62`,`63`) VALUES (3,'$losers[1]','$losers[2]','$losers[3]','$losers[4]','$losers[5]','$losers[6]','$losers[7]','$losers[8]','$losers[9]','$losers[10]','$losers[11]','$losers[12]','$losers[13]','$losers[14]','$losers[15]','$losers[16]','$losers[17]','$losers[18]','$losers[19]','$losers[20]','$losers[21]','$losers[22]','$losers[23]','$losers[24]','$losers[25]','$losers[26]','$losers[27]','$losers[28]','$losers[29]','$losers[30]','$losers[31]','$losers[32]','$losers[33]','$losers[34]','$losers[35]','$losers[36]','$losers[37]','$losers[38]','$losers[39]','$losers[40]','$losers[41]','$losers[42]','$losers[43]','$losers[44]','$losers[45]','$losers[46]','$losers[47]','$losers[48]','$losers[49]','$losers[50]','$losers[51]','$losers[52]','$losers[53]','$losers[54]','$losers[55]','$losers[56]','$losers[57]','$losers[58]','$losers[59]','$losers[60]','$losers[61]','$losers[62]','$losers[63]')";

		mysql_query($query) or die(mysql_error()); //inserts entry into the database

	}
	else { //if the row has been filled, update it
		$query = "UPDATE `master` SET `1`='$losers[1]',`2`='$losers[2]',`3`='$losers[3]',`4`='$losers[4]',`5`='$losers[5]',`6`='$losers[6]',`7`='$losers[7]',`8`='$losers[8]',`9`='$losers[9]',`10`='$losers[10]',`11`='$losers[11]',`12`='$losers[12]',`13`='$losers[13]',`14`='$losers[14]',`15`='$losers[15]',`16`='$losers[16]',`17`='$losers[17]',`18`='$losers[18]',`19`='$losers[19]',`20`='$losers[20]',`21`='$losers[21]',`22`='$losers[22]',`23`='$losers[23]',`24`='$losers[24]',`25`='$losers[25]',`26`='$losers[26]',`27`='$losers[27]',`28`='$losers[28]',`29`='$losers[29]',`30`='$losers[30]',`31`='$losers[31]',`32`='$losers[32]',`33`='$losers[33]',`34`='$losers[34]',`35`='$losers[35]',`36`='$losers[36]',`37`='$losers[37]',`38`='$losers[38]',`39`='$losers[39]',`40`='$losers[40]',`41`='$losers[41]',`42`='$losers[42]',`43`='$losers[43]',`44`='$losers[44]',`45`='$losers[45]',`46`='$losers[46]',`47`='$losers[47]',`48`='$losers[48]',`49`='$losers[49]',`50`='$losers[50]',`51`='$losers[51]',`52`='$losers[52]',`53`='$losers[53]',`54`='$losers[54]',`55`='$losers[55]',`56`='$losers[56]',`57`='$losers[57]',`58`='$losers[58]',`59`='$losers[59]',`60`='$losers[60]',`61`='$losers[61]',`62`='$losers[62]',`63`='$losers[63]' WHERE `id`=3";

		mysql_query($query) or die(mysql_error()); //updates database

	}
	
	$query = "UPDATE `meta` SET `tiebreaker`='$_POST[tiebreaker]' WHERE `id`=1";
	mysql_query($query) or die(mysql_error()); //updates tiebreaker
		
}

else {
		$query = "UPDATE `brackets` SET `tiebreaker`='$_POST[tiebreaker]',`1`='$_POST[1]',`2`='$_POST[2]',`3`='$_POST[3]',`4`='$_POST[4]',`5`='$_POST[5]',`6`='$_POST[6]',`7`='$_POST[7]',`8`='$_POST[8]',`9`='$_POST[9]',`10`='$_POST[10]',`11`='$_POST[11]',`12`='$_POST[12]',`13`='$_POST[13]',`14`='$_POST[14]',`15`='$_POST[15]',`16`='$_POST[16]',`17`='$_POST[17]',`18`='$_POST[18]',`19`='$_POST[19]',`20`='$_POST[20]',`21`='$_POST[21]',`22`='$_POST[22]',`23`='$_POST[23]',`24`='$_POST[24]',`25`='$_POST[25]',`26`='$_POST[26]',`27`='$_POST[27]',`28`='$_POST[28]',`29`='$_POST[29]',`30`='$_POST[30]',`31`='$_POST[31]',`32`='$_POST[32]',`33`='$_POST[33]',`34`='$_POST[34]',`35`='$_POST[35]',`36`='$_POST[36]',`37`='$_POST[37]',`38`='$_POST[38]',`39`='$_POST[39]',`40`='$_POST[40]',`41`='$_POST[41]',`42`='$_POST[42]',`43`='$_POST[43]',`44`='$_POST[44]',`45`='$_POST[45]',`46`='$_POST[46]',`47`='$_POST[47]',`48`='$_POST[48]',`49`='$_POST[49]',`50`='$_POST[50]',`51`='$_POST[51]',`52`='$_POST[52]',`53`='$_POST[53]',`54`='$_POST[54]',`55`='$_POST[55]',`56`='$_POST[56]',`57`='$_POST[57]',`58`='$_POST[58]',`59`='$_POST[59]',`60`='$_POST[60]',`61`='$_POST[61]',`62`='$_POST[62]',`63`='$_POST[63]' WHERE `id`='$_GET[id]'";

		mysql_query($query) or die(mysql_error()); //updates database
}
//scores the brackets
header( 'Location: score.php' );
?>
