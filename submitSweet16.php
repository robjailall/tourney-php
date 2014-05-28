<?php
include("header.php");
include("admin/functions.php");


$closed = "SELECT `closed` FROM `meta` WHERE `id`=1";
$closed = mysql_query($closed,$db);
$closed = mysql_fetch_array($closed);
if($closed['closed'] != 0) {//if the master bracket has been populated
	echo '<div id="main"><div class="left_side">The competition has begun.  Bracket submission is closed.</div></div><div id="footer">
</div>';
	exit();
}

if( $meta['sweet16Competition'] == true )
{
	$master_query = "SELECT * FROM `master` WHERE `id`=2"; //select winners
	$master_data = mysql_query($master_query,$db);
	$winners = mysql_fetch_array($master_data);
		
	$sweet16determined = true;
	for( $i=1; $i <= 48; $i++)
	{
		if( $winners[$i] == "" )
		{
			$sweet16determined = false;
			break;
		}
	}
	
	// If missing winner in first two rounds
	if( $sweet16determined == false ) {
		echo '<div id="main"><div class="left_side">The sweet 16 bracket has not yet been released.</div></div><div id="footer"></div>';
		exit();
	}

	$seedMap = getSeedMap($db);
}


$email = "SELECT email FROM `meta` WHERE `id`=1";

$email = mysql_query($email,$db);
if(!($email = @mysql_fetch_array($email))) {//if fetching the array fails, prompt configuration
	echo '<div id="main"><div class="left_side">Please <a href=\"admin/install.htm\">configure the site.</a></div></div><div id="footer"></div>';
	exit();
}
$teams = "SELECT * FROM `master` WHERE `id`=1"; //select teams
$teams = mysql_query($teams,$db);
if(!($teams = @mysql_fetch_array($teams))) {//if fetching the array fails, prompt configuration
	echo '<div id="main"><div class="left_side">The bracket has not yet been released.</div></div><div id="footer"></div>';
	exit();
}

$teamNames = "SELECT * FROM `master` WHERE `id`=1"; //select teams
$teamNames = mysql_query($teamNames,$db);
if(!($teamNames = @mysql_fetch_array($teamNames))) {//if fetching the array fails, prompt configuration
	echo '<div id="main"><div class="left_side">The bracket has not yet been released.</div></div><div id="footer"></div>';
	exit();
}

$seeds = "SELECT * FROM `master` WHERE `type`='seeds'"; //select seeds
$seeds = mysql_query($seeds,$db);
if(!($seeds = @mysql_fetch_array($seeds))) {//if fetching the array fails, prompt configuration
	echo '<div id="main"><div class="left_side">The bracket has not yet been released.</div></div><div id="footer"></div>';
	exit();
}

for( $i=1; $i <= 64; $i++)
{
	$teamNames[$i] = $seeds[$i].". ".$teamNames[$i];
}

for( $i=1; $i <= 64; $i++)
{
	$winnerNames[$i] = $seedMap[$winners[$i]].". ".$winners[$i];
}


?>
	<script type="text/javascript">

function validateFields( alertText )
{
	for( var i=49; i<64; i++ )
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
						<td>1. <?php echo $teams['1']; ?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['1']].'. '.$winners['1']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['33']].'. '.$winners['33']; ?></td>
						<td rowspan="8"><select name="game49" size="2" class="forms" id="game49" onchange="update('game49','game57',0);">
							<option value="<?php echo $winners[33]?>" ><?php echo $winnerNames['33']?></option>
							<option value="<?php echo $winners[34]?>" ><?php echo $winnerNames['34']?></option>
						</select></td>
						<td rowspan="16"><select name="game57" size="2" class="forms" id="game57" onchange="update('game57','game61',0);">
							
						</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['2']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['3']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['2']].'. '.$winners['2']; ?></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['4']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['5']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['3']].'. '.$winners['3']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['34']].'. '.$winners['34']; ?></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['6']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['7']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['4']].'. '.$winners['4']; ?></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['8']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['9']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['5']].'. '.$winners['5']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['35']].'. '.$winners['35']; ?></td>
						<td rowspan="8"><select name="game50" size="2" class="forms" id="game50" onchange="update('game50','game57',1);">
							<option value="<?php echo $winners[35]?>" ><?php echo $winnerNames['35']?></option>
							<option value="<?php echo $winners[36]?>" ><?php echo $winnerNames['36']?></option>
						</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['10']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['11']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['6']].'. '.$winners['6']; ?></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['12']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['13']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['7']].'. '.$winners['7']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['36']].'. '.$winners['36']; ?></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['14']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['15']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['8']].'. '.$winners['8']; ?></td>
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
						<td rowspan="2"><?php echo $seedMap[$winners['9']].'. '.$winners['9']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['37']].'. '.$winners['37']; ?></td>
						<td rowspan="8"><select name="game51" class="forms" size="2" id="game51" onchange="update('game51','game58',0);">
							<option value="<?php echo $winners[37]?>" ><?php echo $winnerNames['37']?></option>
							<option value="<?php echo $winners[38]?>" ><?php echo $winnerNames['38']?></option>
						</select></td>
						<td rowspan="16"><select name="game58" class="forms" size="2" id="game58" onchange="update('game58','game61',1);">
						</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['18']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['19']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['10']].'. '.$winners['10']; ?></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['20']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['21']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['11']].'. '.$winners['11']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['38']].'. '.$winners['38']; ?></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['22']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['23']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['12']].'. '.$winners['12']; ?></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['24']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['25']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['13']].'. '.$winners['13']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['39']].'. '.$winners['39']; ?></td>
						<td rowspan="8"><select name="game52" class="forms"  size="2" id="game52" onchange="update('game52','game58',1);">
							<option value="<?php echo $winners[39]?>" ><?php echo $winnerNames['39']?></option>
							<option value="<?php echo $winners[40]?>" ><?php echo $winnerNames['40']?></option>
						</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['26']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['27']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['14']].'. '.$winners['14']; ?></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['28']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['29']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['15']].'. '.$winners['15']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['40']].'. '.$winners['40']; ?></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['30']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['31']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['16']].'. '.$winners['16']; ?></td>
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
						<td rowspan="2"><?php echo $seedMap[$winners['17']].'. '.$winners['17']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['41']].'. '.$winners['41']; ?></td>
						<td rowspan="8"><select name="game53" class="forms" size="2" id="game53" onchange="update('game53','game59',0);">
							<option value="<?php echo $winners[41]?>" ><?php echo $winnerNames['41']?></option>
							<option value="<?php echo $winners[42]?>" ><?php echo $winnerNames['42']?></option>
						</select></td>
						<td rowspan="16"><select name="game59" class="forms" size="2" id="game59" onchange="update('game59','game62',0);">
							</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['34']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['35']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['18']].'. '.$winners['18']; ?></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['36']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['37']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['19']].'. '.$winners['19']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['42']].'. '.$winners['42']; ?></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['38']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['39']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['20']].'. '.$winners['20']; ?></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['40']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['41']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['21']].'. '.$winners['21']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['43']].'. '.$winners['43']; ?></td>
						<td rowspan="8"><select name="game54" class="forms" size="2" id="game54" onchange="update('game54','game59',1);">
							<option value="<?php echo $winners[43]?>" ><?php echo $winnerNames['43']?></option>
							<option value="<?php echo $winners[44]?>" ><?php echo $winnerNames['44']?></option>
						</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['42']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['43']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['22']].'. '.$winners['22']; ?></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['44']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['45']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['23']].'. '.$winners['23']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['44']].'. '.$winners['44']; ?></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['46']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['47']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['24']].'. '.$winners['24']; ?></td>
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
						<td rowspan="2"><?php echo $seedMap[$winners['25']].'. '.$winners['25']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['45']].'. '.$winners['45']; ?></td>
						<td rowspan="8"><select name="game55" class="forms" size="2" id="game55" onchange="update('game55','game60',0);">
							<option value="<?php echo $winners[45]?>" ><?php echo $winnerNames['45']?></option>
							<option value="<?php echo $winners[46]?>" ><?php echo $winnerNames['46']?></option>
						</select></td>
						<td rowspan="16"><select name="game60" class="forms" size="2" id="game60" onchange="update('game60','game62',1);">
						</select></td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['50']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['51']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['26']].'. '.$winners['26']; ?></td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['52']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['53']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['27']].'. '.$winners['27']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['46']].'. '.$winners['46']; ?></td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['54']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['55']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['28']].'. '.$winners['28']; ?></td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['56']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['57']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['29']].'. '.$winners['29']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['47']].'. '.$winners['47']; ?></td>
						<td rowspan="8"><select name="game56" class="forms" size="2" id="game56" onchange="update('game56','game60',1);">
							<option value="<?php echo $winners[47]?>" ><?php echo $winnerNames['47']?></option>
							<option value="<?php echo $winners[48]?>" ><?php echo $winnerNames['48']?></option>
						</select></td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['58']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['59']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['30']].'. '.$winners['30']; ?></td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['60']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['61']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['31']].'. '.$winners['31']; ?></td>
						<td rowspan="4"><?php echo $seedMap[$winners['48']].'. '.$winners['48']; ?></td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['62']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['63']?></td>
						<td rowspan="2"><?php echo $seedMap[$winners['32']].'. '.$winners['32']; ?></td>
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
