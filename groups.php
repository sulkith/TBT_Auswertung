<?php
	include_once("resource/sqldb.php");
	include_once('resource/referrer.php');
	include("resource/grouptools.php");
	
	
	
	
	$title = "Gruppenzuordnung";
	include_once("projectspecific/template_head.php");
	setReferrer("groups.php");
?>

<?php
	createGroupTable(3,5)
?>

<?php include_once("projectspecific/template_foot.php");?>