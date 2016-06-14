<?php
	include("resource/referrer.php");
	include("projectspecific/result.php");
	
	#setReferrer("showResult.php");#TODO
	$title = "Ergebnisliste"; #TODO
	$dialog = 1;
	include_once("projectspecific/template_head.php");
	#
	#
	# TODO Display Warning for not included Participations
	# TODO Display Warning for not included Combinations of ArcherClass and BowClass 
	# (maybe only if there are participations)
	#
	#
?>
<table border=1 width=100%>

<?php 
getResultColspan();
getCompleteResult(); 
?>
</table>
<table border=1 width=100%>
<?php 
getResultColspan();
getResultSet(4); 
?>
</table>
<!-- Insert Content here -->
<?php include_once("projectspecific/template_foot.php");?>