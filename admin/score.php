<?php

include("database.php");
include 'functions.php';
validatecookie();

function scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, $scoringType)
{

	$custompoints = getScoringArray($db, $scoringType);
	$query = "SELECT * FROM `brackets`";
	$result = mysql_query($query,$db);	
	
	while ($user_bracket = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$score = 0;
		$bestScore = 0;
		
		for($j=1;$j<64;++$j) 
		{
			// calculate actual score
			if($user_bracket[$j] == $master_data[$j] && $user_bracket[$j] != "" )
			{				
				$seedvalue = $seedMap[ $master_data[$j] ];
				$score += $custompoints[ $seedvalue ][ $roundMap[$j] ];
			}
			
			// calcualte best score
			if( ( $user_bracket[$j] == $master_data[$j] || $loserMap[ $user_bracket[$j] ] == false ) 
				&& $user_bracket[$j] != ""  )
			{				
				$seedvalue = $seedMap[ $user_bracket[$j] ];
				$bestScore += $custompoints[ $seedvalue ][ $roundMap[$j] ];
			}
			
		}
		
		if ($user_bracket['paid'] > 0)
		{
			$user_bracket['name'] = mysql_real_escape_string($user_bracket['name']);
			
			$score_query = "INSERT INTO `scores` () VALUES ('$user_bracket[id]','$user_bracket[name]','$score','$scoringType')";
			mysql_query($score_query,$db) or die(mysql_error());
			
			$score_query = "INSERT INTO `best_scores` () VALUES ('$user_bracket[id]','$user_bracket[name]','$bestScore','$scoringType')";
			mysql_query($score_query,$db) or die(mysql_error());
		}
	}

}



//completely clear all scoreboards to be repopulated
$clear_query= "TRUNCATE TABLE `scores`";
mysql_query($clear_query,$db);
$clear_query= "TRUNCATE TABLE `best_scores`";
mysql_query($clear_query,$db);

$master_query = "SELECT * FROM `master` WHERE `id`=2"; //winners
$master_data = mysql_query($master_query,$db);
$master_data = mysql_fetch_array($master_data);

$seedMap = getSeedMap($db);
$roundMap = getRoundMap();
$loserMap = getLoserMap($db);

scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, 'main');
scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, 'geometric');
scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, 'espn');
//scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, 'fibonacci');
//scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, 'odds');
//scoreBrackets( $db, $master_data, $loserMap, $roundMap, $seedMap, 'constant');

$gamesLeft = 0;

// only 63 games in yourney
for( $i=1; $i<64; $i++ )
{
	if( $master_data[$i] == "" )
	{
		$gamesLeft++;
	}
}

// 11 may be able to execute before timing out
if( $gamesLeft >= 11 )
{
	header( 'Location: index.php' );
}
else
{
	header( 'Location: calculate_paths_to_victory.php' );
}
?>
