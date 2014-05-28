<?php

include("header.php");
include("admin/functions.php");

?>


<?php

$team_query = "SELECT * FROM `master` WHERE `id`=1";
$team_data = mysql_query($team_query,$db);
$team_data = mysql_fetch_array($team_data);

// Get value for each game
$seedMap = getSeedMap($db);
$roundMap = getRoundMap();

$scoring = getScoringArray($db, 'main');

$master_query = "SELECT * FROM `master` WHERE `id`=2";
$picks = mysql_query($master_query,$db);
$picks = mysql_fetch_array($picks);

$totalScore = 0;

for( $i=1; $i<65; $i++ )
{	
	$team_data[$i] = $seedMap[$team_data[$i]].". ".$team_data[$i];
	
	if( $picks[$i] != NULL )
	{
		$correctValue = $scoring[ $seedMap[$picks[$i]] ][ $roundMap[$i]  ];
		$correctValueStr = " <span class=\"gamevalue\">(".$correctValue.")</span>";
		$totalScore += $correctValue;
		$picks[$i] = $picks[$i].$correctValueStr;
	}
}

$score_data['score'] = $totalScore;

$meta = "SELECT * FROM `meta` WHERE `id`=1";
$meta = mysql_query($meta,$db);
$meta = mysql_fetch_array($meta);

$picks['name'] = "Master Bracket";

include('bracket_view_module.php');
viewBracket( $meta, $picks, $team_data, $rank, $score_data, $best_data );

?>

	<div id="footer"> </div>
</div>
</body>
</html>
