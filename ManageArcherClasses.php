<?php
	include_once("projectspecific/ArcherClass.php");
	include_once("formatter/ClassOption.php");
	include_once("formatter/ParticipationList.php");
	include_once 'resource/referrer.php';
	setReferrer("ManageArcherClasses.php");
	if(isset($_GET['del']))
	{
		$acid = $_GET['del'];
		if(checkArcherClassUsed($acid) == true)
		{
			$errhndl->setInfo("Schützenklasse ".getArcherClassName($acid)." wird noch verwendet:");
			$errhndl->setInfo(getParticipatorsWithArcherClass($acid,new ParticipationListFormatter()));
			setReferrer("ManageArcherClasses.php?del=".$acid);
		}
	}
	
	if(isset($_POST['action'])){
		if($_POST['action']=="Klasse Loeschen"){
			if(!isset($_POST['ArcherClassSelect']))
				$errhndl->setError("Keine Schützenklasse ausgewählt");
			else{
				$ArcherClassSelect=$_POST['ArcherClassSelect'];
				$acid=$ArcherClassSelect;
				if(deleteArcherClass($acid) == -1)
				{
					$errhndl->setError("Schützenklasse ".getArcherClassName($acid)." wird noch verwendet:");
					$errhndl->setError(getParticipatorsWithArcherClass($acid,new ParticipationListFormatter()));
					setReferrer("ManageArcherClasses.php?del=".$acid);
					setReferrer("ManageArcherClasses.php?del=".$acid);
				}
				else
					$errhndl->setInfo("Schützenklasse gel&ouml;scht");
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
				$errorCode = AddArcherClass($CName,$CComment);
				if($errorCode == -1)
				{
					$errhndl->setError("Schützenklasse existiert bereits");
				}
				else
				{
					$errhndl->setInfo("Schützenklasse angelegt");
				}			}
		}
	}
	
	
	$title = "Sch&uuml;tzenklassen Management";
	$completetoolbar=1;
	include_once("projectspecific/template_head.php");
?>
  <form action="ManageArcherClasses.php" method="post">
	
	<div class="CaptionSmall">
		<h1>Sch&uuml;tzenklassen Einstellungen</h1>
	</div>
	
	<div class="BodySmall">
		<div class="UserModLeft">
			<div style="width:250px;">
				<?php
					$formatter = new ClassOptionFormatter("<select name='ArcherClassSelect' size='20' style=\"width:100%\">");
					echo getArcherClasses($formatter);
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
