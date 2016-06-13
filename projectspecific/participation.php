<?php
include_once("resource/sqldb.php");
class participationObject{
	private $mPID;
	private $mFirstName;
	private $mLastName;
	private $mClub;
	private $mEmail;
	private $mArcherClass;
	private $mBowClass;
	private $mPoints;
	private $mKills;
	private $mVeggie;
	private $mPaidDate;
	private $mGroupNr;
	
	function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if($i!=1)
        	error("participationObject has to be created with the PID");
        $f='__construct'.$i;
        call_user_func_array(array($this,$f),$a);
    }
   
    function __construct1($pid)
    {    			
    	//Get data from the database
        $query = "SELECT * FROM participation WHERE StartNr='".$pid."';";
		$erg = sqlexecutesinglequery($query);
		$pObj = mysql_fetch_object($erg);
		if(!$pObj){
			error("StartNr: ".$pid." wurde nicht gefunden");
		}
		$this->mPID = $pObj->StartNr;
		$this->mFirstName=$pObj->FirstName;
		$this->mLastName=$pObj->LastName;
		$this->mClub=$pObj->Club;
		$this->mEmail=$pObj->EmailAddress;
		$this->mBowClass=$pObj->BowClassID;
		$this->mArcherClass=$pObj->ArcherClassID;
		$this->mPoints=$pObj->Points;
		$this->mKills=$pObj->Kills;
		$this->mVeggie=$pObj->Veggie;
		$this->mPaidDate=$pObj->PaidDate;
		$this->mGroupNr=$pObj->GroupNr;
    }
	function getPoints()
	{
		return $this->mPoints;
	}
	function setPoints($p)
	{
		$this->mPoints = $p;
	}
	function getKills()
	{
		return $this->mKills;
	}
	function setKills($p)
	{
		$this->mKills = $p;
	}
	function getGroup()
	{
		return $this->mGroupNr;
	}
	function setGroup($p)
	{
		$this->mGroupNr = $p;
	}
	function getLastName()
	{
		return $this->mLastName;
	}
	function setLastName($p)
	{
		$this->mLastName = $p;
	}
	function getFirstName()
	{
		return $this->mFirstName;
	}
	function setFirstName($p)
	{
		$this->mFirstName = $p;
	}
	function getClub()
	{
		return $this->mClub;
	}
	function setClub($p)
	{
		$this->mClub = $p;
	}
	function getEmail()
	{
		return $this->mEmail;
	}
	function getBowClass()
	{
		return $this->mBowClass;
	}
	function getArcherClass()
	{
		return $this->mArcherClass;
	}
	function getVeggie()
	{
		return $this->mVeggie;
	}
	function isFinished()
	{
		if($this->mPoints>-1)
			return true;
		else
			return false;
	}
	function getCompleteName()
	{
		return $this->getFirstName()." ".$this->getLastName();
	}
	
}
function addParticipation($FirstName, $LastName, $Club, $EmailAddress, $BowClassID, $ArcherClassID, $Veggie, $PaidDate)
{
	#todo plaus BowClassID, ArcherClassID, PaidDate
	if(!checkArcherClassExists($ArcherClassID))
	{
		return 2;
	}
	if(!checkBowClassExists($ArcherClassID))
	{
		return 1;
	}
	sqlexecutesinglequery("INSERT INTO `participation` (`StartNr`, `LastName`, `FirstName`, `Club`, `EmailAddress`, `BowClassID`, `ArcherClassID`, `Points`, `Kills`, `Veggie`, `PaidDate`, `GroupNr`, `TicketID`) VALUES
(NULL, '".$LastName."', '".$FirstName."', '".$Club."', '".$EmailAddress."', ".$BowClassID.", ".$ArcherClassID.", -1, -1, ".$Veggie.", '".$PaidDate."', 0, '0');");
	return 0;
}
function getUserNameForUid($uid){
	$uid = intval($uid,10);
	$query = "SELECT * FROM users WHERE uid='".$uid."';";
	$erg = sqlexecutesinglequery($query);
	$userobj = mysql_fetch_object($erg);
	if(isset($userobj->user))
		return $userobj->user;
	else
		return null;
}


function addUngroupedUsersToSelectField(){
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE GroupNr = 0;";
	$erg = sqlexecutesinglequery($query);
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<option value=".$pObj->StartNr.">".$pObj->LastName." ".$pObj->FirstName."</option>\n";
	}
}

function addAllUsersToSelectField(){
	$query = "SELECT StartNr, FirstName, LastName FROM participation;";
	$erg = sqlexecutesinglequery($query);
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<option value=".$pObj->StartNr.">".$pObj->LastName." ".$pObj->FirstName."</option>\n";
	}
}
function addUsersToGroupEnumerate($groupID){
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE GroupNr = '".$groupID."';";
	$erg = sqlexecutesinglequery($query);
	#TODO add Link to modify user
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<li><a href=\"ModifyParticipation.php?pid=".$pObj->StartNr."\">".
		formatParticipationName($pObj->StartNr)."</a></li>\n";
	}
}
function formatParticipationName($pid)
{
	$pObj = new participationObject($pid);
	$points = $pObj->getPoints();
	$group = $pObj->getGroup();
	if($points == -2)
		$string = "<s>";
	else
		$string = "";
	
	$string .= " ".$pObj->getLastName()." ".$pObj->getFirstName();
	
	if($points == -2)
		$string .= "</s>";
	else if($points != -1)
		$string .=  " &radic;";
	return $string;
}
function checkParticipationExists($id)
{
	$query = "SELECT * FROM participation WHERE StartNr='".$id."';";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;
}

?>
