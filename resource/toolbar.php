<?php
	include_once('resource/referrer.php');
	
	
	function getCompleteToolbar()
	{
		echo "
		<div class=\"ToolBar\">
			<input type=button value='Zur&uuml;ck' ".getOnClick()." />
			<input type=button value='Bogenklassen verwalten' onclick=\"window.location.href='ManageBowClasses.php'\" />
			<input type=button value='Sch&uuml;tzenklassen verwalten' onclick=\"window.location.href='ManageArcherClasses.php'\" /><br>
			<input type=button value='Teilnahme hinzuf&uuml;gen' onclick=\"window.location.href='AddParticipation.php'\" />
			<input type=button value='Gruppenzuordnung' onclick=\"window.location.href='groups.php'\" />
		</div>";
	}
	function getSmallToolbar()
	{
		echo "
		<div class=\"ToolBar\">
			<input type=button value='Zur&uuml;ck' <?php echo getOnClick(); ?> />
		</div>";
	}
	function getInfoBox($info)
	{
		if($info != "")
		{
			echo "<div style='background-color:yellow; width: 100%;'>";
			echo $info;
			echo "</div>";
		}
	}
	

?>