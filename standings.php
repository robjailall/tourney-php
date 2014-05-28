<?php
$type = $_GET['type'];

if($type == 'normal') {
	include("normal.php");
} else if ($type == 'best') {
	include("best.php");
 }else {
 	include("choose.php");
}
?>