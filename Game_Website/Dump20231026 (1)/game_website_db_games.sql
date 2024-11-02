-- MariaDB dump 10.19  Distrib 10.4.18-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: game_website_db
-- ------------------------------------------------------
-- Server version	10.7.3-MariaDB

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
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `releaseDate` date NOT NULL,
  `ageRating` varchar(10) NOT NULL DEFAULT 'Not rated',
  `userID` int(11) NOT NULL,
  `genreID` int(11) NOT NULL,
  `description` longtext NOT NULL DEFAULT 'Not available',
  `gameWebsite` varchar(50) NOT NULL DEFAULT 'Not available',
  `gameTrailer` varchar(1024) NOT NULL DEFAULT 'Not available',
  PRIMARY KEY (`id`),
  KEY `idx_games_title_releaseDate_ageRating_userID_genreID` (`title`,`releaseDate`,`ageRating`,`userID`,`genreID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Fifa 21','uploads/FIFA_21_Standard_Edition_Cover.jpg','2021-03-09','Not rated',0,3,'Not available','Not available','Not available'),(2,'Call of Duty Modern Warfare 4','uploads/call_of_duty.jpg','2015-07-24','Not rated',0,5,'Not available','Not available','Not available'),(3,'Need for Speed Rivals','uploads/Need_for_Speed_Rivals_cover.jpg','2018-07-31','Not rated',0,11,'Not available','Not available','Not available'),(4,'Grand Theft Auto V','uploads/Grand_Theft_Auto_V.png','2022-05-15','Not rated',0,4,'Not available','Not available','Not available'),(5,'Forza horizon 4','uploads/Forza_Horizon_4_cover.jpg','2020-09-02','Not rated',0,11,'Not available','Not available','Not available'),(6,'Assassin Creed Valhalla','uploads/ACValhalla.jpg','2022-02-10','Not rated',0,7,'Not available','Not available','Not available'),(7,'Deadpool','uploads/Deadpool_video_game_cover.png','2018-11-30','Not rated',2,7,'Not available','https://deadpool.net','Not available'),(8,'Black Clover','uploads/th-3575416232.jpg','2020-07-09','Not rated',2,7,'Not available','http://blackclover.net','Not available');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-26 12:46:33
