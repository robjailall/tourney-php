<?php
session_start();

function validatecookie()
{	
	if( !isset($_SESSION['admin']) )
	{
		header("Location: ../login.html"); 
	}
	else if($_SESSION['admin'] == false)
	{
		header("Location: ../login.html"); 
	}
}

function getScoringArray($db, $type)
{
	if( $type == NULL )
	{
		$type = 'main';
	}
	$scoring_query = "SELECT * FROM `scoring` WHERE `type` = '".$type."' order by `seed`";
	$scoring_data = mysql_query($scoring_query,$db);
	
	$custompoints = array();
	while ($row = mysql_fetch_array($scoring_data, MYSQL_ASSOC))
	{
		$custompoints[$row['seed' ]][1] =	$row['1'];
		$custompoints[$row['seed' ]][2] =	$row['2'];
		$custompoints[$row['seed' ]][3] =	$row['3'];
		$custompoints[$row['seed' ]][4] =	$row['4'];
		$custompoints[$row['seed' ]][5] =	$row['5'];
		$custompoints[$row['seed' ]][6] =	$row['6'];
	}
	
	return $custompoints;
}

function getRoundMap()
{
	$roundMap = array();
	for($j=1;$j<64;$j++)
	{
		$roundMap[$j] = 6-floor(log( 64-$j, 2));
	}
	
	return $roundMap;
}

function getSeedMap($db)
{
	$seed_query = "SELECT * FROM `master` WHERE `id`=4"; //seeds
	$seed_data = mysql_query($seed_query,$db);
	$seed_data = mysql_fetch_array($seed_data);
	
	$team_query = "SELECT * FROM `master` WHERE `id`=1"; //teams
	$team_data = mysql_query($team_query,$db);
	$team_data = mysql_fetch_array($team_data);
	
	$seedMap = array();
	for ($k=1;$k<65;++$k)
	{
		$seedMap[ $team_data[$k] ] = $seed_data[$k];
	}
	
	return $seedMap;
}

function getLoserMap($db)
{
	$loser_query = "SELECT * FROM `master` WHERE `id`=3"; //select losers
	$loser_data = mysql_query($loser_query,$db);
	$loser_data = mysql_fetch_array($loser_data);
	
	$loserMap = array();
	
	for( $i=0; $i<64; $i++ )
	{	
		if( $loser_data[$i] != NULL )
		{
			$loserMap[$loser_data[$i]] = true;
		}
		else if( $loserMap[$team_data[$i]] != 1 )
		{
			$loserMap[$loser_data[$i]] = false;
		}
	}
	
	return $loserMap;
}

function timeBetween($start,$end,$after=' ago',$color=1){
	//both times must be in seconds
	$time = $end - $start;
	if($time <= 60){
		if($color==1){
			return '<span style="color:#009900;">Online';
		}else{
			return 'Online';
		}
	}
	if(60 < $time && $time <= 3600){
		$minutes = round($time/60,0);
		if ($minutes < 2)
			return $minutes.' minute'.$after;
		else
			return $minutes.' minutes'.$after;
	}
	if(3600 < $time && $time <= 86400){
		$hours = round($time/3600,0);
		if ($hours < 2)
			return $hours.' hour'.$after;
		else
			return $hours.' hours'.$after;
	}
	if(86400 < $time && $time <= 604800){
		$days = round($time/86400,0);
		if ($days < 2)
			return $days.' day'.$after;
		else
			return $days.' days'.$after;
	}
	if(604800 < $time && $time <= 2592000){
		$weeks = round($time/604800,0);
		if ($weeks < 2)
			return $weeks.' week'.$after;
		else
			return $weeks.' weeks'.$after;
	}
	if(2592000 < $time && $time <= 29030400){
		$months = round($time/2592000,0);
		if ($months < 2)
			return $months.' month'.$after;
		else
			return $months.' months'.$after;
	}
	if($time > 29030400){
		return 'More than a year'.$after;
	}
}

function getHistoricalProbabilities()
{
	$probabilities[1][1][16] = 1.000000;
	$probabilities[1][2][15] = 0.946429;
	$probabilities[1][3][14] = 0.857143;
	$probabilities[1][4][13] = 0.785714;
	$probabilities[1][5][12] = 0.660714;
	$probabilities[1][6][11] = 0.660714;
	$probabilities[1][7][10] = 0.598214;
	$probabilities[1][8][9] = 0.482143;
	$probabilities[1][9][8] = 0.517857;
	$probabilities[1][10][7] = 0.401786;
	$probabilities[1][11][6] = 0.339286;
	$probabilities[1][12][5] = 0.339286;
	$probabilities[1][13][4] = 0.214286;
	$probabilities[1][14][3] = 0.142857;
	$probabilities[1][15][2] = 0.053571;
	$probabilities[1][16][1] = 0.000000;
	$probabilities[2][1][8] = 0.814815;
	$probabilities[2][1][9] = 0.931034;
	$probabilities[2][2][7] = 0.738462;
	$probabilities[2][2][10] = 0.585366;
	$probabilities[2][3][6] = 0.557377;
	$probabilities[2][3][11] = 0.657143;
	$probabilities[2][4][5] = 0.533333;
	$probabilities[2][4][12] = 0.607143;
	$probabilities[2][5][4] = 0.466667;
	$probabilities[2][5][13] = 0.785714;
	$probabilities[2][6][3] = 0.442623;
	$probabilities[2][6][14] = 0.846154;
	$probabilities[2][7][2] = 0.261538;
	$probabilities[2][7][15] = 1.000000;
	$probabilities[2][8][1] = 0.185185;
	$probabilities[2][9][1] = 0.068966;
	$probabilities[2][10][2] = 0.414634;
	$probabilities[2][10][15] = 1.000000;
	$probabilities[2][11][3] = 0.342857;
	$probabilities[2][11][14] = 1.000000;
	$probabilities[2][12][4] = 0.392857;
	$probabilities[2][12][13] = 0.800000;
	$probabilities[2][13][5] = 0.214286;
	$probabilities[2][13][12] = 0.200000;
	$probabilities[2][14][6] = 0.153846;
	$probabilities[2][14][11] = 0.000000;
	$probabilities[2][15][7] = 0.000000;
	$probabilities[2][15][10] = 0.000000;
	$probabilities[3][1][4] = 0.707317;
	$probabilities[3][1][5] = 0.800000;
	$probabilities[3][1][12] = 1.000000;
	$probabilities[3][1][13] = 1.000000;
	$probabilities[3][2][3] = 0.628571;
	$probabilities[3][2][6] = 0.769231;
	$probabilities[3][2][11] = 0.909091;
	$probabilities[3][3][2] = 0.371429;
	$probabilities[3][3][7] = 0.666667;
	$probabilities[3][3][10] = 0.692308;
	$probabilities[3][4][1] = 0.292683;
	$probabilities[3][4][8] = 0.333333;
	$probabilities[3][4][9] = 1.000000;
	$probabilities[3][5][1] = 0.200000;
	$probabilities[3][5][8] = 0.000000;
	$probabilities[3][5][9] = 0.500000;
	$probabilities[3][6][2] = 0.230769;
	$probabilities[3][6][7] = 0.500000;
	$probabilities[3][6][10] = 0.666667;
	$probabilities[3][7][3] = 0.333333;
	$probabilities[3][7][6] = 0.500000;
	$probabilities[3][7][11] = 0.000000;
	$probabilities[3][7][14] = 1.000000;
	$probabilities[3][8][4] = 0.666667;
	$probabilities[3][8][5] = 1.000000;
	$probabilities[3][8][12] = 0.000000;
	$probabilities[3][8][13] = 1.000000;
	$probabilities[3][9][4] = 0.000000;
	$probabilities[3][9][5] = 0.500000;
	$probabilities[3][10][3] = 0.307692;
	$probabilities[3][10][6] = 0.333333;
	$probabilities[3][10][11] = 0.000000;
	$probabilities[3][10][14] = 1.000000;
	$probabilities[3][11][2] = 0.090909;
	$probabilities[3][11][7] = 1.000000;
	$probabilities[3][11][10] = 1.000000;
	$probabilities[3][12][1] = 0.000000;
	$probabilities[3][12][8] = 1.000000;
	$probabilities[3][13][1] = 0.000000;
	$probabilities[3][13][8] = 0.000000;
	$probabilities[3][14][7] = 0.000000;
	$probabilities[3][14][10] = 0.000000;
	$probabilities[4][1][2] = 0.473684;
	$probabilities[4][1][3] = 0.600000;
	$probabilities[4][1][6] = 0.750000;
	$probabilities[4][1][7] = 1.000000;
	$probabilities[4][1][10] = 1.000000;
	$probabilities[4][1][11] = 0.400000;
	$probabilities[4][2][1] = 0.526316;
	$probabilities[4][2][4] = 0.333333;
	$probabilities[4][2][5] = 0.000000;
	$probabilities[4][2][8] = 0.500000;
	$probabilities[4][2][12] = 1.000000;
	$probabilities[4][3][1] = 0.400000;
	$probabilities[4][3][4] = 0.666667;
	$probabilities[4][3][5] = 0.666667;
	$probabilities[4][3][8] = 1.000000;
	$probabilities[4][3][9] = 1.000000;
	$probabilities[4][4][2] = 0.666667;
	$probabilities[4][4][3] = 0.333333;
	$probabilities[4][4][6] = 0.666667;
	$probabilities[4][4][7] = 1.000000;
	$probabilities[4][4][10] = 1.000000;
	$probabilities[4][5][2] = 1.000000;
	$probabilities[4][5][3] = 0.333333;
	$probabilities[4][5][6] = 1.000000;
	$probabilities[4][5][10] = 1.000000;
	$probabilities[4][6][1] = 0.250000;
	$probabilities[4][6][4] = 0.333333;
	$probabilities[4][6][5] = 0.000000;
	$probabilities[4][6][8] = 0.000000;
	$probabilities[4][7][1] = 0.000000;
	$probabilities[4][7][4] = 0.000000;
	$probabilities[4][7][8] = 0.000000;
	$probabilities[4][8][2] = 0.500000;
	$probabilities[4][8][3] = 0.000000;
	$probabilities[4][8][6] = 1.000000;
	$probabilities[4][8][7] = 1.000000;
	$probabilities[4][9][3] = 0.000000;
	$probabilities[4][10][1] = 0.000000;
	$probabilities[4][10][4] = 0.000000;
	$probabilities[4][10][5] = 0.000000;
	$probabilities[4][11][1] = 0.600000;
	$probabilities[4][12][2] = 0.000000;
	$probabilities[5][1][1] = 1.000000;
	$probabilities[5][1][2] = 0.705882;
	$probabilities[5][1][3] = 0.428571;
	$probabilities[5][1][4] = 0.750000;
	$probabilities[5][1][5] = 1.000000;
	$probabilities[5][1][6] = 0.500000;
	$probabilities[5][1][8] = 0.500000;
	$probabilities[5][2][1] = 0.294118;
	$probabilities[5][2][2] = 0.750000;
	$probabilities[5][2][3] = 0.600000;
	$probabilities[5][2][4] = 1.000000;
	$probabilities[5][2][5] = 0.000000;
	$probabilities[5][2][6] = 0.500000;
	$probabilities[5][2][8] = 0.000000;
	$probabilities[5][2][11] = 1.000000;
	$probabilities[5][3][1] = 0.571429;
	$probabilities[5][3][2] = 0.400000;
	$probabilities[5][3][3] = 1.000000;
	$probabilities[5][3][4] = 1.000000;
	$probabilities[5][3][8] = 1.000000;
	$probabilities[5][3][11] = 1.000000;
	$probabilities[5][4][1] = 0.250000;
	$probabilities[5][4][2] = 0.000000;
	$probabilities[5][4][3] = 0.000000;
	$probabilities[5][4][5] = 1.000000;
	$probabilities[5][4][6] = 0.000000;
	$probabilities[5][5][1] = 0.000000;
	$probabilities[5][5][2] = 1.000000;
	$probabilities[5][5][4] = 0.000000;
	$probabilities[5][5][5] = 1.000000;
	$probabilities[5][5][8] = 1.000000;
	$probabilities[5][6][1] = 0.500000;
	$probabilities[5][6][2] = 0.500000;
	$probabilities[5][6][4] = 1.000000;
	$probabilities[5][8][1] = 0.500000;
	$probabilities[5][8][2] = 1.000000;
	$probabilities[5][8][3] = 0.000000;
	$probabilities[5][8][5] = 0.000000;
	$probabilities[5][8][11] = 1.000000;
	$probabilities[5][11][2] = 0.000000;
	$probabilities[5][11][3] = 0.000000;
	$probabilities[5][11][8] = 0.000000;
	$probabilities[6][1][1] = 1.000000;
	$probabilities[6][1][2] = 0.705882;
	$probabilities[6][1][3] = 0.428571;
	$probabilities[6][1][4] = 0.750000;
	$probabilities[6][1][5] = 1.000000;
	$probabilities[6][1][6] = 0.500000;
	$probabilities[6][1][8] = 0.500000;
	$probabilities[6][2][1] = 0.294118;
	$probabilities[6][2][2] = 0.750000;
	$probabilities[6][2][3] = 0.600000;
	$probabilities[6][2][4] = 1.000000;
	$probabilities[6][2][5] = 0.000000;
	$probabilities[6][2][6] = 0.500000;
	$probabilities[6][2][8] = 0.000000;
	$probabilities[6][2][11] = 1.000000;
	$probabilities[6][3][1] = 0.571429;
	$probabilities[6][3][2] = 0.400000;
	$probabilities[6][3][3] = 1.000000;
	$probabilities[6][3][4] = 1.000000;
	$probabilities[6][3][8] = 1.000000;
	$probabilities[6][3][11] = 1.000000;
	$probabilities[6][4][1] = 0.250000;
	$probabilities[6][4][2] = 0.000000;
	$probabilities[6][4][3] = 0.000000;
	$probabilities[6][4][5] = 1.000000;
	$probabilities[6][4][6] = 0.000000;
	$probabilities[6][5][1] = 0.000000;
	$probabilities[6][5][2] = 1.000000;
	$probabilities[6][5][4] = 0.000000;
	$probabilities[6][5][5] = 1.000000;
	$probabilities[6][5][8] = 1.000000;
	$probabilities[6][6][1] = 0.500000;
	$probabilities[6][6][2] = 0.500000;
	$probabilities[6][6][4] = 1.000000;
	$probabilities[6][8][1] = 0.500000;
	$probabilities[6][8][2] = 1.000000;
	$probabilities[6][8][3] = 0.000000;
	$probabilities[6][8][5] = 0.000000;
	$probabilities[6][8][11] = 1.000000;
	$probabilities[6][11][2] = 0.000000;
	$probabilities[6][11][3] = 0.000000;
	$probabilities[6][11][8] = 0.000000;
	
	return $probabilities;
}

function getChildGraph()
{
	$childGraph = array();
	$childCounter = 0;
	
	// build a child graph for parents
	for( $i=33; $i < 64; $i++ )
	{
		$childGraph[$i][0] = ++$childCounter;
		$childGraph[$i][1] = ++$childCounter;
	}
	
	return $childGraph;
}

function getParentGraph()
{
	$childGraph = getChildGraph();
	
	$parentGraph = array();
	
	for( $i=63; $i >= 33; $i-- )
	{
		$parentGraph[$childGraph[$i][0]] = $i;
		$parentGraph[$childGraph[$i][1]] = $i;
	}
	
	return $parentGraph;
}

function ordinal_suffix($value)
{
	$suffix = "";
	if( is_numeric($value) )
	{
		if(substr($value, -2, 2) == 11 || substr($value, -2, 2) == 12 || substr($value, -2, 2) == 13){
			$suffix = "th";
		}
		else if (substr($value, -1, 1) == 1){
			$suffix = "st";
		}
		else if (substr($value, -1, 1) == 2){
			$suffix = "nd";
		}
		else if (substr($value, -1, 1) == 3){
			$suffix = "rd";
		}
		else {
			$suffix = "th";
		}
	}
	return $value . $suffix;
}

?>