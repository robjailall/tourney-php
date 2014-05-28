<?php

include("database.php");
include 'functions.php';
validatecookie();

$roundMap = getRoundMap();
$seedMap = getSeedMap($db);
$scoring = getHistoricalProbabilities();
$childGraph = getChildGraph();

	$master_query = "SELECT * FROM `master` WHERE `id`=2"; // winners
	$master_data = mysql_query($master_query, $db);
	$master_data = mysql_fetch_array($master_data);
	
	$gamesLeft = 0;
	$truncate = false;
		
	if( $_GET['truncate'] == 'true' || $argv[1] == "truncate" )
	{
		$truncate = true;
	}
	else
	{	
		// only 63 games in yourney
		for( $i=1; $i<64; $i++ )
		{
			if( $master_data[$i] == "" )
			{
				$gamesLeft++;
				
				if( $i < 49 )
				{
					$truncate = true;
					break;
				}
			}
		}
	}
	
	eliminateImpossibleEndGames( $master_data, $db );
	
	$activeCountQuery = "SELECT count(id) count FROM `end_games` where `round`='7' and `eliminated`=false"; // winners
	$activeCount = mysql_query($activeCountQuery,$db);
	$activeCount = mysql_fetch_array($activeCount, MYSQL_ASSOC);
	$activeCount = $activeCount['count'];
	
	if( $truncate || $activeCount != pow(2,$gamesLeft) )
	{		
		$query = "TRUNCATE TABLE `end_games` ";
		mysql_query($query,$db);
		enumerateRound( 49, 56, array(), $master_data, $childGraph, $db, 4);
		enumerateLaterRound( 57, 60, 4, $master_data, $db, $childGraph );
		enumerateLaterRound( 61, 62, 5, $master_data, $db, $childGraph );
		enumerateLaterRound( 63, 63, 6, $master_data, $db, $childGraph );
		$custompoints = getScoringArray($db, 'main');
		scoreOutcomes( 7, $master_data, $custompoints, $db, "path_to_victory" );
	}
	
	
	$query = "TRUNCATE TABLE `probability_of_winning`";
	mysql_query($query, $db);
	
	$brackets = "SELECT id FROM `brackets` where paid<>'0'";
	$brackets = mysql_query($brackets,$db) or die(mysql_error());

	$numBracketsQuery = "SELECT count(id) count FROM `brackets` where paid<>'0'"; // winners
	
	$numBrackets = mysql_query($numBracketsQuery,$db);
	$numBrackets = mysql_fetch_array($numBrackets, MYSQL_ASSOC);
	$numBrackets = $numBrackets['count'];

	for( $scoreRank=1; $scoreRank <= $maxScoreRanks; $scoreRank++ )
	{
		updateProbabilities( $roundMap, $seedMap, $childGraph, $scoring, $master_data, $scoreRank, $db );
	}
	// Also, do last place calc...
	updateProbabilities( $roundMap, $seedMap, $childGraph, $scoring, $master_data, $numBrackets, $db );
	
	eliminatecalc($db, $maxScoreRanks);

	header( 'Location: index.php' );


////////////////////////////////////////// functions below //////////////////////////////////////////	
	
	
	function updateProbabilities( $roundMap, $seedMap, $childGraph, $scoring, $winners_data, $rank, $db )
	{
		$end_game_query = "select p.bracket_id, e.id eid, score, e.`49`,e.`50`,e.`51`,e.`52`,e.`53`,e.`54`,e.`55`,e.`56`,e.`57`,e.`58`,e.`59`,e.`60`,e.`61`,e.`62`,e.`63` ".
			"from possible_scores p, end_games e ".
			"where e.eliminated = false and e.id = outcome_id and e.round='7' and p.`type`='path_to_victory' and rank=".$rank;
			
		$end_game_data = mysql_query($end_game_query,$db) or die(mysql_error());
		
		$totalPwin = 0;
		$pWinList;
					
		while($bracket = mysql_fetch_array($end_game_data))
		{						
			// prob of bracket winning
			$probability = 1;
			// multiple the prob of winning each game together
			for( $j=49; $j<64; $j++ )
			{
				if( $winners_data[$j] != NULL && $winners_data[$j] == $bracket[$j] )
				{
					// game already played -- don't need to add its probability
					continue;
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
					
					// pwin of a single game
					$pWin = $scoring[ $roundMap[$j] ][ $seedMap[$bracket[$j]] ][ $seedMap[$loser] ];
					if( $pWin == null || $pWin <= 0 || $pWin >= 1 )
					{					
						$winSeed = $seedMap[$bracket[$j]];
						$loseSeed =  $seedMap[$loser];
						
						$pWin = 1 - ($winSeed)/($winSeed + $loseSeed);
						//echo "special case ".$winSeed." ".$loseSeed;
					}
					
					$probability *= $pWin;
				}
			}
			
			// save the probability of this row
			$pWinList[$bracket['bracket_id']][] = $probability;
			
			// keep track of sum for normalizing
			$totalPwin += $probability;
			
			
			//echo $rank." ".$probability." ".$totalPwin."<br>";
		}
				
		// calculate prob of each bracket winning
		$pBracketWin;
		foreach( $pWinList as $bracketId=>$winList )
		{
			// for each endgame
			$pBracketWin = 0;
			foreach( $winList as $pendgame )
			{
				// normalize endgame
				$pWin = $pendgame/$totalPwin;
				
				// add end game to the probability
				$pBracketWin += $pWin;
			}
			
			// save of bracket's total prob
			$probOneEndGame[$bracketId] = $pBracketWin;
		}
				
		foreach( $probOneEndGame as $bracketId=>$prob )
		{
			$probabilityBracketWin = $prob;
				
			$query = "INSERT INTO `probability_of_winning` (`id`,`rank`,`probability_win`) VALUES ('".$bracketId."','".$rank."','".$probabilityBracketWin."')"; // winners
			mysql_query($query, $db);
		}
	}
	
	function eliminateImpossibleEndGames( $master_data, $db )
	{
		$firstUpdate = true;
			
		for( $i=49; $i<64; $i++ )
		{
			if( $master_data[$i] != NULL )
			{
				if( !$firstUpdate )
				{
					$finishedGamesCondition .= " OR ";
				}
				
				$firstUpdate = false;
				$finishedGamesCondition .= "`".$i."` != '".$master_data[$i]."'";
				
			}
		}
	
		$query = "UPDATE `end_games` SET `eliminated` = true WHERE ".$finishedGamesCondition;
		mysql_query($query,$db);
		
		$updateStatus= "UPDATE possible_scores p, end_games e SET p.eliminated = e.eliminated WHERE e.id = p.outcome_id and p.`type`='path_to_victory'";
		mysql_query($updateStatus,$db);
		
		$updateStatus= "INSERT into possible_scores_eliminated p SELECT * from possible_scores p WHERE p.eliminated = true and p.`type`='path_to_victory'";
		mysql_query($updateStatus,$db);
		
		$updateStatus= "DELETE from possible_scores p WHERE eliminated = true and p.`type`='path_to_victory'";
		mysql_query($updateStatus,$db);
	}
	
	function scoreOutcomes( $round, $winnerData, $custompoints, $db, $type )
	{
		//completely clear all scoreboards to be repopulated
		$clear_query= "DELETE from `possible_scores` where type ='".$type."'";
		mysql_query($clear_query,$db) or die(mysql_error());
		
		$clear_query= "DELETE from `possible_scores_eliminated` where type ='".$type."'";
		mysql_query($clear_query,$db) or die(mysql_error());
		
		$brackets_query = "SELECT * FROM `brackets` where paid<>'0'"; // teams
		$brackets_data = mysql_query($brackets_query, $db) or die(mysql_error());;
		
		$brackets = array();
		$i =0;
		while ($user_bracket = mysql_fetch_array($brackets_data, MYSQL_ASSOC))
		{
			$brackets[$i] = $user_bracket;
			$i++;
		}

		$seedMap = getSeedMap($db);
		$roundMap = getRoundMap();
		
		$winnerCombo = array();
		
		$possible_winners_query = "SELECT * FROM `end_games` WHERE `eliminated` = false AND `round`=".$round;
		$possible_winners_data = mysql_query($possible_winners_query, $db);
		while ($possibleGame = mysql_fetch_array($possible_winners_data, MYSQL_ASSOC))
		{
			
			for($i=1; $i<64; ++$i)
			{
				if( $winnerData[$i] != NULL )
				{
					$winnerCombo[$i] = $winnerData[$i];
				}
				else if( $possibleGame[$i] != NULL )
				{
					$winnerCombo[$i] = $possibleGame[$i];
				}
			}
			
			scoreFinishedGame( $brackets, $possibleGame['id'], $winnerCombo, $custompoints, $seedMap, $roundMap, $type, $db);
		}	
	}
	
	function scoreFinishedGame( $bracketsData, $possibleGameId, $winnerData, $custompoints, $seedMap, $roundMap, $scoreType, $db )
	{	
		$score_query = "INSERT INTO `possible_scores` (`outcome_id`, `bracket_id`, `rank`,`score`, `type`) VALUES";
		
		$scores = array();
		
		$numBrackets = count($bracketsData);
		
		for( $i=0; $i < $numBrackets; $i++ )
		{			
			$user_bracket = $bracketsData[$i];
			
			$score = 0;

			
			for($j=1;$j<64;$j++) 
			{
				// calculate actual score
				if($user_bracket[$j] == $winnerData[$j] && $user_bracket[$j] != "" )
				{	
					$seedvalue = $seedMap[ $winnerData[$j] ];
					$score += $custompoints[ $seedvalue ][ $roundMap[$j] ];
				}
			}
			$scores[$i] = array($score, $possibleGameId,$user_bracket['id'] );
		}
		
		rsort($scores );
		
		for( $i=0; $i < count($scores)-1; $i++ )
		{
			$score_query .= "( '".$scores[$i][1]."', '".$scores[$i][2]."',".($i+1).",".$scores[$i][0].",'".$scoreType."'),";
		}
		
		$score_query .= "( '".$scores[$numBrackets-1][1]."', '".$scores[$numBrackets-1][2]."',".($numBrackets).",".$scores[$numBrackets-1][0].",'".$scoreType."')";
		
		if( $numBrackets > 0 )
		{	
			mysql_query( $score_query,$db) or die(mysql_error());
		}
	}
	
	
	function enumerateLaterRound( $startGame, $endGame, $previousRound, $winnerData, $db, $childGraph )
	{
		$possible_winners_query = "SELECT * FROM `end_games` WHERE `round`=".$previousRound;
		$possible_winners_data = mysql_query($possible_winners_query, $db);
		while ($possibleGame = mysql_fetch_array($possible_winners_data, MYSQL_ASSOC))
		{
			$winnerCombo = array();
			for($i=1; $i<64; ++$i)
			{
				if( $winnerData[$i] != NULL )
				{
					$winnerCombo[$i] = $winnerData[$i];
				}
				else if( $possibleGame[$i] != NULL )
				{
					$winnerCombo[$i] = $possibleGame[$i];
				}
			}
			
			enumerateRound( $startGame, $endGame, array(), $winnerCombo, $childGraph, $db, $previousRound+1);
		}	
	}
	
	
	function enumerateRound( $gameNum, $lastGameNum, $peerGamePicks, $winnerData, $childGraph, $db, $round)
	{
		$possibleGameResults = array();
		$numGameResults = 0;
		
		if( $winnerData[$gameNum] != NULL )
		{
			$possibleGameResults[0] = $winnerData[$gameNum];
			$numGameResults = 1;
		}
		else
		{
			// winner of first chiild
			$possibleGameResults[0] = $winnerData[ $childGraph[$gameNum][0] ];
			// winner of second child 
			$possibleGameResults[1] = $winnerData[ $childGraph[$gameNum][1] ];
			$numGameResults = 2;
		}
		
		// for each possible winner
		for( $j=0; $j<$numGameResults; ++$j )
		{	
			$peerGamePicks[ $gameNum ] = $possibleGameResults[$j];
			
			if( $gameNum < $lastGameNum )
			{
				enumerateRound( $gameNum+1, $lastGameNum, $peerGamePicks, $winnerData,  $childGraph, $db, $round );
			}
			
			// print result
			if( $gameNum == $lastGameNum )
			{
				$fields = "";
				$values = "";
				$i = $lastGameNum;
				while( $peerGamePicks[$i] != NULL )
				{
					$fields .= ",`".$i."`";
					$values .= ",'" . mysql_real_escape_string($peerGamePicks[$i]) . "'";
					--$i;
				}
				
				for( $k=$i; $k>=49; --$k )
				{
					$fields .= ",`".$k."`";
					$values .= ",'" . mysql_real_escape_string($winnerData[$k]) . "'";
				}
				
				$possible_bracket = "INSERT INTO `end_games` (`round` ".$fields.") VALUES ( ".$round.$values.") ";
				
				mysql_query($possible_bracket,$db) or die(mysql_error());
				
			}
		}
	}
	
	function eliminatecalc($db, $maxrank)
	{
		$query = "UPDATE `brackets` SET `eliminated` = '1'";
		mysql_query($query,$db) or die(mysql_error());
	
		$query = "SELECT b.id, b.name, count(*) c FROM `brackets` b,`possible_scores` p where p.bracket_id = b.id and p.rank <= " . $maxrank . " group by b.id";
		
		$alive = mysql_query($query,$db) or die(mysql_error());
	
		while ($row = mysql_fetch_array($alive))
		{
			$query = "UPDATE `brackets` SET `eliminated` = '0' WHERE `brackets`.`id` = " . $row['id'];
			mysql_query($query,$db) or die(mysql_error());
		}
	}
	
?>
