<?php
	include_once("resource/sqldb.php");
	include_once("formatter/ParticipationResultCSV.php");
	include_once("formatter/ParticipationList.php");
	include_once("formatter/ResultSetElementList.php");
	include_once("projectspecific/result.php");
	include_once("projectspecific/participation.php");
	
	
	echo getCompleteResult(new ParticipationResultTableCSVFormatter());
?>