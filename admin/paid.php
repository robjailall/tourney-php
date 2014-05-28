<?php
include("database.php");
include 'functions.php';
validatecookie();
include("header.php");
$query = "SELECT id,name,paid,email,person FROM `brackets`";
$names = mysql_query($query,$db);
?>
	<div id="main">
		<div class="full">
			<form method="post" action="post.php?action=paid">
			<h2>Who's Paid?</h2>
			<table class="adminPaid">
					<tr class="paidHeader">
						<td class="paidPerson">Name</th>
						<td class="paidBracket">Bracket</th>
						<td class="paidEmail">Email</th>
						<td class="paidSelector">Paid</th>
						<td class="paidSelector">Unpaid</th>
						<td class="paidSelector">Exempt</th>
					</tr>
					<?php
					$rowCount = 0;
					while($name=mysql_fetch_row($names)) {
						$rowCount = $rowCount + 1;
						echo '<tr class="row'.fmod($rowCount,2).'">' . "\n";
						echo "<td>\n";
						echo stripslashes($name[4]) ."</td><td>". stripslashes($name[1]) ."</td><td> $name[3] ";
						echo "</td>\n";
						echo "<td>\n";
						if($name[2]==1)
							echo "<input type=\"radio\" name=\"$name[0]\" value=\"1\" checked>\n";
						else
							echo "<input type=\"radio\" name=\"$name[0]\" value=\"1\">\n";
						echo "</td>\n";
						echo "<td>\n";
						if($name[2]==0)
							echo "<input type=\"radio\" name=\"$name[0]\" value=\"0\" checked>\n";
						else
							echo "<input type=\"radio\" name=\"$name[0]\" value=\"0\">\n";
						echo "</td>\n";
						echo "<td>\n";
						if($name[2]==2)
							echo "<input type=\"radio\" name=\"$name[0]\" value=\"2\" checked>\n";
						else
							echo "<input type=\"radio\" name=\"$name[0]\" value=\"2\">\n";
						echo "</td>\n";
						echo "</tr>\n";
					}
					?>
				<tr>
					<td colspan="6" align="center"><input type="submit" value="Submit!"/></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</div>
</body>
</html>
