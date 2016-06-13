<?php
	include("projectspecific/participation.php");
	include("projectspecific/ArcherClass.php");
	include("projectspecific/BowClass.php");
	include_once("resource/referrer.php");
	$info = "";
	$error = "";
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
	else if(isset($_POST['action']))
	{
		if($_POST['action']=="Speichern")
		{
			$finished=true;
			$pid = $_POST['pid'];
			if(!checkParticipationExists($pid))
			{
				$info = "Diese Startnummer ist nicht vergeben!<br>";
			}
			$pObj = new participationObject($pid);
			if(($name=$_POST['name'])=="")
				$info .= "Kein Vorname eingegeben<br>";
			if(($lastname=$_POST['lastname'])=="")
				$info .= "Kein Nachname eingegeben";

			if(($veg=$_POST['Veggie'])=="")
				$info .= "Veggie nicht eingegeben";
			
			$bclass=$_POST['BowClassSelect'];
			$aclass=$_POST['ArcherClassSelect'];			
			#TODO Check if old Values are necessary

			
			$email=$_POST['email'];
	
			$club=$_POST['club'];
			
			$points=$_POST['points'];
			$kills=$_POST['kills'];
				
			if(($group=$_POST['group'])=="")
				$group = 0;
			
			
			if($name != $pObj->getFirstName())
				$pObj->setFirstName($name);
			if($lastname != $pObj->getLastName())
				$pObj->setLastName($lastname);
			if($club != $pObj->getClub())
				$pObj->setClub($club);			
			if($email != $pObj->getEmail())
				$pObj->setEmail($email);
			if($veg != $pObj->getVeggie())
				$pObj->setVeggie($veg);
			
			
			if($group != $pObj->getGroup())
				$pObj->setGroup($group);
			if($points != "")
			{
				#points set check bclass aclass...
				if($bclass == -1)
					$error .= "Keine Bogenklasse eingegeben";
				else
				{
					if($bclass != $pObj->getBowClass())
						$pObj->setBowClass($bclass);
					$bCObj = new BowClassObject($bclass);
					$bclasstext = $bCObj->getName();
				}
				if($aclass == -1)
					$error .= "Keine Sch&uuml;tzenklasse eingegeben";
				else
				{
					if($aclass != $pObj->getArcherClass())
						$pObj->setArcherClass($bclass);
					$aCObj = new ArcherClassObject($aclass);
					$aclasstext = $aCObj->getName();
				}
				if($kills == -1)
					$error .= "Keine Kills eingegeben";
				
				if($error == "")
				{
					if($kills != $pObj->getKills())
						$pObj->setKills($kills);
					if($points != $pObj->getPoints())
						$pObj->setPoints($points);
				}
				
				
			}
			else
			{
				if($bclass != -1)
				{
					if($bclass != $pObj->getBowClass())
						$pObj->setBowClass($bclass);
					$bCObj = new BowClassObject($bclass);
					$bclasstext = $bCObj->getName();
				}
				if($aclass != -1)
				{
					if($aclass != $pObj->getArcherClass())
						$pObj->setArcherClass($aclass);
					$aCObj = new ArcherClassObject($aclass);
					$aclasstext = $aCObj->getName();
				}
			}
			if($points =="" && ($pObj->getPoints()>=0))
			{
				$pObj->setKills(-1);
				$kills = "";
				$pObj->setPoints(-1);
				$points = "";
				$finished = false;
			}
			if($error=="" && $info=="")
			{
				$info = "Gespeichert";
			}
		}
	}
	
	$title = "Teilnahme bearbeiten";
	$dialog = 1;
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
<tr><td>Gruppe</td><td><input type="text" name="group" value="<?php echo $group; ?>"/></td><td>0: noch nicht zugewiesen &nbsp;&nbsp;&nbsp;&nbsp; -1: nicht erschienen</td></tr>
</table>
	<h2>Teilnehmerdaten</h2>
	<input type="hidden" name="pid" value="<?php echo $pid; ?>">
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