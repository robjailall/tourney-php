<?php
include("header.php");


function printPaymentList($rows,$listName)
{
	if(mysql_num_rows($rows) > 0)
	{
		echo "<h4>".$listName."</h4>\n";
		echo "<ul>\n";
		while ($row=mysql_fetch_row($rows)){
			// Allow anyone who is logged in to see the user name
			if (isset($_COOKIE['useremail']) == true)
			{
				echo "<li>".stripslashes($row[0])." (".$row[1].")</li>\n";
			}
			else
			{
				echo "<li>".stripslashes($row[0])."</li>\n";
			}
		}
		echo "</ul>\n";
	}
}

$closed = "SELECT closed FROM `meta` WHERE id=1 LIMIT 1";
$closed = mysql_query($closed,$db); //boolean if bracket submission is over
if(!($closed = @mysql_fetch_array($closed))) {//if fetching the array fails, prompt configuration
	echo "Please <a href=\"admin/install.htm\">configure the site.</a>\n";
	exit();
}

$query = "SELECT name,person FROM `brackets` WHERE paid=0 ORDER BY name"; //select names of unpaid entrants
$unpaid = mysql_query($query,$db);

$query = "SELECT name,person FROM `brackets` WHERE paid=1 ORDER BY name"; //select names of paid entrants
$paid = mysql_query($query,$db);

$query = "SELECT name,person FROM `brackets` WHERE paid=2 ORDER BY name"; //select names of exempted entrants
$exempt = mysql_query($query,$db);


?>
		<div id="main">
			<div class="right_side"><?php include("sidebar.php"); ?></div>
			<div class="left_side">
				<h2>The Paid List </h2>
				<h3>HAVE YOU PAID YET? </h3>
				<?php
				printPaymentList($unpaid,"Unpaid");
				printPaymentList($paid,"Paid");
				printPaymentList($exempt,"Exempt");
				?>
			</div>			
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
