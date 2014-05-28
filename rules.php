<?php
include("header.php");

$points = "SELECT * FROM `meta` WHERE id=1";
$points = mysql_query($points,$db);
if(!($points = @mysql_fetch_array($points))) {//if fetching the array fails, prompt configuration
	echo "Please <a href=\"admin/install.htm\">configure the site.</a>\n";
	exit();
}



$scoring = mysql_query("SELECT seed,`1`,`2`,`3`,`4`,`5`,`6` FROM `scoring` WHERE `type` = 'main' ORDER BY `seed`",$db);

?>

		

		<div id="main">

			<div class="right_side">

				

								<?php include("sidebar.php"); ?>



			</div>

			<div class="left_side">

				<h2>The Rules</h2>

				<h3>SCORING AND SUCH</h3>

				
<table border="1" align="center">
	<tr>
		<td colspan="8">Value of a win by a seed in a particular round</td>
	</tr>
	<tr>
		<td>Seed #</td>
		<td>R1</td>
		<td>R2</td>
		<td>R3</td>
		<td>R4</td>
		<td>R5</td>
		<td>R6</td>
	</tr>
	
<?php
while ($row = mysql_fetch_assoc($scoring))
{
	echo "<tr><td>".$row['seed']."</td>";
	
	for( $i=1; $i < 7; $i++ )
	{
		echo "<td>".$row[$i]."</td>";
	}
	
	echo "</tr>";
}
?>
</table>

<p align="center">
	&nbsp;
</p>
<p align="center">
	<strong>Other Rules</strong>
</p>
<?php echo $points['rules']; ?>
</div>
</div>
<div id="footer">
</div>
</div>
</body>
</html>
