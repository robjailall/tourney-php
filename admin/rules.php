<?php
include 'functions.php';
validatecookie();
include("header.php");

$query = "SELECT rules FROM `meta`";
$rules = mysql_query($query,$db);
$rules = @mysql_fetch_array($rules);
?>
	<div id="main">
		<div class="full">
			<form method="post" action="post.php?action=rules">
			<h2>Rules</h2>
			<p>You may enter whatever rules you would like.  They will appear on the rules page exactly as you type them here.</p>
			<p>I recommend at least including your submission deadline and your contact information.</p>
			<table>
				<tr>
					<td><textarea name="rules"><?php echo $rules[0]; ?></textarea></td>
				</tr>
				<tr>
					<td align="center"><input type="submit" value="Submit!"/></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</div>
</body>
</html>
