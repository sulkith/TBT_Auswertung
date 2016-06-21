<?php
include_once("resource/sqldb.php");
include_once("resource/error.php");
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
	private $mRegisteredDate;
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
        $query = "SELECT * FROM participation WHERE StartNr='".sqlescape($pid)."';";
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
		$this->mRegisteredDate=$pObj->RegisterDate;
    }
	function getPaidDate()
	{
		return $this->mPaidDate;
	}
	function getRegisteredDate()
	{
		return $this->mRegisteredDate;
	}
	function getPoints()
	{
		return $this->mPoints;
	}
	function setPoints($p)
	{
		$this->mPoints = $p;
		sqlexecutesinglequery("
			UPDATE participation SET Points = '".sqlescape($this->mPoints)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
		
	}
	function getKills()
	{
		return $this->mKills;
	}
	function setKills($p)
	{
		$this->mKills = $p;
		sqlexecutesinglequery("
			UPDATE participation SET Kills = '".sqlescape($this->mKills)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getGroup()
	{
		return $this->mGroupNr;
	}
	function setGroup($p)
	{
		$this->mGroupNr = intval($p);
		sqlexecutesinglequery("
			UPDATE participation SET GroupNr = '".sqlescape($this->mGroupNr)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getLastName()
	{
		return $this->mLastName;
	}
	function setLastName($p)
	{
		$this->mLastName = $p;
		sqlexecutesinglequery("
			UPDATE participation SET LastName = '".sqlescape($this->mLastName)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getFirstName()
	{
		return $this->mFirstName;
	}
	function setFirstName($p)
	{
		$this->mFirstName = $p;
		sqlexecutesinglequery("
			UPDATE participation SET FirstName = '".sqlescape($this->mFirstName)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getClub()
	{
		return $this->mClub;
	}
	function setClub($p)
	{
		$this->mClub = $p;
		sqlexecutesinglequery("
			UPDATE participation SET Club = '".sqlescape($this->mClub)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getEmail()
	{
		return $this->mEmail;
	}
	function setEmail($p)
	{
		$this->mEmail = $p;
		sqlexecutesinglequery("
			UPDATE participation SET EmailAddress = '".sqlescape($this->mEmail)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getBowClass()
	{
		return $this->mBowClass;
	}
	function setBowClass($p)
	{
		if(!checkBowClassExists($p))
			error("Invalid Bow Class ".$p);
		$this->mBowClass = $p;
		sqlexecutesinglequery("
			UPDATE participation SET BowClassID = '".sqlescape($this->mBowClass)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getArcherClass()
	{
		return $this->mArcherClass;
	}
	function setArcherClass($p)
	{
		if(!checkArcherClassExists($p))
			error("Invalid Archer Class ".$p);
		$this->mArcherClass = $p;
		sqlexecutesinglequery("
			UPDATE participation SET ArcherClassID = '".sqlescape($this->mArcherClass)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
	}
	function getVeggie()
	{
		return $this->mVeggie;
	}
	function setVeggie($p)
	{
		if($p!=true)
			$this->mVeggie = false;
		else
			$this->mVeggie=true;
		sqlexecutesinglequery("
			UPDATE participation SET Veggie = '".sqlescape($this->mVeggie)."' WHERE StartNr='".sqlescape($this->mPID)."';
		");
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
function payParticipation($id)
{
	sqlexecutesinglequery("UPDATE participation SET PaidDate =  CURRENT_DATE() WHERE StartNr='".sqlescape($id)."';");
}
function unPayParticipation($id)
{
	sqlexecutesinglequery("UPDATE participation SET PaidDate = \"0000-00-00\" WHERE StartNr='".sqlescape($id)."';");
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
	sqlexecutesinglequery("INSERT INTO `participation` (`StartNr`, `LastName`, `FirstName`, `Club`, `EmailAddress`, `BowClassID`, `ArcherClassID`, `Points`, `Kills`, `Veggie`, `RegisterDate`, `PaidDate`, `GroupNr`, `TicketID`) VALUES
(NULL, '".sqlescape($LastName)."', '".sqlescape($FirstName)."', '".sqlescape($Club)."', '".sqlescape($EmailAddress)."', '".sqlescape($BowClassID)."', '".sqlescape($ArcherClassID)."', -1, -1, '".sqlescape($Veggie)."', CURRENT_DATE(), '".sqlescape($PaidDate)."', 0, '0');");
	return 0;
}
function getUserNameForUid($uid){
	$uid = intval($uid,10);
	$query = "SELECT * FROM users WHERE uid='".sqlescape($uid)."';";
	$erg = sqlexecutesinglequery($query);
	$userobj = mysql_fetch_object($erg);
	if(isset($userobj->user))
		return $userobj->user;
	else
		return null;
}

function getNumAllParticipators()
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation;";
	return getNumEntries($query);
}
function getNumFinishedParticipators()
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE Points > 0;";
	return getNumEntries($query);
}
function getNumParticipatorsForGroup($groupID)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE GroupNr = '".sqlescape($groupID)."';";
	return getNumEntries($query);
}
function getNumParticipatorsNoPoints()
{
	$query = $query = "SELECT StartNr, FirstName, LastName FROM participation WHERE Points=-1 AND GroupNr != -1 ORDER BY LastName,FirstName;";
	return getNumEntries($query);
}
function getNumParticipatorsNoResult()
{
	$query = $query = "SELECT StartNr, FirstName, LastName FROM participation WHERE Points=-2 AND GroupNr != -1 ORDER BY LastName,FirstName;";
	return getNumEntries($query);
}

###############################################################
#  checking functions
###############################################################
function checkParticipationExists($id)
{
	$query = "SELECT * FROM participation WHERE StartNr='".sqlescape($id)."';";
	$erg = sqlexecutesinglequery($query);
	if(($userobj = mysql_fetch_object($erg)))
		return true;
	return false;
}

###############################################################
#  Formatter based Outputs
###############################################################
function getParticipationsForGroup($groupID, $formatter){
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE GroupNr = '".sqlescape($groupID)."' ORDER BY LastName,FirstName;;";
	return getFormattedResult($query,$formatter);
}
function getMissingParticipators($formatter)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE Points=-1 ORDER BY LastName,FirstName;";
	return getFormattedResult($query,$formatter);
}
function getParticipatorsNoPoints($formatter)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE Points=-1 AND GroupNr != -1 ORDER BY LastName,FirstName;";
	return getFormattedResult($query,$formatter);
}
function getParticipatorsNoResult($formatter)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE Points=-2 OR GroupNr = -1 ORDER BY LastName,FirstName;";
	return getFormattedResult($query,$formatter);
}
function getAllParticipators($formatter)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation ORDER BY LastName,FirstName;";
	return getFormattedResult($query,$formatter);
}
function getParticipatorsWithBowClass($bcid, $formatter)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE BowClassID='".sqlescape($bcid)."';";
	return getFormattedResult($query,$formatter);
}
function getParticipatorsWithArcherClass($acid, $formatter)
{
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE ArcherClassID='".sqlescape($acid)."';";
	return getFormattedResult($query,$formatter);
}
function getNotPaidParticipators($formatter)
{
	$query = "SELECT * FROM participation WHERE PaidDate=\"0000-00-00\" ORDER BY RegisterDate;";
	return getFormattedResult($query,$formatter);
}
function getPaidParticipators($formatter)
{
	$query = "SELECT * FROM participation WHERE PaidDate!=\"0000-00-00\" ORDER BY PaidDate;";
	return getFormattedResult($query,$formatter);
}
function getMaxGroup()
{
	$query = "SELECT MAX(GroupNr) as MAXGROUP FROM participation;";
	$result = sqlexecutesinglequery($query);
	$erg = mysql_fetch_object($result);
	if($erg)
		return $erg->MAXGROUP;
	return 0;
}

?>
