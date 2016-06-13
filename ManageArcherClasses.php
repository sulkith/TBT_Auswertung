<?php
	include("projectspecific/ArcherClass.php");
	include_once 'resource/referrer.php';
	
	
	if(isset($_POST['action'])){
		if($_POST['action']=="Informationen anzeigen"){
			if(!$ArcherClassSelect=$_POST['ArcherClassSelect'])
				$info = "Keine Schützenklasse ausgewählt";
			else{
				$bcid = $ArcherClassSelect;
				header('Location: ArcherClassDetails.php?bcid='.$bcid.'');
			}
		}
		if($_POST['action']=="Klasse Loeschen"){
			if(!$ArcherClassSelect=$_POST['ArcherClassSelect'])
				$info = "Keine Schützenklasse ausgewählt";
			else{
				$bcid=$ArcherClassSelect;
				if(deleteArcherClass($bcid) == -1)
					header('Location: BowClassDetails.php?bcid='.$bcid.'');
				else
					$info = "Schützenklasse gel&ouml;scht";
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
				AddArcherClass($CName,$CComment);
			}
		}
	}
	
	setReferrer("ManageBowClasses.php");
	$title = "Sch&uuml;tzenklassen Management";
	include_once("projectspecific/template_head.php");
?>
  <form action="ManageArcherClasses.php" method="post">
	
	<div class="CaptionSmall">
		<h1>Sch&uuml;tzenklassen Einstellungen</h1>
	</div>
	
	<div class="BodySmall">
		<div class="UserModLeft">
			<div style="height:50%; width:250px;">
				<select name='ArcherClassSelect' size='20' style="width:100%; height:100%;">
					<?php
						//Print users
						addArcherClassesToSelectField(-1);
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
<?php include_once("projectspecific/template_foot.php");?>
