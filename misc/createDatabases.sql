-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 18. Jun 2016 um 19:46
-- Server-Version: 5.6.26
-- PHP-Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `tbttournament`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `archerclasses`
--

CREATE TABLE IF NOT EXISTS `archerclasses` (
  `ClassID` int(11) NOT NULL,
  `ClassName` varchar(10) NOT NULL,
  `ClassComment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bowclasses`
--

CREATE TABLE IF NOT EXISTS `bowclasses` (
  `ClassID` int(11) NOT NULL,
  `ClassName` varchar(10) NOT NULL,
  `ClassComment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `participation`
--

CREATE TABLE IF NOT EXISTS `participation` (
  `StartNr` int(11) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `Club` varchar(100) NOT NULL,
  `EmailAddress` varchar(50) NOT NULL,
  `BowClassID` int(11) NOT NULL,
  `ArcherClassID` int(11) NOT NULL,
  `Points` int(11) NOT NULL,
  `Kills` int(11) NOT NULL,
  `Veggie` tinyint(1) NOT NULL,
  `RegisterDate` date NOT NULL,
  `PaidDate` date NOT NULL,
  `GroupNr` int(11) NOT NULL,
  `TicketID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `resultsetelement`
--

CREATE TABLE IF NOT EXISTS `resultsetelement` (
  `resultSetElementID` int(11) NOT NULL,
  `ResultSetID` int(11) NOT NULL,
  `BowClassID` int(11) NOT NULL,
  `ArcherClassID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `resultsets`
--

CREATE TABLE IF NOT EXISTS `resultsets` (
  `ResultSetID` int(11) NOT NULL,
  `ResultSetName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `archerclasses`
--
ALTER TABLE `archerclasses`
  ADD PRIMARY KEY (`ClassID`);

--
-- Indizes für die Tabelle `bowclasses`
--
ALTER TABLE `bowclasses`
  ADD PRIMARY KEY (`ClassID`);

--
-- Indizes für die Tabelle `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`StartNr`);

--
-- Indizes für die Tabelle `resultsetelement`
--
ALTER TABLE `resultsetelement`
  ADD PRIMARY KEY (`resultSetElementID`);

--
-- Indizes für die Tabelle `resultsets`
--
ALTER TABLE `resultsets`
  ADD PRIMARY KEY (`ResultSetID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `archerclasses`
--
ALTER TABLE `archerclasses`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `bowclasses`
--
ALTER TABLE `bowclasses`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `participation`
--
ALTER TABLE `participation`
  MODIFY `StartNr` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `resultsetelement`
--
ALTER TABLE `resultsetelement`
  MODIFY `resultSetElementID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `resultsets`
--
ALTER TABLE `resultsets`
  MODIFY `ResultSetID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
