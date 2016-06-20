<?php
	include_once("resource/sqldb.php");
	include_once('resource/referrer.php');
	include("projectspecific/grouptools.php");
	
	
	
	
	$title = "Gruppenzuordnung";
	include_once("projectspecific/template_head.php");
	setReferrer("groups.php");
?>

<?php
	//TODO Optimize for mobile use
	$x = 3;
	$y = MAX(5,(getMaxGroup()+2)/3);
	createGroupTable($x,$y)
?>

<?php $ArcherSymbolsLegend=1; include_once("projectspecific/template_foot.php");?>