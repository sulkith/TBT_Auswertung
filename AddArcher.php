<?php
	include_once("resource/sqldb.php");
	include_once("resource/users.php");
	include_once 'resource/log.php';
	include 'resource/settings.php';
	session_start();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = sqlescape($_POST['name']);
	$lastname = sqlescape($_POST['lastname']);
	$bday = sqlescape($_POST['bday']);
	$club = sqlescape($_POST['club']);
	$sex = sqlescape($_POST['sex']);
	$sexmale = "0";
	?>
	fghkaslödjaslkdjaklsjd
	<?php
	if($sex=="male") $sexmale = "1";
	$email = sqlescape($_POST['email']);
	$query ="INSERT INTO `tbttest`.`archer` (`AID`, `NAME`, `LASTNAME`, `BDAY`, `SEXMALE`, `CLUB`, `EMAIL`) 	VALUES (NULL, '".$name."', '".$lastname."', '".$bday."', '".	$sexmale."', '".$club."', '".$email."');";
	//$query = "";
	sqlexecutesinglequery($query);
	}
?>
<form action="RegisterArcher.php" method="post">
Name: <input type="text" name="name" /><br>
Lastname: <input type="text" name="lastname" /><br>
Birthday: <input type="date" name="bday" /><br>
Club: <input type="text" name="club" /><br>
Sex:
<select name="sex">
  <option value="male">Male</option>
  <option value="female">Female</option>
</select><br>
EMail: <input type="text" name="email" />
<input type="submit" value="Anmelden" />
  </form>