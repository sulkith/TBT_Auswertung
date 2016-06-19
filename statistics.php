<?php
	include("resource/referrer.php");
	include_once("projectspecific/participation.php");
	
	setReferrer("statistics.php");#TODO
	$title = "Statistiken"; #TODO
	include_once("projectspecific/template_head.php");
	
?>
<meta http-equiv="refresh" content="10" >
<h1>Allgemeine Statistiken</h1>
<table>
<tr><td>Eingetragene Teilnehmer</td><td><?php echo getNumAllParticipators()?></td></tr>

<tr><td>Fertig erfasste Teilnehmer</td><td><?php echo getNumFinishedParticipators()?></td></tr>
<tr><td>Teilnehmer ohne Punkte</td><td><?php echo getNumParticipatorsNoPoints()?></td></tr>
<tr><td>nicht abgegebene Schießzettel</td><td><?php echo getNumParticipatorsNoResult()?></td></tr>
<tr><td>nicht erschienene Teilnehmer</td><td><?php echo getNumParticipatorsForGroup(-1)?></td></tr>
</table>

<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>