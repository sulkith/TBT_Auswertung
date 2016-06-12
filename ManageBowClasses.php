<?php
	include("resource/BowClass.php");
	include_once 'resource/referrer.php';
	include("resource/toolbar.php");
	
	
	if(isset($_POST['action'])){
		if($_POST['action']=="Informationen anzeigen"){
			if(!$BowClassSelect=$_POST['BowClassSelect'])
				$info = "Keine Bogenklasse ausgewählt";
			else{
				$bcid=$BowClassSelect;
				header('Location: BowClassDetails.php?bcid='.$bcid.'');
			}
		}
		if($_POST['action']=="Klasse Loeschen"){
			if(!$BowClassSelect=$_POST['BowClassSelect'])
				$info = "Keine Bogenklasse ausgewählt";
			else{
				$bcid=$BowClassSelect;
				if(deleteBowClass($bcid) == -1)
				{
					#todo show error with link
					header('Location: BowClassDetails.php?bcid='.$bcid.'');
				}
				else
					$info = "Bogenklasse gel&ouml;scht";
			}
		}
		if($_POST['action']=="Klasse anlegen"){
			$info = "";
			if(($CName = $_POST['CName']) == "")
			{
				$info .= "Kein Klassenname eingegeben<br>";
				echo $info;
			}
			if (($CComment = $_POST['CComment']) == "")
				$info .= "Kein Kommentar eingegeben<br>";
			
			if($info == ""){
				AddBowClass($CName,$CComment);
			}
		}
		
		
	}
	
	setReferrer("ManageBowClasses.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
	<title>Bogenklassen Management</title>
	<link rel="stylesheet" type="text/css" href="CSS/standard.css" />
 </head>
 <body>
  <?php 
	getCompleteToolbar();
	if(isset($info))getInfoBox($info);
 ?>
  <form action="ManageBowClasses.php" method="post">
	<div class="CaptionSmall">
		<h1>Bogenklassen Einstellungen</h1>
	</div>
	
	<div class="BodySmall">
		<div class="UserModLeft">
			<div style="height:50%; width:250px;">
				<select name='BowClassSelect' size='20' style="width:100%; height:100%;">
					<?php
						//Print users
						addBowClassesToSelectField(-1);
					?>
				</select>
			</div>
			<div style="height:50%; width:700px; left:250px; top:0px;">
				<input type=submit name="action" value='Klasse Loeschen'/>
				<input type=submit name="action" value='Informationen anzeigen' />
				<table>
					<tr><td>Klassen Name:</td><td><input type=text name="CName" value="<?php if(isset($CName))echo $CName; ?>"/></td><td></td></tr>
					<tr><td>Kommentar</td><td><input type=text name="CComment" value="<?php if(isset($CComment))echo $CComment; ?>"/></td><tr>
					<tr><td></td><td><input type=submit name="action" value='Klasse anlegen' /></td></tr>
				</table>
			</div>
		</div>

	</div>
	</form>
	</body>
</html>
