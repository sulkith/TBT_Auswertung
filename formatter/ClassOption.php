<?php
include_once("projectspecific/ArcherClass.php");
include_once("projectspecific/BowClass.php");
class ClassOptionFormatter{
	private $mHead = "<select>";
	private $mElements = "";
	private $mSelected = -1;
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("please add the head description to the construction of ClassOptionFormatter");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
	function __construct1($head)
    {
		$this->mHead = $head;
		$this->mSelected = -1;
		$this->mElements = "";
	}
	function setAdditionalElements($s)
	{
		$this->mElements = $s;
	}
	function setSelected($s)
	{
		$this->mSelected = $s;
	}
	function format($pObj)
	{
		if($pObj->ClassID == $this->mSelected)
			return "<option selected value=".$pObj->ClassID.">".$pObj->ClassName."</option>\n";
		else
			return "<option value=".$pObj->ClassID.">".$pObj->ClassName."</option>\n";
	}
	function getHead()
	{
		return $this->mHead.$this->mElements;
	}
	function getFoot()
	{
		return "</select>";
	}
}
?>