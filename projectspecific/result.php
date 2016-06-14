<?php 
include("resource/sqldb.php");
include("projectspecific/ArcherClass.php");
include("projectspecific/BowClass.php");
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
function getUnusedResultSetElementList()
{
	$erg = sqlexecutesinglequery("SELECT archerclasses.ClassID AS aclass, archerclasses.ClassName AS aname , 
	bowclasses.ClassNr AS bclass, bowclasses.ClassName AS bname FROM bowclasses, archerclasses;");
	while($pObj = mysql_fetch_object($erg))
	{
		if(!checkResultSetElementContentExists($pObj->aclass, $pObj->bclass))
		{
			echo "<li>".$pObj->aname." AND ".$pObj->bname."</li>";
		}
	}
}
function getResultSet($id)
{
	$query = "SELECT * FROM participation, ResultSetElement 
	WHERE Points!=-1 AND Points !=-2 AND 
	ResultSetElement.BowClassID = participation.BowClassID AND
	ResultSetElement.ArcherClassID = participation.ArcherClassID AND
	ResultSetElement.ResultSetID=".$id."
	ORDER BY StartNr, Kills, Points;";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	$rank = 1;
	while($pObj = mysql_fetch_object($erg))
	{
		formatTableLineForResult($rank,$pObj->StartNr,$pObj->FirstName,$pObj->LastName,
		$pObj->Club,$pObj->BowClassID,$pObj->ArcherClassID,$pObj->Points,$pObj->Kills,$pObj->GroupNr);
		$rank++;
	}
}
function getCompleteResult()
{
	$query = "SELECT * FROM participation WHERE Points!=-1 AND Points !=-2 ORDER BY StartNr, Kills, Points;";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	$rank = 1;
	while($pObj = mysql_fetch_object($erg))
	{
		formatTableLineForResult($rank,$pObj->StartNr,$pObj->FirstName,$pObj->LastName,
		$pObj->Club,$pObj->BowClassID,$pObj->ArcherClassID,$pObj->Points,$pObj->Kills,$pObj->GroupNr);
		$rank++;
	}
	$query = "SELECT * FROM participation WHERE Points=-1 OR Points =-2 ORDER BY StartNr ;";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	$rank = "-";
	while($pObj = mysql_fetch_object($erg))
	{
		formatTableLineForResult($rank,$pObj->StartNr,$pObj->FirstName,$pObj->LastName,
		$pObj->Club,$pObj->BowClassID,$pObj->ArcherClassID,$pObj->Points,$pObj->Kills,$pObj->GroupNr);
	}
}
function getResultColspan()
{
	echo "<colgroup>
	<col width=1*>
	<col width=1*>
	<col width=6*>
	<col width=6*>
	<col width=2*>
	<col width=2*>
	<col width=10*>
	<col width=2*>
	<col width=2*>
	<col width=2*>
	</colgroup>";
	
}
function formatTableLineForResult($rank, $StartNr, $firstName, $lastName, $club, $bclass, $aclass, $points, $kills, $group)
{
	echo "<tr>".
	"<td>".$rank."</td>".
	"<td>".$StartNr."</td>".
	"<td>".$firstName."</td>".
	"<td>".$lastName."</td>".
	"<td>".getArcherClassName($aclass)."</td>".
	"<td>".getBowClassName($bclass)."</td>".
	"<td>".$club."</td>";
	$pointstext = $points;
	if($points==-1)$pointstext="-";
	if($points==-2)$pointstext="-";
	$killstext = $kills;
	if($kills==-1)$killstext="-";
	$groupName = $group;
	if($group == -1)$groupName="-";
	if($group == -2)$groupName="-";
	echo "<td>".$pointstext."</td>".
	"<td>".$killstext."</td>".
	"<td>".$groupName."</td>".
	"</tr>";
	
	
}
function checkResultSetElementContentExists($aclass,$bclass)
{
	$query = "SELECT * FROM resultsetelement WHERE BowClassID=".$bclass." AND ArcherClassID=".$aclass.";";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;

}
function getResultSetElementsOption($id)
{
	$query = "SELECT resultSetElementID, ResultSetID, BowClassID, ArcherClassID FROM ResultSetElement WHERE ResultSetID=".$id.";";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<option value='".$pObj->resultSetElementID."'>".
		getArcherClassName($pObj->ArcherClassID)." AND ".getBowClassName($pObj->BowClassID).
		"</option>";
	}
}
function getResultSetElementsList($id)
{
	$query = "SELECT resultSetElementID, ResultSetID, BowClassID, ArcherClassID FROM ResultSetElement WHERE ResultSetID=".$id.";";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	echo "<ul>";
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<li>".
		getArcherClassName($pObj->ArcherClassID)." AND ".getBowClassName($pObj->BowClassID).
		"</li>";
	}
	echo "</ul>";
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
function getResultSetTable()
{
	$query = "SELECT ResultSetID, ResultSetName FROM ResultSets;";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<tr><td>".$pObj->ResultSetName."</td><td>";
		echo getResultSetElementsList($pObj->ResultSetID)."</td>";
		echo"<td><a href=\"ManageResultSetElements.php?rsid=".
		$pObj->ResultSetID."\">bearbeiten</a></td>
		<td><a href=\"ManageResultSets.php?remove=".
		$pObj->ResultSetID."\">entfernen</a></td></tr>";
	}
}

#SELECT DISTINCT archerclasses.ClassID, bowclasses.ClassNr FROM bowclasses, archerclasses, resultsetelement WHERE (resultsetelement.ArcherClassID!=archerclasses.ClassID AND resultsetelement.BowClassID!=bowclasses.ClassNr)




?>