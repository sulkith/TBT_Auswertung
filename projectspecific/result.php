<?php 
include_once("resource/sqldb.php");
include_once("projectspecific/ArcherClass.php");
include_once("projectspecific/BowClass.php");
class ResultSetObject{
	private $mID;
	private $mName;
	
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("ResultSet has to be created with the ID");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
   
    function __construct1($id)
    {    			
    	//Get data from the database
        $query = "SELECT * FROM ResultSets WHERE ResultSetID='".$id."';";
		$erg = sqlexecutesinglequery($query);
		$classObj = mysql_fetch_object($erg);
		if(!$classObj){
			error("ID: ".$id." wurde nicht gefunden");
		}
		$this->mid=$classObj->ResultSetID;
		$this->mName=$classObj->ResultSetName;
    }
    function getID(){
    	return $this->mID;
    }
    function getName(){
    	return $this->mName;
    }
	function setName($name)
	{
		$this->mName = $name;
		sqlexecutesinglequery("
			UPDATE ResultSets SET ResultSetName = '".$this->$mName."' WHERE ResultSetID=".$this->mID.";
		");
	}
}
function addResultSet($name)
{
	sqlexecutesinglequery("INSERT INTO resultsets (ResultSetID, ResultSetName) VALUES (NULL, '".$name."');");
	
}
function removeResultSetList($rid)
{
	sqlexecutesinglequery("DELETE FROM resultsetelement WHERE ResultSetID = ".$rid.";");
	sqlexecutesinglequery("DELETE FROM resultsets WHERE ResultSetID = ".$rid.";");
}
function removeResultSetElement($rid)
{
	sqlexecutesinglequery("DELETE FROM resultsetelement WHERE ResultSetElementID = ".$rid.";");
}
function checkResultSetElementIDExists($rsid)
{
	$query = "SELECT * FROM resultsets WHERE ResultSetID=".$rsid.";";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;

}
function addResultSetElement($rsid,$aclass,$bclass)
{
	$query = "INSERT INTO resultsetelement(resultSetElementID, ResultSetID, BowClassID, ArcherClassID) 
	VALUES (NULL, '".$rsid."', '".$bclass."', '".$aclass."');";
	sqlexecutesinglequery($query);
}
function checkResultSetElementExists($rsid,$aclass,$bclass)
{
	$query = "SELECT * FROM resultsetelement WHERE ResultSetID=".$rsid." AND BowClassID=".$bclass." AND ArcherClassID=".$aclass.";";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;

}
function checkResultSetElementHasArcher($aclass,$bclass)
{
	$query = "SELECT * FROM participation WHERE BowClassID=".$bclass." AND ArcherClassID=".$aclass.";";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;

}

function getUnusedResultSetElementListString()
{
	$s = "";
	$erg = sqlexecutesinglequery("SELECT archerclasses.ClassID AS aclass, archerclasses.ClassName AS aname , 
	bowclasses.ClassID AS bclass, bowclasses.ClassName AS bname FROM bowclasses, archerclasses;");
	while($pObj = mysql_fetch_object($erg))
	{
		if(!checkResultSetElementContentExists($pObj->aclass, $pObj->bclass))
		{
			$s .= "<li>".$pObj->aname." AND ".$pObj->bname."</li>";
		}
	}
	return $s;
}


function checkResultSetElementContentExists($aclass,$bclass)
{
	$query = "SELECT * FROM resultsetelement WHERE BowClassID=".$bclass." AND ArcherClassID=".$aclass.";";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;

}


function getResultSetList()
{
	$query = "SELECT ResultSetID, ResultSetName FROM ResultSets;";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<li><a href=\"ManageResultSetElements.php?rsid=".$pObj->ResultSetID."\">".
		$pObj->ResultSetName."</a></li>\n";
	}
}



###############################################################
#  Formatter based Outputs
###############################################################
function getResultSet($id, $formatter)
{
	$query = "SELECT * FROM participation, ResultSetElement 
	WHERE Points!=-1 AND Points !=-2 AND 
	ResultSetElement.BowClassID = participation.BowClassID AND
	ResultSetElement.ArcherClassID = participation.ArcherClassID AND
	ResultSetElement.ResultSetID=".$id."
	ORDER BY StartNr, Kills, Points;";
	$formatter->setRank("1");
	$string = getFormattedResult($query,$formatter);
	return $string;
}

function getCompleteResult($formatter)
{
	$s = $formatter->getHead();
	$formatter->setRank("1");
	$s .= getFormattedResultWithoutHead("SELECT * FROM participation WHERE Points!=-1 AND Points !=-2 ORDER BY StartNr, Kills, Points;",$formatter);
	$formatter->setRank("-");
	$s .= getFormattedResultWithoutHead("SELECT * FROM participation WHERE Points=-1 OR Points =-2 ORDER BY StartNr;",$formatter);
	$s .= $formatter->getFoot();
	return $s;
}
function getUnusedResultSetElements($formatter)
{
	#This function is a bit complicated because of the checking if the Class is active!
	$s = $formatter->getHead();
	$erg = sqlexecutesinglequery("SELECT archerclasses.ClassID AS aclass, archerclasses.ClassName AS aname , 
	bowclasses.ClassID AS bclass, bowclasses.ClassName AS bname FROM bowclasses, archerclasses;");
	while($pObj = mysql_fetch_object($erg))
	{
		if(!checkResultSetElementContentExists($pObj->aclass, $pObj->bclass))
		{
			$s .= $formatter->format($pObj);
		}
	}
	$s .= $formatter->getFoot();
	return $s;
}
function getCompleteResultSets($formatter)
{
	$query = "SELECT ResultSetID, ResultSetName FROM ResultSets;";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	$s = "";
	while($pObj = mysql_fetch_object($erg))
	{
		$s .= "<h1>".$pObj->ResultSetName."</h1>";
		$s .= getResultSet($pObj->ResultSetID,$formatter); 
	}
	return $s;
}
function getUnusedResultSetElementListWithActiveArchers($formatter)
{
	#This function is a bit complicated because of the checking if the Class is active!
	$s = $formatter->getHead();
	$erg = sqlexecutesinglequery("SELECT archerclasses.ClassID AS aclass, archerclasses.ClassName AS aname , 
	bowclasses.ClassID AS bclass, bowclasses.ClassName AS bname FROM bowclasses, archerclasses;");
	while($pObj = mysql_fetch_object($erg))
	{
		if(!checkResultSetElementContentExists($pObj->aclass, $pObj->bclass))
		{
			if(checkResultSetElementHasArcher($pObj->aclass, $pObj->bclass))
			{	
				$s .= $formatter->format($pObj);
			}
		}
	}
	$s .= $formatter->getFoot();
	return $s;
}
function getResultSetElements($id,$formatter)
{
	$query = "SELECT resultSetElementID, ResultSetID, BowClassID, ArcherClassID FROM ResultSetElement WHERE ResultSetID=".$id.";";
	return getFormattedResult($query,$formatter);
}
function getResultSets($formatter)
{
	$query = "SELECT ResultSetID, ResultSetName FROM ResultSets;";
	return getFormattedResult($query,$formatter);
}
?>