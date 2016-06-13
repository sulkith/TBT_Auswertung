<?php
include("participation.php");
function createGroupTable($x,$y)
{
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
			addUsersToGroupEnumerate($group);
			#todo Print Group Members
			echo "</ul></td>";
		}
		echo "</tr>";
	}
	echo "<tr><td> unzugeordnete Teilnehmer<br><ul>";
	addUsersToGroupEnumerate(0);
	echo "</ul></td><td>nicht erschienene Teinehmer<br><ul>";
	addUsersToGroupEnumerate(-1);
	echo "</ul></td></tr>";
	echo "</table>";	
}
?>