<?php
	include("toolbar.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
 <head>
	<title><?php echo $title;?></title>
	<link rel="stylesheet" type="text/css" href="CSS/standard.css" />
 </head>
 <body>
 <?php 
	if(isset($dialog))
		getDialogToolbar();
	else if(!isset($smalltoolbar))
		getCompleteToolbar();
	else
		getSmallToolbar();
	
	if(isset($info))getInfoBox($info);
	if(isset($error))getInfoBox($error);
 ?>