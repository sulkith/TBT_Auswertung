<?php
	include("resource/referrer.php");
	
	setReferrer("template.php");#TODO
	$title = "Template"; #TODO
	include_once("projectspecific/template_head.php");
?>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>