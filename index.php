<?php
include("header.php");
include("admin/functions.php");
 
$query = "SELECT * FROM `blog` ORDER BY id DESC LIMIT 3";
$blog = mysql_query($query,$db);

$query = "SELECT c.time, c.content, c.from, c.bracket, b.name, b.person  FROM `comments` c, `brackets` b WHERE b.id = c.bracket ORDER BY c.time DESC";
$comments = mysql_query($query,$db);

if($blog == NULL) {
	echo "Please <a href=\"admin/install.htm\">configure the site <br />
               AFTER setting up admin/database.php to point to your database.</a>\n";
	exit();
}
?>
	
		<div id="main">
			<?php
				$smackheader=0;
				while ($post = mysql_fetch_array($comments))
				{		
					if( 0 == $smackheader )
					{
						echo "<div id='smacktalk'><h2>Latest Smack Talk</h2><div class='messages'><table width='100%'>";
						$smackheader=1;
					}
					echo "<tr><td><span class='postername' >".stripslashes($post['from']).":</span> <a class='teaser' href=\"view.php?id=" . stripslashes($post['bracket']) . "#comments\">" . substr(stripslashes($post['content']),0,250);
						
					if (strlen($post['content'])>250)
					{
						echo "...";
					}					
					
					echo "</a></td><td><div class='bracketName'><a href=\"view.php?id=" . $post['bracket'] . "#comments\">" . stripslashes($post['name']) . "</a> - <span class='date'>" . timeBetween(strtotime($post['time']),time()) . "</span></div></td></tr>\n";

				}
				if( $smackheader )
				{
					echo "</table></div></div>";
				}
			?>
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
				
				while ($post = mysql_fetch_row($blog)){
					echo "<h2>$post[1]</h2>\n";
					echo "<h3>$post[2]</h3>\n";
					echo "$post[3]\n";
					echo "<p class=\"date\">$post[4]</p>\n";
				}
			?>
				<br />
			</div>
			
		</div>
		
		<div id="footer">
		</div>
	</div>
</body>
</html>
