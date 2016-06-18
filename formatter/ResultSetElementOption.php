<?php
include_once("projectspecific/ArcherClass.php");
include_once("projectspecific/BowClass.php");
class ResultSetElementOptionFormatter{
	private $mHead = "<select>";
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("please add the head description to the construction of ResultSetElementOptionFormatter");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
	function __construct1($head)
    {
		$this->mHead = $head;
	}
	function format($pObj)
	{
		if(isset($pObj->aname) && isset($pObj->bname))
		{

			$aname = $pObj->aname;
			$bname = $pObj->bname;
		}
		else
		{
			$aname = getArcherClassName($pObj->ArcherClassID);
			$bname = getBowClassName($pObj->BowClassID);
		}
		return "<option value='".$pObj->resultSetElementID."'>".
		$aname." AND ".$bname.
		"</option>";
	}
	function getHead()
	{
		return $this->mHead;
	}
	function getFoot()
	{
		return "</select>";
	}
}
?>