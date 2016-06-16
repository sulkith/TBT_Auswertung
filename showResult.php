<?php
	include("resource/referrer.php");
	include("projectspecific/result.php");
	include("projectspecific/participation.php");
	
	#setReferrer("showResult.php");#TODO
	$info = "";
	if(!isset($_POST['action']) || $_POST['action'] != 'Ausblenden')
	{
		$unusedClasses = getUnusedResultSetElementListWithActiveArchersString();
		if($unusedClasses != "")
		{
			$info .= "<b>ACHTUNG in keiner Ergebnisliste enthaltene Kombinationen aus Bogen- und Sch&uuml;tzenklasse</b><ul>".
			$unusedClasses."</ul><br>";
		}

		$missingparticipations = getMissingParticipatorsToEnumerateSorted();
		if($unusedClasses != "")
		{
			$info .= "<b>ACHTUNG bisher keine Punktzahl erfasst</b><ul>".
			$missingparticipations."</ul><br>";
		}

		if($info != "")
		{
			$info .= "<br><form action=\"showResult.php\" method=\"post\"><input type=\"submit\" name=\"action\" value='Ausblenden' /></form>";
		}
	}
	$title = "Ergebnisliste"; #TODO
	$dialog = 1;
	include_once("projectspecific/template_head.php");

	$thead = "<table border=1 width=100%><thead><tr>
      <th>Platz</th>
      <th>StartNr</th>
      <th>Vorname</th>
	  <th>Nachname</th>
	  <th>Sch&uuml;tzenklasse</th>
	  <th>Bogenklasse</th>
	  <th>Verein</th>
	  <th>Punkte</th>
	  <th>Kills</th>
	  <th>Gruppe</th>
    </tr></thead>";
	$tfoot = "</table>";
	getCompleteResultSets($thead, $tfoot);
?>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>