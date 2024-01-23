-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: crypto
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

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
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `msisdn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `referal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auto_records`
--

DROP TABLE IF EXISTS `auto_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auto_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `record_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_date` date NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sell` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_records`
--

LOCK TABLES `auto_records` WRITE;
/*!40000 ALTER TABLE `auto_records` DISABLE KEYS */;
INSERT INTO `auto_records` VALUES (1,'06:00 PM','2022-06-30','51','19085.81','0000:00','2022-06-30 11:30:03','2022-06-30 11:30:03'),(2,'09:00 PM','2022-06-30','74','18937.44','0000:00','2022-06-30 14:30:03','2022-06-30 14:30:03'),(3,'10:00 AM','2022-07-01','35','20133.25','0000:00','2022-07-01 03:30:01','2022-07-01 03:30:01'),(4,'02:00 PM','2022-07-01','30','19513.60','0000:00','2022-07-01 07:30:04','2022-07-01 07:30:04'),(5,'06:00 PM','2022-07-01','14','19181.34','0000:00','2022-07-01 11:30:01','2022-07-01 11:30:01'),(6,'09:00 PM','2022-07-01','39','19333.29','0000:00','2022-07-01 14:30:01','2022-07-01 14:30:01'),(7,'10:00 AM','2022-07-02','38','19153.18','0000:00','2022-07-02 03:30:04','2022-07-02 03:30:04'),(8,'02:00 PM','2022-07-02','52','19225.02','0000:00','2022-07-02 07:30:01','2022-07-02 07:30:01'),(9,'06:00 PM','2022-07-02','03','19240.83','0000:00','2022-07-02 11:30:03','2022-07-02 11:30:03'),(10,'09:00 PM','2022-07-02','28','19312.28','0000:00','2022-07-02 14:30:03','2022-07-02 14:30:03'),(11,'10:00 AM','2022-07-03','13','19261.73','0000:00','2022-07-03 03:30:05','2022-07-03 03:30:05'),(12,'02:00 PM','2022-07-03','83','19118.43','0000:00','2022-07-03 07:30:02','2022-07-03 07:30:02'),(13,'06:00 PM','2022-07-03','24','19132.64','0000:00','2022-07-03 11:30:04','2022-07-03 11:30:04'),(14,'09:00 PM','2022-07-03','90','19049.30','0000:00','2022-07-03 14:30:04','2022-07-03 14:30:04');
/*!40000 ALTER TABLE `auto_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block_numbers`
--

DROP TABLE IF EXISTS `block_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `block_numbers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block_numbers`
--

LOCK TABLES `block_numbers` WRITE;
/*!40000 ALTER TABLE `block_numbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `block_numbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_ins`
--

DROP TABLE IF EXISTS `cash_ins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cash_ins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_ins`
--

LOCK TABLES `cash_ins` WRITE;
/*!40000 ALTER TABLE `cash_ins` DISABLE KEYS */;
/*!40000 ALTER TABLE `cash_ins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_outs`
--

DROP TABLE IF EXISTS `cash_outs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cash_outs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_outs`
--

LOCK TABLES `cash_outs` WRITE;
/*!40000 ALTER TABLE `cash_outs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cash_outs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_records`
--

DROP TABLE IF EXISTS `custom_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `record_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_records`
--

LOCK TABLES `custom_records` WRITE;
/*!40000 ALTER TABLE `custom_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_records`
--

DROP TABLE IF EXISTS `live_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `live_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `record_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_date` date NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sell` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_records`
--

LOCK TABLES `live_records` WRITE;
/*!40000 ALTER TABLE `live_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lucky_numbers`
--

DROP TABLE IF EXISTS `lucky_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lucky_numbers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `section` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lucky_numbers`
--

LOCK TABLES `lucky_numbers` WRITE;
/*!40000 ALTER TABLE `lucky_numbers` DISABLE KEYS */;
INSERT INTO `lucky_numbers` VALUES (1,'51','2022-06-30','06:00 PM','2022-06-30 11:30:03','2022-06-30 11:30:03'),(2,'74','2022-06-30','09:00 PM','2022-06-30 14:30:03','2022-06-30 14:30:03'),(3,'35','2022-07-01','10:00 AM','2022-07-01 03:30:01','2022-07-01 03:30:01'),(4,'30','2022-07-01','02:00 PM','2022-07-01 07:30:04','2022-07-01 07:30:04'),(5,'14','2022-07-01','06:00 PM','2022-07-01 11:30:01','2022-07-01 11:30:01'),(6,'39','2022-07-01','09:00 PM','2022-07-01 14:30:01','2022-07-01 14:30:01'),(7,'38','2022-07-02','10:00 AM','2022-07-02 03:30:04','2022-07-02 03:30:04'),(8,'52','2022-07-02','02:00 PM','2022-07-02 07:30:01','2022-07-02 07:30:01'),(9,'03','2022-07-02','06:00 PM','2022-07-02 11:30:03','2022-07-02 11:30:03'),(10,'28','2022-07-02','09:00 PM','2022-07-02 14:30:03','2022-07-02 14:30:03'),(11,'13','2022-07-03','10:00 AM','2022-07-03 03:30:05','2022-07-03 03:30:05'),(12,'83','2022-07-03','02:00 PM','2022-07-03 07:30:02','2022-07-03 07:30:02'),(13,'24','2022-07-03','06:00 PM','2022-07-03 11:30:04','2022-07-03 11:30:04'),(14,'90','2022-07-03','09:00 PM','2022-07-03 14:30:04','2022-07-03 14:30:04');
/*!40000 ALTER TABLE `lucky_numbers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2019_12_14_000001_create_personal_access_tokens_table',2),(3,'2022_06_27_070938_create_agents_table',2),(4,'2022_06_29_045007_create_cash_ins_table',2),(5,'2022_06_29_045401_create_cash_outs_table',2),(6,'2022_06_29_045550_create_notifications_table',2),(7,'2022_06_29_045634_create_block_numbers_table',2),(8,'2022_06_29_045735_create_payments_table',2),(9,'2014_10_12_100000_create_password_resets_table',3),(10,'2019_08_19_000000_create_failed_jobs_table',3),(11,'2022_06_09_063759_create_live_records_table',3),(12,'2022_06_09_063812_create_custom_records_table',3),(13,'2022_06_09_063823_create_auto_records_table',3),(14,'2022_06_09_070005_create_sections_table',3),(15,'2022_06_13_065252_create_lucky_numbers_table',3),(16,'2022_06_23_043523_create_off_days_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `off_days`
--

DROP TABLE IF EXISTS `off_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `off_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `off_days`
--

LOCK TABLES `off_days` WRITE;
/*!40000 ALTER TABLE `off_days` DISABLE KEYS */;
INSERT INTO `off_days` VALUES (1,'2022-07-02','Sat','2022-07-01 17:35:02','2022-07-01 17:35:02'),(2,'2022-07-02','Sat','2022-07-01 17:35:05','2022-07-01 17:35:05'),(3,'2022-07-02','Sat','2022-07-01 17:35:07','2022-07-01 17:35:07'),(4,'2022-07-02','Sat','2022-07-01 17:35:10','2022-07-01 17:35:10'),(5,'2022-07-02','Sat','2022-07-01 17:35:12','2022-07-01 17:35:12'),(6,'2022-07-02','Sat','2022-07-01 17:35:15','2022-07-01 17:35:15'),(7,'2022-07-02','Sat','2022-07-01 17:35:17','2022-07-01 17:35:17'),(8,'2022-07-02','Sat','2022-07-01 17:35:20','2022-07-01 17:35:20'),(9,'2022-07-02','Sat','2022-07-01 17:35:22','2022-07-01 17:35:22'),(10,'2022-07-02','Sat','2022-07-01 17:35:25','2022-07-01 17:35:25'),(11,'2022-07-02','Sat','2022-07-01 17:35:27','2022-07-01 17:35:27'),(12,'2022-07-02','Sat','2022-07-01 17:35:30','2022-07-01 17:35:30'),(13,'2022-07-02','Sat','2022-07-01 17:35:33','2022-07-01 17:35:33'),(14,'2022-07-02','Sat','2022-07-01 17:35:35','2022-07-01 17:35:35'),(15,'2022-07-02','Sat','2022-07-01 17:35:38','2022-07-01 17:35:38'),(16,'2022-07-02','Sat','2022-07-01 17:35:40','2022-07-01 17:35:40'),(17,'2022-07-02','Sat','2022-07-01 17:35:43','2022-07-01 17:35:43'),(18,'2022-07-02','Sat','2022-07-01 17:35:45','2022-07-01 17:35:45'),(19,'2022-07-02','Sat','2022-07-01 17:35:47','2022-07-01 17:35:47'),(20,'2022-07-02','Sat','2022-07-01 17:35:50','2022-07-01 17:35:50'),(21,'2022-07-02','Sat','2022-07-01 17:35:52','2022-07-01 17:35:52'),(22,'2022-07-02','Sat','2022-07-01 17:35:55','2022-07-01 17:35:55'),(23,'2022-07-02','Sat','2022-07-01 17:35:57','2022-07-01 17:35:57'),(24,'2022-07-03','Sun','2022-07-02 17:35:02','2022-07-02 17:35:02'),(25,'2022-07-03','Sun','2022-07-02 17:35:04','2022-07-02 17:35:04'),(26,'2022-07-03','Sun','2022-07-02 17:35:06','2022-07-02 17:35:06'),(27,'2022-07-03','Sun','2022-07-02 17:35:09','2022-07-02 17:35:09'),(28,'2022-07-03','Sun','2022-07-02 17:35:11','2022-07-02 17:35:11'),(29,'2022-07-03','Sun','2022-07-02 17:35:14','2022-07-02 17:35:14'),(30,'2022-07-03','Sun','2022-07-02 17:35:16','2022-07-02 17:35:16'),(31,'2022-07-03','Sun','2022-07-02 17:35:19','2022-07-02 17:35:19'),(32,'2022-07-03','Sun','2022-07-02 17:35:21','2022-07-02 17:35:21'),(33,'2022-07-03','Sun','2022-07-02 17:35:24','2022-07-02 17:35:24'),(34,'2022-07-03','Sun','2022-07-02 17:35:26','2022-07-02 17:35:26'),(35,'2022-07-03','Sun','2022-07-02 17:35:29','2022-07-02 17:35:29'),(36,'2022-07-03','Sun','2022-07-02 17:35:31','2022-07-02 17:35:31'),(37,'2022-07-03','Sun','2022-07-02 17:35:34','2022-07-02 17:35:34'),(38,'2022-07-03','Sun','2022-07-02 17:35:36','2022-07-02 17:35:36'),(39,'2022-07-03','Sun','2022-07-02 17:35:39','2022-07-02 17:35:39'),(40,'2022-07-03','Sun','2022-07-02 17:35:41','2022-07-02 17:35:41'),(41,'2022-07-03','Sun','2022-07-02 17:35:43','2022-07-02 17:35:43'),(42,'2022-07-03','Sun','2022-07-02 17:35:46','2022-07-02 17:35:46'),(43,'2022-07-03','Sun','2022-07-02 17:35:48','2022-07-02 17:35:48'),(44,'2022-07-03','Sun','2022-07-02 17:35:51','2022-07-02 17:35:51'),(45,'2022-07-03','Sun','2022-07-02 17:35:53','2022-07-02 17:35:53'),(46,'2022-07-03','Sun','2022-07-02 17:35:56','2022-07-02 17:35:56'),(47,'2022-07-03','Sun','2022-07-02 17:35:58','2022-07-02 17:35:58');
/*!40000 ALTER TABLE `off_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section` time NOT NULL,
  `date` date NOT NULL,
  `key_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,'10:00:00','2022-06-30',0,'2022-06-30 09:34:46','2022-06-30 09:34:46'),(2,'14:00:00','2022-06-30',1,'2022-06-30 09:34:53','2022-06-30 09:34:53'),(3,'18:00:00','2022-06-30',2,'2022-06-30 09:34:57','2022-06-30 09:34:57'),(4,'21:00:00','2022-06-30',3,'2022-06-30 09:35:01','2022-06-30 09:35:01');
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `min_amount` int NOT NULL DEFAULT '0',
  `max_amount` int NOT NULL DEFAULT '0',
  `odd` int NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `version_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `force_update` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `msisdn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_win` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','09795864194','$2y$10$gpHlNhuMdIrrb9T6UaBHEeXELoYWjU8njbhR.Lo9jCbae8n3R9P1i','0',0,0,'owner',NULL,NULL,'2022-06-30 09:21:41','2022-06-30 09:21:41'),(2,'connectdoc','09266331136','$2y$10$NmEba0V87XBNPodN8NcCI./lrhoE5Q.Z2yzYFu1kCAhBxVqOxKT5u','0',0,0,'user',NULL,NULL,'2022-06-30 09:24:28','2022-06-30 09:24:28'),(3,'thihaaung','09791642548','$2y$10$7ohirEhp2zo1N.t0pjoXce7Y75uVI8MQrAYXcbtwYwd2RTrETSZ/C','0',0,0,'user',NULL,NULL,'2022-06-30 09:26:48','2022-06-30 09:26:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-03 14:56:59
