<?php

function drawEndGames( $pageMode, $id, $rank, $endgameIds, $db )
{

	$commentMap = getCommentsMap($db);

?>

<style type="text/css">
	.content
	{
		width:1250px;
	}
	
	#main
	{
		width:1250px;
	}
	.scoredetail td
	{
		text-align:center;
	}

</style>
<script type="text/javascript" src="js/wz_tooltip/wz_tooltip.js"></script>
<script type="text/javascript">
				
			
	function showTip( e, val, delay )
	{
		if(!e)
		{
			Tip(val,DELAY,delay, FADEIN, 200, FADEOUT, 200);
			
		}
		else
		{
			// firefox and safari
			Tip(val,DELAY,delay, FADEIN, 200, FADEOUT, 200);
		}
							
		return true;
	}
	
	function clearTip()
	{
		UnTip();
		return true;
	}
	
</script>
<div id="main" class='widetable'>
	<?php
		$roundMap = getRoundMap();
		$seedMap = getSeedMap($db);
		$scoring = getHistoricalProbabilities();
		$childGraph = getChildGraph();
		
		if( $pageMode == "view_all" || $pageMode == "bracket" || $pageMode == "selected_end_games" )
		{ 
			if( $pageMode == "view_all" )
			{
				$bracket_query = "select count(*) num_paths from possible_scores p where rank='".$rank."' and p.`type`='path_to_victory'";
				$bracket_data = mysql_query($bracket_query,$db) or die(mysql_error());
				$bracket_data = mysql_fetch_array($bracket_data);
			}
			else if( $pageMode == "selected_end_games")
			{
				$bracket_data['num_paths'] = count($endgameIds);
			}
			else
			{
				$probQuery = "SELECT `probability_win` FROM `probability_of_winning` WHERE `id` = '".$id."' and `rank`='".$rank."'";
				$prob_data = mysql_query($probQuery,$db) or die(mysql_error());
				$prob_data = mysql_fetch_array($prob_data);
				$pBracketWin = $prob_data['probability_win'];
				
				$bracket_query = "select name, count(*) num_paths, id from brackets b, possible_scores p where b.id = p.bracket_id and id ='".$id."' and rank='".$rank."' and p.`type`='path_to_victory' group by b.name";
				$bracket_data = mysql_query($bracket_query,$db) or die(mysql_error());
				$bracket_data = mysql_fetch_array($bracket_data);
			}
			
						
			if( $pageMode == "view_all" )
			{
				$titleText = "End Game Scenarios For Everyone";
			}
			else if( $pageMode == "selected_end_games")
			{
				$titleText = "Selected End Game Scenarios";
			}
			else
			{
				$titleText = "End Game Scenarios For ".$bracket_data['name'];				
			}
		
		?>
	<div class="full">
		<h2><?php echo $titleText;?></h2>
		<h3>
		<?php
			 echo $bracket_data['num_paths'] ;?> possible paths to finish #<?php echo $rank ;
			if( $pageMode == "bracket" )
			{
				if( $pBracketWin )
				{
					echo ", Probability of winning: ".number_format($pBracketWin*100,2)."%";
				}
			}
		
		?></h3>
	</div>
	<div id="border" align="left">
		<ul>
		<?php
			if( $pageMode == "bracket" || $pageMode == "view_all" )
			{
				echo "<li><a href='endgamesummary.php'>Back to End Game Scenarios Summary</a></br>";
			}
		?>
		<?php
			if( $pageMode == "bracket" )
			{
				echo "<li><a href='view.php?id=".$id."'>View Bracket</a>";
								
				if ($commentMap[$id] > 0) {
					echo " <span class=\"recentComment\"><a href='view.php?id=".$id."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
				}
				
				echo "</li>";
			}
		?>
		</ul>			
		<?php
			
				$winners_query = "SELECT * FROM `master` WHERE `id`=2"; //winners
				$winners_data = mysql_query($winners_query,$db);
				$winners_data = mysql_fetch_array($winners_data);
				
				if( $pageMode == "view_all" )
				{
					$end_game_query = 
						"select b.id, e.id eid, score, name, e.`49`,e.`50`,e.`51`,e.`52`,e.`53`,e.`54`,e.`55`,e.`56`,e.`57`,e.`58`,e.`59`,e.`60`,e.`61`,e.`62`,e.`63` ".
						"from possible_scores p, brackets b, end_games e ".
						"where e.eliminated = false and p.bracket_id = b.id and e.id = outcome_id and e.round='7'  and p.`type`='path_to_victory' and rank=".$rank.
						" order by `name`, `63`,`62`,`61`,`60`,`59`,`58`,`57`,`56`,`55`,`54`,`53`,`52`,`51`,`50`,`49`, score";
				}
				else if( $pageMode == "selected_end_games")
				{
					$endgameList = "(";
					
					foreach( $endgameIds as $id )
					{
						$endgameList .= $id.",";
					}
					
					$endgameList .= " -1)";
				
					$end_game_query = 
						"select b.id, e.id eid, score, name, e.`49`,e.`50`,e.`51`,e.`52`,e.`53`,e.`54`,e.`55`,e.`56`,e.`57`,e.`58`,e.`59`,e.`60`,e.`61`,e.`62`,e.`63` ".
						"from possible_scores p, brackets b, end_games e ".
						"where p.bracket_id = b.id and e.id = outcome_id and p.`type`='path_to_victory' and rank=".$rank." and outcome_id in ".$endgameList.
						" order by `name`, `63`,`62`,`61`,`60`,`59`,`58`,`57`,`56`,`55`,`54`,`53`,`52`,`51`,`50`,`49`, score";						
				}
				else
				{
					$end_game_query = 
						"select e.id eid, score, name, e.`49`,e.`50`,e.`51`,e.`52`,e.`53`,e.`54`,e.`55`,e.`56`,e.`57`,e.`58`,e.`59`,e.`60`,e.`61`,e.`62`,e.`63` ".
						"from possible_scores p, brackets b, end_games e ".
						"where e.eliminated = false and b.id='".$id."'  and p.`type`='path_to_victory'and p.bracket_id = b.id and e.id = outcome_id and e.round='7' and rank=".$rank.
						" order by `63`,`62`,`61`,`60`,`59`,`58`,`57`,`56`,`55`,`54`,`53`,`52`,`51`,`50`,`49`";
				}
				
				$end_game_data = mysql_query($end_game_query,$db) or die(mysql_error());
				
				echo "<table class='scoredetail' border='1' cellpadding='3'>";
				echo "<tr class='tableheader'>\n";
				echo "<td>#</td>";
				if( $pageMode == "view_all" || $pageMode == "selected_end_games" )
				{
					echo "<td>Winner</td>";
				}
				echo "<td>Bracket Score</td>";
				echo "<td colspan='8'>Sweet 16 Winners</td>";
				echo "<td colspan='4'>Elite 8 Winners</td>";
				echo "<td colspan='2'>Final 4 Winners</td>";
				echo "<td>Champ</td>";
				echo "<td>P(Win)</td>";
				echo "</tr>";
				
				
				
				$i =1;
				while($bracket = mysql_fetch_array($end_game_data))
				{
					echo "<tr>\n";
					echo "<td><a href='if.php?id=".$bracket['eid']."'>".$i."</a></td>\n";
					if( $pageMode == "view_all" || $pageMode == "selected_end_games" )
					{
						echo "<td><a href='view.php?id=".$bracket['id']."'>".stripslashes($bracket['name'])."</a>";
						if ($commentMap[$bracket['id']] > 0) {
							echo " <span class=\"recentComment\"><a href='view.php?id=".$bracket['id']."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
						}
						echo "</td>\n";
					}
					echo "<td>".$bracket['score']."</td>\n";
					
					$probability = 1;
					
					for( $j=49; $j<64; $j++ )
					{
						if( $winners_data[$j] != NULL && $winners_data[$j] == $bracket[$j] )
						{
							echo "<td class='right'>".$bracket[$j]."</td>\n";
						}
						else
						{

							// figure out the seed of the predicted loser
							// check the master bracket for the loser
							$loser = "";
							
							$child[0] = $winners_data[$childGraph[$j][0]];
							$child[1] = $winners_data[$childGraph[$j][1]];
							$child[2] = $bracket[$childGraph[$j][0]];
							$child[3] = $bracket[$childGraph[$j][1]];

							foreach( $child as $team )
							{
								if( $team != null and $team != $bracket[$j] )
								{
									$loser = $team;		
									break;	
								}
							}									
							
							//echo  $roundMap[$j]." - ".$seedMap[$bracket[$j]].". ".$bracket[$j]." v ".$seedMap[$loser].". ".$loser." = ".$scoring[ $roundMap[$j] ][ $seedMap[$bracket[$j]] ][ $seedMap[$loser] ]."<br>";
							$special = "";
							$pWin = $scoring[ $roundMap[$j] ][ $seedMap[$bracket[$j]] ][ $seedMap[$loser] ];
							if( $pWin == null || $pWin <= 0 || $pWin >= 1 )
							{
								$special = " imputed (original: ".$pWin.")";
								$winSeed = $seedMap[$bracket[$j]];
								$loseSeed =  $seedMap[$loser];
								$pWin = 1 - ($winSeed)/($winSeed + $loseSeed);
							}
							
							echo "<td onmouseover=\"showTip(event,'".$pWin.$special."')\"  onmouseout=\"clearTip()\" >".$bracket[$j]."</td>\n";
							
							$probability *= $pWin;
						}
					}
					
					echo "<td onmouseover=\"showTip(event,".$probability.")\"  onmouseout=\"clearTip()\" >".number_format($probability,4)."</td>";

					echo "</tr>\n";
					$i++;
				}
		
				echo "</table>\n";
			}
		
		?>
		

	</div>
</div>


<?php

}

?>