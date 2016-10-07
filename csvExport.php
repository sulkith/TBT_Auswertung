<?php
	include_once("resource/sqldb.php");
	include_once("formatter/ParticipationResultCSV.php");
	include_once("formatter/ParticipationList.php");
	include_once("formatter/ResultSetElementList.php");
	include_once("projectspecific/result.php");
	include_once("projectspecific/participation.php");
    $var = getCompleteResult(new ParticipationResultTableCSVFormatter());    //  $var enthält einfach alles, was später in der Datei stehen soll, die der User runterlädt 

    header('Content-Type: text/plain');    //  möglich, dass du hier auch text/plain wählen kannst 
    header('Content-Length: ' . strlen($var)); 
    header('Content-Disposition: attachment; filename="export.csv"'); 

	echo $var;
?>