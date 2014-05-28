<?php
include("header.php");



?>

		

		<div id="main">

			<div class="right_side"><?php include("sidebar.php"); ?>

			</div>

			<div class="left_side">
			<form method="post" action="sendEmailUsers.php">
			<div id="container">
				<h2>Contact the participants </h2>

					<p><small>Subject:</small> <input type="text" name="subject" id="subject" /></p>
					<p><small>Content:</small> <textarea name="body" id="body" rows="15"></textarea></p>	
					<p><input type="submit" name="sendtoall" id="sendtoall" value="Send Email" /></p>
					<ul id="response" />
			</div>
			</form>
			</div>

			

		</div>

		

		<div id="footer">

		</div>

	</div>

</body>

</html>

