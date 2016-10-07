<?php
include_once("resource/misc.php");
class ParticipationPayTableFormatter{
	function __construct()
    {
	}
	function format($pObj)
	{
		
		$string = "";
		$string .= "<tr>".
		"<td>".$pObj->FirstName."</td>".
		"<td>".$pObj->LastName."</td>".
		"<td>".$pObj->Club."</td>";
		if($pObj->PaidDate=="0000-00-00")
			$string .= "<td><a href=\"payRegister.php?pay=".$pObj->StartNr."\">Bezahlt!</a></td>";
		else
			$string .= "<td><a href=\"payRegister.php?unpay=".$pObj->StartNr."\">nicht Bezahlt!</a></td>";
		$string .= "<td>".formatDateFromSQLShort($pObj->RegisterDate)."</td>";
		if($pObj->PaidDate=="0000-00-00")
		{
			$string .= "<td>-</td>";
			$string .= "<td><a href=\"mailto:$pObj->EmailAddress?body=Hallo $pObj->FirstName $pObj->LastName,%0D%0Dleider konnten wir noch keinen Zahlungseingang deiner Startgebühr für Ihre/Deine Turnirteilnahme feststellen.%0D%0DmfG%0DTBT&subject=Turnirteilnahme TBT\">".$pObj->EmailAddress."</td>";
		}
		else
		{
			$string .= "<td>".formatDateFromSQLShort($pObj->PaidDate)."</td>";
			$string .= "<td><a href=\"mailto:$pObj->EmailAddress?body=Hallo $pObj->FirstName $pObj->LastName,%0D%0DHiermit bestätigen wir den eingang der Startgebühr.%0D%0DmfG%0DTBT&subject=Turnirteilnahme TBT\">".$pObj->EmailAddress."</td>";
		}

		return $string;
	}
	function getHead()
	{
		return "
<table border=1 width=100%><thead><tr>
	<th>Vorname</th>
	<th>Nachname</th>
	<th>Verein</th>
	<th>Aktion</th>
	<th>Anmeldedatum</th>
	<th>Bezahldatum</th>
	<th>Email-Adresse</th>
</tr></thead>
<colgroup>
	<col width=6*>
	<col width=6*>
	<col width=10*>
	<col width=8*>
	<col width=4*>
	<col width=4*>
	<col width=10*>
</colgroup>";
	}
	function getFoot()
	{
		return "</table>";
	}
}
?>