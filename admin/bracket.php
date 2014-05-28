<?php
include 'functions.php';
validatecookie();
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
	$iphoneTriggerEvent = "onchange";
}  

$teams = "SELECT * FROM `master` WHERE `id`=1"; //select teams
$teams = mysql_query($teams,$db);
if(!($teams = @mysql_fetch_array($teams))) {//if fetching the array fails, prompt configuration
	echo "The bracket has not yet been released.\n";
	exit();
}

// checking to see if any POST exists eliminates an error message
if($_POST == NULL ) {
   $id = 0;
}
else if($_POST['id'] == NULL) {
	$id = 0;
}
else {
	$id = $_POST['id'];
}
if($id == 0) {
	$query = "SELECT * FROM `master` WHERE `id`=2";
	$picks = mysql_query($query,$db);
	$picks = mysql_fetch_array($picks);
}
else {
	$query = "SELECT * FROM `brackets` WHERE `id` = '$id'"; //select entry
	$picks = mysql_query($query,$db);
	$picks = mysql_fetch_array($picks);
}

if( $id!=0 ) {
	$tb = $picks['tiebreaker'];
}
else {
	$tb = $meta['tiebreaker'];
}

?>
	<div id="main">
		<div class="full">
			<?php if($id == 0) { ?>
			<h2>The Master Bracket</h2>
			<?php } else { ?>
			<h2><?php echo $picks['name']?>&rsquo;s Bracket</h2>
			<?php } ?>
			<h3>&nbsp;</h3>
			<form method="post" name="bracket" class="bracket" id="bracket" action="update.php?id=<?php echo $id?>">
				<p class="highlight"><em><strong>Please note:</strong></em> A game is not selected unless it is HIGHLIGHTED. Every time you submit this form, the master bracket will be overwritten.</p>
				<table width="700" border="1">
					<tr>
						<td colspan="5"><h1><?php echo $meta['region1']?></h1></td>
					</tr>
					<tr>
						<td>1. <?php echo $teams['1']?></td>
						<td rowspan="2">
							<select name="1" size="2" class="forms" id="1" <?php echo $iphoneTriggerEvent ?>="update('1','33',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['1']?>" <?php echo ($teams['1']==$picks['1'] && $picks['1']!=NULL ? "selected" : "")?>><?php echo $teams['1']?></option>
								<option value="<?php echo $teams['2']?>" <?php echo ($teams['2']==$picks['1'] && $picks['1']!=NULL ? "selected" : "")?>><?php echo $teams['2']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="33" size="2" class="forms" id="33" <?php echo $iphoneTriggerEvent ?>="update('33','49',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['1']?>" <?php echo ($picks['1']==$picks['33'] && $picks['33']!=NULL ? "selected" : "")?>><?php echo $picks['1']?></option>
								<option value="<?php echo $picks['2']?>" <?php echo ($picks['2']==$picks['33'] && $picks['33']!=NULL ? "selected" : "")?>><?php echo $picks['2']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="49" size="2" class="forms" id="49" <?php echo $iphoneTriggerEvent ?>="update('49','57',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['33']?>" <?php echo ($picks['33']==$picks['49'] && $picks['49']!=NULL ? "selected" : "")?>><?php echo $picks['33']?></option>
								<option value="<?php echo $picks['34']?>" <?php echo ($picks['34']==$picks['49'] && $picks['49']!=NULL ? "selected" : "")?>><?php echo $picks['34']?></option>
							</select>
						</td>
						<td rowspan="16">
							<select name="57" size="2" class="forms" id="57" <?php echo $iphoneTriggerEvent ?>="update('57','61',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['49']?>" <?php echo ($picks['49']==$picks['57'] && $picks['57']!=NULL ? "selected" : "")?>><?php echo $picks['49']?></option>
								<option value="<?php echo $picks['50']?>" <?php echo ($picks['50']==$picks['57'] && $picks['57']!=NULL ? "selected" : "")?>><?php echo $picks['50']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['2']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['3']?></td>
						<td rowspan="2">
							<select name="2" size="2" class="forms" id="2" <?php echo $iphoneTriggerEvent ?>="update('2','33',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['3']?>" <?php echo ($teams['3']==$picks['2'] && $picks['2']!=NULL ? "selected" : "")?>><?php echo $teams['3']?></option>
								<option value="<?php echo $teams['4']?>" <?php echo ($teams['4']==$picks['2'] && $picks['2']!=NULL ? "selected" : "")?>><?php echo $teams['4']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['4']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['5']?></td>
						<td rowspan="2">
							<select name="3" size="2" class="forms" id="3" <?php echo $iphoneTriggerEvent ?>="update('3','34',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['5']?>" <?php echo ($teams['5']==$picks['3'] && $picks['3']!=NULL ? "selected" : "")?>><?php echo $teams['5']?></option>
								<option value="<?php echo $teams['6']?>" <?php echo ($teams['6']==$picks['3'] && $picks['3']!=NULL ? "selected" : "")?>><?php echo $teams['6']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="34" size="2" class="forms" id="34" <?php echo $iphoneTriggerEvent ?>="update('34','49',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['3']?>" <?php echo ($picks['3']==$picks['34'] && $picks['34']!=NULL ? "selected" : "")?>><?php echo $picks['3']?></option>
								<option value="<?php echo $picks['4']?>" <?php echo ($picks['4']==$picks['34'] && $picks['34']!=NULL ? "selected" : "")?>><?php echo $picks['4']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['6']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['7']?></td>
						<td rowspan="2">
							<select name="4" size="2" class="forms" id="4" <?php echo $iphoneTriggerEvent ?>="update('4','34',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['7']?>" <?php echo ($teams['7']==$picks['4'] && $picks['4']!=NULL ? "selected" : "")?>><?php echo $teams['7']?></option>
								<option value="<?php echo $teams['8']?>" <?php echo ($teams['8']==$picks['4'] && $picks['4']!=NULL ? "selected" : "")?>><?php echo $teams['8']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['8']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['9']?></td>
						<td rowspan="2">
							<select name="5" size="2" class="forms" id="5" <?php echo $iphoneTriggerEvent ?>="update('5','35',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['9']?>" <?php echo ($teams['9']==$picks['5'] && $picks['5']!=NULL ? "selected" : "")?>><?php echo $teams['9']?></option>
								<option value="<?php echo $teams['10']?>" <?php echo ($teams['10']==$picks['5'] && $picks['5']!=NULL ? "selected" : "")?>><?php echo $teams['10']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="35" size="2" class="forms" id="35" <?php echo $iphoneTriggerEvent ?>="update('35','50',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['5']?>" <?php echo ($picks['5']==$picks['35'] && $picks['35']!=NULL ? "selected" : "")?>><?php echo $picks['5']?></option>
								<option value="<?php echo $picks['6']?>" <?php echo ($picks['6']==$picks['35'] && $picks['35']!=NULL ? "selected" : "")?>><?php echo $picks['6']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="50" size="2" class="forms" id="50" <?php echo $iphoneTriggerEvent ?>="update('50','57',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['35']?>" <?php echo ($picks['35']==$picks['50'] && $picks['50']!=NULL ? "selected" : "")?>><?php echo $picks['35']?></option>
								<option value="<?php echo $picks['36']?>" <?php echo ($picks['36']==$picks['50'] && $picks['50']!=NULL ? "selected" : "")?>><?php echo $picks['36']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['10']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['11']?></td>
						<td rowspan="2">
							<select name="6" size="2" class="forms" id="6" <?php echo $iphoneTriggerEvent ?>="update('6','35',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['11']?>" <?php echo ($teams['11']==$picks['6'] && $picks['6']!=NULL ? "selected" : "")?>><?php echo $teams['11']?></option>
								<option value="<?php echo $teams['12']?>" <?php echo ($teams['12']==$picks['6'] && $picks['6']!=NULL ? "selected" : "")?>><?php echo $teams['12']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['12']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['13']?></td>
						<td rowspan="2">
							<select name="7" size="2" class="forms" id="7" <?php echo $iphoneTriggerEvent ?>="update('7','36',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['13']?>" <?php echo ($teams['13']==$picks['7'] && $picks['7']!=NULL ? "selected" : "")?>><?php echo $teams['13']?></option>
								<option value="<?php echo $teams['14']?>" <?php echo ($teams['14']==$picks['7'] && $picks['7']!=NULL ? "selected" : "")?>><?php echo $teams['14']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="36" size="2" class="forms" id="36" <?php echo $iphoneTriggerEvent ?>="update('36','50',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['7']?>" <?php echo ($picks['7']==$picks['36'] && $picks['36']!=NULL ? "selected" : "")?>><?php echo $picks['7']?></option>
								<option value="<?php echo $picks['8']?>" <?php echo ($picks['8']==$picks['36'] && $picks['36']!=NULL ? "selected" : "")?>><?php echo $picks['8']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['14']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['15']?></td>
						<td rowspan="2">
							<select name="8" size="2" class="forms" id="8" <?php echo $iphoneTriggerEvent ?>="update('8','36',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['15']?>" <?php echo ($teams['15']==$picks['8'] && $picks['8']!=NULL ? "selected" : "")?>><?php echo $teams['15']?></option>
								<option value="<?php echo $teams['16']?>" <?php echo ($teams['16']==$picks['8'] && $picks['8']!=NULL ? "selected" : "")?>><?php echo $teams['16']?></option>
							</select>
						</td>
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
						<td rowspan="2">
							<select name="9" class="forms" size="2" id="9" <?php echo $iphoneTriggerEvent ?>="update('9','37',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['17']?>" <?php echo ($teams['17']==$picks['9'] && $picks['9']!=NULL ? "selected" : "")?>><?php echo $teams['17']?></option>
								<option value="<?php echo $teams['18']?>" <?php echo ($teams['18']==$picks['9'] && $picks['9']!=NULL ? "selected" : "")?>><?php echo $teams['18']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="37" class="forms" size="2" id="37" <?php echo $iphoneTriggerEvent ?>="update('37','51',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['9']?>" <?php echo ($picks['9']==$picks['37'] && $picks['37']!=NULL ? "selected" : "")?>><?php echo $picks['9']?></option>
								<option value="<?php echo $picks['10']?>" <?php echo ($picks['10']==$picks['37'] && $picks['37']!=NULL ? "selected" : "")?>><?php echo $picks['10']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="51" class="forms" size="2" id="51" <?php echo $iphoneTriggerEvent ?>="update('51','58',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['37']?>" <?php echo ($picks['37']==$picks['51'] && $picks['51']!=NULL ? "selected" : "")?>><?php echo $picks['37']?></option>
								<option value="<?php echo $picks['38']?>" <?php echo ($picks['38']==$picks['51'] && $picks['51']!=NULL ? "selected" : "")?>><?php echo $picks['38']?></option>
							</select>
						</td>
						<td rowspan="16">
							<select name="58" class="forms" size="2" id="58" <?php echo $iphoneTriggerEvent ?>="update('58','61',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['51']?>" <?php echo ($picks['51']==$picks['58'] && $picks['58']!=NULL ? "selected" : "")?>><?php echo $picks['51']?></option>
								<option value="<?php echo $picks['52']?>" <?php echo ($picks['52']==$picks['58'] && $picks['58']!=NULL ? "selected" : "")?>><?php echo $picks['52']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['18']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['19']?></td>
						<td rowspan="2">
							<select name="10" class="forms" size="2" id="10" <?php echo $iphoneTriggerEvent ?>="update('10','37',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['19']?>" <?php echo ($teams['19']==$picks['10'] && $picks['10']!=NULL ? "selected" : "")?>><?php echo $teams['19']?></option>
								<option value="<?php echo $teams['20']?>" <?php echo ($teams['20']==$picks['10'] && $picks['10']!=NULL ? "selected" : "")?>><?php echo $teams['20']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['20']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['21']?></td>
						<td rowspan="2">
							<select name="11" class="forms" size="2" id="11" <?php echo $iphoneTriggerEvent ?>="update('11','38',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['21']?>" <?php echo ($teams['21']==$picks['11'] && $picks['11']!=NULL ? "selected" : "")?>><?php echo $teams['21']?></option>
								<option value="<?php echo $teams['22']?>" <?php echo ($teams['22']==$picks['11'] && $picks['11']!=NULL ? "selected" : "")?>><?php echo $teams['22']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="38" class="forms" size="2" id="38" <?php echo $iphoneTriggerEvent ?>="update('38','51',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['11']?>" <?php echo ($picks['11']==$picks['38'] && $picks['38']!=NULL ? "selected" : "")?>><?php echo $picks['11']?></option>
								<option value="<?php echo $picks['12']?>" <?php echo ($picks['12']==$picks['38'] && $picks['38']!=NULL ? "selected" : "")?>><?php echo $picks['12']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['22']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['23']?></td>
						<td rowspan="2">
							<select name="12" class="forms" size="2" id="12" <?php echo $iphoneTriggerEvent ?>="update('12','38',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['23']?>" <?php echo ($teams['23']==$picks['12'] && $picks['12']!=NULL ? "selected" : "")?>><?php echo $teams['23']?></option>
								<option value="<?php echo $teams['24']?>" <?php echo ($teams['24']==$picks['12'] && $picks['12']!=NULL ? "selected" : "")?>><?php echo $teams['24']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['24']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['25']?></td>
						<td rowspan="2">
							<select name="13" class="forms"  size="2"id="13" <?php echo $iphoneTriggerEvent ?>="update('13','39',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['25']?>" <?php echo ($teams['25']==$picks['13'] && $picks['13']!=NULL ? "selected" : "")?>><?php echo $teams['25']?></option>
								<option value="<?php echo $teams['26']?>" <?php echo ($teams['26']==$picks['13'] && $picks['13']!=NULL ? "selected" : "")?>><?php echo $teams['26']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="39" class="forms"  size="2"id="39" <?php echo $iphoneTriggerEvent ?>="update('39','52',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['13']?>" <?php echo ($picks['13']==$picks['39'] && $picks['39']!=NULL ? "selected" : "")?>><?php echo $picks['13']?></option>
								<option value="<?php echo $picks['14']?>" <?php echo ($picks['14']==$picks['39'] && $picks['39']!=NULL ? "selected" : "")?>><?php echo $picks['14']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="52" class="forms"  size="2" id="52" <?php echo $iphoneTriggerEvent ?>="update('52','58',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['39']?>" <?php echo ($picks['39']==$picks['52'] && $picks['52']!=NULL ? "selected" : "")?>><?php echo $picks['39']?></option>
								<option value="<?php echo $picks['40']?>" <?php echo ($picks['40']==$picks['52'] && $picks['52']!=NULL ? "selected" : "")?>><?php echo $picks['40']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['26']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['27']?></td>
						<td rowspan="2">
							<select name="14" size="2" class="forms" id="14" <?php echo $iphoneTriggerEvent ?>="update('14','39',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['27']?>" <?php echo ($teams['27']==$picks['14'] && $picks['14']!=NULL ? "selected" : "")?>><?php echo $teams['27']?></option>
								<option value="<?php echo $teams['28']?>" <?php echo ($teams['28']==$picks['14'] && $picks['14']!=NULL ? "selected" : "")?>><?php echo $teams['28']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['28']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['29']?></td>
						<td rowspan="2">
							<select name="15" class="forms" size="2" id="15" <?php echo $iphoneTriggerEvent ?>="update('15','40',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['29']?>" <?php echo ($teams['29']==$picks['15'] && $picks['15']!=NULL ? "selected" : "")?>><?php echo $teams['29']?></option>
								<option value="<?php echo $teams['30']?>" <?php echo ($teams['30']==$picks['15'] && $picks['15']!=NULL ? "selected" : "")?>><?php echo $teams['30']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="40" class="forms" size="2" id="40" <?php echo $iphoneTriggerEvent ?>="update('40','52',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['15']?>" <?php echo ($picks['15']==$picks['40'] && $picks['40']!=NULL ? "selected" : "")?>><?php echo $picks['15']?></option>
								<option value="<?php echo $picks['16']?>" <?php echo ($picks['16']==$picks['40'] && $picks['40']!=NULL ? "selected" : "")?>><?php echo $picks['16']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['30']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['31']?></td>
						<td rowspan="2">
							<select name="16" class="forms" size="2" id="16" <?php echo $iphoneTriggerEvent ?>="update('16','40',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['31']?>" <?php echo ($teams['31']==$picks['16'] && $picks['16']!=NULL ? "selected" : "")?>><?php echo $teams['31']?></option>
								<option value="<?php echo $teams['32']?>" <?php echo ($teams['32']==$picks['16'] && $picks['16']!=NULL ? "selected" : "")?>><?php echo $teams['32']?></option>
							</select>
						</td>
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
						<td rowspan="2">
							<select name="17" class="forms" size="2" id="17" <?php echo $iphoneTriggerEvent ?>="update('17','41',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['33']?>" <?php echo ($teams['33']==$picks['17'] && $picks['17']!=NULL ? "selected" : "")?>><?php echo $teams['33']?></option>
								<option value="<?php echo $teams['34']?>" <?php echo ($teams['34']==$picks['17'] && $picks['17']!=NULL ? "selected" : "")?>><?php echo $teams['34']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="41" class="forms" size="2" id="41" <?php echo $iphoneTriggerEvent ?>="update('41','53',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['17']?>" <?php echo ($picks['17']==$picks['41'] && $picks['41']!=NULL ? "selected" : "")?>><?php echo $picks['17']?></option>
								<option value="<?php echo $picks['18']?>" <?php echo ($picks['18']==$picks['41'] && $picks['41']!=NULL ? "selected" : "")?>><?php echo $picks['18']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="53" class="forms" size="2" id="53" <?php echo $iphoneTriggerEvent ?>="update('53','59',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['41']?>" <?php echo ($picks['41']==$picks['53'] && $picks['53']!=NULL ? "selected" : "")?>><?php echo $picks['41']?></option>
								<option value="<?php echo $picks['42']?>" <?php echo ($picks['42']==$picks['53'] && $picks['53']!=NULL ? "selected" : "")?>><?php echo $picks['42']?></option>
							</select>
						</td>
						<td rowspan="16">
							<select name="59" class="forms" size="2" id="59" <?php echo $iphoneTriggerEvent ?>="update('59','62',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['53']?>" <?php echo ($picks['53']==$picks['59'] && $picks['59']!=NULL ? "selected" : "")?>><?php echo $picks['53']?></option>
								<option value="<?php echo $picks['54']?>" <?php echo ($picks['54']==$picks['59'] && $picks['59']!=NULL ? "selected" : "")?>><?php echo $picks['54']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['34']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['35']?></td>
						<td rowspan="2">
							<select name="18" size="2" class="forms" id="18" <?php echo $iphoneTriggerEvent ?>="update('18','41',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['35']?>" <?php echo ($teams['35']==$picks['18'] && $picks['18']!=NULL ? "selected" : "")?>><?php echo $teams['35']?></option>
								<option value="<?php echo $teams['36']?>" <?php echo ($teams['36']==$picks['18'] && $picks['18']!=NULL ? "selected" : "")?>><?php echo $teams['36']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['36']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['37']?></td>
						<td rowspan="2">
							<select name="19" size="2" class="forms" id="19" <?php echo $iphoneTriggerEvent ?>="update('19','42',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['37']?>" <?php echo ($teams['37']==$picks['19'] && $picks['19']!=NULL ? "selected" : "")?>><?php echo $teams['37']?></option>
								<option value="<?php echo $teams['38']?>" <?php echo ($teams['38']==$picks['19'] && $picks['19']!=NULL ? "selected" : "")?>><?php echo $teams['38']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="42" size="2" class="forms" id="42" <?php echo $iphoneTriggerEvent ?>="update('42','53',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['19']?>" <?php echo ($picks['19']==$picks['42'] && $picks['42']!=NULL ? "selected" : "")?>><?php echo $picks['19']?></option>
								<option value="<?php echo $picks['20']?>" <?php echo ($picks['20']==$picks['42'] && $picks['42']!=NULL ? "selected" : "")?>><?php echo $picks['20']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['38']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['39']?></td>
						<td rowspan="2">
							<select name="20" size="2" class="forms" id="20" <?php echo $iphoneTriggerEvent ?>="update('20','42',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['39']?>" <?php echo ($teams['39']==$picks['20'] && $picks['20']!=NULL ? "selected" : "")?>><?php echo $teams['39']?></option>
								<option value="<?php echo $teams['40']?>" <?php echo ($teams['40']==$picks['20'] && $picks['20']!=NULL ? "selected" : "")?>><?php echo $teams['40']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['40']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['41']?></td>
						<td rowspan="2">
							<select name="21" size="2" class="forms" id="21" <?php echo $iphoneTriggerEvent ?>="update('21','43',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['41']?>" <?php echo ($teams['41']==$picks['21'] && $picks['21']!=NULL ? "selected" : "")?>><?php echo $teams['41']?></option>
								<option value="<?php echo $teams['42']?>" <?php echo ($teams['42']==$picks['21'] && $picks['21']!=NULL ? "selected" : "")?>><?php echo $teams['42']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="43" class="forms" size="2" id="43" <?php echo $iphoneTriggerEvent ?>="update('43','54',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['21']?>" <?php echo ($picks['21']==$picks['43'] && $picks['43']!=NULL ? "selected" : "")?>><?php echo $picks['21']?></option>
								<option value="<?php echo $picks['22']?>" <?php echo ($picks['22']==$picks['43'] && $picks['43']!=NULL ? "selected" : "")?>><?php echo $picks['22']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="54" class="forms" size="2" id="54" <?php echo $iphoneTriggerEvent ?>="update('54','59',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['43']?>" <?php echo ($picks['43']==$picks['54'] && $picks['54']!=NULL ? "selected" : "")?>><?php echo $picks['43']?></option>
								<option value="<?php echo $picks['44']?>" <?php echo ($picks['44']==$picks['54'] && $picks['54']!=NULL ? "selected" : "")?>><?php echo $picks['44']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['42']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['43']?></td>
						<td rowspan="2">
							<select name="22" class="forms" size="2" id="22" <?php echo $iphoneTriggerEvent ?>="update('22','43',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['43']?>" <?php echo ($teams['43']==$picks['22'] && $picks['22']!=NULL ? "selected" : "")?>><?php echo $teams['43']?></option>
								<option value="<?php echo $teams['44']?>" <?php echo ($teams['44']==$picks['22'] && $picks['22']!=NULL ? "selected" : "")?>><?php echo $teams['44']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['44']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['45']?></td>
						<td rowspan="2">
							<select name="23" class="forms" size="2" id="23" <?php echo $iphoneTriggerEvent ?>="update('23','44',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['45']?>" <?php echo ($teams['45']==$picks['23'] && $picks['23']!=NULL ? "selected" : "")?>><?php echo $teams['45']?></option>
								<option value="<?php echo $teams['46']?>" <?php echo ($teams['46']==$picks['23'] && $picks['23']!=NULL ? "selected" : "")?>><?php echo $teams['46']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="44" class="forms" size="2" id="44" <?php echo $iphoneTriggerEvent ?>="update('44','54',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['23']?>" <?php echo ($picks['23']==$picks['44'] && $picks['44']!=NULL ? "selected" : "")?>><?php echo $picks['23']?></option>
								<option value="<?php echo $picks['24']?>" <?php echo ($picks['24']==$picks['44'] && $picks['44']!=NULL ? "selected" : "")?>><?php echo $picks['24']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['46']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['47']?></td>
						<td rowspan="2">
							<select name="24" class="forms" size="2" id="24" <?php echo $iphoneTriggerEvent ?>="update('24','44',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['47']?>" <?php echo ($teams['47']==$picks['24'] && $picks['24']!=NULL ? "selected" : "")?>><?php echo $teams['47']?></option>
								<option value="<?php echo $teams['48']?>" <?php echo ($teams['48']==$picks['24'] && $picks['24']!=NULL ? "selected" : "")?>><?php echo $teams['48']?></option>
							</select>
						</td>
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
						<td rowspan="2">
							<select name="25" class="forms" size="2" id="25" <?php echo $iphoneTriggerEvent ?>="update('25','45',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['49']?>" <?php echo ($teams['49']==$picks['25'] && $picks['25']!=NULL ? "selected" : "")?>><?php echo $teams['49']?></option>
								<option value="<?php echo $teams['50']?>" <?php echo ($teams['50']==$picks['25'] && $picks['25']!=NULL ? "selected" : "")?>><?php echo $teams['50']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="45" class="forms" size="2" id="45" <?php echo $iphoneTriggerEvent ?>="update('45','55',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['25']?>" <?php echo ($picks['25']==$picks['45'] && $picks['45']!=NULL ? "selected" : "")?>><?php echo $picks['25']?></option>
								<option value="<?php echo $picks['26']?>" <?php echo ($picks['26']==$picks['45'] && $picks['45']!=NULL ? "selected" : "")?>><?php echo $picks['26']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="55" class="forms" size="2" id="55" <?php echo $iphoneTriggerEvent ?>="update('55','60',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['45']?>" <?php echo ($picks['45']==$picks['55'] && $picks['55']!=NULL ? "selected" : "")?>><?php echo $picks['45']?></option>
								<option value="<?php echo $picks['46']?>" <?php echo ($picks['46']==$picks['55'] && $picks['55']!=NULL ? "selected" : "")?>><?php echo $picks['46']?></option>
							</select>
						</td>
						<td rowspan="16">
							<select name="60" class="forms" size="2" id="60" <?php echo $iphoneTriggerEvent ?>="update('60','62',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['55']?>" <?php echo ($picks['55']==$picks['60'] && $picks['60']!=NULL ? "selected" : "")?>><?php echo $picks['55']?></option>
								<option value="<?php echo $picks['56']?>" <?php echo ($picks['56']==$picks['60'] && $picks['60']!=NULL ? "selected" : "")?>><?php echo $picks['56']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>16. <?php echo $teams['50']?></td>
					</tr>
					<tr>
						<td>8. <?php echo $teams['51']?></td>
						<td rowspan="2">
							<select name="26" class="forms" size="2" id="26" <?php echo $iphoneTriggerEvent ?>="update('26','45',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['51']?>" <?php echo ($teams['51']==$picks['26'] && $picks['26']!=NULL ? "selected" : "")?>><?php echo $teams['51']?></option>
								<option value="<?php echo $teams['52']?>" <?php echo ($teams['52']==$picks['26'] && $picks['26']!=NULL ? "selected" : "")?>><?php echo $teams['52']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>9. <?php echo $teams['52']?></td>
					</tr>
					<tr>
						<td>5. <?php echo $teams['53']?></td>
						<td rowspan="2">
							<select name="27" class="forms" size="2" id="27" <?php echo $iphoneTriggerEvent ?>="update('27','46',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['53']?>" <?php echo ($teams['53']==$picks['27'] && $picks['27']!=NULL ? "selected" : "")?>><?php echo $teams['53']?></option>
								<option value="<?php echo $teams['54']?>" <?php echo ($teams['54']==$picks['27'] && $picks['27']!=NULL ? "selected" : "")?>><?php echo $teams['54']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="46" class="forms" size="2" id="46" <?php echo $iphoneTriggerEvent ?>="update('46','55',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['27']?>" <?php echo ($picks['27']==$picks['46'] && $picks['46']!=NULL ? "selected" : "")?>><?php echo $picks['27']?></option>
								<option value="<?php echo $picks['28']?>" <?php echo ($picks['28']==$picks['46'] && $picks['46']!=NULL ? "selected" : "")?>><?php echo $picks['28']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>12. <?php echo $teams['54']?></td>
					</tr>
					<tr>
						<td>4. <?php echo $teams['55']?></td>
						<td rowspan="2">
							<select name="28" class="forms" size="2" id="28" <?php echo $iphoneTriggerEvent ?>="update('28','46',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['55']?>" <?php echo ($teams['55']==$picks['28'] && $picks['28']!=NULL ? "selected" : "")?>><?php echo $teams['55']?></option>
								<option value="<?php echo $teams['56']?>" <?php echo ($teams['56']==$picks['28'] && $picks['28']!=NULL ? "selected" : "")?>><?php echo $teams['56']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>13. <?php echo $teams['56']?></td>
					</tr>
					<tr>
						<td>6. <?php echo $teams['57']?></td>
						<td rowspan="2">
							<select name="29" class="forms" size="2" id="29" <?php echo $iphoneTriggerEvent ?>="update('29','47',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['57']?>" <?php echo ($teams['57']==$picks['29'] && $picks['29']!=NULL ? "selected" : "")?>><?php echo $teams['57']?></option>
								<option value="<?php echo $teams['58']?>" <?php echo ($teams['58']==$picks['29'] && $picks['29']!=NULL ? "selected" : "")?>><?php echo $teams['58']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="47" class="forms" size="2" id="47" <?php echo $iphoneTriggerEvent ?>="update('47','56',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['29']?>" <?php echo ($picks['29']==$picks['47'] && $picks['47']!=NULL ? "selected" : "")?>><?php echo $picks['29']?></option>
								<option value="<?php echo $picks['30']?>" <?php echo ($picks['30']==$picks['47'] && $picks['47']!=NULL ? "selected" : "")?>><?php echo $picks['30']?></option>
							</select>
						</td>
						<td rowspan="8">
							<select name="56" class="forms" size="2" id="56" <?php echo $iphoneTriggerEvent ?>="update('56','60',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['47']?>" <?php echo ($picks['47']==$picks['56'] && $picks['56']!=NULL ? "selected" : "")?>><?php echo $picks['47']?></option>
								<option value="<?php echo $picks['48']?>" <?php echo ($picks['48']==$picks['56'] && $picks['56']!=NULL ? "selected" : "")?>><?php echo $picks['48']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>11. <?php echo $teams['58']?></td>
					</tr>
					<tr>
						<td>3. <?php echo $teams['59']?></td>
						<td rowspan="2">
							<select name="30" class="forms" size="2" id="30" <?php echo $iphoneTriggerEvent ?>="update('30','47',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['59']?>" <?php echo ($teams['59']==$picks['30'] && $picks['30']!=NULL ? "selected" : "")?>><?php echo $teams['59']?></option>
								<option value="<?php echo $teams['60']?>" <?php echo ($teams['60']==$picks['30'] && $picks['30']!=NULL ? "selected" : "")?>><?php echo $teams['60']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>14. <?php echo $teams['60']?></td>
					</tr>
					<tr>
						<td>7. <?php echo $teams['61']?></td>
						<td rowspan="2">
							<select name="31" class="forms" size="2" id="31" <?php echo $iphoneTriggerEvent ?>="update('31','48',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['61']?>" <?php echo ($teams['61']==$picks['31'] && $picks['31']!=NULL ? "selected" : "")?>><?php echo $teams['61']?></option>
								<option value="<?php echo $teams['62']?>" <?php echo ($teams['62']==$picks['31'] && $picks['31']!=NULL ? "selected" : "")?>><?php echo $teams['62']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="48" class="forms" size="2" id="48" <?php echo $iphoneTriggerEvent ?>="update('48','56',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['31']?>" <?php echo ($picks['31']==$picks['48'] && $picks['48']!=NULL ? "selected" : "")?>><?php echo $picks['31']?></option>
								<option value="<?php echo $picks['32']?>" <?php echo ($picks['32']==$picks['48'] && $picks['48']!=NULL ? "selected" : "")?>><?php echo $picks['32']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>10. <?php echo $teams['62']?></td>
					</tr>
					<tr>
						<td>2. <?php echo $teams['63']?></td>
						<td rowspan="2">
							<select name="32" class="forms" size="2" id="32" <?php echo $iphoneTriggerEvent ?>="update('32','48',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $teams['63']?>" <?php echo ($teams['63']==$picks['32'] && $picks['32']!=NULL ? "selected" : "")?>><?php echo $teams['63']?></option>
								<option value="<?php echo $teams['64']?>" <?php echo ($teams['64']==$picks['32'] && $picks['32']!=NULL ? "selected" : "")?>><?php echo $teams['64']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>15. <?php echo $teams['64']?></td>
					</tr>
				</table>
				<br />
				<table width="700" border="1">
					<tr>
						<td colspan="3"><h1 align="center">FINAL FOUR</h1></td>
					</tr>
					<tr>
						<td><?php echo $meta['region1']?> Champion</td>
						<td rowspan="2">
							<select name="61" size="2" class="forms" id="61" <?php echo $iphoneTriggerEvent ?>="update('61','63',0);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['57']?>" <?php echo ($picks['57']==$picks['61'] && $picks['61']!=NULL ? "selected" : "")?>><?php echo $picks['57']?></option>
								<option value="<?php echo $picks['58']?>" <?php echo ($picks['58']==$picks['61'] && $picks['61']!=NULL ? "selected" : "")?>><?php echo $picks['58']?></option>
							</select>
						</td>
						<td rowspan="4">
							<select name="63" size="2" class="forms" id="63">
								<option value="<?php echo $picks['61']?>" <?php echo ($picks['61']==$picks['63'] && $picks['63']!=NULL ? "selected" : "")?>><?php echo $picks['61']?></option>
								<option value="<?php echo $picks['62']?>" <?php echo ($picks['62']==$picks['63'] && $picks['63']!=NULL ? "selected" : "")?>><?php echo $picks['62']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $meta['region2']?> Champion</td>
					</tr>
					<tr>
						<td><?php echo $meta['region3']?> Champion</td>
						<td rowspan="2">
							<select name="62" size="2" class="forms" id="62" <?php echo $iphoneTriggerEvent ?>="update('62','63',1);">
								<?php echo $iphoneOption ?>								
								<option value="<?php echo $picks['59']?>" <?php echo ($picks['59']==$picks['62'] && $picks['62']!=NULL ? "selected" : "")?>><?php echo $picks['59']?></option>
								<option value="<?php echo $picks['60']?>" <?php echo ($picks['60']==$picks['62'] && $picks['62']!=NULL ? "selected" : "")?>><?php echo $picks['60']?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $meta['region4']?> Champion</td>
					</tr>
				</table>
					<div align="center">
					<p>Tiebreaker <input type="text" name="tiebreaker" value="<?php echo $picks['tiebreaker']?>" size="10" maxlength="3" /></p>
					<p><input type="submit" name="Submit" value="Submit" /></p>
					</div>
				</p>
			</form>
		</div>
	</div>
	<div id="footer"> </div>
</div>
</body>
</html>
