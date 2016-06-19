<?php
include_once("projectspecific/participation.php");
function formatParticipationName($pid)
{
	$pObj = new participationObject($pid);
	$points = $pObj->getPoints();
	$group = $pObj->getGroup();
	if(($points == -2)||($group == -1))
		$string = "<s>";
	else
		$string = "";
	
	$string .= " ".$pObj->getLastName()." ".$pObj->getFirstName();
	if(($points == -2)||($group == -1))
		$string .= "</s>";
	else if($points != -1)
		$string .=  " &radic;";
	
	return $string;
}
?>