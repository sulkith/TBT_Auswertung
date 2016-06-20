<?php
	include_once("projectspecific/participation.php");
	include_once("projectspecific/ArcherClass.php");
	include_once("projectspecific/BowClass.php");
	include_once("formatter/ClassOption.php");
	include_once("formatter/ParticipationList.php");
	include_once("formatter/TabbedParticipationList.php");
	include_once("resource/referrer.php");
	include_once("resource/error.php");
	include_once("resource/misc.php");

	if(isset($_GET['pid']))
	{
		$pid = $_GET['pid'];
		if(!checkParticipationExists($pid))
		{
			$errhndl->setError("Diese Startnummer ist nicht vergeben!");
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
		$paiddate = formatDateFromSQL($pObj->getPaidDate());
		$registereddate = formatDateFromSQL($pObj->getRegisteredDate());
	}
	else if(isset($_POST['action']))
	{
		if($_POST['action']=="Speichern")
		{
			$finished=true;
			$pid = $_POST['pid'];
			if(!checkParticipationExists($pid))
			{
				$errhndl->setError("Diese Startnummer ist nicht vergeben!");
			}
			$pObj = new participationObject($pid);
			if(($name=$_POST['name'])=="")
				$errhndl->setError("Kein Vorname eingegeben");
			if(($lastname=$_POST['lastname'])=="")
				$errhndl->setError("Kein Nachname eingegeben");

			if(($veg=$_POST['Veggie'])=="")
				$errhndl->setError("Veggie nicht eingegeben");
			
			$bclass=$_POST['BowClassSelect'];
			$aclass=$_POST['ArcherClassSelect'];			
			#TODO Check if old Values are necessary

			
			$email=$_POST['email'];
	
			$club=$_POST['club'];
			
			$points=$_POST['points'];
			$kills=$_POST['kills'];
			
			$paiddate = formatDateFromSQL($pObj->getPaidDate());
			$registereddate = formatDateFromSQL($pObj->getRegisteredDate());
				
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
					$errhndl->setError("Keine Bogenklasse eingegeben");
				else
				{
					if($bclass != $pObj->getBowClass())
					$pObj->setBowClass($bclass);
					$bCObj = new BowClassObject($bclass);
					$bclasstext = $bCObj->getName();
				}
				if($aclass == -1)
					$errhndl->setError("Keine Sch&uuml;tzenklasse eingegeben");
				else
				{
					if($aclass != $pObj->getArcherClass())
					$pObj->setArcherClass($aclass);
					$aCObj = new ArcherClassObject($aclass);
					$aclasstext = $aCObj->getName();
				}
				if($kills == -1)
					$errhndl->setError("Keine Kills eingegeben");
				
				if(!$errhndl->hasError())
				{
					if($kills != $pObj->getKills())
						$pObj->setKills($kills);
					if($points != $pObj->getPoints())
						$pObj->setPoints($points);
				}
				else
				{
					$finished = false;
				}
				
				
			}
			else
			{
				$finished = false;
				if($bclass != -1)
				{
					if($bclass != $pObj->getBowClass())
					$pObj->setBowClass($bclass);
				}
				if($aclass != -1)
				{
					if($aclass != $pObj->getArcherClass())
					$pObj->setArcherClass($aclass);
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
			if(!$errhndl->hasError())
			{
				$errhndl->setInfo("Gespeichert");
			}
		}
	}
	if($group == 0)
	{
		$grouptabindex = 1;
		$savetabindex1 = 2;
	}
	else
	{
		$grouptabindex = 100;
		$savetabindex1 = 25;
	}
	$bCObj = new BowClassObject($pObj->getBowClass());
	$bclasstext = $bCObj->getName();
	$aCObj = new ArcherClassObject($pObj->getArcherClass());
	$aclasstext = $aCObj->getName();
	
	$title = "Teilnahme bearbeiten";
	$dialog = 1;
	include_once("projectspecific/template_head.php");
?>
<table><tr><td>
<form action="ModifyParticipation.php" method="post">
<div class="CaptionSmall">
		<h1><?php echo $pObj->getCompleteName();?></h1>
	</div>
	<h2>Turnierdaten</h2>
	<table>
<tr><td>Punkte</td><td><input type="number" tabindex=20 name="points" value="<?php if($points != -1)echo $points; ?>" /></td><td>-2: Kein Ergebnis abgegeben</td></tr>
<tr><td>Kills</td><td><input type="number" tabindex=21 name="kills" value="<?php if($kills != -1)echo $kills; ?>"/></td></tr>
<tr><td>Bogenklasse</td><td>
					<?php
						$formatter = new ClassOptionFormatter("<select name='BowClassSelect' tabindex=22 size='1' style=\"width:100%\">");
						if($finished == true)
							$formatter->setSelected($bclass);
						else
							$formatter->setAdditionalElements("<option value=-1 selected>Bitte Ausw&auml;hlen</option>");
						echo getBowClasses($formatter);
					?>
				</td></tr>
<tr><td>Sch&uuml;tzenklasse</td><td>
					<?php
						$formatter = new ClassOptionFormatter("<select name='ArcherClassSelect' tabindex=23 size='1' style=\"width:100%\">");
						if($finished == true)
							$formatter->setSelected($aclass);
						else
							$formatter->setAdditionalElements("<option value=-1 selected>Bitte Ausw&auml;hlen</option>");
						echo getArcherClasses($formatter);
					?></td></tr>
<tr><td>Gruppe</td><td><input type="number" tabindex=<?php echo $grouptabindex ?> name="group" value="<?php echo $group; ?>"/></td><td>0: noch nicht zugewiesen &nbsp;&nbsp;&nbsp;&nbsp; -1: nicht erschienen</td></tr>
</table>
<input type="submit" name="action" tabindex=<?php echo $savetabindex1 ?> value='Speichern' />
	<h2>Teilnehmerdaten</h2>
	<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<table>
<tr><td>Vorname</td><td><input type="text" tabindex=30 name="name" value="<?php if(isset($name))echo $name; ?>" /></td></tr>
<tr><td>Nachname</td><td><input type="text" tabindex=31 name="lastname" value="<?php if(isset($lastname))echo $lastname; ?>"/></td></tr>
<tr><td>Verein</td><td><input type="text" tabindex=32 name="club" value="<?php if(isset($club))echo $club; ?>"/></td></tr>
<tr><td>Bogenklasse</td><td><input type="text" tabindex=100 value="<?php if(isset($bclasstext))echo $bclasstext; ?>" disabled/></td></tr>
<tr><td>Sch&uuml;tzenklasse</td><td><input type="text" tabindex=100 value="<?php if(isset($aclasstext))echo $aclasstext; ?>" disabled/></td></tr>
<tr><td>Veggie</td><td><select name='Veggie' tabindex=33 size='1' style="width:100%">
<?php
if($veg == 1)
	echo "<option selected value=1>Yes</option><option value=0>No</option>";
else
	echo "<option value=1>Yes</option><option selected value=0>No</option>"
?>
</select></td></tr>
<tr><td>E-Mail</td><td><input type="email" tabindex=34 name="email" value="<?php if(isset($email))echo $email; ?>"/></td></tr>
<tr><td>Anmeldedatum</td><td><input type="text" tabindex=100 value="<?php echo $registereddate; ?>" disabled/></td></tr>
<tr><td>Zahldatum</td><td><input type="text" tabindex=100 value="<?php echo $paiddate; ?>" disabled/></td></tr>
</table>

<input type="submit" name="action" tabindex=35 value='Speichern' />
  </form></td><td style="vertical-align:top">
  <!--<table width=600px><colgroup><col width="1*"><col width="1*"></colgroup><tr>
  <td style="vertical-align:top">-->
<?php 
	if($group>0)
	{
		if($finished==true)
			echo "<br>Alle Schützen in dieser Gruppe:".getParticipationsForGroup($group,new TabbedParticipationListFormatter());
		else
			echo "<br>Alle Schützen in dieser Gruppe:".getParticipationsForGroup($group,new ParticipationListFormatter());
	}
?>
  <!--</td>
  <td style="vertical-align:top">-->
  <?php echo "<br>Alle unzugeordneten Schützen:".getParticipationsForGroup(0,new ParticipationListFormatter());?>
  <!--</td></tr>
  <table>--></td></tr></table>
  
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>