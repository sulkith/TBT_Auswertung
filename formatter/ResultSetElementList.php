<?php
include_once("projectspecific/ArcherClass.php");
include_once("projectspecific/BowClass.php");
class ResultSetElementListFormatter{
	function format($pObj)
	{
		if(isset($pObj->aname) && isset($pObj->bname))
		{
			return "<li>".$pObj->aname." AND ".$pObj->bname."</li>
			";
		}
		$aname = getArcherClassName($pObj->ArcherClassID);
		$bname = getBowClassName($pObj->BowClassID);
		return "<li>".$aname." AND ".$bname."</li>
		";
	}
	function getHead()
	{
		return "<ul>";
	}
	function getFoot()
	{
		return "</ul>";
	}
}
?>