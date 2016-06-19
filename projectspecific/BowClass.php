<?php
include_once("resource/sqldb.php");
include_once("resource/error.php");
class BowClassObject{
	private $mID;
	private $mName;
	private $mComment;
	
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("BowClassObject has to be created with the ID");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
   
    function __construct1($id)
    {    			
    	//Get data from the database
        $query = "SELECT * FROM BowClasses WHERE ClassID='".$id."';";
		$erg = sqlexecutesinglequery($query);
		$classObj = mysql_fetch_object($erg);
		if(!$classObj){
			error("UID: ".$uid." wurde nicht gefunden");
		}
		$this->mid=$classObj->ClassID;
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
			UPDATE bowclasses SET ClassName = '".$name."' WHERE ClassIF=".$this->mID.";
		");
	}
	function setComment($Comment)
	{
		sqlexecutesinglequery("
			UPDATE bowclasses SET ClassComment = '".$Comment."' WHERE ClassIF=".$this->mID.";
		");
	}

}

function getBowClassName($id)
{
	$query = "SELECT * FROM BowClasses WHERE ClassID='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(!($ClassObj = mysql_fetch_object($erg)))
		return -1;
	return $ClassObj->ClassName;
}

function checkBowClassExists($id)
{
	$query = "SELECT * FROM bowclasses WHERE ClassID='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;
}
function checkBowClassUsed($id)
{
	$query = "SELECT * FROM participation WHERE BowClassID='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;
}
function deleteBowClass($id)
{
	if(checkBowClassUsed($id))
		return -1;
	sqlexecutesinglequery("DELETE FROM bowclasses WHERE ClassID=".$id.";");
	return 1;
	#TODO Check if class is used. if not used delete it.
}
function AddBowClass($name, $comment)
{
	if(getIDBowClassName($name) != -1)
		return -1;
	sqlexecutesinglequery("
	INSERT INTO `tbttournament`.`bowclasses` (`ClassID`, `ClassName`, `ClassComment`) VALUES (NULL, '".$name."', '".$comment."');
	");
	return 0;
}
function getIDBowClassName($name)
{
	$query = "SELECT * FROM bowclasses WHERE ClassName='".$name."';";
	$erg = sqlexecutesinglequery($query);
	if(!($ClassObj = mysql_fetch_object($erg)))
		return -1;
	return $ClassObj->ClassID;
}
function getBowClasses($formatter)
{
	$query = "SELECT * FROM BowClasses;";
	return getFormattedResult($query,$formatter);
}
?>
