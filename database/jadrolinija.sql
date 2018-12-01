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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `karta`
--

DROP TABLE IF EXISTS `karta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `karta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sifPutnika` int(11) NOT NULL,
  `sifLinije` int(11) NOT NULL,
  `sifBroda` int(11) NOT NULL,
  `datKarte` datetime DEFAULT CURRENT_TIMESTAMP,
  `satPolaska` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sifPutnika` (`sifPutnika`),
  KEY `sifLinije` (`sifLinije`),
  KEY `sifBroda` (`sifBroda`),
  CONSTRAINT `karta_ibfk_1` FOREIGN KEY (`sifPutnika`) REFERENCES `putnik` (`sifputnik`) ON UPDATE CASCADE,
  CONSTRAINT `karta_ibfk_2` FOREIGN KEY (`sifLinije`) REFERENCES `linija` (`sifralinije`) ON UPDATE CASCADE,
  CONSTRAINT `karta_ibfk_3` FOREIGN KEY (`sifBroda`) REFERENCES `brod` (`sifbrod`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `provjeriLiniju` BEFORE INSERT ON `linija` FOR EACH ROW BEGIN
        IF TIME_TO_SEC(NEW.satDolaska) <= TIME_TO_SEC(NEW.satOdlaska) THEN
        	signal sqlstate '45001' set message_text = 'Vrijeme dolaska mora biti veće od vremena odlaska', MYSQL_ERRNO = 1001;
        END IF;
        IF NEW.sifraOdlaznogPristanista = NEW.sifraDolaznogPristanista THEN
        	signal sqlstate '45002' set message_text = 'Odlazno i dolazno pristanište moraju biti različiti', MYSQL_ERRNO = 1002;
        END IF;
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `updateLuka` BEFORE UPDATE ON `luka` FOR EACH ROW BEGIN
        DECLARE trenutnoPristanista INT DEFAULT 0;
        SELECT count(*) INTO trenutnoPristanista from pristaniste WHERE sifraLuke = new.sifraLuke;
        IF NEW.brojPristanista < trenutnoPristanista THEN 
          signal sqlstate '45003' SET message_text = 'Ne možete smanjiti broj pristaništa', MYSQL_ERRNO = 1003;
        END IF;
  END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `provjeriPistaniste` BEFORE INSERT ON `pristaniste` FOR EACH ROW BEGIN
    	DECLARE maxPristanista, trenutnoPristanista INT DEFAULT 0;
        SELECT count(*) INTO trenutnoPristanista from pristaniste WHERE sifraLuke = new.sifraLuke;
        select brojPristanista INTO maxPristanista from luka where sifraLuke = new.sifraLuke;
        
        IF trenutnoPristanista >= maxPristanista THEN
        	signal sqlstate '45000' set message_text = 'Prekoracen maksimalni broj pristanista', MYSQL_ERRNO = 1000;
        END IF;
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `putnik`
--

DROP TABLE IF EXISTS `putnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `putnik` (
  `sifPutnik` int(11) NOT NULL AUTO_INCREMENT,
  `imePutnik` varchar(50) NOT NULL,
  `prezimePutnik` varchar(50) NOT NULL,
  `brojPutovnice` varchar(50) NOT NULL,
  `drzavljanstvo` varchar(50) NOT NULL,
  PRIMARY KEY (`sifPutnik`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-01 10:52:50
