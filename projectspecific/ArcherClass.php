<?php
include_once("resource/sqldb.php");
include_once("resource/error.php");
class ArcherClassObject{
	private $mID;
	private $mName;
	private $mComment;
	
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("ArcherClassObject has to be created with the ID");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
   
    function __construct1($id)
    {    			
    	//Get data from the database
        $query = "SELECT * FROM ArcherClasses WHERE ClassID='".$id."';";
		$erg = sqlexecutesinglequery($query);
		$classObj = mysql_fetch_object($erg);
		if(!$classObj){
			error("ID: ".$id." wurde nicht gefunden");
		}
		$this->mUid=$classObj->ClassID;
		$this->mName=$classObj->ClassName;
		$this->mComment=$classObj->ClassComment;
    }
    function getID(){
    	return $this->mID;
    }
    function getName(){
    	return $this->mName;
    }
    function getComment(){
    	return $this->mComment;
    }
	function setName($name)
	{
		sqlexecutesinglequery("
			UPDATE archerclasses SET ClassName = '".$name."' WHERE ClassID=".$this->mID.";
		");
	}
	function setComment($Comment)
	{
		sqlexecutesinglequery("
			UPDATE archerclasses SET ClassComment = '".$Comment."' WHERE ClassID=".$this->mID.";
		");
	}

}
function getACIDForArcherClassName($name)
{
	$query = "SELECT * FROM archerclasses WHERE ClassName='".$name."';";
	$erg = sqlexecutesinglequery($query);
	if(!($ClassObj = mysql_fetch_object($erg)))
		return -1;
	return $ClassObj->ClassID;
}
function getArcherClassName($id)
{
	$query = "SELECT * FROM archerclasses WHERE ClassID='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(!($ClassObj = mysql_fetch_object($erg)))
		return -1;
	return $ClassObj->ClassName;
}


function checkArcherClassExists($id)
{
	$query = "SELECT * FROM archerclasses WHERE ClassID='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;
}
function checkArcherClassUsed($id)
{
	$query = "SELECT * FROM participation WHERE ArcherClassID='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;
}
function deleteArcherClass($id)
{
	if(checkArcherClassUsed($id))
		return -1;
	sqlexecutesinglequery("DELETE FROM archerclasses WHERE ClassID=".$id.";");
	return 1;
	#TODO Check if class is used. if not used delete it.
}
function AddArcherClass($name, $comment)
{
	sqlexecutesinglequery("
	INSERT INTO `archerclasses` (`ClassID`, `ClassName`, `ClassComment`) VALUES (NULL, '".$name."', '".$comment."');
	");
}
function getArcherClasses($formatter)
{
	$query = "SELECT * FROM ArcherClasses;";
	return getFormattedResult($query,$formatter);
}

?>
