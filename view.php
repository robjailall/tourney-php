<?php

include("admin/database.php");
include("admin/functions.php");


session_start();
$query = "SELECT closed FROM `meta` WHERE `id`=1";
$meta = mysql_query($query,$db);
$meta = mysql_fetch_array($meta);

if($meta['closed'] == 0) {
	$_SESSION['errors'] = "No peeking until submission is closed!";
	header('Location:index.php');
	exit();
}

include("header.php");

$id = (int) $_GET['id'];
$query = "SELECT * FROM `brackets` WHERE `id` = '$id'"; //select entry
$picks = mysql_query($query,$db);
$picks = mysql_fetch_array($picks);

if($picks['name'] != NULL)
{

	$team_query = "SELECT * FROM `master` WHERE `id`=1"; //select teams
	$team_data = mysql_query($team_query,$db);
	$team_data = mysql_fetch_array($team_data);
	
	$master_query = "SELECT * FROM `master` WHERE `id`=2"; //select winners
	$master_data = mysql_query($master_query,$db);
	$master_data = mysql_fetch_array($master_data);
	
	$loserMap = getLoserMap($db);
	$seedMap = getSeedMap($db);	
	
	for( $i=0; $i<64; $i++ )
	{
		$team_data[$i] = $seedMap[$team_data[$i]].". ".$team_data[$i];
	}
	
	$query = "SELECT * FROM `scores` WHERE `id` = '$id' and scoring_type='main' "; //select entry
	$score_data = mysql_query($query,$db);
	$score_data = mysql_fetch_array($score_data);
	
	$query = "SELECT * FROM `best_scores` WHERE `id` = '$id' and scoring_type='main' "; //select entry
	$best_data = mysql_query($query,$db);
	$best_data = mysql_fetch_array($best_data);
	
	//get rank
	$query = "SELECT * FROM `scores`  WHERE scoring_type='main' ORDER BY `score` DESC";
	$result = mysql_query($query,$db) or die(mysql_error());  
	$i=1;
	$rankCounter = 0;
	$prevScore = -1;
	while($user = mysql_fetch_array($result)) {
		// Print out the contents of each row into a table
		if( $user['score'] != $prevScore )
		{
			$rankCounter = $i;
		}
		
		if ($user['id'] == $id) {
			$rank = $rankCounter;
			break;
		}
		
		$prevScore = $user['score'];
		$i++;
			
	}
	
	$scoring = getScoringArray($db, 'main');
	$roundMap = getRoundMap();
	
	for($j=1;$j<64;$j++)
	{
		$gameValue = $scoring[ $seedMap[$picks[$j]] ][ $roundMap[$j] ];
		$gameValueStr = " <span class=\"gamevalue\">(".$gameValue.")</span>";
		$pickSeed = "<span class=\"gamevalue\">".$seedMap[$picks[$j]].". </span>";
		
		$nextGameValue = $scoring[ $seedMap[$picks[$j]] ][ $roundMap[$j] + 1 ];
		$nextGameValueStr = " onmouseover=\"return displayNextRoundWinValue('".$nextGameValue."');\" onmouseout=\"return clearStatus();\"";

		if($master_data[$j] != NULL)
		{
			
			if($picks[$j] != $master_data[$j]) 
			{
				$correctSeed = "<span class=\"gamevalue\">".$seedMap[$master_data[$j]].". </span>";
				$correctValue = $scoring[ $seedMap[$master_data[$j]] ][ $roundMap[$j] ];
				$correctValueStr = " <span class=\"gamevalue\">(".$correctValue.")</span>";
				
				$nextCorrectGameValue = $scoring[ $seedMap[$master_data[$j]] ][ $roundMap[$j] + 1 ];
				$nextCorrectGameValueStr = " onmouseover=\"return displayNextRoundWinValue('".$nextCorrectGameValue."');\"";
				
				$picks[$j] = "<span class=\"strike\">".$pickSeed.$picks[$j].$gameValueStr;
				$picks[$j] .= "</span>";
				$picks[$j] .= "<br/><span class=\"correction\"".$nextCorrectGameValueStr.">".$correctSeed.$master_data[$j].$correctValueStr;
				$picks[$j] .= "</span>";
			}
			
			if($picks[$j] == $master_data[$j])
			{
				$picks[$j] = "<span class=\"right\"".$nextGameValueStr.">" .$pickSeed.$picks[$j].$gameValueStr;
				$picks[$j] .= "</span>";
			}
		}
		else if( $loserMap[$picks[$j]] == 1 )
		{
			$picks[$j] = "<span class=\"strike\">".$pickSeed.$picks[$j].$gameValueStr;
			$picks[$j] .= "</span>";
		}
		else
		{
			$picks[$j] = "<span ".$nextGameValueStr.">".$pickSeed.$picks[$j].$gameValueStr."</span>";
		}	
	}	
?>

<?php 

include('bracket_view_module.php');
viewBracket( $meta, $picks, $team_data, $rank, $score_data, $best_data );

?>

<div id="smacktalk" class="full">
<a name="comments"></a>
<h2>Smack Talk</h2><h3></h3>
<div class="messages" style="max-height: 100%;">
<table width="100%">

<?php
$posts = "SELECT c.time, c.content, c.from, c.bracket FROM `comments` c WHERE `bracket`=$id";

$posts = mysql_query($posts,$db);

while ($post = mysql_fetch_array($posts)) {
	
	echo "<tr valign='top'><td nowrap><span class='postername' >".stripslashes($post['from']).":</span></td><td>" . stripslashes($post['content']);	
	echo "</td><td nowrap><span class='date'>" . timeBetween(strtotime($post['time']),time()) . "</span></td></tr>\n";

}

$query = "SELECT * FROM `brackets` WHERE `email` = '" . $_COOKIE['useremail'] ."' LIMIT 0,1"; //select entry
$user = mysql_query($query,$db);
$user = mysql_fetch_array($user);

?>

</table>
</div>

<br>
<h2>Add Smack Talk</h2><h3></h3>

<?php if (isset($_COOKIE['useremail']) == true) { ?>
	<div id="addcomment">

	<form method="post" action="addcomment.php">
		
		
			<script type="text/javascript">
			 $(document).ready(function(){
			   $("#from").val("<?php echo ($user['person']); ?>");
			   });
			</script>
		
			<p><div class="comment_field">From:</div><input type="text" name="from" id="from" /></p>
			<p><div class="comment_field">Comment:</div><textarea name="comment" id="comment" rows="12"></textarea></p>
			<input type="hidden" name="id" value="<?php echo $id ?>" />
			<p><input type="submit" name="add" id="add" value="Submit" /></p>
			<!--<ul id="response" /> -->
	</form>

	</div>
<?php } else { ?>
	Users must log in on the home page to post smack talk.
<?php } ?>
</div>


<div id="footer"></div>
</body> 
</html> 
<?php

}else {

?> 
<div id="main"> 
  <div class="right_side"> 
    <?php include("sidebar.php"); ?> 
  </div> 
  <div class="left_side"> 
    <h2 align="center">Sorry. That bracket does not exist.</h2> 
    <h2 align="center"><br /> 
      Please try again. </h2> 
    <p align="center"> 
      <input type=button value="Back" onClick="history.back()" /> 
    </p> 
  </div> 
</div> 
</div> 
</body></html><?php } ?>
