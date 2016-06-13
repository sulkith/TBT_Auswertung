<?php
	include("resource/referrer.php");
	include("projectspecific/Participation.php");
	
	setReferrer("AlphabeticalParticipation.php");
	$title = "Ergebniserfassung";
	include_once("projectspecific/template_head.php");
?>
<table>
<tr>
<td>
<b>Alle Sch&uuml;tzen</b>
<ul>
<?php addAllParticipatorsToEnumerateSorted();?>
</ul>
</td>
<td>
<b>Alle Sch&uuml;tzen ohne Ergebnis</b>
<ul>
<?php addParticipatorsToEnumerateSorted();?>
</ul>
</td>
</tr>
</table>
<?php include_once("projectspecific/template_foot.php");?>