<?php
	include_once 'sqldb.php';
	function formatTimestampFromSql($timestamp){
		return substr($timestamp,8,2).".".substr($timestamp,5,2).".".substr($timestamp,0,4)." ".substr($timestamp,11,5);	
	}
	function stripUnwantedTags($string){
		return strip_tags($string,'<p><a><i><b><br>');
	}
	function stripAndEscape($string){
		return sqlescape(stripUnwantedTags($string));
	}
?>