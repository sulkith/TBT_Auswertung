<?php
	include("resource/referrer.php");
	include_once("resource/error.php");
	include_once("projectspecific/ArcherClass.php");
	include_once("projectspecific/BowClass.php");
	include_once("projectspecific/Participation.php");
	$fn_pos = 1;
	$ln_pos = 2;
	$club_pos = 3;
	$ac_pos = 4;
	$bc_pos = 5;
#Michael;Drost;TBT;M;BHR
#Katharina;Engel;TBT;W;BHR
#Heinz;Drost;TBT;M;WHR
	if(isset($_POST['action']))
	if($_POST['action']=="Import")
	{
		if(($fn_pos=$_POST['FN_POS'])=="")
			$errhndl->setError("Keine Vornamen Spalte eingegeben");
		if(($ln_pos=$_POST['LN_POS'])=="")
			$errhndl->setError("Keine Nachnamen Spalte eingegeben");
		if(($bc_pos=$_POST['BC_POS'])=="")
			$errhndl->setError("Keine Bogenklassen Spalte eingegeben");
		if(($ac_pos=$_POST['AC_POS'])=="")
			$errhndl->setError("Keine Sch&uuml;tzenklassen Spalte eingegeben");
		if(($club_pos=$_POST['CLUB_POS'])=="")
			$errhndl->setError("Keine Vereins Spalte eingegeben");
		if(($csv=$_POST['csv'])=="")
			$errhndl->setError("Keine Daten zum import eingegeben");
		$testmode=isset($_POST['testmode']);
		$lineArray = explode("\n", $csv);
		#print var_dump($lineArray);
		#Sanity Check of positions
			
		if(!$errhndl->hasError())
		{
			$leftovers = "";
			if($testmode)$errhndl->setInfo("Testausgabe:\nVN: Vorname NN:Nachname CLUB:Verein BK:Bogenklasse SK:Schützenklasse");
			foreach ($lineArray as $line)
			{
				if(trim($line) == "")continue;
				#skip empty lines
				$elements = explode(";",$line);
				$name = trim($elements[$fn_pos-1]);
				$lastname = trim($elements[$ln_pos-1]);
				$bclassname = trim($elements[$bc_pos-1]);
				$aclassname = trim($elements[$ac_pos-1]);
				$club = trim($elements[$club_pos-1]);
				$bc = trim(getIDBowClassName($bclassname));
				$ac = trim(getIDArcherClassName($aclassname));
				if($bc == -1)
				{
					$errhndl->setError("Bogenklasse $bclassname bei $name $lastname unbekannt");
				}
				if($ac == -1)
				{
					$errhndl->setError("Schützenklasse $aclassname bei $name $lastname unbekannt");
				}
				if($ac != -1 && $bc != -1)
				{
					#print var_dump($bc) + var_dump($ac) + var_dump($club);
					if(!$testmode)
					{
						$errorCode = addParticipation($name, $lastname, $club, "", $bc, $ac, "", "0000-00-00");
						if($errorCode == 0)
						{
							$errhndl->setInfo("Teilnahme von $name $lastname erfolgreich hinzugefügt");
						}
						else if($errorCode == 1)
						{
							$errhndl->setError("Bogenklasse bei $name $lastname ungültig");
						}
						else if($errorCode == 2)
						{
							$errhndl->setError("Sch&uuml;tzenklasse bei $name $lastname ungültig");
						}
					}
					else
					{
						$bcname = getBowClassName($bc);
						$acname = getArcherClassName($ac);
						$errhndl->setInfo("VN: $name NN:$lastname CLUB:$club SK:$acname BK:$bcname");
					}
				}
				else
				{
					#add to leftovers.
					#print var_dump($line) + var_dump($leftovers)+"\n";
					if($leftovers == "")
						$leftovers = $line;
					else
						$leftovers = "$leftovers\n$line";
					#print var_dump($line) + var_dump($leftovers)+"\n";
				}
				
			}
			if($testmode)
			{
				$leftovers = $csv;
				#print "testmode\n";
			}
		}
	}
	setReferrer("csvImport.php");
	$title = "CSVImport";
	include_once("projectspecific/template_head.php");
?>
<form action="csvImport.php" method="post">
<div class="CaptionSmall">
<h1>CSV Import</h1>
</div>
Vorname Spalte: <input name="FN_POS" width="4" value="<?php print $fn_pos; ?>"></input><br>
Nachname Spalte: <input name="LN_POS" width="4" value="<?php print $ln_pos; ?>"></input><br>
Verein Spalte: <input name="CLUB_POS" width="4" value="<?php print $club_pos; ?>"></input><br>
Schützenklasse Spalte: <input name="AC_POS" width="4" value="<?php print $ac_pos; ?>"></input><br>
Bogenklasse Spalte: <input name="BC_POS" width="4" value="<?php print $bc_pos; ?>"></input><br>
<input type="checkbox" name="testmode" value "1" checked> Test-Modus<br>
<br>
<textarea name="csv" cols="100%" rows="40"><?php
	if(isset($leftovers))print $leftovers;
?></textarea><br>
<input type=submit name="action" value='Import' />
</form>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>