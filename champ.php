<?php
include("header.php");
?>

		<div id="main">
			<div class="right_side"><?php include("sidebar.php"); ?>
			</div>
			<div class="left_side">
				<h2>Who Picked Who </h2>
				<h3>WHO MADE THE SAME PICKS? </h3>
				<div id="border" align="center">
			  	<table width="300" border="1" align="center">
					<tr>
						<td width="89"><div align="center"><strong>TEAM</strong></div></td>
						<td width="195"><div align="center">
							<p><strong># OF BRACKETS</strong></p>
							<p><strong>(CLICK TO SEE THE NAMES) </strong></p>
						</div></td>
					</tr>
					<?php
						$query = "SELECT * FROM `brackets` ORDER BY `63` ASC";
						$selected = array();
						$winners = mysql_query($query,$db) or die(mysql_error()); 
						while($teams = mysql_fetch_array($winners)) {
							// Print out the contents of each row into a table
							if(!in_array($teams['63'],$selected)) {
								$query = "SELECT COUNT(*) FROM `brackets` WHERE `63`='$teams[63]'";
								$picks = mysql_query($query,$db) or die(mysql_error()); 
								$picks = mysql_fetch_array($picks);
								echo "<tr><td>"; 
								echo $teams['63'];
								echo "</td><td>"; 
								echo "<a href=\"picks.php?team=$teams[63]\">$picks[0]</a>";
								echo "</td></tr>"; 
							}
							array_push($selected,$teams['63']);

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
