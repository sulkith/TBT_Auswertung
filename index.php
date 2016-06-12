<?php 
	include_once('resource/referrer.php');
	setReferrer("index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
	<title>TBT Auswertung</title>
	<link rel="stylesheet" type="text/css" href="CSS/standard.css" />
 </head>
 <body>
	<div class="ToolBar">
		<input type=button value='Zur&uuml;ck' <?php echo getOnClick(); ?> />
	</div>
	<div class="CaptionSmall">
		<h1>TBT Auswertung</h1>
	</div>
	<div class="BodySmall">
		<input type=button value='Bogenklassen verwalten' onclick="window.location.href='ManageBowClasses.php'" /><br>
		<input type=button value='Sch&uuml;tzenklassen verwalten' onclick="window.location.href='ManageArcherClasses.php'" /><br><br>
		<input type=button value='Teilnahme hinzuf&uuml;gen' onclick="window.location.href='AddParticipation.php'" /><br>
		<input type=button value='Gruppenzuordnung' onclick="window.location.href='groups.php'" /><br>
	</div>
 </body>
</html>