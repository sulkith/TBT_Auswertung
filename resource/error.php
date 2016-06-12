<?php
	function error($message){
		die($message);
		exit;
	}
	
	function errorPermissionDenied(){
		//TODO session_destroy();
		die("Permission denied");
		exit;
	}
?>