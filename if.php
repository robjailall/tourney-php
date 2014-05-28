<?php
include("admin/functions.php");
include("header.php");

if( $_GET['id'] != null )
{
	$possible_endgame_query = 
		"SELECT * FROM `end_games` e WHERE `id`='".$_GET['id']."'";
	$if_data = mysql_query($possible_endgame_query, $db);
	$if_data = mysql_fetch_array($if_data);
}
else
{
	//clean input
	for($i=49;$i<64;++$i)
	{
		$if_data[$i] = $_POST['game'.$i]; 			
	}
}


?>

<div id="main">		

			<div class="right_side"><?php include("sidebar.php"); ?>

			</div>

			<div class="left_side">

				<h2>What If? </h2>

				<h3>WHERE WOULD YOU RANK?  </h3>

				<div id="border" align="center">

			  	
<?php

	
	
	?>
	
	
	
	<table width="500" border="1" align="center">

	<tr>

		<td width="82"><div align="center"><strong>POSITION</strong></div></td>

		<td width="314"><div align="center"> <strong>NAME</strong></div></td>

		<td width="80">							<p align="center"><strong>SCORE</strong></p></td>

	</tr>

	
	<?php
	
	// if all ARE filled in, show a ranking
	if( $_GET['scoring_type'] == null )
	{
		$scoringType = 'main';
	}
	else
	{
		$scoringType =  $_GET['scoring_type'];
	}
	
	$custompoints = getScoringArray($db, $scoringType);
	$seedMap = getSeedMap($db);
	$roundMap = getRoundMap();

	$master_query = "SELECT * FROM `master` WHERE `id`=2";
	$master_data = mysql_query($master_query, $db);
	$master_data = mysql_fetch_array($master_data);


	$query = "SELECT * FROM `brackets`";
	$result = mysql_query($query,$db);	
	
	$i = 0;
	while ($user_bracket = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$score = 0;

		for($j=1;$j<49;++$j)
		{
			if($user_bracket[$j] == $master_data[$j] && $user_bracket[$j] != "" )
			{
				$seedvalue = $seedMap[ $master_data[$j] ];
				$score += $custompoints[ $seedvalue ][ $roundMap[$j] ];
			}
		}
		for($j=49;$j<64;++$j)
		{
			if($user_bracket[$j] == $if_data[$j])
			{
				$seedvalue = $seedMap[ $user_bracket[$j] ];
				$score += $custompoints[ $seedvalue ][ $roundMap[$j] ];
			}
		}

		$info[$i] = array($score, $user_bracket['id'], $user_bracket['name'], $user_bracket['email']);
		$i++;
	}


	rsort($info);

	for($j=0;$j<$i;$j++)
	{
		$score = $info[$j][0];
		$id = $info[$j][1];
		$name = $info[$j][2];
		$useremail = $info[$j][3];
		if( $j==0 ) 
		{
			$top_score = $score;
			$prev_score = $score;
			$rankCounter = 1;
			$rank=1;
		}
		if( $score != $prev_score )
		{
			$prev_score = $score;
			$rank = $rankCounter;
		}
				
		if ($useremail == $_COOKIE['useremail'] & $useremail != "")
		{
			echo '<tr class="thisuser">';
		}
		else
		{
			echo "<tr>";
		}
		// Print out the contents of each row into a table
		echo "<td align='right'>"; 

		echo $rank;

		echo "</td><td>"; 

		echo "<a href=\"view.php?id=".$id."\">".stripslashes($name)."</a>";
		if ($commentMap[$id] > 0) {
			echo " <span class=\"recentComment\"><a href='view.php?id=".$id."#comments'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></span>";
		}

		echo "</td><td>"; 

		echo $score;					

		echo "</td></tr>";
		
		$rankCounter++;

	}
	?>

				</table>

				</div>

			</div>
				

		</div>

		

		<div id="footer">

		</div>

	</div>

</body>

</html>

