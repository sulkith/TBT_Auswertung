<?php
	include_once("settings/settings.php");
	include_once("resource/sqldb.php");
	if(isset($_POST['pwd']))
	{
		if($_POST['pwd']==$createdbpass)
		{
			echo "Creating DB<br>";
			sqlcreatedb();
			sqlexecutesinglequery('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
			sqlexecutesinglequery('SET time_zone = "+00:00";');

			echo "Creating archerclasses<br>";
			sqlexecutesinglequery('CREATE TABLE IF NOT EXISTS archerclasses (
			  ClassID int(11) NOT NULL,
			  ClassName varchar(10) NOT NULL,
			  ClassComment varchar(100) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
			sqlexecutesinglequery('ALTER TABLE archerclasses
			  ADD PRIMARY KEY (ClassID);');
			sqlexecutesinglequery('ALTER TABLE archerclasses
			  MODIFY ClassID int(11) NOT NULL AUTO_INCREMENT;');


			echo "Creating bowclasses<br>";
			sqlexecutesinglequery('CREATE TABLE IF NOT EXISTS bowclasses (
			  ClassID int(11) NOT NULL,
			  ClassName varchar(10) NOT NULL,
			  ClassComment varchar(100) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
			sqlexecutesinglequery('ALTER TABLE bowclasses
			  ADD PRIMARY KEY (ClassID);');
			sqlexecutesinglequery('ALTER TABLE bowclasses
			  MODIFY ClassID int(11) NOT NULL AUTO_INCREMENT;');

			echo "Creating participation<br>";
			sqlexecutesinglequery('CREATE TABLE IF NOT EXISTS participation (
			  StartNr int(11) NOT NULL,
			  LastName varchar(30) NOT NULL,
			  FirstName varchar(30) NOT NULL,
			  Club varchar(100) NOT NULL,
			  EmailAddress varchar(50) NOT NULL,
			  BowClassID int(11) NOT NULL,
			  ArcherClassID int(11) NOT NULL,
			  Points int(11) NOT NULL,
			  Kills int(11) NOT NULL,
			  Veggie tinyint(1) NOT NULL,
			  RegisterDate date NOT NULL,
			  PaidDate date NOT NULL,
			  GroupNr int(11) NOT NULL,
			  TicketID varchar(10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
			sqlexecutesinglequery('ALTER TABLE participation
			  ADD PRIMARY KEY (StartNr);');
			sqlexecutesinglequery('ALTER TABLE participation
			  MODIFY StartNr int(11) NOT NULL AUTO_INCREMENT;');

			echo "Creating resultsetelement<br>";
			sqlexecutesinglequery('CREATE TABLE IF NOT EXISTS resultsetelement (
			  resultSetElementID int(11) NOT NULL,
			  ResultSetID int(11) NOT NULL,
			  BowClassID int(11) NOT NULL,
			  ArcherClassID int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
			sqlexecutesinglequery('ALTER TABLE resultsetelement
			  ADD PRIMARY KEY (resultSetElementID);');
			sqlexecutesinglequery('ALTER TABLE resultsetelement
			  MODIFY resultSetElementID int(11) NOT NULL AUTO_INCREMENT;');

			echo "Creating resultsets<br>";
			sqlexecutesinglequery('CREATE TABLE IF NOT EXISTS resultsets (
			  ResultSetID int(11) NOT NULL,
			  ResultSetName varchar(100) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
			sqlexecutesinglequery('ALTER TABLE resultsets
			  ADD PRIMARY KEY (ResultSetID);');
			sqlexecutesinglequery('ALTER TABLE resultsets
			  MODIFY ResultSetID int(11) NOT NULL AUTO_INCREMENT;');
		}
	}
?>
<html><head><title>DATENBANK ERSTELLEN</title></head><body>
<form action="init.php" method="post">
PLEASE TYPE IN PASSWORD
<input type=password name=pwd />
<input type="submit" name="action" value='OK' />
</form>
</body>
</html>