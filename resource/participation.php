<?php
include_once("permissions.php");
include_once("sqldb.php");
include_once("error.php");
include 'settings.php';
class userObject{
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
        	error("userObject has to be created with the UID");
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
function addUsersToGroupEnumerate($groupID){
	$query = "SELECT StartNr, FirstName, LastName FROM participation WHERE GroupNr = '".$groupID."';";
	$erg = sqlexecutesinglequery($query);
	while($pObj = mysql_fetch_object($erg))
	{
		echo "<li>".$pObj->LastName." ".$pObj->FirstName."</li>\n";
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

function getUidForUserName($name){
	$query = "SELECT * FROM users WHERE user='".$name."';";
	$erg = sqlexecutesinglequery($query);
	if(!($userobj = mysql_fetch_object($erg)))
		return -1;
	return $userobj->uid;
}

?>
