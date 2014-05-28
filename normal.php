<?php
include("header.php");
session_start();


function getRankFormat ($original, $hypothetical)
{
	if( $hypothetical < $original )
	{
		$change = "<span class='right'>+".($original-$hypothetical)."</span>";
	}
	else if( $hypothetical > $original )
	{
		$change = "<span class='wrong'>-".($hypothetical-$original)."</span>";
	}
	else
	{
		$change = "+0";
	}
	
	return $change."&nbsp;(".$hypothetical.")";
}

// get sort style
if( $_GET['sort'] != NULL )
{
	$sortStyle = $_GET['sort'];
}
else
{
	$sortStyle = 'main';
}


// get info about scoring systems
$scoringInfo = array();
$scoringDescriptions = "";
$scoringTables = array();

$scoringTypeNames = array();
$scoringTypesQuery = "SELECT scoring_type name, scoring_info.display_name, description ".
	"FROM scores, scoring_info WHERE scores.scoring_type = scoring_info.type GROUP BY scoring_type ORDER BY display_name";
$scoringTypes = mysql_query($scoringTypesQuery,$db) or die(mysql_error());

$j = 0;
while($scoringType = mysql_fetch_array($scoringTypes))
{
	// store scoring system ids
	$scoringSystem = $scoringType['name'];
	$scoringTypeNames[$j] = $scoringSystem;
	
	// store display names and descriptions
	$scoringInfo[$scoringType['name']]['name'] = $scoringType['display_name'];
	$scoringInfo[$scoringType['name']]['description'] = $scoringType['description'];
	
	if( $scoringSystem != 'main' && $scoringSystem == $sortStyle )
	{
		// create a select list for each scoring type for sorting purposes
		$additionalSortingSources .= ", (SELECT id, score FROM scores WHERE scoring_type = '".$scoringSystem."' ) ".$scoringSystem."";	
		// create a where condition for each scoring type for sorting purposes
		$additionalSortingConditions .= "AND ".$scoringSystem.".id = brackets.id ";
	}
		
	// create html descriptions of each scoring system
	
	// just get this from descriptions since the html is already generated
	$scoringTables[$j] = $scoringInfo[$scoringType['name']]['description'];
	
	
	$scoringDescriptions .= "\"".$scoringTables[$j]."\",";
	
	
	// get rankings for each scoring system
	$rankingQuery = "SELECT id, score FROM scores WHERE scoring_type = '".$scoringSystem."' ORDER BY score DESC";
	$ranking = mysql_query($rankingQuery,$db) or die(mysql_error());
	
	$i = 0;
	$rankCounter = 0;
	while($entry = mysql_fetch_array($ranking))
	{
		if( $rankCounter == 0 )
		{
			$topScore = $entry['score'];
			$prevScore = $topScore;
			$rankCounter =1;
			$i=1;
		}
		
		if( $entry['score'] != $prevScore )
		{
			$prevScore = $entry['score'];
			$rankCounter = $i;
		}
		
		$rankings[$scoringSystem][$entry['id']] = $rankCounter;
		$i++;
	}
	
	$j++;
}
$scoringDescriptions .= "\"\"";


?>
	<script type="text/javascript" src="js/wz_tooltip/wz_tooltip.js"></script>
	<script type="text/javascript">
		
		scoringDescriptions = new Array( <?php echo $scoringDescriptions; ?> );
		
		hideTip = true;
		lastVal = -1;
				
		function showScoring( e, val, delay )
		{
			hideTip = false;
			if( lastVal != val )
			{			
				if(!e)
				{
					Tip(scoringDescriptions[val],DELAY,delay, FADEIN, 200, FADEOUT, 200);
					
				}
				else
				{
					// firefox and safari
					Tip(scoringDescriptions[val],DELAY,delay, FADEIN, 200, FADEOUT, 200);
				}
				
				lastVal = val;
				
				return true;
			}
		}
		
		function clearScoring()
		{
			hideTip = true;
			setTimeout( 'closeTip()', 500 );
			
			return true;
		}
		
		function closeTip()
		{
			if( hideTip == true )
			{
				UnTip();
				lastVal = -1;
			}
		}
		
	</script>
	<style type="text/css" >
		.content
			{
				width:1100px;
			}
			
			#main
			{
				width:1100px;
			}
	</style>
		<div id="main" class="widetable">
			<div class="full">

				<h2>The Standings </h2>
				<h3>WHERE DO YOU RANK?  </h3>
				</div>
				<div class="recentComment">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Recent Smack Talk</div>
			<div id="border" align="left">
			  	<table class='scoredetail' align="left" width='100%'>
					<tr>
						<td><div align="center"><strong>Rank</strong></div></td>
						<td><div align="center"><strong>Name</strong></div></td>
						<td><div align="center"><strong>Score</strong></div></td>
						<td><div align="center"><strong>PPR</strong></div></td>
						<td><div align="center"><strong><a href="standings.php?type=best">Best</a></strong></div></td>
						<td><div align="center"><strong>Tiebreaker</strong></div></td>
						
						<?php
							for( $i=0; $i<count($scoringTypeNames); $i++ )
							{
								echo "<td onmouseover='showScoring( event, ".$i.",0);' onmouseout='clearScoring();' >";
								if( $scoringTypeNames[$i] == $sortStyle )
								{
									echo "<div align=\"center\" class='selected_sort'>";
								}
								else
								{
									echo "<div align=\"center\">";
								}
								echo "<strong><a href=\"standings.php?type=normal&sort=".$scoringTypeNames[$i]."\">";
								echo $scoringInfo[$scoringTypeNames[$i]]['name']."</a></strong></div></td>";
							}
						?>
					</tr>
					<?php				
						$query = "SELECT main.id, main.name, main.score, best_main.score AS b_score, brackets.tiebreaker, brackets.63, brackets.email, brackets.eliminated, brackets.person
								FROM 
								scores main, 
								best_scores best_main, 
								brackets 
								
								".$additionalSortingSources."
								
								WHERE 
								main.scoring_type = best_main.scoring_type AND 
								main.id = best_main.id AND 
								main.scoring_type = 'main' AND 
								main.id = brackets.id 
								
								".$additionalSortingConditions."
								
								ORDER BY 
								
								".$sortStyle.".score DESC, best_main.score DESC,
								
								main.name ASC";
						
						$result = mysql_query($query,$db) or die(mysql_error());
						$eliminated=0;
						$top_score = -1;
						
						$commentMap = getCommentsMap($db);
						
						while($user = mysql_fetch_array($result))
						{
							$useremail = $user['email'];
							
							if( $top_score < 0 )
							{
								$top_score = $user['score'];
							}

							// Print out the contents of each row into a table
							if (strtolower($useremail) == strtolower($_COOKIE['useremail']) & $useremail != "")
							{
								echo '<tr class="thisuser">';
							}
							else
							{
								if( $user['eliminated'] > 0 )
								{
									echo "<tr class='eliminated'>";
									$eliminated=1;
								}
								else
								{
									echo "<tr>";
								}
							}
							
							echo "<td align='right'>&nbsp;&nbsp;".$rankings[$sortStyle][$user['id']]."</td><td>";
 							/* If the user is the admin (has the admin cookie set), then show the names of the people that the brackets belong to. */
							//if( isset($_SESSION['admin']) && $_SESSION['admin'] == true) 
							
							// Simply allow anyone who is logged in to see the user name
							if (isset($_COOKIE['useremail']) == true)
							{
								echo "<a href=\"view.php?id=$user[id]\">" . stripslashes($user[name]) . "</a>" . " (" . stripslashes($user[person]) . ")";
							}
							else
							{
								echo "<a href=\"view.php?id=$user[id]\">" . stripslashes($user[name]) . "</a>";
							}
							if ($user['eliminated'] > 0 & strtolower($useremail) == strtolower($_COOKIE['useremail'] )) {
								echo " - Eliminated";
							}
							if ($commentMap[$user['id']] > 0) {
								echo "<span class=\"recentComment\"><a href='view.php?id=".$user['id']."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
							}
							echo "</td><td>";
							echo $user['score'];
							echo "</td><td>";
							echo $user['b_score']-$user['score'];
							echo "</td><td>";
							echo $user['b_score'];
							echo "</td><td>";
							echo $user['63'];
							echo " - ";
							echo $user['tiebreaker'];
							echo "</td>";
							
							for( $j=0; $j<count($scoringTypeNames); $j++ )
							{
								echo "<td onmouseover='showScoring( event, ".$j.",2000);' onmouseout='clearScoring();'>";
								echo getRankFormat( $rankings['main'][$user['id']], $rankings[$scoringTypeNames[$j]][$user['id']] )."</td>";
							}
							echo "</tr>";
						}
					?>
				</table>
				<?php
					if( $eliminated==1 ) {
						echo "<span class='eliminated'>&nbsp;&nbsp;Eliminated&nbsp;&nbsp;</span>";
					}
				?>
				</div>			
		</div>

		<div id="footer">
		</div>
	</div>
</body>
</html>
