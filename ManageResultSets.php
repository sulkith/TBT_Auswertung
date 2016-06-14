<?php
	include("resource/referrer.php");
	include("projectspecific/result.php");
	
	setReferrer("ManageResultSets.php");#TODO
	$title = "Ergbnislisten bearbeiten"; #TODO
	include_once("projectspecific/template_head.php");
	if(isset($_GET['remove']))
	{
		removeResultSetList($_GET['remove']);
		$info = "Ergebnisliste entfernt<br>";
	}
	if(isset($_POST['action']))
	{
		if($_POST['action'] == "Anlegen")
		{
			$name = $_POST['rsname'];
			if($name != "")
				addResultSet($name);
		}
	}
?>
<div class="CaptionSmall">
		<h1>Ergebnislisten verwalten</h1>
	</div>
	<h2>Ergebnislisten</h2>
<table border=1>
	<!--<th><td>Listenname</td><td>Inhalt</td><td>bearbeiten</td><td>entfernen</td></th>-->
	<?php getResultSetTable();?>
</table>
</ul>
<form action="ManageResultSets.php" method="post">
<table>
Ergebnislistenname: <input type="text" name="rsname" />
<input type="submit" name="action" value='Anlegen' />
</form>
<br>
<h2>in keiner Ergebnisliste enthaltene Kombinationen</h2>
<ul>
<?php getUnusedResultSetElementList();?>
</ul>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>