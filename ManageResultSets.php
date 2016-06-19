<?php
	include_once("resource/referrer.php");
	include_once("resource/error.php");
	include_once("projectspecific/result.php");
	include_once("formatter/ResultSetElementList.php");
	include_once("formatter/ResultSetTable.php");
	
	
	setReferrer("ManageResultSets.php");#TODO
	
	if(isset($_GET['remove']))
	{
		removeResultSetList($_GET['remove']);
		$errhndl->setInfo("Ergebnisliste entfernt");
	}
	if(isset($_POST['action']))
	{
		if($_POST['action'] == "Anlegen")
		{
			$name = $_POST['rsname'];
			if($name != "")
			{
				addResultSet($name);
				$errhndl->setInfo("Ergebnisliste angelegt");
			}
		}
	}
	$title = "Ergbnislisten bearbeiten"; #TODO
	include_once("projectspecific/template_head.php");
?>
<div class="CaptionSmall">
		<h1>Ergebnislisten verwalten</h1>
	</div>
	<h2>Ergebnislisten</h2>
<table border=1>
	<!--<th><td>Listenname</td><td>Inhalt</td><td>bearbeiten</td><td>entfernen</td></th>-->
	<?php echo getResultSets(new ResultSetTableFormatter(new ResultSetElementListFormatter));?>
</table>
</ul>
<form action="ManageResultSets.php" method="post">
<table>
Ergebnislistenname: <input type="text" name="rsname" />
<input type="submit" name="action" value='Anlegen' />
</form>
<br>
<h2>in keiner Ergebnisliste enthaltene Kombinationen</h2>
<?php echo getUnusedResultSetElements(new ResultSetElementListFormatter());?>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>