<?php 
	include_once('resource/referrer.php');
	setReferrer("index.php");
	include_once('resource/error.php');
	$smalltoolbar = 1;
	$title = "TBT-Auswertung";
	include_once("projectspecific/template_head.php");
?>
	<div class="CaptionSmall">
		<h1>TBT Auswertung</h1>
	</div>
	<div class="BodySmall">
	<table><tr><td>
		<input type=button style='width:100%' value='Bogenklassen verwalten' onclick="window.location.href='ManageBowClasses.php'" /></td></tr><tr><td>
		<input type=button style='width:100%' value='Sch&uuml;tzenklassen verwalten' onclick="window.location.href='ManageArcherClasses.php'" /></td></tr><tr><td>
		<input type=button style='width:100%' value='Ergebnislisten verwalten' onclick="window.location.href='ManageResultSets.php'" /></td></tr><tr><td>
		</td></tr><tr><td>
		<input type=button style='width:100%' value='Teilnahme hinzuf&uuml;gen' onclick="window.location.href='AddParticipation.php'" /></td></tr><tr><td>
		<input type=button style='width:100%' value='Gruppenzuordnung' onclick="window.location.href='groups.php'" /></td></tr><tr><td>
		<input type=button style='width:100%' value='Ergebniserfassung' onclick="window.location.href='AlphabeticalParticipation.php'" /></td></tr><tr><td>
		</td></tr><tr><td>
		<input type=button style='width:100%' value='Ergebnislisten anzeigen' onclick="window.location.href='showResult.php'" /></td></tr><tr><td>
		<input type=button style='width:100%' value='Statistik anzeigen' onclick="window.location.href='statistics.php'" /></td></tr>
		</table>
	</div>
<?php include_once("projectspecific/template_foot.php");?>