<?php
include("admin/functions.php");
include("header.php");

$bracketViewLimit = 1024;

include('endgamesummary_view_module.php');

?>

		<div id="main" class="widetable">
			
			<?php
			
				$summary_query = "SELECT count(*) num_scenarios FROM `end_games` where eliminated = false and round='7'"; //winners
				$summary_data = mysql_query($summary_query,$db);
				$summary_data = mysql_fetch_array($summary_data);
			?>
			
			<div class="full">
				<h2>End Game Scenarios (<?php echo $summary_data['num_scenarios']; ?> Remaining)</h2>
				<h3>Do you still have a chance?</h3>
			</div>
			<div id="border" align="left">
			
				<?php
					$last_place_query = "SELECT max(rank) rank FROM `possible_scores` p WHERE p.`type`='path_to_victory'"; //winners
					$last_place_data = mysql_query($last_place_query,$db);
					$last_place_data = mysql_fetch_array($last_place_data);
					
					$lowestRank = $last_place_data['rank'];
					
					$viewAll = false;					
					if( $summary_data['num_scenarios'] <= 1025 )
					{
						$viewAll = true;
					}
				
				
				?>
				
				<h5>
				Sort:
				<?php
					if( $_REQUEST['sort'] == "pwin" )
					{
						echo "<a href='endgamesummary.php'>Number of Paths</a> | <em>Probability of Winning</em>";
					}
					else
					{
						echo "<em>Number of Paths</em> | <a href='endgamesummary.php?sort=pwin'>Probability of Winning</a>";
					}					
				?>
				</h5>
				
				<table border="0" >
					<tr valign="top">
					<?php
					for( $showRanks=1; $showRanks <= $maxScoreRanks; $showRanks++ )
					{
						echo "<td>";
						$rankName = ordinal_suffix( $showRanks ) . " Place";
						createSummaryTable($db, $showRanks, $rankName, $viewAll, $summary_data['num_scenarios'], $_REQUEST['sort']);
						echo "</td>";

						if( $showRanks % 3 == 0 ) 
						{
							echo "</tr>";
							if( $showRanks < $maxScoreRanks )
							{
								echo "<tr>";
							}
						}
					}
					if( ($showRanks-1)%3 != 0 )
					{
						echo "</tr>";
					}
					?>
					
					<tr>
						<td colspan='3'><?php createSummaryTable($db, $lowestRank, "Last Place", $viewAll, $summary_data['num_scenarios'],$_REQUEST['sort']); ?></td>
					</tr>
				</table>	
			</div>			
		</div>
		<div id="footer"></div>
	</div>
</body>
</html>
