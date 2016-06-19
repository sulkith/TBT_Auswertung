<?php
include_once("formatter/ResultSetElementList.php");
class ResultSetTableFormatter{
	private $rselemformatter;
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("please add a resourcesetelementformatter to the construction of the ResultSetTableFormatter as argument");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
	function __construct1($formatter)
    {
		$this->rselemformatter = $formatter;
	}
	function format($pObj)
	{
		$s = "<tr><td>".$pObj->ResultSetName."</td><td>";
		$s .= getResultSetElements($pObj->ResultSetID,$this->rselemformatter);
		$s .= "<td><a href=\"ManageResultSetElements.php?rsid=".
		$pObj->ResultSetID."\">bearbeiten</a></td>
		<td><a href=\"ManageResultSets.php?remove=".
		$pObj->ResultSetID."\">entfernen</a></td></tr>
		";
		return $s;
	}
	function getHead()
	{
		return "<table border=1>";
	}
	function getFoot()
	{
		return "</table>";
	}
}
?>