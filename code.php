<?php
include 'admin/functions.php';
validatecookie();
include("header.php");





?>
	
		<div id="main">
			<div class="right_side">
				<?php include("sidebar.php"); ?>
			</div>
			<div class="left_side">
				<?php
                if(isset($_SESSION['success'])) {
				?>
                <div class="success"><?php echo $_SESSION['success']?></div>
				<?php
				}
				if(isset($_SESSION['errors'])) { 
				?>
                <div class="errors"><p><em>Errors:</em></p><?php echo $_SESSION['errors']?></div>
				<?php
				}
				unset($_SESSION['errors']);
				unset($_SESSION['success']);

			
			?>
			
				<form action="admin/sendcode.php" method="post">
				<p>Name: <input type="text" name="name" /></p>
				<p>Email Address: <input type="text" name="email" /></p>
				<p>Number of brackets: <input type="text" name="number" /></p>
				<input type="submit" value="Send code">
				</form>
			
				<br />
			</div>
			
		</div>
		
		<div id="footer">
		</div>
	</div>
</body>
</html>
