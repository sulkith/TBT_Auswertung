<?php
function error($msg)
{
	die($msg);
}

class errorHandler
{
	private $mInfo;
	private $mWarn;
	private $mError;
	function __construct()
    {
		$this->mInfo = "";
		$this->mWarn = "";
		$this->mError = "";
	}
	function setInfo($i)
	{
		if($this->mInfo != "")
			$this->mInfo .= "<br>".$i;
		else
			$this->mInfo .= $i;
	}
	function setInfoNoBr($i)
	{
		$this->mInfo .= $i;
	}
	function hasInfo()
	{
		return !($this->mInfo == "");
	}
	function getInfo()
	{
		return $this->mInfo;
	}
	
	function setWarn($i)
	{
		if($this->mWarn != "")
			$this->mWarn .= "<br>".$i;
		else
			$this->mWarn .= $i;
	}
	function setWarnNoBr($i)
	{
		$this->mWarn .= $i;
	}
	function hasWarn()
	{
		return !($this->mWarn == "");
	}
	function getWarn()
	{
		return $this->mWarn;
	}
	
	function setError($i)
	{
		if($this->mError != "")
			$this->mError .= "<br>".$i;
		else
			$this->mError .= $i;
	}
	function setErrorNoBr($i)
	{
		$this->mError .= $i;
	}
	function hasError()
	{
		return !($this->mError == "");
	}
	function getError()
	{
		return $this->mError;
	}
	function getBoxes()
	{
		$s = "";
		if($this->mError != "")
		{
			$s .= "<div style='background-color:red; class='ErrorBox' width: 100%;'>";
			$s .= $this->mError."</div>";
		}
		if($this->mWarn != "")
		{
			$s .= "<div style='background-color:yellow; class='WarnBox' width: 100%;'>";
			$s .= $this->mWarn."</div>";
		}
		if($this->mInfo != "")
		{
			$s .= "<div style='background-color:#00FF00; class='InfoBox' width: 100%;'>";
			$s .= $this->mInfo."</div>";
		}
		return $s;
	}
}
$errhndl = new errorHandler();
?>