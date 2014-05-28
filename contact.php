<?php
include("header.php");



?>

		

		<div id="main">

			<div class="right_side"><?php include("sidebar.php"); ?>

			</div>

			<div class="left_side">
			<form method="post" action="sendEmail.php">
			<div id="container">
				<h2>Contact Us </h2>

					<p><small>Name:</small> <input type="text" name="name" id="name" /></p>
					<p><small>Email Address:</small> <input type="text" name="email" id="email" /></p>
					<p><small>Questions/Comments:</small> <textarea name="comments" id="comments" rows="12"></textarea></p>	
					<p><input type="submit" name="submit" id="submit" value="Email Us!" /></p>
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

