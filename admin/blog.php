<?php
include 'functions.php';
validatecookie();
include("header.php");

$query = "SELECT id,title,subtitle FROM `blog`";
$posts = mysql_query($query,$db);
?>
	<div id="main">
		<div class="full">
			<form method="post" action="post.php?action=post">
			<h2>Write a Post</h2>
			<table>
				<tr>
					<td>Post Title</td>
					<td><input type="text" name="title" /></td>
				</tr>
				<tr>
					<td>Post Subtitle</td>
					<td><input type="text" name="subtitle" /></td>
				</tr>
				<tr>
					<td>Post Content</td>
					<td><textarea name="content"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Submit!"/></td>
				</tr>
			</table>
		</form>
			<form method="post" action="post.php?action=delete">
			<h2>Delete a Post</h2>
			<table>
				<tr>
					<td>Select a Post</td>
					<td>
						<select name="post">
						<?php
						while($post = mysql_fetch_row($posts))
							echo "<option value=\"$post[0]\">$post[1]-$post[2]</option>\n";
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Submit!"/></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</div>
</body>
</html>
