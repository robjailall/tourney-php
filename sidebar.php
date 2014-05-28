<div class="nav">

<?php

function getRanksForScores( $scoreData )
{
	$rankCounter = 1;
	$currentScore = -1;
	foreach( $scoreData as $scoreInfo )
	{
		if( $currentScore != $scoreInfo['score'] )
		{
			$rank = $rankCounter;
		}

		$currentScore = $scoreInfo['score'];

		$rankMap[ $scoreInfo['id'] ] = $rank;

		$rankCounter += 1;
	}

	return $rankMap;
}

$closed = "SELECT closed FROM `meta` WHERE id=1 LIMIT 1";
$closed = mysql_query($closed,$db); //boolean if bracket submission is over
$closed = @mysql_fetch_array($closed); //boolean if bracket submission is over

if($closed[0] == 1)
{
	$query = 'SELECT * FROM `scores` WHERE `scoring_type`="main" ORDER BY `score` DESC, `name` ASC';
	$result = mysql_query($query,$db) or die(mysql_error());  
	$scores;
	while($user = mysql_fetch_array($result))
	{
		$scores[] = $user;				
	}
	
	$rankMap = getRanksForScores( $scores );
	
	$commentMap = getCommentsMap($db);	
}

if (isset($_COOKIE['useremail']) == false) {
	echo '
	<h2>User Login</h2>
	<form action="getemail.php" method="post">
	<p>Email Address: <input type="text" name="useremail" />
	<input type="submit" value="Login"></p>
	</form>';
}
else {
	$useremail = $_COOKIE['useremail'];
	
	$getuser = "SELECT b.id, b.email, b.name, b.person, s.score FROM `brackets` b, `scores` s WHERE email='$useremail' and s.id = b.id  and s.scoring_type = 'main' order by s.score desc";
	
	$result = mysql_query($getuser,$db);
	
	$myBrackets = "<table width='100%'>";
	
	while($bracket = mysql_fetch_array($result))
	{
		$username = $bracket['person'];
		$bracketName = stripslashes($bracket['name']);
		$myBrackets .= "<tr><td>".$rankMap[$bracket['id']].". <a href='view.php?id=".$bracket['id']."'>$bracketName</a>";
		if ($commentMap[$bracket['id']] > 0) {
			$myBrackets .= " <span class=\"recentComment\"><a href='view.php?id=".$bracket['id']."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
		}		
		
		$myBrackets .= "</td></tr>";
	}
	$myBrackets .= "</table>";
	
        // boefore tourney gets going, this can be blank sometimes, so let's populate it.
        if( $username == "" )
        {
		$getuser = "SELECT email, person FROM `brackets` WHERE email='$useremail'";
		$getuser = mysql_query($getuser,$db); //grabs administrator's email
		$getuser = mysql_fetch_array($getuser);
		$username = $getuser['person'];        
        }	
	echo '<p><div id="logout">';
	if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) 
	{
		echo '<a href="admin/index.php">[Admin Area]</a> ';
	}
	echo '<a href="getemail.php?type=logout">[Logout]</a></div></p>';
	echo "<h2>Hello " . $username . "</h2>";
	
	echo $myBrackets;
		
}
	
	?>
	<br>
		<?php
		$top=5;  // might make this a config setting someday

		echo "<h2>Top $top Standings</h2> ";
		if($closed[0] == 1)
		{
			if( count( $scores > 1 ) )
			{
				// Print out the top entries in an ordered list
				$lastRank = -1;
				foreach( $scores as $score )
				{
					$rank = $rankMap[$score['id']];
					if( $lastRank != $rank )
					{
						$lastRank = $rank;
					}

					if( $rank > $top )
					{
						break;
					}				
					
					$id = $score['id'];
					$name = stripslashes($score['name']);
					echo "$rank - <a href=\"view.php?id=$id\">$name</a>";
					
					if ($commentMap[$score['id']] > 0) {
						echo " <span class=\"recentComment\"><a href='view.php?id=".$score['id']."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
					}
					echo "<br/>";
				}
				echo "<a href=\"standings.php?type=normal\">[full standings]</a><br/>";
			}
			else
			{				
				echo "<p>Standings will be available after the first games are completed.</p>\n";
			}
			

		}
		else
			echo "<p>Standings will be available when the tournament begins.</p>\n";
		?>

	<br />
	<h2>Site Stats </h2>
	<?php
	//calculate some stats
	$query = "SELECT COUNT(id) FROM `brackets`";
	$entries = mysql_query($query,$db);
	$entries = @mysql_fetch_array($entries);	

	$query = "SELECT COUNT(id) FROM `brackets` WHERE `paid`=1";
	$paidentries = mysql_query($query,$db);
	$paidentries = @mysql_fetch_array($paidentries);

	$query = "SELECT COUNT(DISTINCT email) FROM `brackets`";
	$participants = mysql_query($query,$db);
	$participants = @mysql_fetch_array($participants);	

	?>
	<ul id ='stats'>
	<li> Participants: <?php echo $participants[0]; ?></li>
	<li>&nbsp;&nbsp; Total Brackets: <?php echo $entries[0]; ?></li>


		<?php
		$needul = 1;
		if($closed[0] == 1) {
			$query = "SELECT cost,cut,cutType FROM `meta` WHERE id=1";
			$pot = mysql_query($query,$db);
			$pot = mysql_fetch_array($pot);
			
			if($pot['cost'] != 0) {		
				if($pot['cutType']==1) {
					$cut = (100-$pot['cut'])/100;
					$totalPot = round($paidentries[0]*$pot['cost']*$cut,2);
				}
				else {
					$totalPot = $paidentries[0]*$pot['cost']-$pot['cut'];
				}
				echo "<li>&nbsp;&nbsp; Paid Brackets: ".$paidentries[0]." </li>\n";
				echo "<li>&nbsp;&nbsp; Pot Size: $",$totalPot,"</li>\n";
			}
			
			if($entries[0] != 0) {
				$query = "SELECT `63`, COUNT(*) AS `quantity` FROM `brackets` GROUP BY `63` ORDER BY `quantity` DESC";
				$favorites = mysql_query($query,$db) or die(mysql_error());
				echo "<li id=\"stats\"><b>Favorite Teams:</b></li></ul>\n";
				$needul=0;
				while( $favorite = mysql_fetch_array($favorites) ) {
					$percent = round($favorite['quantity']/$entries[0]*100,2);
					echo "<p>&nbsp;&nbsp; <a href='picks.php?team=$favorite[0]'>$favorite[0]</a> ($percent%)</p>\n";
				}
			}

		}
		if($needul == 1) echo "</ul>";

		?>
</div>
