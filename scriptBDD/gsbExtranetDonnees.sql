-- MySQL dump 10.19  Distrib 10.3.39-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gsbextranet
-- ------------------------------------------------------
-- Server version	10.3.39-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `historiqueconnexion`
--

DROP TABLE IF EXISTS `historiqueconnexion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historiqueconnexion` (
  `idMedecin` int(11) NOT NULL,
  `dateDebutLog` datetime NOT NULL,
  `dateFinLog` datetime DEFAULT NULL,
  PRIMARY KEY (`idMedecin`,`dateDebutLog`) USING BTREE,
  CONSTRAINT `historiqueconnexion_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historiqueconnexion`
--

LOCK TABLES `historiqueconnexion` WRITE;
/*!40000 ALTER TABLE `historiqueconnexion` DISABLE KEYS */;
INSERT INTO `historiqueconnexion` VALUES (1,'2024-05-01 08:00:00','2024-05-01 08:45:00'),(1,'2024-05-04 14:00:00','2024-05-04 14:20:00'),(2,'2024-05-02 09:15:00','2024-05-02 09:50:00'),(3,'2024-05-03 10:00:00','2024-05-03 10:30:00'),(4,'2024-05-05 16:00:00','2024-05-05 16:40:00'),(6,'2026-09-09 15:22:41','2026-09-09 15:22:41'),(6,'2026-09-09 15:22:53','2026-09-09 15:22:53');
/*!40000 ALTER TABLE `historiqueconnexion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medecin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `motDePasse` varchar(30) DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `rpps` varchar(10) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `dateDiplome` date DEFAULT NULL,
  `sport` tinyint(1) DEFAULT NULL,
  `dateConsentement` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medecin`
--

LOCK TABLES `medecin` WRITE;
/*!40000 ALTER TABLE `medecin` DISABLE KEYS */;
INSERT INTO `medecin` VALUES (1,'Dupont','Marie','0601020304','marie.dupont@mail.fr','1980-05-12','$2y$10$exempleHashMotDePasse1','2024-01-10 09:00:00','1000123456','','2005-06-20',0,'2024-01-10'),(2,'Martin','Jean','0611223344','jean.martin@mail.fr','1975-11-03','$2y$10$exempleHashMotDePasse2','2024-01-15 10:30:00','1000987654','','1999-09-15',1,'2024-01-15'),(3,'Bernard','Sophie','0622334455','sophie.bernard@mail.fr','1990-02-25','$2y$10$exempleHashMotDePasse3','2024-02-01 08:15:00','1000555667','','2015-07-01',0,'2024-02-01'),(4,'Petit','Lucas','0633445566','lucas.petit@mail.fr','1985-07-19','$2y$10$exempleHashMotDePasse4','2024-02-10 14:00:00','1000444332','','2010-06-30',1,'2024-02-10'),(5,'Durand','Claire','0644556677','claire.durand@mail.fr','1978-12-08','$2y$10$exempleHashMotDePasse5','2024-03-01 11:45:00','1000777889','','2003-05-22',0,'2024-03-01'),(6,NULL,NULL,NULL,'docteur1@gmail.com',NULL,'Docteur123.','2026-09-09 15:22:41',NULL,NULL,NULL,NULL,'2026-09-09'),(7,NULL,NULL,NULL,'docteur1@gmail.com',NULL,'Docteur123.','2026-09-09 15:22:53',NULL,NULL,NULL,NULL,'2026-09-09');
/*!40000 ALTER TABLE `medecin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medecinproduit`
--

DROP TABLE IF EXISTS `medecinproduit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medecinproduit` (
  `idMedecin` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Heure` time NOT NULL,
  PRIMARY KEY (`idMedecin`,`idProduit`,`Date`,`Heure`),
  KEY `idProduit` (`idProduit`),
  CONSTRAINT `medecinproduit_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`),
  CONSTRAINT `medecinproduit_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medecinproduit`
--

LOCK TABLES `medecinproduit` WRITE;
/*!40000 ALTER TABLE `medecinproduit` DISABLE KEYS */;
INSERT INTO `medecinproduit` VALUES (1,1,'2024-04-10','09:30:00'),(2,2,'2024-04-11','10:00:00'),(3,3,'2024-04-12','11:15:00'),(4,4,'2024-04-13','14:30:00'),(5,1,'2024-04-14','15:00:00');
/*!40000 ALTER TABLE `medecinproduit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medecinvisio`
--

DROP TABLE IF EXISTS `medecinvisio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medecinvisio` (
  `idMedecin` int(11) NOT NULL,
  `idVisio` int(11) NOT NULL,
  `dateInscription` date NOT NULL,
  PRIMARY KEY (`idMedecin`,`idVisio`),
  KEY `idVisio` (`idVisio`),
  CONSTRAINT `medecinvisio_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`),
  CONSTRAINT `medecinvisio_ibfk_2` FOREIGN KEY (`idVisio`) REFERENCES `visioconference` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medecinvisio`
--

LOCK TABLES `medecinvisio` WRITE;
/*!40000 ALTER TABLE `medecinvisio` DISABLE KEYS */;
INSERT INTO `medecinvisio` VALUES (1,1,'2024-04-01'),(2,1,'2024-04-01'),(3,2,'2024-04-08'),(4,3,'2024-04-15'),(5,3,'2024-04-16');
/*!40000 ALTER TABLE `medecinvisio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `objectif` mediumtext NOT NULL,
  `information` mediumtext NOT NULL,
  `effetIndesirable` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES (1,'Doliprane 1000mg','Traitement de la douleur et de la fièvre','Comprimé à prendre toutes les 6h maximum','Nausées, réactions cutanées rares'),(2,'Amoxicilline 500mg','Traitement antibiotique','Cure de 7 jours, 3 prises par jour','Troubles digestifs, allergies possibles'),(3,'Ventoline','Traitement de l’asthme','Inhalateur à utiliser en cas de crise','Tremblements, tachycardie'),(4,'Levothyrox 75µg','Traitement de l’hypothyroïdie','À prendre à jeun le matin','Palpitations, insomnie en cas de surdosage');
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visioconference`
--

DROP TABLE IF EXISTS `visioconference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visioconference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomVisio` varchar(100) DEFAULT NULL,
  `objectif` text DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `dateVisio` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visioconference`
--

LOCK TABLES `visioconference` WRITE;
/*!40000 ALTER TABLE `visioconference` DISABLE KEYS */;
INSERT INTO `visioconference` VALUES (1,'Présentation Doliprane','Présenter les nouveautés sur le Doliprane','https://visio.gsb.fr/room1','2024-04-05'),(2,'Formation Amoxicilline','Point sur les protocoles antibiotiques','https://visio.gsb.fr/room2','2024-04-12'),(3,'Webinaire Ventoline','Nouvelles recommandations asthme','https://visio.gsb.fr/room3','2024-04-20');
/*!40000 ALTER TABLE `visioconference` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-09 15:31:03
