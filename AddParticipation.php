<?php
	include("projectspecific/ArcherClass.php");
	include("projectspecific/BowClass.php");
	include("projectspecific/Participation.php");
	include("resource/referrer.php");
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
				$info = "Teilnahme erfolgreich hinzugefügt";
				unset ($name, $lastname, $email, $aclass, $bclass, $veg, $club);
			}
			else if($errorCode == 1)
			{
				$info = "Bogenklasse ungültig";
			}
			else if($errorCode == 2)
			{
				$info = "Sch&uuml;tzenklasse ungültig";
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
<?php include_once("projectspecific/template_foot.php");?>