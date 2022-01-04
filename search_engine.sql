-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: search_engine
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `_field`
--

DROP TABLE IF EXISTS `_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_field` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'имя поля',
  `selector` varchar(255) NOT NULL COMMENT 'CSS-выражение, позволяющее получить содержимое конкретного поля',
  `weight` float NOT NULL COMMENT 'релевантность (вес) поля от 0 до 1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COMMENT='поля на страницах сайтов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_field`
--

LOCK TABLES `_field` WRITE;
/*!40000 ALTER TABLE `_field` DISABLE KEYS */;
INSERT INTO `_field` VALUES (1,'title','title',1),(2,'body','body',0.8);
/*!40000 ALTER TABLE `_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_index`
--

DROP TABLE IF EXISTS `_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_index` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL COMMENT 'идентификатор страницы',
  `lemma_id` int NOT NULL COMMENT 'идентификатор леммы',
  `rank` float NOT NULL COMMENT 'ранг леммы на этой странице',
  PRIMARY KEY (`id`),
  KEY `lemma_id_idx` (`lemma_id`) /*!80000 INVISIBLE */,
  KEY `page_id_idx` (`page_id`),
  CONSTRAINT `lemma_id` FOREIGN KEY (`lemma_id`) REFERENCES `_lemma` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `page_id` FOREIGN KEY (`page_id`) REFERENCES `_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='поисковый индекс';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_index`
--

LOCK TABLES `_index` WRITE;
/*!40000 ALTER TABLE `_index` DISABLE KEYS */;
/*!40000 ALTER TABLE `_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_lemma`
--

DROP TABLE IF EXISTS `_lemma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_lemma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lemma` varchar(255) NOT NULL COMMENT 'нормальная форма слова',
  `frequency` int NOT NULL COMMENT 'количество страниц, на которых слово встречается хотя бы один раз. Максимальное значение не может превышать общее количество слов на сайте.',
  `site_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id_idx` (`site_id`),
  CONSTRAINT `site_id_2` FOREIGN KEY (`site_id`) REFERENCES `_site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='леммы, встречающиеся в текстах (см. справочно: лемматизация)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_lemma`
--

LOCK TABLES `_lemma` WRITE;
/*!40000 ALTER TABLE `_lemma` DISABLE KEYS */;
/*!40000 ALTER TABLE `_lemma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_page`
--

DROP TABLE IF EXISTS `_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_page` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` int NOT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `site_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id_idx` (`site_id`) /*!80000 INVISIBLE */,
  KEY `path_idx` (`path`(50)),
  CONSTRAINT `site_id` FOREIGN KEY (`site_id`) REFERENCES `_site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='проиндексированная страница';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_page`
--

LOCK TABLES `_page` WRITE;
/*!40000 ALTER TABLE `_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `_site`
--

DROP TABLE IF EXISTS `_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_site` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` enum('INDEXING','INDEXED','FAILED') NOT NULL,
  `status_time` datetime NOT NULL,
  `last_error` text,
  `url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_UNIQUE` (`url`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_site`
--

LOCK TABLES `_site` WRITE;
/*!40000 ALTER TABLE `_site` DISABLE KEYS */;
/*!40000 ALTER TABLE `_site` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-04 16:57:53
