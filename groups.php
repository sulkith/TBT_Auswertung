<?php
	include_once("resource/sqldb.php");
	include_once('resource/referrer.php');
	include("projectspecific/grouptools.php");
	
	
	
	
	$title = "Gruppenzuordnung";
	include_once("projectspecific/template_head.php");
	setReferrer("groups.php");
?>

<?php
	createGroupTable(3,5)
?>

<?php $ArcherSymbolsLegend=1; include_once("projectspecific/template_foot.php");?>