<?php
include("admin/database.php");

$query = "SELECT * FROM `meta` WHERE id=1";
$meta = mysql_query($query,$db);
@$meta = mysql_fetch_array($meta);

header("Expires: ".gmdate("D, d M Y H:i:s")." GMT"); // Always expired
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");// always modified 
header("Cache-Control: no-cache, must-revalidate");// HTTP/1.1 
header("Pragma: nocache");// HTTP/1.0


function getCommentsMap($db)
{
	$commentCount =  "SELECT COUNT(*) count, bracket FROM `comments` WHERE UNIX_TIMESTAMP(`time`)>" . (time()-86400) . " GROUP BY `bracket`";
	$commentCountList = mysql_query($commentCount,$db) or die(mysql_error());
	$commentMap;
	
	while( $commentCount = mysql_fetch_array($commentCountList) )
	{
		$commentMap[$commentCount['bracket']] = $commentCount['count'];
	}
	
	return $commentMap;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>March Madness</title>
	<meta name="robots" content="noarchive" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Language" content="en-us" />
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE, must-revalidate">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="pragma" content="no-cache">
	<style type="text/css" media="screen">@import "images/style.css";</style>
	<link rel="shortcut icon" href="images/favicon.ico">
	<script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/emailall.js"></script>

<?php
//if this is the submit or what-if page, include the necessary javascript
if(strpos($_SERVER['PHP_SELF'],"submitSweet16.php") !== FALSE || strpos($_SERVER['PHP_SELF'],"submit.php") !== FALSE || strpos($_SERVER['PHP_SELF'],"whatif.php") !== FALSE) {
?>
<script type="text/javascript">
// The key to this array is the game number and the value is the parent node
parents = new Array(-1, 
	33, 33, 34, 34, 35, 35, 36, 36, 
	37, 37, 38, 38, 39, 39, 40, 40, 
	41, 41, 42, 42, 43, 43, 44, 44, 
	45, 45, 46, 46, 47, 47, 48, 48, 
	49, 49, 50, 50, 51, 51, 52, 52, 
	53, 53, 54, 54, 55, 55, 56, 56, 
	57, 57, 58, 58, 59, 59, 60, 60, 
	61, 61, 62, 62, 63, 63, -1 );


function update(childGameId,target, index) 
{
	var childSel = document.getElementById(childGameId);
	var parentSel = document.getElementById(target);
	if( childSel.options.length > 1 )
	{
		var deselectedChildVal = childSel.options[(childSel.selectedIndex + 1) % 2].value;
		deleteTeam( parentSel, deselectedChildVal );	
	}

	var selectedValue = childSel.options[childSel.selectedIndex].value;
	var selectedText = childSel.options[childSel.selectedIndex].text;
	parentSel.options[index] = new Option(selectedText,selectedValue);
}

function deleteTeam( rootNode, teamToDelete )
{	
	//alert( rootNode.id + " " + teamToDelete + " " + childGameNum + " " + parentGameNum);

	var childGameNum = parseInt( rootNode.id.substring(4) );	
	
	for( i =0; i < rootNode.options.length; i++ )
	{
		if( rootNode.options[i].value == teamToDelete )
		{
			rootNode.options[i] = new Option("","");
		}
	}
	
	
	var parentGameNum = parents[childGameNum];	

	if( parentGameNum != -1 )
	{
		var parentGameId = "game" + parentGameNum;
		var parentSel = document.getElementById( parentGameId );

		deleteTeam( parentSel, teamToDelete);
	}		
}

function resetBracket( startId )
{
	if( startId == null )
	{
		startId = 1;
	}
	var resetBracket = window.confirm('Are you sure that you want to reset this bracket?');
	if( resetBracket )
	{
		for( i = startId; i < parents.length -1; i++ )
		{
			var selectBox = document.getElementById( "game" + parents[i] );
			while (selectBox.options.length > 0) {
				selectBox.options[0] = null;
			}
		}
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<?php } ?>

</head>

<body>
	<div class="content">
		<div id="top">
			<div class="rightlinks"><a href="http://sourceforge.net/projects/tourney"><span class="info"><?php echo $mmm_info ?> | <?php echo $mmm_vers ?></span></a></div>
		</div>
		<div id="header">
			
			<div class="info">
				<h1><?php echo $meta['title']; ?></h1>
				<h2><?php echo $meta['subtitle']; ?></h2>
			</div>
		</div>
	
		<div id="subheader">
			<div id="menu">
			  	<ul>
					<li><a href="index.php">HOME</a></li>
					<?php if( $meta['sweet16Competition'] == true ) { ?>
						<li><a href="submitSweet16.php">CREATE BRACKET</a></li>
					<?php } else { ?>
					<li><a href="submit.php">CREATE BRACKET</a></li>
					<?php } ?>
					<li><a href="rules.php">RULES</a></li>
					<li><a href="choose.php">STANDINGS</a></li>
					<?php if($meta['cost'] != 0) { ?>
					<li><a href="paid.php">PAYMENT TRACKER</a></li>
					<?php } ?>
					<?php if($meta['mail'] != 0 ) { ?>
					<li><a href="contact.php">CONTACT</a></li>
					<?php } ?>
      			</ul>
			</div>
		</div>
