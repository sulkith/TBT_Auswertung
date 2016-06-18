<?php
	include("resource/referrer.php");
	include_once("projectspecific/Participation.php");
	include_once("formatter/ParticipationList.php");
	
	$formatter = new ParticipationListFormatter();
	
	setReferrer("AlphabeticalParticipation.php");
	$title = "Ergebniserfassung";
	include_once("projectspecific/template_head.php");
?>
<table border=1 width=100%>
<colgroup>
<col width=1*>
<col width=1*>
<col width=1*>
</colgroup>
<tr>
<td style="vertical-align:top">
<b>Alle Sch&uuml;tzen ohne Ergebnis</b>
<?php echo getParticipatorsNoPoints($formatter);?>
</td>
<td style="vertical-align:top">
<b>Alle Sch&uuml;tzen ohne Wertung</b>
<?php echo getParticipatorsNoResult($formatter);?>
</td>
<td style="vertical-align:top">
<b>Alle Sch&uuml;tzen</b>
<?php echo getAllParticipators($formatter);?>
</td>
</tr>
</table>

<?php $legend = 1; include_once("projectspecific/template_foot.php");?>