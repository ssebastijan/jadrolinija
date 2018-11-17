-- MySQL dump 10.13  Distrib 8.0.12, for osx10.14 (x86_64)
--
-- Host: localhost    Database: jadrolinija
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brod`
--

DROP TABLE IF EXISTS `brod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `brod` (
  `sifBrod` int(11) NOT NULL AUTO_INCREMENT,
  `nazivBrod` varchar(50) NOT NULL,
  `kapacitetPutnici` int(11) NOT NULL,
  PRIMARY KEY (`sifBrod`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `linija`
--

DROP TABLE IF EXISTS `linija`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `linija` (
  `sifraLinije` int(11) NOT NULL AUTO_INCREMENT,
  `satOdlaska` time NOT NULL,
  `satDolaska` time NOT NULL,
  `dan` varchar(50) NOT NULL,
  `sifraOdlaznogPristanista` int(11) NOT NULL,
  `sifraDolaznogPristanista` int(11) NOT NULL,
  PRIMARY KEY (`sifraLinije`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `luka`
--

DROP TABLE IF EXISTS `luka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `luka` (
  `sifraLuke` int(11) NOT NULL AUTO_INCREMENT,
  `nazivLuke` varchar(255) NOT NULL,
  `nazivMjesta` varchar(255) NOT NULL,
  `brojPristanista` int(11) NOT NULL,
  PRIMARY KEY (`sifraLuke`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pristaniste`
--

DROP TABLE IF EXISTS `pristaniste`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `pristaniste` (
  `sifPristanista` int(11) NOT NULL AUTO_INCREMENT,
  `sifraLuke` int(11) NOT NULL,
  `nazivPristanista` varchar(50) NOT NULL,
  `kapacitetBroda` int(11) NOT NULL,
  `sifraNadredenogPristanista` int(11) DEFAULT NULL,
  PRIMARY KEY (`sifPristanista`),
  KEY `sifraLuke` (`sifraLuke`),
  CONSTRAINT `pristaniste_ibfk_1` FOREIGN KEY (`sifraLuke`) REFERENCES `luka` (`sifraluke`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-15  7:11:14
