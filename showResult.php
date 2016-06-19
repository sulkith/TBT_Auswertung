<?php
	include_once("resource/referrer.php");
	include_once("resource/sqldb.php");
	include_once("resource/error.php");
	include_once("formatter/ParticipationResultTable.php");
	include_once("formatter/ParticipationList.php");
	include_once("formatter/ResultSetElementList.php");
	include_once("projectspecific/result.php");
	include_once("projectspecific/participation.php");
	
	$tableFormatter = new ParticipationResultTableFormatter();
	if(!isset($_POST['action']) || $_POST['action'] != 'Ausblenden')
	{
		$unusedClasses = getUnusedResultSetElementListWithActiveArchers(new ResultSetElementListFormatter());
		if($unusedClasses != "")
		{
			$errhndl->setWarn("<b>ACHTUNG in keiner Ergebnisliste enthaltene Kombinationen aus Bogen- und Sch&uuml;tzenklasse, f&uuml;r die Teilnehmer gemeldet sind</b>".
			$unusedClasses."<a href=\"ManageResultSets.php\">Ergebnislisten verwalten</a><br>");
		}
		$missingparticipations = getMissingParticipators(new ParticipationListFormatter());
		if($unusedClasses != "")
		{
			$errhndl->setWarn("<b>ACHTUNG bisher keine Punktzahl erfasst</b>".
			$missingparticipations);
		}

		if($errhndl->hasWarn())
		{
			$errhndl->setWarn("<br><form action=\"showResult.php\" method=\"post\"><input type=\"submit\" name=\"action\" value='Ausblenden' /></form>");
		}
	}
	$title = "Ergebnisliste"; #TODO
	$dialog = 1;
	include_once("projectspecific/template_head.php");
	
	echo getCompleteResultSets($tableFormatter);
?>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>