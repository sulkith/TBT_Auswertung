﻿<?php
	include_once("resource/error.php");
	include_once("projectspecific/ArcherClass.php");
	include_once("projectspecific/BowClass.php");
	include_once("projectspecific/Participation.php");
	include_once("formatter/ClassOption.php");
	include("resource/referrer.php");
	if(isset($_POST['action']))
	if($_POST['action']=="Eintragen")
	{
		if(($name=$_POST['name'])=="")
			$errhndl->setError("Kein Vorname eingegeben");
		if(($lastname=$_POST['lastname'])=="")
			$errhndl->setError("Kein Nachname eingegeben");
		if(($bclass=$_POST['BowClassSelect'])=="")
			$errhndl->setError("Keine Bogenklasse eingegeben");
		if(($aclass=$_POST['ArcherClassSelect'])=="")
			$errhndl->setError("Keine Sch&uuml;tzenklasse eingegeben");
		if(($veg=$_POST['Veggie'])=="")
			$errhndl->setError("Veggie nicht eingegeben");
		#Is this Website only used by the club? Or is an contact mail address needed?
		$email=$_POST['email'];
		#if(($email=$_POST['email'])=="")
		#	$errhndl->setError("Keine E-Mail eingegeben");
	
		$club=$_POST['club'];
			
		if(!$errhndl->hasError())
		{
			$errorCode = addParticipation($name, $lastname, $club, $email, $bclass, $aclass, $veg, "0000-00-00");
			if($errorCode == 0)
			{
				$errhndl->setInfo("Teilnahme erfolgreich hinzugefügt");
				unset ($name, $lastname, $email, $aclass, $bclass, $veg, $club);
			}
			else if($errorCode == 1)
			{
				$errhndl->setError("Bogenklasse ungültig");
			}
			else if($errorCode == 2)
			{
				$errhndl->setError("Sch&uuml;tzenklasse ungültig");
			}
		}
	}
	setReferrer("AddParticipation.php");
	$title = "Teilnahme hinzuf&uuml;gen";
	include_once("projectspecific/template_head.php");
?>
<form action="AddParticipation.php" method="post">
<div class="CaptionSmall">
		<h1>Teilnahme hinzuf&uuml;gen</h1>
	</div>
<table>
<tr><td>Vorname:</td><td><input type="text" name="name" value="<?php if(isset($name))echo $name; ?>" /></td></tr>
<tr><td>Nachname</td><td><input type="text" name="lastname" value="<?php if(isset($lastname))echo $lastname; ?>"/></td></tr>
<tr><td>Verein</td><td><input type="text" name="club" value="<?php if(isset($club))echo $club; ?>"/></td></tr>
<tr><td>Bogenklasse</td><td>
					<?php
						$formatter = new ClassOptionFormatter("<select name='BowClassSelect' size='1' style=\"width:100%\">");
						echo getBowClasses($formatter);
					?>
				</td></tr>
<tr><td>Sch&uuml;tzenklasse</td><td>
				<?php
					$formatter = new ClassOptionFormatter("<select name='ArcherClassSelect' size='1' style=\"width:100%\">");
					echo getArcherClasses($formatter);
				?>
				</td></tr>
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
<?php include_once("projectspecific/template_foot.php");?>