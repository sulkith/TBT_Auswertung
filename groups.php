<?php
	include_once("resource/sqldb.php");
	include("resource/toolbar.php");
	include("resource/grouptools.php");
	
	setReferrer("groups.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
	<title>Gruppenzuordnung</title>
	<link rel="stylesheet" type="text/css" href="CSS/standard.css" />
 </head>
 <body>
 <?php 
	getCompleteToolbar();
	if(isset($info))getInfoBox($info);
 ?>
<?php
	createGroupTable(3,5)
?>
</body>
</html>