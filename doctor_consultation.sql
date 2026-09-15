-- MySQL dump 10.13  Distrib 8.0.43, for macos15.4 (arm64)
--
-- Host: 127.0.0.1    Database: clinic
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `doctor_consultation`
--

DROP TABLE IF EXISTS `doctor_consultation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor_consultation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patientId` varchar(45) DEFAULT NULL,
  `quantity` varchar(45) DEFAULT NULL,
  `medicine_name` varchar(45) DEFAULT NULL,
  `dose` varchar(45) DEFAULT NULL,
  `route` varchar(45) DEFAULT NULL,
  `frequency` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `instruction` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_consultation`
--

LOCK TABLES `doctor_consultation` WRITE;
/*!40000 ALTER TABLE `doctor_consultation` DISABLE KEYS */;
INSERT INTO `doctor_consultation` VALUES (1,'8668','23','CARBOCISTEINE - MUCOLIEF 500MG','1 capsule','Oral','3 times a day','5 days','sfsfsfddsf','2026-08-31 23:05:08',NULL),(2,'8670','15','CARBOCISTEINE - MUCOLIEF 500MG','1 capsule','Oral','3 times a day','5 days','reterter','2026-08-31 23:20:11',NULL),(3,'8672','10','mefenamic acid - myrefen','1 capsule','Oral','3 times a day','5 days','qarwerwer','2026-08-31 23:31:35',NULL),(4,'8669','10','mefenamic acid - myrefen','1 Capsule','Oral','Once daily (one time a day)','5 days','take after every meal','2026-09-02 18:22:46','2026-09-02 18:26:57'),(5,'8669','10','Amoxicillin - Britamox','1 Tablet','Oral','Once daily (one time a day)','5 days','qrqwr','2026-09-02 18:26:57','2026-09-02 18:30:16'),(6,'8669','10','Amoxicillin - Britamox','1 Tablet','Parenteral (Injection)','Three times a day (every 8 hours)','5 days','ewfew','2026-09-02 18:30:16','2026-09-02 18:33:18'),(7,'8669','1','AMOXICILLIN 500MG - SAVERMOX','1 Tablet','Parenteral (Injection)','Once daily (one time a day)','5 days','wq','2026-09-02 18:33:18','2026-09-02 18:36:46'),(8,'8669','1','Amoxicillin - Britamox','1 Tablet','Oral','Once daily (one time a day)','5 days','ewr','2026-09-02 18:36:46','2026-09-02 21:23:49'),(9,'8671','4','Amoxicillin - Britamox','4 Tablet','Oral','Once daily (one time a day)','5 days','wtwe','2026-09-02 18:38:24','2026-09-02 19:11:12'),(10,'8671','1','Amoxicillin - Britamox','1 Tablet','Oral','Once daily (one time a day)','5 days','zxvz','2026-09-02 19:11:12','2026-09-02 21:53:07'),(11,'8671','15','Amoxicillin - Britamox','1 Tablet','Oral','Twice a day (every 12 hours)','5 days','Take after every meal','2026-09-02 21:53:07',NULL),(12,'8671','10','mefenamic acid - myrefen','1 Tablet','Oral','Once daily (one time a day)','5 days','Take after every meal','2026-09-02 21:53:07',NULL),(13,'8673','20','CARBOCISTEINE - MUCOLIEF 500MG','1 Tablet','Oral','Twice a day (every 12 hours)','5 days','','2026-09-03 00:14:37',NULL),(14,'8675','10','Amoxicillin - Britamox','1 Tablet','Oral','Once daily (one time a day)','5 days','after kaun or ma','2026-09-03 19:22:16',NULL);
/*!40000 ALTER TABLE `doctor_consultation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-15 10:49:33
