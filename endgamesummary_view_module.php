<?php

function createSummaryTable( $db, $rank, $rankName, $viewAll, $totalScenarios, $sort )
{	?>
<style type="text/css">
	.content
	{
		width:900px;
	}
	
	#main
	{
		width:900px;
	}
	.scoredetail td
	{
		text-align:center;
	}

</style>

<?php
	
	$commentMap = getCommentsMap($db);
	
	$bracketsQuery = "select b.id, name, email, p.probability_win pWin from brackets b, probability_of_winning p WHERE p.id = b.id and p.rank = '".$rank."'";
	$bracketsData = mysql_query($bracketsQuery,$db) or die(mysql_error());
	
	
	while($b = mysql_fetch_array($bracketsData))
	{
		$brackets[ $b['id'] ] = array($b['name'],$b['email'], $b['pWin']);
	}

	$end_game_query = "select count(*) num_paths, bracket_id id from possible_scores p where eliminated=false and rank='".$rank."'  and `type`='path_to_victory' group by bracket_id";
	
	$end_game_data = mysql_query($end_game_query,$db) or die(mysql_error());

	$sortedBrackets = array();
	$i = 0;
	while($bracket = mysql_fetch_array($end_game_data))
	{
		if( $sort == "pwin" )
		{
			$sortedBrackets[$i] = array( $brackets[$bracket['id']][2], $bracket['num_paths'], $bracket['id'], $brackets[$bracket['id']][0], $brackets[$bracket['id']][1], $brackets[$bracket['id']][2]);

		}
		else
		{
			$sortedBrackets[$i] = array( $bracket['num_paths'], $bracket['id'], $brackets[$bracket['id']][0], $brackets[$bracket['id']][1], $brackets[$bracket['id']][2]);
		}
		$i++;
	}
	$numBrackets = $i;
	rsort( $sortedBrackets );
	
	$viewAllLink = "";
	if( $viewAll == true )
	{
		$viewAllLink = " <a href='endgame.php?view_all=true&rank=".$rank."'>(View All)</a>\n";
	}
	
	echo "<table cellpadding='1' border='1'>\n";
	echo "<tr class='tableheader'><td colspan='3'><strong>".$rankName.$viewAllLink."</strong></td></tr>\n";
	echo "<tr class='tableheader'><td>Bracket Name</td><td># of Paths<br>(Click to View)</td><td>p(W)</td></tr>\n";
	
	// this is really ghetto
	$offset = 0;
	if( $sort == "pwin" )
	{
		$offset = 1;
	}
	
	for( $i=0; $i < $numBrackets; $i++ )
	{
		$useremail = $sortedBrackets[$i][3+$offset];
		
		if ($useremail == $_COOKIE['useremail'] & $useremail != "")
		{
			echo '<tr class="thisuser">';
		}
		else
		{
			echo "<tr>";
		}
		
		echo "<td><a href='view.php?id=".$sortedBrackets[$i][1+$offset]."'>".stripslashes($sortedBrackets[$i][2+$offset])."</a>";
		
		
		if ($commentMap[$sortedBrackets[$i][1+$offset]] > 0) {
			echo "<span class=\"recentComment\"><a href='view.php?id=".$sortedBrackets[$i][1+$offset]."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
		}
		echo "</td>\n";

		if( (int)$sortedBrackets[$i][0+$offset] < 1025 )
		{
			echo "<td nowrap><a href='endgame.php?id=".$sortedBrackets[$i][1+$offset]."&rank=".$rank."'>".$sortedBrackets[$i][0+$offset]." (".number_format(100*($sortedBrackets[$i][0+$offset]/$totalScenarios),0)."%)</a></td><td>".number_format(100*$sortedBrackets[$i][4+$offset],2)."%</td>\n\n";

		}
		else
		{
			echo "<td nowrap>".$sortedBrackets[$i][0+$offset]." (".number_format(100*($sortedBrackets[$i][0+$offset]/$totalScenarios),0)."%)</td><td>".number_format(100*$sortedBrackets[$i][4+$offset],2)."%</td>\n\n";
		
		}
		echo "</tr>";
	}
	echo "</table>\n";
}


?>