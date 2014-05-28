<?php
include 'functions.php';
validatecookie();
include("database.php");


for($i = 1; $i <= 64; $i++ )
{
	$_POST[$i] = str_replace("\'","",$_POST[$i]);
}

print_r($_POST);

$update = "SELECT * FROM `master` WHERE id=1";
$update = mysql_query($update,$db);
if(!(@mysql_fetch_array($update))) {//if the row has not yet been filled, insert it
	$query = "INSERT INTO `master` (`id`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`,`13`,`14`,`15`,`16`,`17`,`18`,`19`,`20`,`21`,`22`,`23`,`24`,`25`,`26`,`27`,`28`,`29`,`30`,`31`,`32`,`33`,`34`,`35`,`36`,`37`,`38`,`39`,`40`,`41`,`42`,`43`,`44`,`45`,`46`,`47`,`48`,`49`,`50`,`51`,`52`,`53`,`54`,`55`,`56`,`57`,`58`,`59`,`60`,`61`,`62`,`63`,`64`) VALUES (1,'$_POST[1]','$_POST[2]','$_POST[3]','$_POST[4]','$_POST[5]','$_POST[6]','$_POST[7]','$_POST[8]','$_POST[9]','$_POST[10]','$_POST[11]','$_POST[12]','$_POST[13]','$_POST[14]','$_POST[15]','$_POST[16]','$_POST[17]','$_POST[18]','$_POST[19]','$_POST[20]','$_POST[21]','$_POST[22]','$_POST[23]','$_POST[24]','$_POST[25]','$_POST[26]','$_POST[27]','$_POST[28]','$_POST[29]','$_POST[30]','$_POST[31]','$_POST[32]','$_POST[33]','$_POST[34]','$_POST[35]','$_POST[36]','$_POST[37]','$_POST[38]','$_POST[39]','$_POST[40]','$_POST[41]','$_POST[42]','$_POST[43]','$_POST[44]','$_POST[45]','$_POST[46]','$_POST[47]','$_POST[48]','$_POST[49]','$_POST[50]','$_POST[51]','$_POST[52]','$_POST[53]','$_POST[54]','$_POST[55]','$_POST[56]','$_POST[57]','$_POST[58]','$_POST[59]','$_POST[60]','$_POST[61]','$_POST[62]','$_POST[63]','$_POST[64]')";

	mysql_query($query) or die(mysql_error()); //inserts entry into the database
	
}
else { //if the row has been filled, update it
	$query = "UPDATE `master` SET `1`='$_POST[1]',`2`='$_POST[2]',`3`='$_POST[3]',`4`='$_POST[4]',`5`='$_POST[5]',`6`='$_POST[6]',`7`='$_POST[7]',`8`='$_POST[8]',`9`='$_POST[9]',`10`='$_POST[10]',`11`='$_POST[11]',`12`='$_POST[12]',`13`='$_POST[13]',`14`='$_POST[14]',`15`='$_POST[15]',`16`='$_POST[16]',`17`='$_POST[17]',`18`='$_POST[18]',`19`='$_POST[19]',`20`='$_POST[20]',`21`='$_POST[21]',`22`='$_POST[22]',`23`='$_POST[23]',`24`='$_POST[24]',`25`='$_POST[25]',`26`='$_POST[26]',`27`='$_POST[27]',`28`='$_POST[28]',`29`='$_POST[29]',`30`='$_POST[30]',`31`='$_POST[31]',`32`='$_POST[32]',`33`='$_POST[33]',`34`='$_POST[34]',`35`='$_POST[35]',`36`='$_POST[36]',`37`='$_POST[37]',`38`='$_POST[38]',`39`='$_POST[39]',`40`='$_POST[40]',`41`='$_POST[41]',`42`='$_POST[42]',`43`='$_POST[43]',`44`='$_POST[44]',`45`='$_POST[45]',`46`='$_POST[46]',`47`='$_POST[47]',`48`='$_POST[48]',`49`='$_POST[49]',`50`='$_POST[50]',`51`='$_POST[51]',`52`='$_POST[52]',`53`='$_POST[53]',`54`='$_POST[54]',`55`='$_POST[55]',`56`='$_POST[56]',`57`='$_POST[57]',`58`='$_POST[58]',`59`='$_POST[59]',`60`='$_POST[60]',`61`='$_POST[61]',`62`='$_POST[62]',`63`='$_POST[63]',`64`='$_POST[64]' WHERE `id`=1";

	mysql_query($query) or die(mysql_error()); //updates database

}
	header( 'Location: index.php' );
?>
