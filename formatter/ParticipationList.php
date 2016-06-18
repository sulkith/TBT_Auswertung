<?php
include_once("formatter/ParticipationTools.php");
class ParticipationListFormatter{
	private $mLink;
	function __construct()
    {
		$this->mLink=true;
	}
	function setLink($l)
	{
		$this->mLink=$l;
	}
	function format($pObj)
	{
		$s = "<li>";
		if($this->mLink)$s .= "<a href=\"ModifyParticipation.php?pid=".$pObj->StartNr."\">";
		$s .= formatParticipationName($pObj->StartNr);
		if($this->mLink)$s .= "</a>";
		$s .= "</li>
		";
		return $s;
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