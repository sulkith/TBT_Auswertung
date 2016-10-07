<?php
class ParticipationResultTableCSVFormatter{
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
		$s = "";
		$s .= $this->mRank.";";
		$s .= $pObj->StartNr.";";
		$s .= $pObj->FirstName.";";
		$s .= $pObj->LastName.";";

		$s .= getArcherClassName($pObj->ArcherClassID).";";
		$s .= getBowClassName($pObj->BowClassID).";";
		
		$s .= $pObj->Club.";";
		
		$s .= $pObj->Points.";";
		$s .= $pObj->Kills.";";
		$s .= $pObj->GroupNr.";";

		$s .= $pObj->Veggie.";";
		$s .= $pObj->EmailAddress.";";
		$s .= $pObj->RegisterDate.";";
		$s .= $pObj->PaidDate."";
		$s .= "
";
		if($this->mRank != "-")
			$this->mRank++;
		return $s;
	}
	function getHead()
	{
		return "Platz;StartNr;Vorname;Nachname;Schuetzenklasse;Bogenklasse;Verein;Punkte;Kills;Gruppe;Veggie;Email;Anmeldedatum;Bezahldatum
";
	}
	function getFoot()
	{
		return "";
	}
}
?>