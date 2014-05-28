<?php
include("admin/functions.php");
include("header.php");

function drawScoringTable( $db, $winners_data, $custompoints, $seedMap,  $roundStart, $roundEnd, $roundNum, $tableWidth )
{
	$totalPointsForRound = 0;
	$winnerListForRound = array();
	$j = 0;
	// Get the winners for this round
	// Get the total points for this round
	for( $i=$roundStart; $i<= $roundEnd; $i++)
	{
		if( $winners_data[$i] != NULL )
		{
			$seedvalue = $seedMap[$winners_data[$i]];
			$gameValue = $custompoints[ $seedvalue ][ $roundNum ];
			$winnerListForRound[$j] = array( $gameValue, $seedvalue, $i, $winners_data[$i] );
			$totalPointsForRound += $gameValue;
			$j++;
		}
	}
	
	// sort winners by reverse order of seed
	$numWinners = $j;
	
	if( $numWinners > 0 )
	{
		rsort($winnerListForRound);
		
		// print out winners header
		echo "<a name='round".$roundNum."'>
			<a href='#top'>Top</a> |
			<a href='#round1'>First Round</a> | 
			<a href='#round2'>Second Round</a> | 
			<a href='#round3'>Sweet 16</a> | 
			<a href='#round4'>Elite Eight</a> | 
			<a href='#round5'>Final Four</a> | 
			<a href='#round6'>Championship</a>";
			
		echo "<table class='scoredetail' cellspacing='0' >\n";
		echo "<tr class='tableheader'><td colspan='4'>Round ".$roundNum."</td><td colspan='".($numWinners)."'>Winners</td></tr>";
		echo "<tr class='tableheader'><td>Bracket</td><td>T</td><td>R".$roundNum."</td><td>#</td>";
		for( $i = 0; $i < $numWinners; $i++ )
		{
			
			//$width = floor($winnerListForRound[$i][0]/$totalPointsForRound * $tableWidth);
			
			echo "<td onmouseover=\"showTeam( event, ".$winnerListForRound[$i][2].");\" onmouseout='clearTeam();'>"
				.$winnerListForRound[$i][1]."<br>(".$winnerListForRound[$i][0].")</td>";
		}
		echo "</tr>";
		
		$commentMap = getCommentsMap($db);
		
		// Now, get the list of brackets in score order
		$bracketsQuery = "SELECT scores.id, scores.name, scores.score, brackets.* FROM scores, 
			brackets WHERE scores.scoring_type='main' AND scores.id = brackets.id ORDER BY scores.score DESC, scores.name ASC";
		$brackets = mysql_query($bracketsQuery,$db) or die(mysql_error());
		
		$rank = 0;
		$rankCounter = 1;
		$totalScore = 0;
		$totalPointsEarnedByUsers = 0;
		$totalHitsByUsers = 0;
		while($bracket = mysql_fetch_array($brackets))
		{
			if( $rank==0 )
			{
				$top_score = $brackets['score'];
				$prev_score = $brackets['score'];
				$rankCounter = 1;
				$rank = $rankCounter;
			}
			if( $bracket['score'] != $prev_score ) {
				$prev_score = $bracket['score'];
				$rank = $rankCounter;
			}
			
			$useremail = $bracket['email'];
		
			if ($useremail == $_COOKIE['useremail'] & $useremail != "")
			{
				echo '<tr class="thisuser">';
			}
			else
			{
				echo "<tr>";
			}
			
			// Simply allow anyone who is logged in to see the user name
			if (isset($_COOKIE['useremail']) == true)
			{
				echo "<td class='bracketname'><a href='view.php?id=".$bracket['id']."'>".$rank.". ".stripslashes($bracket['name'])."</a>" . " (" . stripslashes($bracket['person']) . ")";
			}
			else
			{
				echo "<td class='bracketname'><a href='view.php?id=".$bracket['id']."'>".$rank.". ".stripslashes($bracket['name'])."</a>";
			}
			
			
			if ($commentMap[$bracket['id']] > 0) {
				echo " <span class=\"recentComment\"><a href='view.php?id=".$bracket['id']."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
			}
			
			echo "</td><td>".$bracket['score']."</td>";
			
			$totalScore += $bracket['score'];
			
			$totalEarnedForRound = 0;
			$numHitsForRound = 0;
			for( $i = 0; $i < $numWinners; $i++ )
			{
				if( $winnerListForRound[$i][3] == $bracket[ $winnerListForRound[$i][2] ] )
				{
					$status[$i] = "hit";
					if( $winnerListForRound[$i][4] == NULL )
					{
						$winnerListForRound[$i][4] = 1;
					}
					else
					{
						$winnerListForRound[$i][4]++;
					}
					$totalEarnedForRound += $winnerListForRound[$i][0];
					$numHitsForRound++;
				}
				else
				{
					$status[$i] = "miss";
				}
				
			}
			
			echo "<td>".$totalEarnedForRound."</td>";
			echo "<td>".$numHitsForRound."</td>";
			
			$totalPointsEarnedByUsers += $totalEarnedForRound;
			$totalHitsByUsers += $numHitsForRound;
			
			for( $i = 0; $i < $numWinners; $i++ )
			{
				echo "<td class='".$status[$i]."' onmouseover=\"showTeam( event,".$winnerListForRound[$i][2].");\" onmouseout='clearTeam();'>&nbsp;</td>";
			}
			echo "</tr>";
			
			$rankCounter++;
		}

		$avgPointsThisRound = round( $totalPointsEarnedByUsers/ ($rankCounter-1), 2 );
		$avgScore = round( $totalScore/ ($rankCounter-1), 2);
		$avgHits = round( $totalHitsByUsers/ ($rankCounter-1), 2);
		
		echo "<tr class='tablefooter'><td>Averages/Totals</td><td>".$avgScore."</td><td>"
			.$avgPointsThisRound."</td><td>".$avgHits."</td>";
		for( $i = 0; $i < $numWinners; $i++ )
		{
			if (!$winnerListForRound[$i][4]) {
				$winnerListForRound[$i][4] = 0;
			}
			echo "<td onmouseover=\"showTeam( event,".$winnerListForRound[$i][2].");\" onmouseout='clearTeam();'>".$winnerListForRound[$i][4]."</td>";
		}
		echo "</tr>";
		echo "</table><br />\n";
	}
}

?>
		<script type="text/javascript" src="js/wz_tooltip/wz_tooltip.js"></script>
		<style type="text/css">
			.content
			{
				width:1250px;
			}
			
			#main
			{
				width:1250px;
			}

		</style>
		
		<?php
				$winners_query = "SELECT * FROM `master` WHERE `id`=2"; //winners
				$winners_data = mysql_query($winners_query,$db);
				$winners_data = mysql_fetch_array($winners_data);
				
				$teamNameTable = "'',";
				for( $i=1; $i< 64; $i++)
				{
					$teamNameTable .= "'" . mysql_real_escape_string($winners_data[$i]) . "',";
				}
				$teamNameTable .= "''";
		?>
				
		<script type="text/javascript">
		
		teamNames = new Array( <?php echo $teamNameTable ?> );
		
		function showTeam( e, val )
		{
			selectedIndex = -1;
			columnHeader = "";
			if(!e)
			{
				// IE6 and earlier only, IE 7+ already has e.
				e = window.event;
			}
			if( e.srcElement )
			{
				selectedIndex = e.srcElement.cellIndex;
				columnHeader = e.srcElement.parentNode.parentNode.parentNode.rows[1].cells[selectedIndex];
			}
			else
			{
				// firefox and safari
				selectedIndex = e.target.cellIndex;
				columnHeader = e.target.parentNode.parentNode.parentNode.rows[1].cells[selectedIndex];
			}
			teamName = teamNames[val];
			headerTxt = teamName + " " + columnHeader.innerHTML;
			Tip(headerTxt,DELAY,0);			
			return true;
		}
		
		function clearTeam()
		{
			UnTip();
			return true;
		}
		
		</script>
		<div id="main" class="widetable">
			
			<div class="full">
				<h2>Scoring Detail</h2>
				<h3>Who picked what team?</h3>
			</div>
			<div id="border" align="left">
								
				<?php				
					$custompoints = getScoringArray($db, 'main');
					$seedMap = getSeedMap($db);
					
					drawScoringTable( $db, $winners_data, $custompoints, $seedMap, 63, 63, 6, 800);
					
					drawScoringTable( $db, $winners_data, $custompoints, $seedMap, 61, 62, 5, 800);
					
					drawScoringTable( $db, $winners_data, $custompoints, $seedMap, 57, 60, 4, 800);
					
					drawScoringTable( $db, $winners_data, $custompoints, $seedMap, 49, 56, 3, 800);
					
					drawScoringTable( $db, $winners_data, $custompoints, $seedMap, 33, 48, 2, 800);
					
					drawScoringTable( $db, $winners_data, $custompoints, $seedMap, 1, 32, 1, 800);
					
					?>
			</div>			
		</div>
		<div id="footer"></div>
	</div>
</body>
</html>
