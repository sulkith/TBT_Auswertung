<?php
	include_once("resource/sqldb.php");
	include("resource/ArcherClass.php");
	include("resource/BowClass.php");
	include("resource/Participation.php");
	include("resource/toolbar.php");
	if(isset($_POST['action']))
	if($_POST['action']=="Eintragen")
	{
		$info = "";
		if(($name=$_POST['name'])=="")
			$info .= "Kein Vorname eingegeben<br>";
		if(($lastname=$_POST['lastname'])=="")
			$info .= "Kein Nachname eingegeben";
		if(($bclass=$_POST['BowClassSelect'])=="")
			$info .= "Keine Bogenklasse eingegeben";
		if(($aclass=$_POST['ArcherClassSelect'])=="")
			$info .= "Keine Sch&uuml;tzenklasse eingegeben";
		if(($veg=$_POST['Veggie'])=="")
			$info .= "Veggie nicht eingegeben";
		#Is this Website only used by the club? Or is an contact mail address needed?
		$email=$_POST['email'];
		#if(($email=$_POST['email'])=="")
		#	$info .= "Keine E-Mail eingegeben";
	
		$club=$_POST['club'];
			
		if($info == "")
		{
			$errorCode = addParticipation($name, $lastname, $club, $email, $bclass, $aclass, $veg, "0000-00-00");
			if($errorCode == 0)
			{
				$info = "Teilnahme erfolgreich hinzugef�gt";
				unset ($name, $lastname, $email, $aclass, $bclass, $veg, $club);
			}
			else if($errorCode == 1)
			{
				$info = "Bogenklasse ung�ltig";
			}
			else if($errorCode == 2)
			{
				$info = "Sch&uuml;tzenklasse ung�ltig";
			}
		}
	}
	setReferrer("AddParticipation.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
	<title>Teilnahme hinzuf&uuml;gen</title>
	<link rel="stylesheet" type="text/css" href="CSS/standard.css" />
 </head>
 <body>
 <?php 
	getCompleteToolbar();
	if(isset($info))getInfoBox($info);
 ?>
<form action="AddParticipation.php" method="post">
<table>
<tr><td>Vorname:</td><td><input type="text" name="name" value="<?php if(isset($name))echo $name; ?>" /></td></tr>
<tr><td>Nachname</td><td><input type="text" name="lastname" value="<?php if(isset($lastname))echo $lastname; ?>"/></td></tr>
<tr><td>Verein</td><td><input type="text" name="club" value="<?php if(isset($club))echo $club; ?>"/></td></tr>
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
<tr><td>Veggie</td><td><select name='Veggie' size='1' style="width:100%">
<?php
if($veg == 1)
	echo "<option selected value=1>Yes</option><option value=0>No</option>";
else
	echo "<option value=1>Yes</option><option selected value=0>No</option>"
?>
</select></td></tr>
<tr><td>E-Mail</td><td><input type="text" name="email" value="<?php if(isset($email))echo $email; ?>"/></td></tr>
</table>

<input type="submit" name="action" value='Eintragen' />
  </form>
  	</body>
</html>