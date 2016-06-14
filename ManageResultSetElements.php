<?php
	include("resource/referrer.php");
	include("projectspecific/result.php");
	
	$info = "";
	$error = "";
	if(isset($_GET['rsid']))
	{
		$rsid = $_GET['rsid'];
		#todo better error Message
		$rs = new ResultSetObject($rsid);
		$rsname = $rs->getName();
	}
	else if(isset($_POST['action']))
	{
		if($_POST['action']=='Hinzufuegen')
		{
			$rsid = $_POST['rsid'];
			$bclass = $_POST['BowClassSelect'];
			$aclass = $_POST['ArcherClassSelect'];
			if(!checkArcherClassExists($aclass))
			{
				$error .= "Schützenklasse existiert nicht<br>";
			}
			if(!checkBowClassExists($aclass))
			{
				$error .= "Schützenklasse existiert nicht<br>";
			}
			if(!checkResultSetElementIDExists($rsid))
			{
				$error .= "Ergebnisliste existiert nicht<br>";
			}
			if($error == "")
			{
				if(!checkResultSetElementExists($rsid,$aclass,$bclass))
				{
					addResultSetElement($rsid,$aclass,$bclass);
				}
				else
				{
					$info .= "Die Auswahl ist bereits in dieser Ergebnisliste enthalten<br>";
				}
			}
			$rs = new ResultSetObject($rsid);
			$rsname = $rs->getName();
		}
		else if($_POST['action']=='Entfernen')
		{
			$rsid = $_POST['rsid'];
			$rseid = $_POST['ResultSetElement'];
			removeResultSetElement($rseid);
			$rs = new ResultSetObject($rsid);
			$rsname = $rs->getName();
		}
	}
	$dialog = 1;
	$title = "'".$rsname ."' bearbeiten"; #TODO
	include_once("projectspecific/template_head.php");
?>
<div class="CaptionSmall">
		<h1><?php echo "'".$rsname ."' bearbeiten";?></h1>
	</div>
<form action="ManageResultSetElements.php" method="post">
<input type=hidden name='rsid' value="<?php echo $rsid?>">
<select name='ResultSetElement' size='10' style="width:250px">
<?php getResultSetElementsOption($rsid) ?>
</select><br>
<input type="submit" name="action" value='Entfernen' /><br>
<table>
<tr><td>Bogenklasse</td><td><select name='BowClassSelect' size='1' style="width:100%">
					<?php
						//Print users
						addBowClassesToSelectField($bclass);
					?>
				</select></td></tr>
<tr><td>Sch&uuml;tzenklasse</td><td><select name='ArcherClassSelect' size='1' style="width:100%">
					<?php
						//Print users
						addArcherClassesToSelectField($aclass);
					?>
				</select></td></tr>
</table>
<input type="submit" name="action" value='Hinzufuegen' />
</form>
<br>
<h2>in keiner Ergebnisliste enthaltene Kombinationen</h2>
<?php #TODO make links to add the combination via _GET?>
<ul>
<?php getUnusedResultSetElementList();?>
</ul>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>