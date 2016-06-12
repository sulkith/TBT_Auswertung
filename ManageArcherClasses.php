<?php
	#include("resource/auth.php");
	include("resource/ArcherClass.php");
	#include_once("resource/sqldb.php");
	include_once 'resource/referrer.php';
	
	
	if(isset($_POST['action'])){
		if($_POST['action']=="Informationen anzeigen"){
			if(!$ArcherClassSelect=$_POST['ArcherClassSelect'])
				$info = "Keine Schützenklasse ausgewählt";
			else{
				$bcid=getACIDForArcherClassName($ArcherClassSelect);
				header('Location: ArcherClassDetails.php?bcid='.$bcid.'');
			}
		}
		if($_POST['action']=="Klasse Loeschen"){
			if(!$ArcherClassSelect=$_POST['ArcherClassSelect'])
				$info = "Keine Schützenklasse ausgewählt";
			else{
				$bcid=getACIDForArcherClassName($ArcherClassSelect);
				if(deleteArcherClass($bcid) == -1)
					header('Location: BowClassDetails.php?bcid='.$bcid.'');
				else
					$info = "Schützenklasse gel&ouml;scht";
			}
		}
		if($_POST['action']=="Klasse anlegen"){
			if(!isset($_POST['CName']))
				$info = "Kein Klassenname eingegeben";
			else if (!isset($_POST['CComment']))
				$info = "Kein Kommentar eingegeben";
			else{
				AddArcherClass($_POST['CName'],$_POST['CComment']);
			}
		}
		
		
	}
	
	setReferrer("ManageBowClasses.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
	<title>Schützenklassen Management</title>
	<link rel="stylesheet" type="text/css" href="CSS/standard.css" />
 </head>
 <body>
  <form action="ManageArcherClasses.php" method="post">
	<div class="ToolBar">
		<input type=button value='Zur&uuml;ck' onclick="window.location.href='<?php echo linkBack();?>'" />
		<input type=button value='Hauptseite' onclick="window.location.href='index.php'" />
	</div>
	
	<div class="CaptionSmall">
		<h1>Schützenklassen Einstellungen</h1>
	</div>
	
	<div class="BodySmall">
		<div class="UserModInfo">	
			<p><?php if(isset($info)) echo $info;?></p>
		</div>
		
		<div class="UserModLeft">
			<div style="height:100%; width:250px;">
				<select name='ArcherClassSelect' size='20' style="width:100%; height:100%;">
					<?php
						//Print users
						addArcherClassesToSelectField(-1);
					?>
				</select>
			</div>
			<div style="height:100%; width:700px; left:250px; top:0px;">
				<input type=submit name="action" value='Klasse Loeschen'/>
				<input type=submit name="action" value='Informationen anzeigen' />
				<table>
					<tr><td>Klassen Name:</td><td><input type=text name="CName" /></td><td></td></tr>
					<tr><td>Kommentar</td><td><input type=text name="CComment" /></td><td><input type=submit name="action" value='Klasse anlegen' /></td></tr>
				</table>
			</div>
		</div>

	</div>
	</form>
	</body>
</html>
