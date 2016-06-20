<?php
function sqlopenhandle(){
	include ("settings/settings.php");
	$chandle = mysql_connect($sqlhost, $sqldbuser, $sqldbpass) 
		or die("Connection Failure to Database");
	//echo "Connected to database server<br>";
	mysql_select_db($sqldbname, $chandle) or die ($sqldbname . " Database not found." . $sqldbuser);
	//echo "Database " .  $database . " is selected";
	return $chandle;
}
function sqlcreatedb(){
	include ("settings/settings.php");
	$chandle = mysql_connect($sqlhost, $sqldbuser, $sqldbpass) 
		or die("Connection Failure to Database");
	//echo "Connected to database server<br>";
	$ergebnis = sqlexecutequery($chandle, "CREATE DATABASE IF NOT EXISTS ".$sqldbname.";");
	mysql_select_db($sqldbname, $chandle) or die ($sqldbname . " Database not found." . $sqldbuser);
	//echo "Database " .  $database . " is selected";
	return $ergebnis;
}
function sqlclosehandle($chandle){
	mysql_close($chandle);
}
function sqlexecuteQuery($chandle, $query){
	$ergebnis = mysql_query($query);// WHERE user=$username AND hash=md5($password)");	
	if (!$ergebnis)
		die("Query Error-Cannot execute Query:".mysql_error());
	return $ergebnis;
}
function sqlexecutesinglequery($query){
	$chandle = sqlopenhandle();
	$ergebnis = sqlexecutequery($chandle, $query);
	sqlclosehandle($chandle);
	return $ergebnis;
}

function sqlopenhandleGlobal(){
	include ("settings/settings.php");
	$chandle = mysql_connect($sqlhost, $sqldbuser, $sqldbpass) 
		or die("Connection Failure to Database");
	return $chandle;
}
function sqlexecuteQuerytry($chandle, $query){
	$ergebnis = mysql_query($query);// WHERE user=$username AND hash=md5($password)");	
	if (!$ergebnis)
		echo "Query Error-Cannot execute Query:".mysql_error()."<br>";
	return $ergebnis;
}
function sqlexecutesinglequerytry($query){
	$chandle = sqlopenhandleGlobal();
	$ergebnis = sqlexecutequerytry($chandle, $query);
	sqlclosehandle($chandle);
	return $ergebnis;
}
function sqlescape($string){
	include ("settings/settings.php");
	return addslashes($string);
}
function getFormattedResult($query,$formatter)
{
	$resultString = $formatter->getHead();
	$erg = sqlexecutesinglequery($query);
	while($pObj = mysql_fetch_object($erg))
	{
		$resultString .= $formatter->format($pObj);
	}
	$resultString .= $formatter->getFoot();
	return $resultString;
}
function getNumEntries($query)
{
	$erg = sqlexecutesinglequery($query);
	$r = mysql_num_rows($erg);
	if($r == false)$r=0;
	return $r;
}
function getFormattedResultWithoutHead($query,$formatter)
{
	$resultString = "";
	$erg = sqlexecutesinglequery($query);
	while($pObj = mysql_fetch_object($erg))
	{
		$resultString .= $formatter->format($pObj);
	}
	return $resultString;
}
?>