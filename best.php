<?php
include("header.php");
?>

		<div id="main">

			<div class="full">
				<h2>The Best Case Standings </h2>
				<h3>WHERE DO YOU RANK?  </h3>
			<div id="border" align="center">
			  	<table width="750" border="1" align="center">
					<tr>
						<td><div align="center"><strong>RANK</strong></div></td>
						<td><div align="center"><strong>NAME</strong></div></td>
						<td><div align="center"><strong>BEST</strong></div></td>
						<td><div align="center"><strong><a href="standings.php?type=normal">ACTUAL</a></strong></div></td>
						<td><div align="center"><strong>PPR</strong></div></td>
						<td><div align="center"><strong>TIEBREAKER</strong></div></td>
					</tr>
					<?php
						$query = "SELECT scores.id, scores.name, scores.score, best_scores.score AS b_score, brackets.tiebreaker, brackets.63, brackets.email, brackets.person FROM scores, best_scores, brackets WHERE scores.scoring_type = best_scores.scoring_type and scores.scoring_type = 'main' and scores.id = best_scores.id AND scores.id = brackets.id ORDER BY best_scores.score DESC, scores.score DESC, scores.name ASC";
						$result = mysql_query($query,$db) or die(mysql_error());
						$rankCounter = 1;
						$i=0;
						while($user = mysql_fetch_array($result)) {
							
							$useremail = $user['email'];
							if( $i==0 ) {
								$prev_score = $user['b_score'];
								$rankCounter = 1;
								$i=1;
							}
							if( $user['b_score'] != $prev_score ) {
								$prev_score = $user['b_score'];
								$i++;
								$i = $rankCounter;
							}
							// Print out the contents of each row into a table
							if ($useremail == $_COOKIE['useremail'] & $useremail != ""){
								echo '<tr class="thisuser">';
							} else {
								echo "<tr>";
							}
							echo "<td align='right'>";
							echo $i;
							echo "&nbsp;&nbsp;</td><td>";
							// Simply allow anyone who is logged in to see the user name
							if (isset($_COOKIE['useremail']) == true)
							{
								echo "<a href=\"view.php?id=$user[id]\">" . stripslashes($user[name]) . "</a>" . " (" . stripslashes($user[person]) . ")";
							}
							else
							{
								echo "<a href=\"view.php?id=$user[id]\">" . stripslashes($user[name]) . "</a>";
							}

							echo "</td><td>";
							echo $user['b_score'];
							echo "</td><td>";
							echo $user['score'];
							echo "</td><td>";
							echo $user['b_score']-$user['score'];
							echo "</td><td>";
							echo $user['63'];
							echo " - ";
							echo $user['tiebreaker'];
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
