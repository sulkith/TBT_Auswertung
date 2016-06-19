<?php
	include_once('resource/referrer.php');
	
	
	function getCompleteToolbar()
	{
		echo "
		<div class=\"ToolBar\">
		<table><tr><td>
			<input type=button style='width:100%' value='Zur&uuml;ck' ".getOnClick()." /></td><td>
			<input type=button style='width:100%' value='Bogenklassen verwalten' onclick=\"window.location.href='ManageBowClasses.php'\" /></td><td>
			<input type=button style='width:100%' value='Sch&uuml;tzenklassen verwalten' onclick=\"window.location.href='ManageArcherClasses.php'\" /></td><td>
			<input type=button style='width:100%' value='Ergebnislisten verwalten' onclick=\"window.location.href='ManageResultSets.php'\" /></td>
			</tr><tr><td>
			<input type=button style='width:100%' value='Home' onclick=\"window.location.href='index.php'\" /></td><td>
			<input type=button style='width:100%' value='Teilnahme hinzuf&uuml;gen' onclick=\"window.location.href='AddParticipation.php'\" /></td><td>
			<input type=button style='width:100%' value='Gruppenzuordnung' onclick=\"window.location.href='groups.php'\" /></td><td>
			<input type=button style='width:100%' value='Ergebniserfassung' onclick=\"window.location.href='AlphabeticalParticipation.php'\" /></td>
			</table>
		</div>";
	}
	function getSmallToolbar()
	{
		echo "
		<div class=\"ToolBar\">
			<input type=button value='Zur&uuml;ck' ".getOnClick()." />
		</div>";
	}
	function getDialogToolbar()
	{
		echo "
		<div class=\"ToolBar\">
			<input type=button value='Zur&uuml;ck' ".getOnClickNoReferrer()." />
		</div>";
	}
	function getInfoBox($info)
	{
		if($info != "")
		{
			echo "<div style='background-color:#00FF00; width: 100%;'>";
			echo $info;
			echo "</div>";
		}
	}
	function getWarnBox($info)
	{
		if($info != "")
		{
			echo "<div style='background-color:yellow; width: 100%;'>";
			echo $info;
			echo "</div>";
		}
	}
	function getErrorBox($error)
	{
		if($error != "")
		{
			echo "<div style='background-color:red; width: 100%;'>";
			echo $error;
			echo "</div>";
		}
	}
	

?>