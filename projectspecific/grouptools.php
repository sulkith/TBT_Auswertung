<?php
include("participation.php");
include_once("formatter/ParticipationList.php");
function createGroupTable($x,$y)
{
	$formatter = new ParticipationListFormatter();
	$i=1;
	echo ' <table border="1" width="100%"><colgroup>';
	for($xi = 0; $xi<$x;$xi++)
	echo '<col width="1*">';
	echo '</colgroup>';

	for($yi = 0; $yi < $y; $yi++)
	{
		echo "<tr>";
		for($xi = 0; $xi<$x;$xi++)
		{
			$group = $yi * $x + $xi + 1;
			echo "<td><b>Gruppe ".$group."</b><br><ul>";
			echo getParticipationsForGroup($group,$formatter);
			#todo Print Group Members
			echo "</ul></td>";
		}
		echo "</tr>";
	}
	echo "<tr><td> unzugeordnete Teilnehmer<br><ul>";
	echo getParticipationsForGroup(0,$formatter);
	echo "</ul></td><td>nicht erschienene Teinehmer<br><ul>";
	echo getParticipationsForGroup(-1,$formatter);
	echo "</ul></td></tr>";
	echo "</table>";	
}
?>