-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: roomReser
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Block`
--

DROP TABLE IF EXISTS `Block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Block` (
  `blockId` int(11) NOT NULL AUTO_INCREMENT,
  `blockName` varchar(10) NOT NULL,
  PRIMARY KEY (`blockId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Block`
--

LOCK TABLES `Block` WRITE;
/*!40000 ALTER TABLE `Block` DISABLE KEYS */;
INSERT INTO `Block` VALUES (1,'A1');
/*!40000 ALTER TABLE `Block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Booking`
--

DROP TABLE IF EXISTS `Booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Booking` (
  `user` int(11) NOT NULL,
  `confirmedBy` int(11) NOT NULL,
  `madeAt` time NOT NULL,
  `madeOn` date NOT NULL,
  `roomId` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `description` varchar(300) DEFAULT NULL,
  `Start_Date` date NOT NULL DEFAULT '0000-00-00',
  `End_Date` date NOT NULL DEFAULT '0000-00-00',
  `Start_Time` varchar(10) NOT NULL DEFAULT '00:00:00',
  `End_Time` time NOT NULL DEFAULT '00:00:00',
  `Repeat_Type` char(9) NOT NULL DEFAULT 'None',
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`booking_id`),
  UNIQUE KEY `booking_id` (`booking_id`),
  KEY `user` (`user`),
  KEY `confirmedBy` (`confirmedBy`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Booking`
--

LOCK TABLES `Booking` WRITE;
/*!40000 ALTER TABLE `Booking` DISABLE KEYS */;
INSERT INTO `Booking` VALUES (1,2,'20:45:28','2011-11-15',2,0,'My Trybooking2','2011-11-10','2011-11-10','08:30:00','10:30:00','DAILY',1),(1,2,'20:45:28','2011-11-15',2,1,'My Trybooking2','2011-11-11','2011-11-11','08:30:00','10:30:00','DAILY',7),(1,2,'21:33:44','2011-11-09',2,1,'My Trybooking4','2011-11-08','2011-11-13','06:30:00','08:00:00','DAILY',5),(1,2,'21:44:44','2011-11-09',2,0,'My Trybooking5','2012-01-31','2012-03-31','06:30:00','08:00:00','MONTHLY',6),(1,2,'20:45:28','2011-11-15',2,1,'My Trybooking2','2011-11-10','2011-11-10','10:30:00','11:30:00','DAILY',3);
/*!40000 ALTER TABLE `Booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Building`
--

DROP TABLE IF EXISTS `Building`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Building` (
  `buildId` int(11) NOT NULL AUTO_INCREMENT,
  `buildingName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`buildId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Building`
--

LOCK TABLES `Building` WRITE;
/*!40000 ALTER TABLE `Building` DISABLE KEYS */;
INSERT INTO `Building` VALUES (1,'nilgiri'),(2,'vindhya'),(3,'Himalayas');
/*!40000 ALTER TABLE `Building` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Category`
--

DROP TABLE IF EXISTS `Category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Category` (
  `catId` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`catId`),
  UNIQUE KEY `catName` (`catName`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Category`
--

LOCK TABLES `Category` WRITE;
/*!40000 ALTER TABLE `Category` DISABLE KEYS */;
INSERT INTO `Category` VALUES (1,'Projector_Room',NULL),(2,'AC',NULL),(3,'Teach_lab',NULL),(4,'abhay','test');
/*!40000 ALTER TABLE `Category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Room`
--

DROP TABLE IF EXISTS `Room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Room` (
  `roomId` int(11) NOT NULL AUTO_INCREMENT,
  `roomName` varchar(8) NOT NULL,
  `buildingName` int(11) NOT NULL,
  `blockName` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `Capacity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`roomId`),
  UNIQUE KEY `roomName` (`roomName`),
  KEY `building` (`buildingName`),
  KEY `block` (`blockName`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Room`
--

LOCK TABLES `Room` WRITE;
/*!40000 ALTER TABLE `Room` DISABLE KEYS */;
INSERT INTO `Room` VALUES (1,'301_NIL',1,0,NULL,100),(2,'302_NIL',1,0,NULL,100),(3,'TL1',1,0,NULL,0),(4,'TL2',1,0,NULL,0),(5,'SH1',2,0,NULL,250),(6,'SH2',2,0,NULL,250),(10,'305_NIL',1,0,NULL,100),(8,'CR1',2,0,NULL,0),(9,'CR2',2,0,NULL,0),(11,'TS',3,0,NULL,0);
/*!40000 ALTER TABLE `Room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Room_Cat`
--

DROP TABLE IF EXISTS `Room_Cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Room_Cat` (
  `roomId` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  PRIMARY KEY (`roomId`,`catId`),
  KEY `catId` (`catId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Room_Cat`
--

LOCK TABLES `Room_Cat` WRITE;
/*!40000 ALTER TABLE `Room_Cat` DISABLE KEYS */;
INSERT INTO `Room_Cat` VALUES (1,1),(2,1),(3,3),(4,3),(5,1),(5,2),(6,1),(6,2),(8,1),(9,1);
/*!40000 ALTER TABLE `Room_Cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'user','pwd','parag.gupta@students.iiit.ac.in',0),(2,'su','supwd','su@students.iiit.ac.in',1),(3,'user1','user1','user1@students.iiit.ac.in',0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-11-16 19:07:56
