<?php

include("header.php");
$team = $_GET['team'];
if($team == 'Texas A') 
	$team = 'Texas A&M'; //quick hack...ampersand broke things
$query = "SELECT * FROM `brackets` WHERE `63` = '$team'";
$brackets = mysql_query($query,$db);
$brackets = mysql_fetch_array($brackets);

if($brackets['name'] != NULL) {
?>


	<div id="main">
		<div class="left_side">
			<h2>People who picked <?php echo $brackets['63']; ?></h2>
			<ul>
			<?php
			$query = "SELECT * FROM `brackets` WHERE `63` = '$team'";
			$brackets = mysql_query($query);
				while($bracket = mysql_fetch_array($brackets)) {
					// Simply allow anyone who is logged in to see the user name
					if (isset($_COOKIE['useremail']) == true)
					{
						echo "<li><a href=\"view.php?id=$bracket[id]\">" . stripslashes($bracket[name]) . "</a> ( $bracket[tiebreaker] ) " . " - " . stripslashes($bracket['person']) . "</li>";
					}
					else
					{
						echo "<li><a href=\"view.php?id=$bracket[id]\">" . stripslashes($bracket[name]) . "</a> ( $bracket[tiebreaker] ) </li>";
					}
			
				}

			?>
			</li>
		</div>
	</div>
	<div id="footer"> </div>
</div>
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
				<h2 align="center">Sorry. No one picked that team.</h2>
				<h2 align="center"><br />
					Please try again. </h2>
				<p align="center"><input type=button value="Back" onClick="history.back()" /></p>
			</div>
			
		</div>
		
		<div id="footer">
		</div>
	</div>
</body>
</html>
<?php } ?>
