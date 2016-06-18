<?php
	include_once 'sqldb.php';
	function formatTimestampFromSql($timestamp){
		return substr($timestamp,8,2).".".substr($timestamp,5,2).".".substr($timestamp,0,4)." ".substr($timestamp,11,5);	
	}
	function formatDateFromSQL($d){
		# 0 1 2 3 4 5 6 7 8 9
		# 2 0 1 6 - 0 6 - 1 8
		return substr($d,8,2).".".substr($d,5,2).".".substr($d,0,4);	
	}
	function stripUnwantedTags($string){
		return strip_tags($string,'<p><a><i><b><br>');
	}
	function stripAndEscape($string){
		return sqlescape(stripUnwantedTags($string));
	}
?>