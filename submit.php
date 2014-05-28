<?php
include("header.php");


$iphoneOption = "";
$iphoneTriggerEvent = "onchange";
$iphone = false;
if( (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE ) || 
	(strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== FALSE ) ||
	(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE )
)  
{
	$iphone = true;
	$iphoneOption = "<option value=\"\"></option>";
	$iphoneTriggerEvent = "onblur";
}  


$closed = "SELECT `closed` FROM `meta` WHERE `id`=1";
$closed = mysql_query($closed,$db);
$closed = mysql_fetch_array($closed);
if($closed['closed'] != 0) {//if the master bracket has been populated
	echo '<div id="main"><div class="left_side">The competition has begun.  Bracket submission is closed.</div></div><div id="footer"></div>';
	exit();
}

if( $meta['sweet16Competition'] == true )
{
	echo '<div id="main"><div class="left_side">You have reached this page by mistake. Please click the <a href="submitSweet16.php">Create Bracket link</a> to create a Sweet 16 Bracket.</div></div><div id="footer"></div>';
	exit();

}

$email = "SELECT email FROM `meta` WHERE `id`=1";

$email = mysql_query($email,$db);
if(!($email = @mysql_fetch_array($email))) {//if fetching the array fails, prompt configuration
	echo "Please <a href=\"admin/install.htm\">configure the site.</a>\n";
	exit();
}
$teams = "SELECT * FROM `master` WHERE `id`=1"; //select teams
$teams = mysql_query($teams,$db);
if(!($teams = @mysql_fetch_array($teams))) {//if fetching the array fails, prompt configuration
	echo "The bracket has not yet been released.\n";
	exit();
}

$teamNames = "SELECT * FROM `master` WHERE `id`=1"; //select teams
$teamNames = mysql_query($teamNames,$db);
if(!($teamNames = @mysql_fetch_array($teamNames))) {//if fetching the array fails, prompt configuration
	echo "The bracket has not yet been released.\n";
	exit();
}

$seeds = "SELECT * FROM `master` WHERE `type`='seeds'"; //select seeds
$seeds = mysql_query($seeds,$db);
if(!($seeds = @mysql_fetch_array($seeds))) {//if fetching the array fails, prompt configuration
	echo "The bracket has not yet been released.\n";
	exit();
}


for( $i=1; $i <= 64; $i++)
{
	$teamNames[$i] = $seeds[$i].". ".$teamNames[$i];
}


?>
	<script type="text/javascript">

function validateFields( alertText )
{
	for( var i=1; i<64; i++ )
	{
		var field = document.getElementsByName('game'+i)[0];
		if( field.value == "" )
		{
			alert( "You must pick a winner for this game." );
			field.focus();
			return false;
		}
	}
	
	var moreFields = new Array('bracketname','name','e-mail','tiebreaker');
	
	for( var i=0; i < moreFields.length; i++ )
	{
		var field = document.getElementsByName( moreFields[i] )[0];
		if( field.value == "" )
		{
			alert( "You must fill out this field");
			field.focus();
			return false;
		}
	}
	
	if( alertText != "" )
	{
		return window.confirm(alertText);
	}
	else
	{
		return true;
	}
}
	

	</script>
	
	<div id="main">
		<div class="full">
			<h2>The Bracket</h2>
			<h3>&nbsp;</h3>
			<form method="post" name="bracket" class="bracket" id="bracket" action="bracket.php">
				<?php
				if(isset($_SESSION['errors'])) {
				?>
                <div class="errors"><p><em>Errors:</em></p><?php echo $_SESSION['errors']?></div>
                <?php 
                }
				unset($_SESSION['errors']);
				?>
				<p class="highlight"><em><strong>Please note:</strong></em> 
				A game is not selected unless it is HIGHLIGHTED. If you leave a game blank, it is an automatic loss. 
				<?php if($meta['mail'] != 0 ) { ?>
				If you believe you have made a mistake, <a href="contact.php">contact</a> us.</p>
				<?php } else { ?>
				If you believe you have made a mistake, notify the tourney administrator.</p>
				<?php } ?>
<p>
If you want a hard copy of your bracket before the tournament begins, please PRINT your bracket before submitting it.</p>
				<table width="700" border="1">
					<tr>
						<td colspan="5"><h1><?php echo $meta['region1']?></h1></td>
					</tr>
					<tr>
						<td>1. <?php echo $teams['1']?></td>
						<td rowspan="2"><select name="game1" size="2" class="forms" id="game1" onchange="update('game1','game33',0);">
								<option value="<?php echo $teams[1]?>"><?php echo $teamNames['1']?></option>
								<option value="<?php echo $teams[2]?>"><?php echo $teamNames['2']?></option>
							</select></td>
						<td rowspan="4"><select name="game33" size="2" class="forms" id="game33" onchange="update('game33','game49',0);">
						</select></td>
						<td rowspan="8"><select name="game49" size="2" class="forms" id="game49" onchange="update('game49','game57',0);">
						</select></td>
						<td rowspan="16"><select name="game57" size="2" class="forms" id="game57" onchange="update('game57','game61',0);">
																		</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['2']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['3']?></td>
						<td rowspan="2"><select name="game2" size="2" class="forms" id="game2" onchange="update('game2','game33',1);">
								<option value="<?php echo $teams[3]?>" ><?php echo $teamNames['3']?></option>
								<option value="<?php echo $teams[4]?>" ><?php echo $teamNames['4']?></option>
							</select></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['4']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['5']?></td>
						<td rowspan="2"><select name="game3" size="2" class="forms" id="game3" onchange="update('game3','game34',0);">
								<option value="<?php echo $teams[5]?>" ><?php echo $teamNames['5']?></option>
								<option value="<?php echo $teams[6]?>" ><?php echo $teamNames['6']?></option>
							</select></td>
						<td rowspan="4"><select name="game34" size="2" class="forms" id="game34" onchange="update('game34','game49',1);">
							</select></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['6']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['7']?></td>
						<td rowspan="2"><select name="game4" size="2" class="forms" id="game4" onchange="update('game4','game34',1);">
								<option value="<?php echo $teams[7]?>" ><?php echo $teamNames['7']?></option>
								<option value="<?php echo $teams[8]?>" ><?php echo $teamNames['8']?></option>
							</select></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['8']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['9']?></td>
						<td rowspan="2"><select name="game5" size="2" class="forms" id="game5" onchange="update('game5','game35',0);">
								<option value="<?php echo $teams[9]?>" ><?php echo $teamNames['9']?></option>
								<option value="<?php echo $teams[10]?>" ><?php echo $teamNames['10']?></option>
							</select></td>
						<td rowspan="4"><select name="game35" size="2" class="forms" id="game35" onchange="update('game35','game50',0);">
							</select></td>
						<td rowspan="8"><select name="game50" size="2" class="forms" id="game50" onchange="update('game50','game57',1);">
							</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['10']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['11']?></td>
						<td rowspan="2"><select name="game6" size="2" class="forms" id="game6" onchange="update('game6','game35',1);">
								<option value="<?php echo $teams[11]?>" ><?php echo $teamNames['11']?></option>
								<option value="<?php echo $teams[12]?>" ><?php echo $teamNames['12']?></option>
							</select></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['12']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['13']?></td>
						<td rowspan="2"><select name="game7" size="2" class="forms" id="game7" onchange="update('game7','game36',0);">
								<option value="<?php echo $teams[13]?>" ><?php echo $teamNames['13']?></option>
								<option value="<?php echo $teams[14]?>" ><?php echo $teamNames['14']?></option>
							</select></td>
						<td rowspan="4"><select name="game36" size="2" class="forms" id="game36" onchange="update('game36','game50',1);">
							</select></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['14']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['15']?></td>
						<td rowspan="2"><select name="game8" size="2" class="forms" id="game8" onchange="update('game8','game36',1);">
								<option value="<?php echo $teams[15]?>" ><?php echo $teamNames['15']?></option>
								<option value="<?php echo $teams[16]?>" ><?php echo $teamNames['16']?></option>
							</select></td>
					</tr>
					<tr>
						<td>15. <?php echo $teams['16']?></td>
					</tr>
				</table>
				<table width="700" border="1">
					<tr>
						<td colspan="5"><h1><?php echo $meta['region2']?></h1></td>
					</tr>
					<tr>
						<td>1. <?php echo $teams['17']?></td>
						<td rowspan="2"><select name="game9" class="forms" size="2" id="game9" onchange="update('game9','game37',0);">
								<option value="<?php echo $teams[17]?>" ><?php echo $teamNames['17']?></option>
								<option value="<?php echo $teams[18]?>" ><?php echo $teamNames['18']?></option>
							</select></td>
						<td rowspan="4"><select name="game37" class="forms" size="2" id="game37" onchange="update('game37','game51',0);">
						</select></td>
						<td rowspan="8"><select name="game51" class="forms" size="2" id="game51" onchange="update('game51','game58',0);">
						</select></td>
						<td rowspan="16"><select name="game58" class="forms" size="2" id="game58" onchange="update('game58','game61',1);">
						</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['18']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['19']?></td>
						<td rowspan="2"><select name="game10" class="forms" size="2" id="game10" onchange="update('game10','game37',1);">
								<option value="<?php echo $teams[19]?>" ><?php echo $teamNames['19']?></option>
								<option value="<?php echo $teams[20]?>" ><?php echo $teamNames['20']?></option>
							</select></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['20']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['21']?></td>
						<td rowspan="2"><select name="game11" class="forms" size="2" id="game11" onchange="update('game11','game38',0);">
							<option value="<?php echo $teams[21]?>" ><?php echo $teamNames['21']?></option>
							<option value="<?php echo $teams[22]?>" ><?php echo $teamNames['22']?></option>
							</select></td>
						<td rowspan="4"><select name="game38" class="forms" size="2" id="game38" onchange="update('game38','game51',1);">
							</select></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['22']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['23']?></td>
						<td rowspan="2"><select name="game12" class="forms" size="2" id="game12" onchange="update('game12','game38',1);">
							<option value="<?php echo $teams[23]?>" ><?php echo $teamNames['23']?></option>
							<option value="<?php echo $teams[24]?>" ><?php echo $teamNames['24']?></option>
							</select></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['24']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['25']?></td>
						<td rowspan="2"><select name="game13" class="forms"  size="2"id="game13" onchange="update('game13','game39',0);">
								<option value="<?php echo $teams[25]?>" ><?php echo $teamNames['25']?></option>
								<option value="<?php echo $teams[26]?>" ><?php echo $teamNames['26']?></option>
							</select></td>
						<td rowspan="4"><select name="game39" class="forms"  size="2"id="game39" onchange="update('game39','game52',0);">
							</select></td>
						<td rowspan="8"><select name="game52" class="forms"  size="2" id="game52" onchange="update('game52','game58',1);">
							</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['26']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['27']?></td>
						<td rowspan="2"><select name="game14" size="2" class="forms" id="game14" onchange="update('game14','game39',1);">
								<option value="<?php echo $teams[27]?>" ><?php echo $teamNames['27']?></option>
								<option value="<?php echo $teams[28]?>" ><?php echo $teamNames['28']?></option>
							</select></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['28']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['29']?></td>
						<td rowspan="2"><select name="game15" class="forms" size="2" id="game15" onchange="update('game15','game40',0);">
								<option value="<?php echo $teams[29]?>" ><?php echo $teamNames['29']?></option>
								<option value="<?php echo $teams[30]?>" ><?php echo $teamNames['30']?></option>
							</select></td>
						<td rowspan="4"><select name="game40" class="forms" size="2" id="game40" onchange="update('game40','game52',1);">
							</select></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['30']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['31']?></td>
						<td rowspan="2"><select name="game16" class="forms" size="2" id="game16" onchange="update('game16','game40',1);">
								<option value="<?php echo $teams[31]?>" ><?php echo $teamNames['31']?></option>
								<option value="<?php echo $teams[32]?>" ><?php echo $teamNames['32']?></option>
							</select></td>
					</tr>
					<tr>
						<td>15. <?php echo $teams['32']?></td>
					</tr>
				</table>
				<table width="700" border="1">
					<tr>
						<td colspan="5"><h1><?php echo $meta['region3']?></h1></td>
					</tr>
					<tr>
						<td>1. <?php echo $teams['33']?></td>
						<td rowspan="2"><select name="game17" class="forms" size="2" id="game17" onchange="update('game17','game41',0);">
								<option value="<?php echo $teams[33]?>" ><?php echo $teamNames['33']?></option>
								<option value="<?php echo $teams[34]?>" ><?php echo $teamNames['34']?></option>
							</select></td>
						<td rowspan="4"><select name="game41" class="forms" size="2" id="game41" onchange="update('game41','game53',0);">
							</select></td>
						<td rowspan="8"><select name="game53" class="forms" size="2" id="game53" onchange="update('game53','game59',0);">
							</select></td>
						<td rowspan="16"><select name="game59" class="forms" size="2" id="game59" onchange="update('game59','game62',0);">
							</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['34']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['35']?></td>
						<td rowspan="2"><select name="game18" size="2" class="forms" id="game18" onchange="update('game18','game41',1);">
								<option value="<?php echo $teams[35]?>" ><?php echo $teamNames['35']?></option>
								<option value="<?php echo $teams[36]?>" ><?php echo $teamNames['36']?></option>
							</select></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['36']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['37']?></td>
						<td rowspan="2"><select name="game19" size="2" class="forms" id="game19" onchange="update('game19','game42',0);">
							<option value="<?php echo $teams[37]?>" ><?php echo $teamNames['37']?></option>
							<option value="<?php echo $teams[38]?>" ><?php echo $teamNames['38']?></option>
												</select></td>
						<td rowspan="4"><select name="game42" size="2" class="forms" id="game42" onchange="update('game42','game53',1);">
							</select></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['38']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['39']?></td>
						<td rowspan="2"><select name="game20" size="2" class="forms" id="game20" onchange="update('game20','game42',1);">
								<option value="<?php echo $teams[39]?>" ><?php echo $teamNames['39']?></option>
								<option value="<?php echo $teams[40]?>" ><?php echo $teamNames['40']?></option>
							</select></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['40']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['41']?></td>
						<td rowspan="2"><select name="game21" size="2" class="forms" id="game21" onchange="update('game21','game43',0);">
							<option value="<?php echo $teams[41]?>" ><?php echo $teamNames['41']?></option>
							<option value="<?php echo $teams[42]?>" ><?php echo $teamNames['42']?></option>
							</select></td>
						<td rowspan="4"><select name="game43" class="forms" size="2" id="game43" onchange="update('game43','game54',0);">
							</select></td>
						<td rowspan="8"><select name="game54" class="forms" size="2" id="game54" onchange="update('game54','game59',1);">
							</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['42']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['43']?></td>
						<td rowspan="2"><select name="game22" class="forms" size="2" id="game22" onchange="update('game22','game43',1);">
							<option value="<?php echo $teams[43]?>" ><?php echo $teamNames['43']?></option>
							<option value="<?php echo $teams[44]?>" ><?php echo $teamNames['44']?></option>
							</select></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['44']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['45']?></td>
						<td rowspan="2"><select name="game23" class="forms" size="2" id="game23" onchange="update('game23','game44',0);">
							<option value="<?php echo $teams[45]?>" ><?php echo $teamNames['45']?></option>
							<option value="<?php echo $teams[46]?>" ><?php echo $teamNames['46']?></option>
							</select></td>
						<td rowspan="4"><select name="game44" class="forms" size="2" id="game44" onchange="update('game44','game54',1);">
							</select></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['46']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['47']?></td>
						<td rowspan="2"><select name="game24" class="forms" size="2" id="game24" onchange="update('game24','game44',1);">
								<option value="<?php echo $teams[47]?>" ><?php echo $teamNames['47']?></option>
								<option value="<?php echo $teams[48]?>" ><?php echo $teamNames['48']?></option>
							</select></td>
					</tr>
					<tr>
						<td>15. <?php echo $teams['48']?></td>
					</tr>
				</table>
				<table width="700" border="1">
					<tr>
						<td colspan="5"><h1><?php echo $meta['region4']?></h1></td>
					</tr>
					<tr>
						<td>1. <?php echo $teams['49']?></td>
						<td rowspan="2"><select name="game25" class="forms" size="2" id="game25" onchange="update('game25','game45',0);">
							<option value="<?php echo $teams[49]?>" ><?php echo $teamNames['49']?></option>
							<option value="<?php echo $teams[50]?>" ><?php echo $teamNames['50']?></option>
						</select></td>
						<td rowspan="4"><select name="game45" class="forms" size="2" id="game45" onchange="update('game45','game55',0);">
						</select></td>
						<td rowspan="8"><select name="game55" class="forms" size="2" id="game55" onchange="update('game55','game60',0);">
						</select></td>
						<td rowspan="16"><select name="game60" class="forms" size="2" id="game60" onchange="update('game60','game62',1);">
						</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['50']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['51']?></td>
						<td rowspan="2"><select name="game26" class="forms" size="2" id="game26" onchange="update('game26','game45',1);">
								<option value="<?php echo $teams[51]?>" ><?php echo $teamNames['51']?></option>
								<option value="<?php echo $teams[52]?>" ><?php echo $teamNames['52']?></option>
							</select></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['52']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['53']?></td>
						<td rowspan="2"><select name="game27" class="forms" size="2" id="game27" onchange="update('game27','game46',0);">
							<option value="<?php echo $teams[53]?>" ><?php echo $teamNames['53']?></option>
							<option value="<?php echo $teams[54]?>" ><?php echo $teamNames['54']?></option>
							</select></td>
						<td rowspan="4"><select name="game46" class="forms" size="2" id="game46" onchange="update('game46','game55',1);">
							</select></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['54']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['55']?></td>
						<td rowspan="2"><select name="game28" class="forms" size="2" id="game28" onchange="update('game28','game46',1);">
								<option value="<?php echo $teams[55]?>" ><?php echo $teamNames['55']?></option>
								<option value="<?php echo $teams[56]?>" ><?php echo $teamNames['56']?></option>
							</select></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['56']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['57']?></td>
						<td rowspan="2"><select name="game29" class="forms" size="2" id="game29" onchange="update('game29','game47',0);">
								<option value="<?php echo $teams[57]?>" ><?php echo $teamNames['57']?></option>
								<option value="<?php echo $teams[58]?>" ><?php echo $teamNames['58']?></option>
							</select></td>
						<td rowspan="4"><select name="game47" class="forms" size="2" id="game47" onchange="update('game47','game56',0);">
							</select></td>
						<td rowspan="8"><select name="game56" class="forms" size="2" id="game56" onchange="update('game56','game60',1);">
							</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['58']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['59']?></td>
						<td rowspan="2"><select name="game30" class="forms" size="2" id="game30" onchange="update('game30','game47',1);">
								<option value="<?php echo $teams[59]?>" ><?php echo $teamNames['59']?></option>
								<option value="<?php echo $teams[60]?>" ><?php echo $teamNames['60']?></option>
							</select></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['60']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['61']?></td>
						<td rowspan="2"><select name="game31" class="forms" size="2" id="game31" onchange="update('game31','game48',0);">
								<option value="<?php echo $teams[61]?>" ><?php echo $teamNames['61']?></option>
								<option value="<?php echo $teams[62]?>" ><?php echo $teamNames['62']?></option>
							</select></td>
						<td rowspan="4"><select name="game48" class="forms" size="2" id="game48" onchange="update('game48','game56',1);">
							</select></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['62']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['63']?></td>
						<td rowspan="2"><select name="game32" class="forms" size="2" id="game32" onchange="update('game32','game48',1);">
								<option value="<?php echo $teams[63]?>" ><?php echo $teamNames['63']?></option>
								<option value="<?php echo $teams[64]?>" ><?php echo $teamNames['64']?></option>
							</select></td>
					</tr>
					<tr>
						<td>15. <?php echo $teams['64']?></td>
					</tr>
				</table>
				<p>&nbsp;</p>
				<table width="700" border="1">
					<tr>
						<td colspan="3"><h1 align="center">FINAL FOUR</h1></td>
					</tr>
					<tr>
						<td><?php echo $meta['region1']?> Champion </td>
						<td rowspan="2"><select name="game61" size="2" class="forms" id="game61" onchange="update('game61','game63',0);">
						</select></td>
						<td rowspan="4"><select name="game63" size="2" class="forms" id="game63">
						</select></td>
					</tr>
					<tr>
						<td><?php echo $meta['region2']?> Champion </td>
					</tr>
					<tr>
						<td><?php echo $meta['region3']?> Champion </td>
						<td rowspan="2"><select name="game62" size="2" class="forms" id="game62" onchange="update('game62','game63',1);">
						</select></td>
					</tr>
					<tr>
						<td><?php echo $meta['region4']?> Champion </td>
					</tr>
				</table>
									<br />
				<p align="center"><label for="name">Bracket Name:</label><input name="bracketname" type="text" id="bracketname" /></p>
				<p align="center"><label for="e-mail">Your Name:</label><input name="name" type="text" id="name" /></p>
				<p align="center"><label for="e-mail">E-Mail Address:</label><input name="e-mail" type="text" id="e-mail" /></p>
				<!--<p align="center"><label for="password">Submission Code:</label><input name="password" type="text" id="password" /></p>-->
				<p align="center">Tiebreaker (total points scored in championship)
					<input name="tiebreaker" type="text" id="tiebreaker" size="10" maxlength="3" />
					<br />
					<br />
					<input type="submit" name="submit" value="Submit" onclick="return validateFields('All fields appear to be filled. Are you sure you want to submit this bracket?')" />
					<input type="reset" name="reset"  value="Reset (BE CAREFUL!)" onclick="return resetBracket();" />
					<input type="submit" name="print" value="Print Your Bracket!" onclick="if(validateFields('')){ document.bracket.target='_blank'; } else { return false;}" />
				</p>
			</form>
		</div>
	</div>
	<div id="footer"> </div>
</div>
</body>
</html>
