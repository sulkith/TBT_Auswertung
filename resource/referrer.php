<?php
	if(!isset($_SESSION))
	{
		session_start();
	} 
	function setReferrer($address){
		if(!isset($_SESSION['last2'])){
			$_SESSION['last1'] = $address;
			$_SESSION['last2'] = $address;
		}
		else
		{	if($_SESSION['last1']!=$address)
			{
				$_SESSION['last2'] = $_SESSION['last1'];
				$_SESSION['last1'] = $address;
			}
		}
	}
	
	//This should be called after setReferrer.
	function linkBack(){
		return $_SESSION['last2'];
	}
		//This should be called if setReferrer is not invoked.
	function linkBackNoReferrer(){
		return $_SESSION['last1'];
	}
	function getOnClick()
	{
		$var = linkBack();
		return "onclick=\"window.location.href='".$var."'\"";
	}
?>