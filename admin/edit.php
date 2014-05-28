<?php
include("header.php");
$query = "SELECT id,name FROM `brackets`";
$users = mysql_query($query,$db);
?>
	<div id="main">
		<div class="full">
			<form method="post" action="bracket.php">
			<h2>Select a User</h2>
			<table>
				<tr>
					<td>
						<select name="id" class="forms" id="id">
						<?php
						while($user = mysql_fetch_array($users)) {
							echo "<option value=\"$user[0]\">$user[1]</option>\n";
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" value="Submit!"/></td>
				</tr>
			</table>
			</form>
			<p>

			</p>

		</div>
	</div>
</div>
</body>
</html>
