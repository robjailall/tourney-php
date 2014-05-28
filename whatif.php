<?php
include("admin/functions.php");
include("admin/database.php");

function drawBracketSelectBox($gameId, $winners, $postData, $parentGraph, $childGraph, $seedMap )
{
	if( $gameId >= 49 )
	{		
		$index = 0;
		
		if( $childGraph[$parentGraph[$gameId]][1] == $gameId )
		{
			$index = 1;
		}
	
		$optionString = "";
		
		$alreadyWonCount = 0;
		
		$firstTeam = $winners[$childGraph[$gameId][0]];
		
		if( "" != $postData["game".$childGraph[$gameId][0]] )
		{
			$firstTeam = $postData["game".$childGraph[$gameId][0]];
		}		
		if( $firstTeam != "")
		{
			$seed = $seedMap[$firstTeam];
			
			$optionString .= "<option value='".$firstTeam."' ";
			if( $winners[$gameId] == $firstTeam )
			{
				$optionString .= " selected ";
				$alreadyWonCount += 1;
			}
			if( $postData["game".$gameId] == $firstTeam )
			{
				$optionString .= " selected ";
			}
			$optionString .= ">".$seed.". ".$firstTeam."</option>";
		}
		else
		{
			$optionString .=  "<option></option>";
		}
		
		
		$secondTeam = $winners[$childGraph[$gameId][1]];
		
		if( "" != $postData["game".$childGraph[$gameId][1]] )
		{
			$secondTeam = $postData["game".$childGraph[$gameId][1]];
		}		
		if( $secondTeam != "")
		{
			$seed = $seedMap[$secondTeam];
			
			$optionString .= "<option value='".$secondTeam."' ";
			if( $winners[$gameId] == $secondTeam )
			{
				$optionString .= " selected ";
				$alreadyWonCount += 1;
			}
			if( $postData["game".$gameId] == $secondTeam )
			{
				$optionString .= " selected ";
			}
			$optionString .= ">".$seed.". ".$secondTeam."</option>";
		}
		else
		{
			$optionString .=  "<option></option>";
		}
		
		$disabledString = "";
		if( $alreadyWonCount == 1 )
		{
			$disabledString = "disabled";
		}
		
		echo "<select ".$disabledString." name='game".$gameId."' size='2' class='forms' id='game".$gameId."' onchange=\"update('game".$gameId."','game".$parentGraph[$gameId]."',".$index.");\">";
		echo $optionString;
		echo "</select>";
	}
	else
	{
		echo "Not a sweet 16 game or later";
	}
}

$childGraph = getChildGraph();
$parentGraph = getParentGraph();

$team_query = "SELECT * FROM `master` WHERE `id`=2"; //select winners
$team_data = mysql_query($team_query,$db);
$team_data = mysql_fetch_array($team_data);

$seedData = getSeedMap($db);

$dataPosted = false;
if( $_POST['Submit'] )
{
	$dataPosted = true;
}

//clean input
for($i=49;$i<64;++$i)
{
	if( $_POST['game'.$i] != "")
	{
		$if_data[$i] = $_POST['game'.$i];
	}	
	else
	{
		$if_data[$i] = $team_data[$i];
	}
}


// check if all games filled in
$partialEndGame = false;
$numSelectedGames = 0;
foreach( $if_data as $chosenGame )
{	
	if( $chosenGame == "" )
	{
		$partialEndGame = true;
	}
	else {
		$numSelectedGames += 1;
	}
}

$endGameIds;
$conditions;
for($i=49;$i<64;++$i)
{
	if( $if_data[$i] != "" )
	{
		$conditions .= " `".$i."`='".$if_data[$i]."' AND";
	}				
}
$conditions .= " `round`=7 ";

$query = "SELECT id from end_games WHERE ".$conditions;			
$endgame_data = mysql_query($query, $db);

while( $endgame = mysql_fetch_array($endgame_data) )
{
	$endGameIds[] = $endgame['id'];
}

if( false /*!$partialEndGame*/ )
{
	header( 'Location: if.php?id='.$endGameIds[0] );	
	exit();
}
else
{
	include("header.php");
}


?>

	<div id="main">

		<div class="full">

			<h2>What If? </h2>

			<h3>&nbsp;</h3>

			<form action="whatif.php" method="post" name="bracket" class="bracket" id="bracket">

				<p class="highlight"><em><strong>INSTRUCTIONS: </strong></em>Select winners for each game to view the standings in difference scenarios.</p>

				<table width="700" border="1">

					<tr>

						<td colspan="4"><h1>SWEET 16 </h1></td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("49", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

						<td rowspan="2"><?php drawBracketSelectBox("57", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

						<td rowspan="4"><?php drawBracketSelectBox("61", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

						<td rowspan="8"><?php drawBracketSelectBox("63", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("50", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							</td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("51", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							</td>

						<td rowspan="2"><?php drawBracketSelectBox("58", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("52", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							</td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("53", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							</td>

						<td rowspan="2"><?php drawBracketSelectBox("59", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

						<td rowspan="4"><?php drawBracketSelectBox("62", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("54", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							</td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("55", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							</td>

						<td rowspan="2"><?php drawBracketSelectBox("60", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?></td>

					</tr>

					<tr>

						<td><?php drawBracketSelectBox("56", $team_data, $_POST, $parentGraph, $childGraph, $seedData ); ?>

							

							

												</select></td>

					</tr>

				</table>

				<p align="center"><br />

					<input type="submit" name="Submit" value="Submit" />

					<input name="Reset" type="reset" id="Reset" value="Reset" onclick="return resetBracket(49);" />

				</p>

			</form>

		</div>

	</div>
	<br>
	<br>
	
	
	<?php				
		if( $dataPosted )
		{
			if( true /*$partialEndGame*/ )
			{			
				if( pow(2, 15-$numSelectedGames) <= 1024 )
				{																
					include("endgame_view_module.php");
					drawEndGames( "selected_end_games", -1, 1 , $endGameIds, $db);
				}
				else
				{
					$last_place_query = "SELECT max(rank) rank FROM `possible_scores` p WHERE p.`type`='path_to_victory'"; //winners
					$last_place_data = mysql_query($last_place_query,$db);
					$last_place_data = mysql_fetch_array($last_place_data);
					
					$lowestRank = $last_place_data['rank'];
					
					include('endgamesummary_view_module.php');
				?>
					<table border="0" >
						<tr valign="top">
							<td><?php createSummaryTable($db, 1, "First Place", false , pow(2, 15-$numSelectedGames), $_REQUEST['sort']); ?></td>
							<td><?php createSummaryTable($db, 2, "Second Place", false ,pow(2, 15-$numSelectedGames), $_REQUEST['sort']); ?></td>
							<td><?php createSummaryTable($db, 3, "Third Place", false , pow(2, 15-$numSelectedGames), $_REQUEST['sort']); ?></td>
						</tr>
						<tr>
							<td colspan='3'><?php createSummaryTable($db, $lowestRank, "Last Place", false, pow(2, 15-$numSelectedGames),$_REQUEST['sort']); ?></td>
						</tr>
					</table>
				<?php
				}
			}
			else
			{
				echo "Shouldn't get here. Should be at if.php";
			}
		}
	
	?>

	<div id="footer"> </div>

</div>

</body>

</html>

