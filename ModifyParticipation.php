<?php
	include_once 'resource/referrer.php';
	include("projectspecific/participation.php");
	include("projectspecific/ArcherClass.php");
	include("projectspecific/BowClass.php");
	if(isset($_GET['pid']))
	{
		$pid = $_GET['pid'];
		if(!checkParticipationExists($pid))
		{
			$info = "Diese Startnummer ist nicht vergeben!<br>";
		}
		$pObj = new participationObject($pid);
		$name = $pObj->getFirstName();
		$lastname = $pObj->getLastName();
		$club = $pObj->getClub();
		$bclass = $pObj->getBowClass();
		$bCObj = new BowClassObject($bclass);
		$bclasstext = $bCObj->getName();
		$aclass = $pObj->getArcherClass();
		$aCObj = new ArcherClassObject($aclass);
		$aclasstext = $aCObj->getName();
		$veg = $pObj->getVeggie();
		$email = $pObj->getEmail();
		$points = $pObj->getPoints();
		$kills = $pObj->getKills();
		$group = $pObj->getGroup();
		$finished = $pObj->isFinished();
	}
	
	setReferrer("ModifyParticipation.php&pid=".$pid);#TODO
	$title = "Teilnahme bearbeiten"; #TODO
	include_once("projectspecific/template_head.php");
?>

<form action="ModifyParticipation.php" method="post">
<div class="CaptionSmall">
		<h1><?php echo $pObj->getCompleteName();?></h1>
	</div>
	<h2>Turnierdaten</h2>
	<table>
<tr><td>Punkte</td><td><input type="text" name="points" value="<?php if($points != -1)echo $points; ?>" /></td><td>-2: Kein Ergebnis abgegeben</td></tr>
<tr><td>Kills</td><td><input type="text" name="kills" value="<?php if($kills != -1)echo $kills; ?>"/></td></tr>
<tr><td>Bogenklasse</td><td><select name='BowClassSelect' size='1' style="width:100%">
					<?php
						if($finished == false)
						{
							echo "<option value=-1 selected>Bitte Ausw&auml;hlen</option>";
							addBowClassesToSelectField(-1);
						}
						else
						{
							addBowClassesToSelectField($bclass);
						}
					?>
				</select></td></tr>
<tr><td>Sch&uuml;tzenklasse</td><td><select name='ArcherClassSelect' size='1' style="width:100%">
					<option value=-1 selected>Bitte Ausw&auml;hlen</option>
					<?php
						if($finished == false)
						{
							echo "<option value=-1 selected>Bitte Ausw&auml;hlen</option>";
							addArcherClassesToSelectField(-1);
						}
						else
						{
							addArcherClassesToSelectField($aclass);
						}
					?>
				</select></td></tr>
<tr><td>Gruppe</td><td><input type="text" name="group" value="<?php echo $group; ?>"/></td><td>-1: nicht erschienen</td></tr>
</table>
	<h2>Teilnehmerdaten</h2>
<table>
<tr><td>Vorname</td><td><input type="text" name="name" value="<?php if(isset($name))echo $name; ?>" /></td></tr>
<tr><td>Nachname</td><td><input type="text" name="lastname" value="<?php if(isset($lastname))echo $lastname; ?>"/></td></tr>
<tr><td>Verein</td><td><input type="text" name="club" value="<?php if(isset($club))echo $club; ?>"/></td></tr>
<tr><td>Bogenklasse</td><td><input type="text" value="<?php if(isset($bclasstext))echo $bclasstext; ?>" disabled/></td></tr>
<tr><td>Sch&uuml;tzenklasse</td><td><input type="text" value="<?php if(isset($aclasstext))echo $aclasstext; ?>" disabled/></td></tr>
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

<input type="submit" name="action" value='Speichern' />
  </form>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>