<?php
class ParticipationResultTableFormatter{
	private $mRank;
	function __construct()
    {
		$this->mRank=1;
	}
	function setRank($r)
	{
		$this->mRank=$r;
	}
	function format($pObj)
	{
		$string = "";
		$string .= "<tr>".
		"<td>".$this->mRank."</td>".
		"<td>".$pObj->StartNr."</td>".
		"<td>".$pObj->FirstName."</td>".
		"<td>".$pObj->LastName."</td>".
		"<td>".getArcherClassName($pObj->ArcherClassID)."</td>".
		"<td>".getBowClassName($pObj->BowClassID)."</td>".
		"<td>".$pObj->Club."</td>";
		$pointstext = $pObj->Points;
		if($pObj->Points==-1)$pointstext="-";
		if($pObj->Points==-2)$pointstext="-";
		$killstext = $pObj->Kills;
		if($pObj->Kills==-1)$killstext="-";
		$groupName = $pObj->GroupNr;
		if($pObj->GroupNr == -1)$groupName="-";
		if($pObj->GroupNr == -2)$groupName="-";
		$string .= "<td>".$pointstext."</td>".
		"<td>".$killstext."</td>".
		"<td>".$groupName."</td>".
		"</tr>
		";
		if($this->mRank != "-")
			$this->mRank++;
		return $string;
	}
	function getHead()
	{
		return "
<table border=1 width=100%><thead><tr>
	<th>Platz</th>
	<th>StartNr</th>
	<th>Vorname</th>
	<th>Nachname</th>
	<th>Sch&uuml;tzenklasse</th>
	<th>Bogenklasse</th>
	<th>Verein</th>
	<th>Punkte</th>
	<th>Kills</th>
	<th>Gruppe</th>
</tr></thead>
<colgroup>
	<col width=1*>
	<col width=1*>
	<col width=6*>
	<col width=6*>
	<col width=2*>
	<col width=2*>
	<col width=10*>
	<col width=2*>
	<col width=2*>
	<col width=2*>
</colgroup>";
	}
	function getFoot()
	{
		return "</table>";
	}
}
?>