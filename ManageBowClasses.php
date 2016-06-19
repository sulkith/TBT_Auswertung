<?php
	include("projectspecific/BowClass.php");
	include_once('resource/referrer.php');
	include_once('resource/error.php');
	include_once("formatter/ClassOption.php");
	include_once("formatter/ParticipationList.php");
	setReferrer("ManageBowClasses.php");
	if(isset($_GET['del']))
	{
		$bcid = $_GET['del'];
		if(checkBowClassUsed($bcid) == true)
		{
			$errhndl->setInfo("Bogenklasse ".getBowClassName($bcid)." wird noch verwendet:");
			$errhndl->setInfo(getParticipatorsWithBowClass($bcid,new ParticipationListFormatter()));
			setReferrer("ManageBowClasses.php?del=".$bcid);
		}
	}
	
	if(isset($_POST['action'])){
		if($_POST['action']=="Klasse Loeschen"){
			if(!isset($_POST['BowClassSelect']))
				$errhndl->setError("Keine Bogenklasse ausgewählt");
			else{
				$BowClassSelect=$_POST['BowClassSelect'];
				$bcid=$BowClassSelect;
				if(deleteBowClass($bcid) == -1)
				{
					$errhndl->setError("Bogenklasse ".getBowClassName($bcid)." wird noch verwendet:");
					$errhndl->setError(getParticipatorsWithBowClass($bcid,new ParticipationListFormatter()));
					setReferrer("ManageBowClasses.php?del=".$bcid);
				}
				else
					$errhndl->setInfo("Bogenklasse gel&ouml;scht");
			}
		}
		if($_POST['action']=="Klasse anlegen"){
			if(!isset($_POST['CName']) || $_POST['CName']=="")
			{
				$errhndl->setError("Kein Klassenname eingegeben");
			}
			else
			{
				$CName = $_POST['CName'];
			}
			if (!isset($_POST['CComment']))
			{
				$CComment="";
				#Comment is not neccessary --> displayed nowhere!
				#$errhndl->setError("Kein Kommentar eingegeben");
			}
			else
			{
				$CComment = $_POST['CComment'];
			}
			
			if(!$errhndl->hasError()){
				$errorCode = AddBowClass($CName,$CComment);
				if($errorCode == -1)
				{
					$errhndl->setError("Bogenklasse existiert bereits");
				}
				else
				{
					$errhndl->setInfo("Bogenklasse angelegt");
				}
			}
		}
	}
	
	$title = "Bogenklassen Management";
	include_once("projectspecific/template_head.php");
?>
  <form action="ManageBowClasses.php" method="post">
	<div class="CaptionSmall">
		<h1>Bogenklassen Einstellungen</h1>
	</div>
	
	<div class="BodySmall">
		<div class="UserModLeft">
			<div style="height:50%; width:250px;">
					<?php
						$formatter = new ClassOptionFormatter("<select name='BowClassSelect' size='20' style=\"width:100%\">");
						echo getBowClasses($formatter);
					?>
			</div>
			<div style="height:50%; width:700px; left:250px; top:0px;">
				<input type=submit name="action" value='Klasse Loeschen'/>
				<table>
					<tr><td>Klassen Name:</td><td><input type=text name="CName" value="<?php if(isset($CName))echo $CName; ?>"/></td><td></td></tr>
					<tr><td>Kommentar</td><td><input type=text name="CComment" value="<?php if(isset($CComment))echo $CComment; ?>"/></td><tr>
					<tr><td></td><td><input type=submit name="action" value='Klasse anlegen' /></td></tr>
				</table>
			</div>
		</div>

	</div>
	</form>
<?php include_once("projectspecific/template_foot.php");?>
