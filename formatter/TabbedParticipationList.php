<?php
include_once("formatter/ParticipationTools.php");
class TabbedParticipationListFormatter{
	private $mLink;
	private $mTabIdx;
	function __construct()
    {
		$this->mLink=true;
		$this->mTabIdx=1;
	}
	function setLink($l)
	{
		$this->mLink=$l;
	}
	function setTabIdx($l)
	{
		$this->mTabIdx=$l;
	}
	function getTabIdx()
	{
		return $this->mTabIdx;
	}
	function format($pObj)
	{
		$s = "<li>";
		if($this->mLink)$s .= "<a tabindex=".$this->mTabIdx." href=\"ModifyParticipation.php?pid=".$pObj->StartNr."\">";
		$s .= formatParticipationName($pObj->StartNr);
		if($this->mLink)$s .= "</a>";
		$s .= "</li>
		";
		$this->mTabIdx++;
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