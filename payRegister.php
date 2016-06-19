<?php
	include("resource/referrer.php");
	include_once("resource/error.php");
	include_once("projectspecific/participation.php");
	include_once("formatter/ParticipationPayTable.php");
	


	if(isset($_GET['pay']))
	{
		payParticipation($_GET['pay']);
		$errhndl->setInfo("Zahlungseingang gespeichert");
	}
	if(isset($_GET['unpay']))
	{
		unPayParticipation($_GET['unpay']);
		$errhndl->setInfo("Zahlungseingang gelöscht");
	}
	setReferrer("payRegister.php");#TODO
	$title = "Bezalhungserfassung"; #TODO
	include_once("projectspecific/template_head.php");
?>
<table>
<tr>
<td style="vertical-align:top">
<b>noch nicht bezahlt</b>
<?php echo getNotPaidParticipators(new ParticipationPayTableFormatter());?>
</td>

<td style="vertical-align:top">
<b>bereits bezahlt</b>
<?php echo getPaidParticipators(new ParticipationPayTableFormatter());?>
</td>
</tr>
</table>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>