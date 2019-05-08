-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2019 at 05:19 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_project_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `lnedit`
--

CREATE TABLE `lnedit` (
  `EditID` int(11) NOT NULL,
  `LineID_FK` int(11) NOT NULL,
  `Text` mediumtext NOT NULL,
  `Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LnNum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Line data';

-- --------------------------------------------------------

--
-- Table structure for table `lnperm`
--

CREATE TABLE `lnperm` (
  `LnPermID` int(11) NOT NULL,
  `LineID_FK` int(11) NOT NULL,
  `UserID_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Line permission';

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `NoteID` int(11) NOT NULL,
  `OwnID_FK` int(11) NOT NULL,
  `NoteName` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='NoteID + Note name';

-- --------------------------------------------------------

--
-- Table structure for table `notelist`
--

CREATE TABLE `notelist` (
  `NoteListID` int(11) NOT NULL,
  `UserID_FK` int(11) NOT NULL,
  `NoteID_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `noteln`
--

CREATE TABLE `noteln` (
  `LineID` int(11) NOT NULL,
  `NoteID_FK` int(11) NOT NULL,
  `OwnID_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Line list';

-- --------------------------------------------------------

--
-- Table structure for table `noteperm`
--

CREATE TABLE `noteperm` (
  `NotePermID` int(11) NOT NULL,
  `NoteID_FK` int(11) NOT NULL,
  `UserID_FK` int(11) NOT NULL,
  `Role` enum('ADMIN') NOT NULL DEFAULT 'ADMIN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User data';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lnedit`
--
ALTER TABLE `lnedit`
  ADD PRIMARY KEY (`EditID`),
  ADD KEY `LineID_FK` (`LineID_FK`);

--
-- Indexes for table `lnperm`
--
ALTER TABLE `lnperm`
  ADD PRIMARY KEY (`LnPermID`),
  ADD KEY `LineID_FK` (`LineID_FK`),
  ADD KEY `UserID_FK` (`UserID_FK`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`NoteID`),
  ADD KEY `OwnID_FK` (`OwnID_FK`);

--
-- Indexes for table `notelist`
--
ALTER TABLE `notelist`
  ADD PRIMARY KEY (`NoteListID`),
  ADD KEY `UserID_FK` (`UserID_FK`),
  ADD KEY `NoteID_FK` (`NoteID_FK`);

--
-- Indexes for table `noteln`
--
ALTER TABLE `noteln`
  ADD PRIMARY KEY (`LineID`),
  ADD KEY `NoteID_FK` (`NoteID_FK`),
  ADD KEY `OwnID_FK` (`OwnID_FK`);

--
-- Indexes for table `noteperm`
--
ALTER TABLE `noteperm`
  ADD PRIMARY KEY (`NotePermID`),
  ADD KEY `NoteID_FK` (`NoteID_FK`),
  ADD KEY `UserID_FK` (`UserID_FK`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lnedit`
--
ALTER TABLE `lnedit`
  MODIFY `EditID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lnperm`
--
ALTER TABLE `lnperm`
  MODIFY `LnPermID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `NoteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notelist`
--
ALTER TABLE `notelist`
  MODIFY `NoteListID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noteln`
--
ALTER TABLE `noteln`
  MODIFY `LineID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noteperm`
--
ALTER TABLE `noteperm`
  MODIFY `NotePermID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lnedit`
--
ALTER TABLE `lnedit`
  ADD CONSTRAINT `lnedit_ibfk_1` FOREIGN KEY (`LineID_FK`) REFERENCES `noteln` (`LineID`);

--
-- Constraints for table `lnperm`
--
ALTER TABLE `lnperm`
  ADD CONSTRAINT `lnperm_ibfk_1` FOREIGN KEY (`LineID_FK`) REFERENCES `noteln` (`LineID`),
  ADD CONSTRAINT `lnperm_ibfk_2` FOREIGN KEY (`UserID_FK`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`OwnID_FK`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `notelist`
--
ALTER TABLE `notelist`
  ADD CONSTRAINT `notelist_ibfk_1` FOREIGN KEY (`UserID_FK`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `notelist_ibfk_2` FOREIGN KEY (`NoteID_FK`) REFERENCES `note` (`NoteID`);

--
-- Constraints for table `noteln`
--
ALTER TABLE `noteln`
  ADD CONSTRAINT `noteln_ibfk_1` FOREIGN KEY (`NoteID_FK`) REFERENCES `note` (`NoteID`),
  ADD CONSTRAINT `noteln_ibfk_2` FOREIGN KEY (`OwnID_FK`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `noteperm`
--
ALTER TABLE `noteperm`
  ADD CONSTRAINT `noteperm_ibfk_1` FOREIGN KEY (`NoteID_FK`) REFERENCES `note` (`NoteID`),
  ADD CONSTRAINT `noteperm_ibfk_2` FOREIGN KEY (`UserID_FK`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
