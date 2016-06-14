<?php
	include("resource/referrer.php");
	include("projectspecific/Participation.php");
	
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
<ul>
<?php addParticipatorsToEnumerateSortedNoPoints();?>
</ul>
</td>
<td style="vertical-align:top">
<b>Alle Sch&uuml;tzen ohne Wertung</b>
<ul>
<?php addParticipatorsToEnumerateSortedNoResult();?>
</ul>
</td>
<td style="vertical-align:top">
<b>Alle Sch&uuml;tzen</b>
<ul>
<?php addAllParticipatorsToEnumerateSorted();?>
</ul>
</td>
</tr>
</table>

<?php $legend = 1; include_once("projectspecific/template_foot.php");?>