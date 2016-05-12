-- MySQL dump 10.13  Distrib 5.6.26, for osx10.8 (x86_64)
--
-- Host: localhost    Database: Package_11000_empty_domain
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `AccountProfileContact`
--

DROP TABLE IF EXISTS `AccountProfileContact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AccountProfileContact` (
  `account_id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(11) NOT NULL,
  `facebook_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_image_height` int(11) NOT NULL,
  `facebook_image_width` int(11) NOT NULL,
  `has_profile` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`account_id`),
  KEY `image_id` (`image_id`,`has_profile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AccountProfileContact`
--

LOCK TABLES `AccountProfileContact` WRITE;
/*!40000 ALTER TABLE `AccountProfileContact` DISABLE KEYS */;
/*!40000 ALTER TABLE `AccountProfileContact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AppAdvert`
--

DROP TABLE IF EXISTS `AppAdvert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AppAdvert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_date` date NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `entered` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AppAdvert`
--

LOCK TABLES `AppAdvert` WRITE;
/*!40000 ALTER TABLE `AppAdvert` DISABLE KEYS */;
/*!40000 ALTER TABLE `AppAdvert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AppCustomPages`
--

DROP TABLE IF EXISTS `AppCustomPages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AppCustomPages` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `json` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AppCustomPages`
--

LOCK TABLES `AppCustomPages` WRITE;
/*!40000 ALTER TABLE `AppCustomPages` DISABLE KEYS */;
/*!40000 ALTER TABLE `AppCustomPages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AppNotification`
--

DROP TABLE IF EXISTS `AppNotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AppNotification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_date` date NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `entered` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AppNotification`
--

LOCK TABLES `AppNotification` WRITE;
/*!40000 ALTER TABLE `AppNotification` DISABLE KEYS */;
/*!40000 ALTER TABLE `AppNotification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Article`
--

DROP TABLE IF EXISTS `Article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `author_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publication_date` date NOT NULL DEFAULT '0000-00-00',
  `abstract` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_abstract` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `suspended_sitemgr` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `number_views` int(11) NOT NULL DEFAULT '0',
  `avg_review` int(11) NOT NULL DEFAULT '0',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `cat_1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_4_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_5_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level4_id` int(11) NOT NULL DEFAULT '0',
  `package_id` int(11) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `publication_date` (`publication_date`),
  KEY `status` (`status`),
  KEY `level` (`level`),
  KEY `account_id` (`account_id`),
  KEY `friendly_url` (`friendly_url`),
  KEY `random_number` (`random_number`),
  KEY `entered` (`entered`),
  KEY `updated` (`updated`),
  KEY `cat_1_id` (`cat_1_id`),
  KEY `parcat_1_level1_id` (`parcat_1_level1_id`),
  KEY `cat_2_id` (`cat_2_id`),
  KEY `parcat_2_level1_id` (`parcat_2_level1_id`),
  KEY `cat_3_id` (`cat_3_id`),
  KEY `parcat_3_level1_id` (`parcat_3_level1_id`),
  KEY `cat_4_id` (`cat_4_id`),
  KEY `parcat_4_level1_id` (`parcat_4_level1_id`),
  KEY `cat_5_id` (`cat_5_id`),
  KEY `parcat_5_level1_id` (`parcat_5_level1_id`),
  FULLTEXT KEY `fulltextsearch_keyword` (`fulltextsearch_keyword`),
  FULLTEXT KEY `fulltextsearch_where` (`fulltextsearch_where`),
  FULLTEXT KEY `fulltextsearch_title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Article`
--

LOCK TABLES `Article` WRITE;
/*!40000 ALTER TABLE `Article` DISABLE KEYS */;
/*!40000 ALTER TABLE `Article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ArticleCategory`
--

DROP TABLE IF EXISTS `ArticleCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ArticleCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `summary_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `active_article` int(11) NOT NULL DEFAULT '0',
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `count_sub` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `active_article` (`active_article`),
  KEY `title1` (`title`),
  KEY `friendly_url1` (`friendly_url`),
  FULLTEXT KEY `keywords` (`keywords`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ArticleCategory`
--

LOCK TABLES `ArticleCategory` WRITE;
/*!40000 ALTER TABLE `ArticleCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `ArticleCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ArticleLevel`
--

DROP TABLE IF EXISTS `ArticleLevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ArticleLevel` (
  `value` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaultlevel` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `detail` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `images` int(3) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`value`,`theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ArticleLevel`
--

LOCK TABLES `ArticleLevel` WRITE;
/*!40000 ALTER TABLE `ArticleLevel` DISABLE KEYS */;
INSERT INTO `ArticleLevel` VALUES (50,'article','y','y',5,30.00,'y','','y','default');
/*!40000 ALTER TABLE `ArticleLevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Banner`
--

DROP TABLE IF EXISTS `Banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P',
  `suspended_sitemgr` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `target_window` tinyint(1) NOT NULL DEFAULT '1',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'general',
  `content_line1` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `content_line2` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `destination_protocol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `display_url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `destination_url` text COLLATE utf8_unicode_ci NOT NULL,
  `unpaid_impressions` int(11) NOT NULL DEFAULT '0',
  `impressions` int(11) NOT NULL DEFAULT '0',
  `unlimited_impressions` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `expiration_setting` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `show_type` tinyint(4) NOT NULL DEFAULT '0',
  `script` text COLLATE utf8_unicode_ci,
  `package_id` int(11) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `section` (`section`),
  KEY `expiration_setting` (`expiration_setting`),
  KEY `impressions` (`impressions`),
  KEY `account_id` (`account_id`),
  KEY `category_id` (`category_id`),
  KEY `random_number` (`random_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Banner`
--

LOCK TABLES `Banner` WRITE;
/*!40000 ALTER TABLE `Banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `Banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BannerLevel`
--

DROP TABLE IF EXISTS `BannerLevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BannerLevel` (
  `value` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaultlevel` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `impression_block` mediumint(9) NOT NULL DEFAULT '0',
  `impression_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `popular` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`value`,`theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BannerLevel`
--

LOCK TABLES `BannerLevel` WRITE;
/*!40000 ALTER TABLE `BannerLevel` DISABLE KEYS */;
INSERT INTO `BannerLevel` VALUES (1,'leaderboard','y',50.00,728,90,1000,50.00,'y','n','','leaderboard','default'),(2,'large mobile ','n',20.00,320,100,1000,20.00,'y','n','','large mobile banner','default'),(3,'square','n',40.00,250,250,1000,40.00,'y','n','','square','default'),(4,'wide skyscraper','n',40.00,160,600,1000,40.00,'y','n','','wide skyscraper','default'),(50,'sponsored links','n',10.00,320,100,1000,10.00,'y','n','','sponsored links','default');
/*!40000 ALTER TABLE `BannerLevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BlogCategory`
--

DROP TABLE IF EXISTS `BlogCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root_id` int(11) NOT NULL DEFAULT '0',
  `left` int(11) NOT NULL DEFAULT '0',
  `right` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `summary_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `active_post` int(11) NOT NULL DEFAULT '0',
  `full_friendly_url` text COLLATE utf8_unicode_ci,
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `legacy_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `legacy_id` (`legacy_id`),
  KEY `category_id` (`category_id`),
  KEY `active_post` (`active_post`),
  KEY `title1` (`title`),
  KEY `friendly_url1` (`friendly_url`),
  KEY `level` (`level`),
  FULLTEXT KEY `keywords` (`keywords`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogCategory`
--

LOCK TABLES `BlogCategory` WRITE;
/*!40000 ALTER TABLE `BlogCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `BlogCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Blog_Category`
--

DROP TABLE IF EXISTS `Blog_Category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Blog_Category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `category_root_id` int(11) NOT NULL,
  `category_node_left` int(11) NOT NULL,
  `category_node_right` int(11) NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`),
  KEY `status` (`status`),
  KEY `category_status` (`category_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Blog_Category`
--

LOCK TABLES `Blog_Category` WRITE;
/*!40000 ALTER TABLE `Blog_Category` DISABLE KEYS */;
/*!40000 ALTER TABLE `Blog_Category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CheckIn`
--

DROP TABLE IF EXISTS `CheckIn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CheckIn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'listing' COMMENT 'listing/event',
  `member_id` int(11) NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quick_tip` text COLLATE utf8_unicode_ci,
  `checkin_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listing_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CheckIn`
--

LOCK TABLES `CheckIn` WRITE;
/*!40000 ALTER TABLE `CheckIn` DISABLE KEYS */;
/*!40000 ALTER TABLE `CheckIn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Claim`
--

DROP TABLE IF EXISTS `Claim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Claim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `listing_id` int(11) NOT NULL,
  `listing_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `step` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_location_1` int(11) NOT NULL,
  `new_location_1` int(11) NOT NULL,
  `old_location_2` int(11) NOT NULL,
  `new_location_2` int(11) NOT NULL,
  `old_location_3` int(11) NOT NULL,
  `new_location_3` int(11) NOT NULL,
  `old_location_4` int(11) NOT NULL,
  `new_location_4` int(11) NOT NULL,
  `old_location_5` int(11) NOT NULL,
  `new_location_5` int(11) NOT NULL,
  `old_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_zip_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `new_zip_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `old_level` tinyint(3) NOT NULL,
  `new_level` tinyint(3) NOT NULL,
  `old_listingtemplate_id` int(11) NOT NULL DEFAULT '0',
  `new_listingtemplate_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Claim`
--

LOCK TABLES `Claim` WRITE;
/*!40000 ALTER TABLE `Claim` DISABLE KEYS */;
/*!40000 ALTER TABLE `Claim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Classified`
--

DROP TABLE IF EXISTS `Classified`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Classified` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) NOT NULL DEFAULT '0',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contactname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summarydesc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_summarydesc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detaildesc` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `zip5` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `latitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `location_1` int(11) NOT NULL DEFAULT '0',
  `location_2` int(11) NOT NULL DEFAULT '0',
  `location_3` int(11) NOT NULL DEFAULT '0',
  `location_4` int(11) NOT NULL DEFAULT '0',
  `location_5` int(11) NOT NULL DEFAULT '0',
  `level` int(3) NOT NULL DEFAULT '0',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `suspended_sitemgr` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `cat_1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_4_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_5_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level4_id` int(11) NOT NULL DEFAULT '0',
  `classified_price` double(9,2) DEFAULT NULL,
  `number_views` int(11) NOT NULL DEFAULT '0',
  `map_zoom` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`location_1`),
  KEY `state_id` (`location_2`),
  KEY `region_id` (`location_3`),
  KEY `latitude` (`latitude`),
  KEY `longitude` (`longitude`),
  KEY `level` (`level`),
  KEY `status` (`status`),
  KEY `account_id` (`account_id`),
  KEY `city_id` (`location_4`),
  KEY `area_id` (`location_5`),
  KEY `title` (`title`),
  KEY `friendly_url` (`friendly_url`),
  KEY `random_number` (`random_number`),
  KEY `cat_1_id` (`cat_1_id`),
  KEY `parcat_1_level1_id` (`parcat_1_level1_id`),
  FULLTEXT KEY `fulltextsearch_keyword` (`fulltextsearch_keyword`),
  FULLTEXT KEY `fulltextsearch_where` (`fulltextsearch_where`),
  FULLTEXT KEY `fulltextsearch_title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Classified`
--

LOCK TABLES `Classified` WRITE;
/*!40000 ALTER TABLE `Classified` DISABLE KEYS */;
/*!40000 ALTER TABLE `Classified` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ClassifiedCategory`
--

DROP TABLE IF EXISTS `ClassifiedCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ClassifiedCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `summary_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `active_classified` int(11) NOT NULL DEFAULT '0',
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `count_sub` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `active_classified` (`active_classified`),
  KEY `title1` (`title`),
  KEY `friendly_url1` (`friendly_url`),
  FULLTEXT KEY `keywords` (`keywords`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClassifiedCategory`
--

LOCK TABLES `ClassifiedCategory` WRITE;
/*!40000 ALTER TABLE `ClassifiedCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `ClassifiedCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ClassifiedLevel`
--

DROP TABLE IF EXISTS `ClassifiedLevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ClassifiedLevel` (
  `value` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaultlevel` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `detail` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `images` int(3) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `popular` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`value`,`theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClassifiedLevel`
--

LOCK TABLES `ClassifiedLevel` WRITE;
/*!40000 ALTER TABLE `ClassifiedLevel` DISABLE KEYS */;
INSERT INTO `ClassifiedLevel` VALUES (50,'silver','n','n',0,0.00,'y','','','','default'),(30,'gold','n','y',3,25.00,'y','','y','','default'),(10,'diamond','y','y',7,50.00,'y','y','y','','default');
/*!40000 ALTER TABLE `ClassifiedLevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ClassifiedLevel_Field`
--

DROP TABLE IF EXISTS `ClassifiedLevel_Field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ClassifiedLevel_Field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(3) NOT NULL,
  `field` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `theme` (`theme`,`level`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClassifiedLevel_Field`
--

LOCK TABLES `ClassifiedLevel_Field` WRITE;
/*!40000 ALTER TABLE `ClassifiedLevel_Field` DISABLE KEYS */;
INSERT INTO `ClassifiedLevel_Field` VALUES (1,'default',10,'contact_name'),(2,'default',30,'contact_name'),(5,'default',10,'fax'),(7,'default',10,'url'),(9,'default',10,'long_description'),(10,'default',30,'long_description'),(13,'default',10,'main_image'),(14,'default',30,'main_image'),(15,'default',50,'main_image'),(22,'default',10,'summary_description'),(23,'default',30,'summary_description'),(24,'default',50,'summary_description'),(28,'default',10,'contact_phone'),(29,'default',30,'contact_phone'),(30,'default',50,'contact_phone'),(34,'default',10,'contact_email'),(35,'default',30,'contact_email'),(36,'default',50,'contact_email'),(40,'default',10,'price'),(41,'default',30,'price'),(42,'default',50,'price');
/*!40000 ALTER TABLE `ClassifiedLevel_Field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Classified_LocationCounter`
--

DROP TABLE IF EXISTS `Classified_LocationCounter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Classified_LocationCounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_level` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `full_friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Classified_LocationCounter`
--

LOCK TABLES `Classified_LocationCounter` WRITE;
/*!40000 ALTER TABLE `Classified_LocationCounter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Classified_LocationCounter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `reply_id` int(11) NOT NULL DEFAULT '0',
  `member_id` int(11) NOT NULL,
  `member_name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8_unicode_ci,
  `approved` int(1) NOT NULL,
  `legacy_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `legacy_id` (`legacy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Content`
--

DROP TABLE IF EXISTS `Content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'general',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sitemap` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `section` (`section`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Content`
--

LOCK TABLES `Content` WRITE;
/*!40000 ALTER TABLE `Content` DISABLE KEYS */;
INSERT INTO `Content` VALUES (1,'0000-00-00 00:00:00','Home Page','Home Page','','','','general','',0),(2,'0000-00-00 00:00:00','Home Page Bottom','Home Page Bottom','','','','general','',0),(3,'0000-00-00 00:00:00','Directory Results','Directory Results','','','','general','',0),(4,'0000-00-00 00:00:00','Directory Results Bottom','Directory Results Bottom','','','','general','',0),(5,'0000-00-00 00:00:00','Advertise with Us','Advertise with Us','','','','advertise_general','<h1>Sign up today - It\'s quick and simple!</h1>\r\n<p>Demo Directory is proud to announce its new directory service which is now available online to visitors and new suppliers. It boasts endless amounts of new features for customers and suppliers.</p>\r\n<p>Your directory items are also controlled entirely by you. We have a members interface where you can log in and change any details, add special promotions for Demo Directory customers and much more!</p>',0),(6,'0000-00-00 00:00:00','Advertise with Us Bottom','Advertise with Us Bottom','','','','advertise_general','',0),(7,'0000-00-00 00:00:00','Contact Us','Contact Us','','','','general','<h1>Contact Us</h1>\r\n<p>Need help with something? Get in touch with us and we\'ll do our best to answer your question as soon as possible.</p>',0),(8,'0000-00-00 00:00:00','Terms of Use','Terms of Use','','','','general','<h2>Terms of Use</h2>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque nulla sem, suscipit quis mattis et, imperdiet nec massa. Mauris faucibus fermentum aliquam. Aliquam commodo egestas iaculis. Pellentesque ut mauris nisi, commodo gravida elit. Phasellus eget diam eros. Donec ante velit, dignissim in congue eget, congue in quam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed ut ipsum nisi, ut pulvinar augue. Quisque blandit facilisis velit non ornare. Cras et urna nunc. Praesent non ante urna. Sed vehicula nulla sit amet lacus mattis scelerisque. Sed non felis arcu. Morbi congue aliquet ante, quis vestibulum ipsum gravida non. Sed ante felis, lobortis ac pharetra fermentum, aliquet id elit.<br /><br />Maecenas lobortis eleifend turpis, eu luctus sapien ultricies vitae. Aliquam erat volutpat. Nullam dolor odio, dapibus sed pellentesque nec, adipiscing eget quam. Integer mi sem, pharetra ac convallis eget, sodales in mauris. Suspendisse quis urna non nisl ullamcorper imperdiet a quis eros. Vivamus egestas posuere consequat. Nulla a commodo nunc. Morbi ut enim lectus, vitae pretium dui. Phasellus lacinia, lorem id malesuada luctus, enim augue fermentum augue, eu luctus dolor magna et turpis. Praesent vitae ornare mauris.<br /><br />Nam eget libero at tortor auctor placerat at vitae orci. Fusce tempus luctus dolor. Vivamus pharetra erat vitae ipsum pharetra ut tincidunt lacus pharetra. Sed viverra interdum fringilla. Aenean cursus nulla at neque luctus et pellentesque ante dignissim. Ut luctus odio et velit suscipit imperdiet. Cras semper, leo quis venenatis elementum, nibh diam blandit nulla, ut dictum ipsum lectus non diam. Vivamus ac convallis velit. Nulla est magna, bibendum eu luctus sed, dignissim in libero. Etiam sit amet purus ut odio mollis varius. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec non velit vel augue mollis blandit eu eu metus. Morbi dapibus porttitor scelerisque. Praesent ultricies erat ac nisi laoreet sit amet consequat leo fringilla. Fusce egestas neque ut nisl mattis eget dignissim elit accumsan. Phasellus mollis dapibus tristique. Sed ut velit non nibh sagittis ornare sed feugiat nibh.</p>',0),(9,'0000-00-00 00:00:00','Listing Advertisement','Listing Advertisement','','','','advertise_listing','',0),(10,'0000-00-00 00:00:00','Listing Home','Listing Home','','','','listing','',0),(11,'0000-00-00 00:00:00','Listing Home Bottom','Listing Home Bottom','','','','listing','',0),(12,'0000-00-00 00:00:00','Listing Results','Listing Results','','','','listing','',0),(13,'0000-00-00 00:00:00','Listing Results Bottom','Listing Results Bottom','','','','listing','',0),(14,'0000-00-00 00:00:00','Listing View All Categories','Listing View All Categories','','','','listing','',0),(15,'0000-00-00 00:00:00','Listing View All Categories Bottom','Listing View All Categories Bottom','','','','listing','',0),(16,'0000-00-00 00:00:00','Listing View All Locations','Listing View All Locations','','','','listing','',0),(17,'0000-00-00 00:00:00','Listing View All Locations Bottom','Listing View All Locations Bottom','','','','listing','',0),(18,'0000-00-00 00:00:00','Deal Home','Deal Home','','','','deal','',0),(19,'0000-00-00 00:00:00','Deal Home Bottom','Deal Home Bottom','','','','deal','',0),(20,'0000-00-00 00:00:00','Deal Results','Deal Results','','','','deal','',0),(21,'0000-00-00 00:00:00','Deal Results Bottom','Deal Results Bottom','','','','deal','',0),(22,'0000-00-00 00:00:00','Deal View All Categories','Deal View All Categories','','','','deal','',0),(23,'0000-00-00 00:00:00','Deal View All Categories Bottom','Deal View All Categories Bottom','','','','deal','',0),(24,'0000-00-00 00:00:00','Deal View All Locations','Deal View All Locations','','','','deal','',0),(25,'0000-00-00 00:00:00','Deal View All Locations Bottom','Deal View All Locations Bottom','','','','deal','',0),(26,'0000-00-00 00:00:00','Event Advertisement','Event Advertisement','','','','advertise_event','',0),(27,'0000-00-00 00:00:00','Event Home','Event Home','','','','event','',0),(28,'0000-00-00 00:00:00','Event Home Bottom','Event Home Bottom','','','','event','',0),(29,'0000-00-00 00:00:00','Event Results','Event Results','','','','event','',0),(30,'0000-00-00 00:00:00','Event Results Bottom','Event Results Bottom','','','','event','',0),(31,'0000-00-00 00:00:00','Event View All Categories','Event View All Categories','','','','event','',0),(32,'0000-00-00 00:00:00','Event View All Categories Bottom','Event View All Categories Bottom','','','','event','',0),(33,'0000-00-00 00:00:00','Event View All Locations','Event View All Locations','','','','event','',0),(34,'0000-00-00 00:00:00','Event View All Locations Bottom','Event View All Locations Bottom','','','','event','',0),(35,'0000-00-00 00:00:00','Banner Advertisement','','','','','advertise_banner','<ul>\r\n<li>Display targeted ads that match the directory content</li>\r\n<li>Reach people seeking information on products and services in the directory</li>\r\n<li>Build brand recognition</li>\r\n<li>Return on Investment - Start getting customers in minutes!</li>\r\n</ul>',0),(36,'0000-00-00 00:00:00','Classified Advertisement','Classified Advertisement','','','','advertise_classified','',0),(37,'0000-00-00 00:00:00','Classified Home','Classified Home','','','','classified','',0),(38,'0000-00-00 00:00:00','Classified Home Bottom','Classified Home Bottom','','','','classified','',0),(39,'0000-00-00 00:00:00','Classified Results','Classified Results','','','','classified','',0),(40,'0000-00-00 00:00:00','Classified Results Bottom','Classified Results Bottom','','','','classified','',0),(41,'0000-00-00 00:00:00','Classified View All Categories','Classified View All Categories','','','','classified','',0),(42,'0000-00-00 00:00:00','Classified View All Categories Bottom','Classified View All Categories Bottom','','','','classified','',0),(43,'0000-00-00 00:00:00','Classified View All Locations','Classified View All Locations','','','','classified','',0),(44,'0000-00-00 00:00:00','Classified View All Locations Bottom','Classified View All Locations Bottom','','','','classified','',0),(45,'0000-00-00 00:00:00','Article Advertisement','','','','','advertise_article','<p>Post your article and become known to prospective clients and customers.</p>',0),(46,'0000-00-00 00:00:00','Article Home','Article Home','','','','article','',0),(47,'0000-00-00 00:00:00','Article Home Bottom','Article Home Bottom','','','','article','',0),(48,'0000-00-00 00:00:00','Article Results','Article Results','','','','article','',0),(49,'0000-00-00 00:00:00','Article Results Bottom','Article Results Bottom','','','','article','',0),(50,'0000-00-00 00:00:00','Article View All Categories','Article View All Categories','','','','article','',0),(51,'0000-00-00 00:00:00','Article View All Categories Bottom','Article View All Categories Bottom','','','','article','',0),(52,'0000-00-00 00:00:00','Sponsor Home','Sponsor Home','','','','member','',0),(53,'0000-00-00 00:00:00','Sponsor Home Bottom','Sponsor Home Bottom','','','','member','',0),(54,'0000-00-00 00:00:00','Manage Account','Manage Account','','','','member','',0),(55,'0000-00-00 00:00:00','Manage Account Bottom','Manage Account Bottom','','','','member','',0),(56,'0000-00-00 00:00:00','Sponsor Help','Sponsor Help','','','','member','',0),(57,'0000-00-00 00:00:00','Sponsor Help Bottom','Sponsor Help Bottom','','','','member','',0),(58,'0000-00-00 00:00:00','Event Change Level','Event Change Level','','','','member','',0),(59,'0000-00-00 00:00:00','Listing Change Level','Listing Change Level','','','','member','',0),(60,'0000-00-00 00:00:00','Transaction','Transaction','','','','member','',0),(61,'0000-00-00 00:00:00','Transaction Bottom','Transaction Bottom','','','','member','',0),(62,'0000-00-00 00:00:00','Sitemap','Sitemap','','','','general','',0),(63,'0000-00-00 00:00:00','Error Page','Error Page','Page not found','','','general','<h1 style=\"text-align: center;\"><span style=\"color: #efefef; font-size: 300px;\">404</span></h1><p style=\"text-align: center;\">&nbsp;</p><h2 style=\"text-align: center;\"><span style=\"color: #cdcdcd; font-size: 50px;\">Oops</span></h2><p style=\"text-align: center;\"><span style=\"color: #999999;\">&nbsp;</span></p><p style=\"text-align: center;\"><span style=\"color: #999999; font-size: 24px;\">We couldn\'t find the page you are looking for.</span></p><p style=\"text-align: center;\"><span style=\"color: #999999;\">&nbsp;</span></p><p style=\"text-align: center;\"><span style=\"color: #999999; font-size: 16px;\">Have you tried the search option to easily find what you are looking for?﻿</span></p><p style=\"text-align: center;\"><span style=\"color: #999999;\">...</span></p>',0),(64,'0000-00-00 00:00:00','Maintenance Page','Maintenance Page','','','','general','<p style=\"color: #efefef; font-size: 150px; text-align: center;\"><span class=\"fa-stack fa-lg\"> <em class=\"fa fa-circle fa-stack-2x\"></em>&nbsp; <em class=\"fa fa-coffee fa-stack-1x fa-inverse\"></em></span></p><h1 style=\"text-align: center;\"><span style=\"color: #cdcdcd; font-size: 30px; text-transform: uppercase;\">We are under maintenance</span></h1><p style=\"text-align: center;\"><span style=\"color: #999999;\">&nbsp;</span></p><p style=\"text-align: center;\"><span style=\"color: #999999; font-size: 16px;\">Please come back later</span></p>',0),(65,'0000-00-00 00:00:00','Profile Page','Profile Page','','','','general','',0),(66,'0000-00-00 00:00:00','Profile Page Login','Log in','','','','general','<h2>Welcome back! It\'s always good to see you here again!</h2><p>&nbsp;</p><p style=\"color: #eeeeee; font-size: 150px; text-align: center;\"><span class=\"fa-stack\"><em class=\"fa fa-circle fa-stack-2x\"></em>&nbsp;<em class=\"fa fa-sign-in fa-stack-1x fa-inverse\"></em></span>&nbsp;</p><p style=\"font-size: 1.2em;\">Join us today and stay connected to businesses around the world. <span>With a single login using your computer, tablet, phone or our app!</span></p><p>&nbsp;</p><p>&nbsp;</p>',0),(67,'0000-00-00 00:00:00','Profile Page Bottom','Profile Page Bottom','','','','general','',0),(68,'0000-00-00 00:00:00','Add Profile Page','Add Profile Page','','','','general','<h2>Sign up today and join our community!</h2><p>&nbsp;</p><p style=\"color: #eeeeee; font-size: 150px; text-align: center;\"><span class=\"fa-stack\"><em class=\"fa fa-circle fa-stack-2x\"></em>&nbsp;<em class=\"fa fa-users fa-stack-1x fa-inverse\"></em></span>&nbsp;</p><p style=\"font-size: 1.2em;\">Join us today and stay connected to businesses around the world. <span>With a single login using your computer, tablet, phone or our app!</span></p><p>&nbsp;</p><p>&nbsp;</p>',0),(69,'0000-00-00 00:00:00','Packages Offer','Packages Offer','','','','advertise_general','',0),(70,'0000-00-00 00:00:00','Blog Home','Blog Home','','','','blog','',0),(71,'0000-00-00 00:00:00','Blog Home Bottom','Blog Home Bottom','','','','blog','',0),(72,'0000-00-00 00:00:00','Blog Results','Blog Results','','','','blog','',0),(73,'0000-00-00 00:00:00','Blog Results Bottom','Blog Results Bottom','','','','blog','',0),(74,'0000-00-00 00:00:00','Blog View All Categories','Blog View All Categories','','','','blog','',0),(75,'0000-00-00 00:00:00','Blog View All Categories Bottom','Blog View All Categories Bottom','','','','blog','',0),(76,'0000-00-00 00:00:00','Classified Change Level','Classified Change Level','','','','member','',0),(77,'0000-00-00 00:00:00','Leads Form','Enquire','','','','general','<h1>Did you not find what you\'re looking for?</h1> \r\n<p>Please, let us know more about what you\'re looking for.<br>We\'d like to know a few details so we can present you with the best options available.</p>',0),(78,'0000-00-00 00:00:00','Privacy Policy','Privacy Policy','','','','general','<h2>Privacy Policy</h2>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque nulla sem, suscipit quis mattis et, imperdiet nec massa. Mauris faucibus fermentum aliquam. Aliquam commodo egestas iaculis. Pellentesque ut mauris nisi, commodo gravida elit. Phasellus eget diam eros. Donec ante velit, dignissim in congue eget, congue in quam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed ut ipsum nisi, ut pulvinar augue. Quisque blandit facilisis velit non ornare. Cras et urna nunc. Praesent non ante urna. Sed vehicula nulla sit amet lacus mattis scelerisque. Sed non felis arcu. Morbi congue aliquet ante, quis vestibulum ipsum gravida non. Sed ante felis, lobortis ac pharetra fermentum, aliquet id elit.<br /><br />Maecenas lobortis eleifend turpis, eu luctus sapien ultricies vitae. Aliquam erat volutpat. Nullam dolor odio, dapibus sed pellentesque nec, adipiscing eget quam. Integer mi sem, pharetra ac convallis eget, sodales in mauris. Suspendisse quis urna non nisl ullamcorper imperdiet a quis eros. Vivamus egestas posuere consequat. Nulla a commodo nunc. Morbi ut enim lectus, vitae pretium dui. Phasellus lacinia, lorem id malesuada luctus, enim augue fermentum augue, eu luctus dolor magna et turpis. Praesent vitae ornare mauris.<br /><br />Nam eget libero at tortor auctor placerat at vitae orci. Fusce tempus luctus dolor. Vivamus pharetra erat vitae ipsum pharetra ut tincidunt lacus pharetra. Sed viverra interdum fringilla. Aenean cursus nulla at neque luctus et pellentesque ante dignissim. Ut luctus odio et velit suscipit imperdiet. Cras semper, leo quis venenatis elementum, nibh diam blandit nulla, ut dictum ipsum lectus non diam. Vivamus ac convallis velit. Nulla est magna, bibendum eu luctus sed, dignissim in libero. Etiam sit amet purus ut odio mollis varius. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec non velit vel augue mollis blandit eu eu metus. Morbi dapibus porttitor scelerisque. Praesent ultricies erat ac nisi laoreet sit amet consequat leo fringilla. Fusce egestas neque ut nisl mattis eget dignissim elit accumsan. Phasellus mollis dapibus tristique. Sed ut velit non nibh sagittis ornare sed feugiat nibh.</p>',0),(79,'0000-00-00 00:00:00','Footer','','','','','general','<div style=\"padding:40px 0; background: url(/assets/images/bg-downloadapps.png) no-repeat center bottom; \"><div class=\"container\"><div class=\"row\"><div class=\"col-sm-2 text-right text-center-sm\"><br><a href=\"https://play.google.com/store/apps/details?id=com.arcasolutions\" style=\"font-size:20px; font-weight:300; line-height:1;\">Available on the Play Store</a></div><div class=\"col-sm-8\"><br><p class=\"text-uppercase text-center\" style=\"font-size:24px; font-weight:300;\">Download our App</p></div><div class=\"col-sm-2 text-left text-center-sm\"><br><a href=\"https://itunes.apple.com/br/app/edirectory/id337135168?mt=8\" style=\"font-size:20px; font-weight:300; line-height:1;\">Available on the Apple Store</a></div></div></div></div>',0),(80,'0000-00-00 00:00:00','FAQ','FAQ','','','','faq','',0);
/*!40000 ALTER TABLE `Content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CustomInvoice`
--

DROP TABLE IF EXISTS `CustomInvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CustomInvoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sent_date` text COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `sent` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `completed` char(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `paid` (`paid`),
  KEY `sent` (`sent`),
  KEY `completed` (`completed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CustomInvoice`
--

LOCK TABLES `CustomInvoice` WRITE;
/*!40000 ALTER TABLE `CustomInvoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `CustomInvoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CustomInvoice_Items`
--

DROP TABLE IF EXISTS `CustomInvoice_Items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CustomInvoice_Items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `custominvoice_id` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `custominvoice_id` (`custominvoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CustomInvoice_Items`
--

LOCK TABLES `CustomInvoice_Items` WRITE;
/*!40000 ALTER TABLE `CustomInvoice_Items` DISABLE KEYS */;
/*!40000 ALTER TABLE `CustomInvoice_Items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CustomText`
--

DROP TABLE IF EXISTS `CustomText`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CustomText` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CustomText`
--

LOCK TABLES `CustomText` WRITE;
/*!40000 ALTER TABLE `CustomText` DISABLE KEYS */;
INSERT INTO `CustomText` VALUES ('header_title','Demodirectory'),('header_author','Arca Solutions'),('header_description',''),('header_keywords',''),('footer_copyright',''),('claim_textlink','Is this your listing?'),('promotion_default_conditions','There is a limit of 1 deal per person. The promotional value of this deal expires in 3 months. Deal must be presented in order to receive discount. This deal is not valid for cash back, can only be used once, does not cover tax or gratuities. This deal can not be combined with other offers.'),('payment_tax_label','Sales Tax');
/*!40000 ALTER TABLE `CustomText` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Discount_Code`
--

DROP TABLE IF EXISTS `Discount_Code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Discount_Code` (
  `id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  `recurring` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `listing` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `event` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `banner` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `classified` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `article` char(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Discount_Code`
--

LOCK TABLES `Discount_Code` WRITE;
/*!40000 ALTER TABLE `Discount_Code` DISABLE KEYS */;
/*!40000 ALTER TABLE `Discount_Code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Editor_Choice`
--

DROP TABLE IF EXISTS `Editor_Choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Editor_Choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `available` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `available` (`available`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Editor_Choice`
--

LOCK TABLES `Editor_Choice` WRITE;
/*!40000 ALTER TABLE `Editor_Choice` DISABLE KEYS */;
/*!40000 ALTER TABLE `Editor_Choice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Email_Notification`
--

DROP TABLE IF EXISTS `Email_Notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Email_Notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `days` tinyint(3) NOT NULL DEFAULT '0',
  `deactivate` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bcc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_type` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `use_variables` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `deactivate` (`deactivate`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Email_Notification`
--

LOCK TABLES `Email_Notification` WRITE;
/*!40000 ALTER TABLE `Email_Notification` DISABLE KEYS */;
INSERT INTO `Email_Notification` VALUES (1,'30 day renewal reminder',30,'0','0000-00-00 00:00:00','','Listing renewal notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,LISTING_TITLE,LISTING_RENEWAL_DATE,DAYS_INTERVAL,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(2,'15 day renewal reminder',15,'0','0000-00-00 00:00:00','','Listing renewal notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,LISTING_TITLE,LISTING_RENEWAL_DATE,DAYS_INTERVAL,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(3,'7 day renewal reminder',7,'0','0000-00-00 00:00:00','','Listing renewal notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,LISTING_TITLE,LISTING_RENEWAL_DATE,DAYS_INTERVAL,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(4,'1 day renewal reminder',1,'0','0000-00-00 00:00:00','','Listing renewal notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,LISTING_TITLE,LISTING_RENEWAL_DATE,DAYS_INTERVAL,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(5,'Sponsor Account Create (sitemgr area)',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Account','text/plain','Dear ACCOUNT_NAME,\r\n\r\nThank you for signing up for an account in DEFAULT_URL\r\nLogin to manage your account with the username and password below.\r\n\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nUsername: ACCOUNT_USERNAME\r\nPassword: ACCOUNT_PASSWORD\r\n\r\nDEFAULT_URL','ACCOUNT_NAME,ACCOUNT_USERNAME,ACCOUNT_PASSWORD,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(6,'Sponsor Account Update (sitemgr area)',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Account','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour account is updated in DEFAULT_URL\r\nLogin to manage your account with the username and password below.\r\n\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nUsername: ACCOUNT_USERNAME\r\nPassword: ACCOUNT_PASSWORD\r\n\r\nDEFAULT_URL','ACCOUNT_NAME,ACCOUNT_USERNAME,ACCOUNT_PASSWORD,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(7,'Visitor Account Create (sitemgr area)',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Account','text/plain','Dear ACCOUNT_NAME,\r\n\r\nThank you for signing up for an account in DEFAULT_URL\r\n\r\nUsername: ACCOUNT_USERNAME\r\nPassword: ACCOUNT_PASSWORD\r\n\r\nDEFAULT_URL','ACCOUNT_NAME,ACCOUNT_USERNAME,ACCOUNT_PASSWORD,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(8,'Visitor Account Update (sitemgr area)',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Account','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour account is updated in DEFAULT_URL\r\n\r\nUsername: ACCOUNT_USERNAME\r\nPassword: ACCOUNT_PASSWORD\r\n\r\nDEFAULT_URL','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(9,'Forgotten Password',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE account information','text/plain','As requested, here is the information regarding your EDIRECTORY_TITLE account.\r\nTo change your forgotten password please click the link below and enter a new password.\r\nKEY_ACCOUNT\r\n\r\nFor further assistance please contact SITEMGR_EMAIL.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE.','ACCOUNT_NAME,ACCOUNT_USERNAME,KEY_ACCOUNT,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(10,'New Listing',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYou have just added one listing in our directory.\r\n\r\nWhat do I do next?\r\n\r\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your listing.\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nOnce this has been completed a directory administrator will review your listing and set it live within the directory.\r\n\r\nSubmissions are reviewed within 2 working days following payment.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(11,'New Event',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nThank you for adding your event to our directory calendar.\r\n\r\nAn administrator will review your event and make it live within the directory within 2 working days.\r\n\r\nYou can see your event in DEFAULT_URL/MEMBERS_URL/\"Dashboard\" link.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(12,'New Banner',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYou have just added one banner in our directory.\r\n\r\nWhat do I do next?\r\n\r\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your banner.\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nOnce this has been completed a directory administrator will review your banner and set it live within the directory.\r\n\r\nSubmissions are reviewed within 2 working days following payment.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(13,'New Classified',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYou have just added one classified in our directory.\r\n\r\nWhat do I do next?\r\n\r\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your classified.\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nOnce this has been completed a directory administrator will review your classified and set it live within the directory.\r\n\r\nSubmissions are reviewed within 2 working days following payment.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(14,'New Article',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYou have just added one article in our directory.\r\n\r\nWhat do I do next?\r\n\r\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your article.\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nOnce this has been completed a directory administrator will review your article and set it live within the directory.\r\n\r\nSubmissions are reviewed within 2 working days following payment.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(15,'Custom Invoice',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Invoice','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour invoice is ready for payment at the following link:\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nAmount Due: CUSTOM_INVOICE_AMOUNT CUSTOM_INVOICE_TAX\r\n\r\nEDIRECTORY_TITLE\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,CUSTOM_INVOICE_AMOUNT,CUSTOM_INVOICE_TAX,MEMBERS_URL'),(16,'Active Listing',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Activation Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour listing is live and active on EDIRECTORY_TITLE\r\n\r\nLISTING_DEFAULT_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,LISTING_DEFAULT_URL'),(17,'Active Event',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Activation Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour event is live and active on EDIRECTORY_TITLE\r\n\r\nEVENT_DEFAULT_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,EVENT_DEFAULT_URL '),(18,'Active Banner',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Activation Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour banner is live and active on EDIRECTORY_TITLE\r\n\r\nDEFAULT_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(19,'Active Classified',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Activation Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour classified is live and active on EDIRECTORY_TITLE\r\n\r\nCLASSIFIED_DEFAULT_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,CLASSIFIED_DEFAULT_URL'),(20,'Active Article',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Activation Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour article is live and active on EDIRECTORY_TITLE\r\n\r\nARTICLE_DEFAULT_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,ARTICLE_DEFAULT_URL'),(22,'Listing Signup',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Signup Notification','text/plain','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,EDIRECTORY_TITLE,MEMBERS_URL'),(23,'Event Signup',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Signup Notification','text/plain','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,EDIRECTORY_TITLE,MEMBERS_URL'),(24,'Banner Signup',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Signup Notification','text/plain','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,EDIRECTORY_TITLE,MEMBERS_URL'),(25,'Classified Signup',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Signup Notification','text/plain','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,EDIRECTORY_TITLE,MEMBERS_URL'),(26,'Article Signup',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Signup Notification','text/plain','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,EDIRECTORY_TITLE,MEMBERS_URL'),(27,'Claimer Signup',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Claimer Signup Notification','text/plain','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see your account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.','ACCOUNT_NAME,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(28,'Claim Automatically Approved',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Claim Approved Notification','text/plain','Dear ACCOUNT_NAME,\r\nYour claim to the item \"LISTING_TITLE\" was \"automatically approved\".\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(29,'Claim Approved',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Claim Approved Notification','text/plain','Dear ACCOUNT_NAME,\r\nYour claim to the item \"LISTING_TITLE\" was \"approved\" by site manager.\r\nYou can see your item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(30,'Claim Denied',0,'0','0000-00-00 00:00:00','','EDIRECTORY_TITLE Claim Denied Notification','text/plain','Dear ACCOUNT_NAME,\r\nYour claim to the item \"LISTING_TITLE\" from DEFAULT_URL was \"denied\" by site manager.','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(31,'Approve Reply',0,'0','0000-00-00 00:00:00','','[EDIRECTORY_TITLE] Reply Approved Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour reply was approved by site manager.\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ \r\n  \r\nThank you for being a member of the EDIRECTORY_TITLE! \r\n  \r\nRegards \r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(32,'Approve Review',0,'0','0000-00-00 00:00:00','','[EDIRECTORY_TITLE] Review Approved Notification','text/plain','Dear ACCOUNT_NAME, \r\n  \r\nYour item has a new review approved by site manager.\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ \r\n  \r\nRegards \r\nEDIRECTORY_TITLE Team ','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(33,'New Review',0,'0','0000-00-00 00:00:00','','[EDIRECTORY_TITLE] New Review Notification','text/plain','Dear ACCOUNT_NAME, \r\n  \r\nYour item on EDIRECTORY_TITLE has a new review. \r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n  \r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards \r\n EDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(34,'Invoice Notification',0,'0','0000-00-00 00:00:00',NULL,'[EDIRECTORY_TITLE] Invoice Notification','text/plain','Dear ACCOUNT_NAME, \r\n\r\nYou can see your invoice in DEFAULT_URL \r\n\r\nRegards \r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(35,'Visitor Account Create',0,'0','0000-00-00 00:00:00','','Activate your EDIRECTORY_TITLE Account','text/plain','Dear ACCOUNT_NAME,\r\nThank you for creating your profile in EDIRECTORY_TITLE.\r\nClick on the link below to activate your account.\r\n\r\nLINK_ACTIVATE_ACCOUNT\r\n\r\nAfter that, you can login to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nRegards \r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,LINK_ACTIVATE_ACCOUNT,ACCOUNT_LOGIN_INFORMATION,DEFAULT_URL,EDIRECTORY_TITLE'),(36,'Sponsor Stats & Engagement E-mail',0,'0','0000-00-00 00:00:00',NULL,'Activity for your listing on EDIRECTORY_TITLE','text/plain','Dear \r\n\r\nACCOUNT_NAME,\r\n\r\nHere is the activity for LISTING_TITLE for the last 30 days:\r\n\r\n[TABLE_STATS]\r\n\r\nUpdate your listing and get more visibility by signing in here:\r\n\r\nDEFAULT_URL/MEMBERS_URL/\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team\r\n\r\nTo stop receiving this email please login and change your email settings, or send an email to \r\n\r\nSITEMGR_EMAIL','ACCOUNT_NAME,LISTING_TITLE,TABLE_STATS,DEFAULT_URL,EDIRECTORY_TITLE,SITEMGR_EMAIL,MEMBERS_URL'),(37,'Deal Redeemed (Owner)',0,'0','0000-00-00 00:00:00',NULL,'[EDIRECTORY_TITLE] Deal Redeemed Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour deal on EDIRECTORY_TITLE was redeemed. \r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n  \r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,MEMBERS_URL'),(38,'Deal Redeemed (Visitor)',0,'0','0000-00-00 00:00:00',NULL,'[EDIRECTORY_TITLE] Deal Redeemed','text/plain','Dear ACCOUNT_NAME,\r\n\r\nThank you for redeeming a deal in EDIRECTORY_TITLE (DEFAULT_URL).\r\nYou can see it by logging in your visitor area.\r\n\r\nYour code: REDEEM_CODE\r\n\r\nRegards \r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,DEFAULT_URL,EDIRECTORY_TITLE,REDEEM_CODE'),(39,'Account Activation',0,'0','0000-00-00 00:00:00',NULL,'[EDIRECTORY_TITLE] Account Activation','text/plain','Dear ACCOUNT_NAME,\r\n\r\nTo activate your account, please click on the link below.\r\n\r\nLINK_ACTIVATE_ACCOUNT\r\n\r\nFor further assistance please contact SITEMGR_EMAIL.\r\n\r\nRegards\r\n\r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,LINK_ACTIVATE_ACCOUNT,SITEMGR_EMAIL,EDIRECTORY_TITLE'),(40,'New Lead',0,'0','0000-00-00 00:00:00','','[EDIRECTORY_TITLE] New Lead Notification','text/plain','Dear ACCOUNT_NAME,\r\n\r\nYour item on EDIRECTORY_TITLE received the following lead.\r\n\r\nLEAD_MESSAGE\r\n\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\n\r\nEDIRECTORY_TITLE Team','ACCOUNT_NAME,ACCOUNT_USERNAME,DEFAULT_URL,SITEMGR_EMAIL,EDIRECTORY_TITLE,LEAD_MESSAGE,MEMBERS_URL');
/*!40000 ALTER TABLE `Email_Notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Email_Notification_Default`
--

DROP TABLE IF EXISTS `Email_Notification_Default`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Email_Notification_Default` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body_text` text COLLATE utf8_unicode_ci NOT NULL,
  `body_html` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Email_Notification_Default`
--

LOCK TABLES `Email_Notification_Default` WRITE;
/*!40000 ALTER TABLE `Email_Notification_Default` DISABLE KEYS */;
INSERT INTO `Email_Notification_Default` VALUES (1,'Listing renewal notification','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.<br /><br />\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below. <br /><br />\r\n<a href=\"DEFAULT_URL/MEMBERS_URL/billing/index.php\">DEFAULT_URL/MEMBERS_URL/billing/index.php</a><br /><br />\r\nFor further assistance please contact <a href=\"mailto:SITEMGR_EMAIL\">SITEMGR_EMAIL</a> <br /><br />\r\nThank you for being a member of the Directory. <br /><br />\r\nRegards,<br />\r\nThe EDIRECTORY_TITLE Team\r\n</div>\r\n</body>\r\n</html>'),(2,'Listing renewal notification','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.<br /><br />\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below. <br /><br />\r\n<a href=\"DEFAULT_URL/MEMBERS_URL/billing/index.php\">DEFAULT_URL/MEMBERS_URL/billing/index.php</a><br /><br />\r\nFor further assistance please contact <a href=\"mailto:SITEMGR_EMAIL\">SITEMGR_EMAIL</a> <br /><br />\r\nThank you for being a member of the Directory. <br /><br />\r\nRegards,<br />\r\nThe EDIRECTORY_TITLE Team\r\n</div>\r\n</body>\r\n</html>'),(3,'Listing renewal notification','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.<br /><br />\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below. <br /><br />\r\n<a href=\"DEFAULT_URL/MEMBERS_URL/billing/index.php\">DEFAULT_URL/MEMBERS_URL/billing/index.php</a><br /><br />\r\nFor further assistance please contact <a href=\"mailto:SITEMGR_EMAIL\">SITEMGR_EMAIL</a> <br /><br />\r\nThank you for being a member of the Directory. <br /><br />\r\nRegards,<br />\r\nThe EDIRECTORY_TITLE Team\r\n</div>\r\n</body>\r\n</html>'),(4,'Listing renewal notification','Dear ACCOUNT_NAME,\r\n\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.\r\n\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below.\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nFor further assistance please contact SITEMGR_EMAIL\r\n\r\nThank you for being a member of the Directory.\r\n\r\nRegards,\r\nThe EDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour listing \"LISTING_TITLE\" will expire in DAYS_INTERVAL days.<br /><br />\r\nYou can renew immediately by logging in to your account and submitting a credit card payment through the Payment area by the link below. <br /><br />\r\n<a href=\"DEFAULT_URL/MEMBERS_URL/billing/index.php\">DEFAULT_URL/MEMBERS_URL/billing/index.php</a><br /><br />\r\nFor further assistance please contact <a href=\"mailto:SITEMGR_EMAIL\">SITEMGR_EMAIL</a> <br /><br />\r\nThank you for being a member of the Directory. <br /><br />\r\nRegards,<br />\r\nThe EDIRECTORY_TITLE Team\r\n</div>\r\n</body>\r\n</html>'),(5,'EDIRECTORY_TITLE Account','Dear ACCOUNT_NAME,\n\nThank you for signing up for an account in DEFAULT_URL\nLogin to manage your account with the username and password below.\n\nDEFAULT_URL/MEMBERS_URL\n\nUsername: ACCOUNT_USERNAME\nPassword: ACCOUNT_PASSWORD\n\nDEFAULT_URL','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nThank you for signing up for an account in <a href=\"DEFAULT_URL\">DEFAULT_URL</a><br />\nLogin to manage your account with the username and password below.<br /><br />\n<a href=\"DEFAULT_URL/MEMBERS_URL\">DEFAULT_URL/MEMBERS_URL</a><br /><br />\nUsername: ACCOUNT_USERNAME<br />\nPassword: ACCOUNT_PASSWORD<br /><br />\n<a href=\"DEFAULT_URL\">DEFAULT_URL</a></div>\n</body>\n</html>'),(6,'EDIRECTORY_TITLE Account','Dear ACCOUNT_NAME,\n\nYour account is updated in DEFAULT_URL\nLogin to manage your account with the username and password below.\n\nDEFAULT_URL/MEMBERS_URL\n\nUsername: ACCOUNT_USERNAME\nPassword: ACCOUNT_PASSWORD\n\nDEFAULT_URL','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour account is updated in <a href=\"DEFAULT_URL\">DEFAULT_URL</a><br />\nLogin to manage your account with the username and password below.<br /><br />\n<a href=\"DEFAULT_URL/MEMBERS_URL\">DEFAULT_URL/MEMBERS_URL</a><br /><br />\nUsername: ACCOUNT_USERNAME<br />\nPassword: ACCOUNT_PASSWORD<br /><br />\n<a href=\"DEFAULT_URL\">DEFAULT_URL</a></div>\n</body>\n</html>'),(7,'EDIRECTORY_TITLE Account','Dear ACCOUNT_NAME,\n\nThank you for signing up for an account in DEFAULT_URL\n\nUsername: ACCOUNT_USERNAME\nPassword: ACCOUNT_PASSWORD\n\nDEFAULT_URL','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nThank you for signing up for an account in <a href=\"DEFAULT_URL\">DEFAULT_URL</a><br />\nUsername: ACCOUNT_USERNAME<br />\nPassword: ACCOUNT_PASSWORD<br /><br />\n<a href=\"DEFAULT_URL\">DEFAULT_URL</a></div>\n</body>\n</html>'),(8,'EDIRECTORY_TITLE Account','Dear ACCOUNT_NAME,\n\nYour account is updated in DEFAULT_URL\n\nDEFAULT_URL/MEMBERS_URL\n\nUsername: ACCOUNT_USERNAME\nPassword: ACCOUNT_PASSWORD\n\nDEFAULT_URL','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour account is updated in <a href=\"DEFAULT_URL\">DEFAULT_URL</a><br />\nUsername: ACCOUNT_USERNAME<br />\nPassword: ACCOUNT_PASSWORD<br /><br />\n<a href=\"DEFAULT_URL\">DEFAULT_URL</a></div>\n</body>\n</html>'),(9,'EDIRECTORY_TITLE account information','As requested, here is the information regarding your EDIRECTORY_TITLE account.\nTo change your forgotten password please click the link below and enter a new password.\nKEY_ACCOUNT\n\nFor further assistance please contact SITEMGR_EMAIL.\n\nThank you for being a member of the EDIRECTORY_TITLE.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nAs requested, here is the information regarding your EDIRECTORY_TITLE account.<br />\nTo change your forgotten password please click the link below and enter a new password.<br />\nKEY_ACCOUNT<br /><br />\nFor further assistance please contact SITEMGR_EMAIL.<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE.</div>\n</body>\n</html>'),(10,'EDIRECTORY_TITLE Notification','Dear ACCOUNT_NAME,\r\n\r\nYou have just added one listing in our directory.\r\n\r\nWhat do I do next?\r\n\r\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your listing.\r\nDEFAULT_URL/MEMBERS_URL\r\n\r\nOnce this has been completed a directory administrator will review your listing and set it live within the directory.\r\n\r\nSubmissions are reviewed within 2 working days following payment.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team\r\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYou have just added one listing in our directory.<br /><br />\nWhat do I do next? <br /><br />\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your listing. <br />\n<a href=\"DEFAULT_URL/MEMBERS_URL\" class=\"email_style_settings\">DEFAULT_URL/MEMBERS_URL</a> <br /><br />\nOnce this has been completed a directory administrator will review your listing and set it live within the directory.<br /><br />\nSubmissions are reviewed within 2 working days following payment.<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Advertising Team</div>\n</body>\n</html>'),(11,'EDIRECTORY_TITLE Notification','Dear ACCOUNT_NAME,\r\n\r\nThank you for adding your event to our directory calendar.\r\n\r\nAn administrator will review your event and make it live within the directory within 2 working days.\r\n\r\nYou can see your event in DEFAULT_URL/MEMBERS_URL/\"Dashboard\" link.\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Advertising Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nThank you for adding your event to our directory calendar.<br /><br />\r\nAn administrator will review your event and make it live within the directory within 2 working days.<br /><br />\r\nYou can see your event in DEFAULT_URL/MEMBERS_URL/\"Dashboard\" link.<br /><br />\r\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Advertising Team</div>\r\n</body>\r\n</html>'),(12,'EDIRECTORY_TITLE Notification','Dear ACCOUNT_NAME,\n\nYou have just added one banner in our directory.\n\nWhat do I do next?\n\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your banner.\nDEFAULT_URL/MEMBERS_URL\n\nOnce this has been completed a directory administrator will review your banner and set it live within the directory.\n\nSubmissions are reviewed within 2 working days following payment.\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Advertising Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYou have just added one banner in our directory.<br /><br />\nWhat do I do next? <br /><br />\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your banner. <br />\n<a href=\"DEFAULT_URL/MEMBERS_URL\" class=\"email_style_settings\">DEFAULT_URL/MEMBERS_URL</a> <br /><br />\nOnce this has been completed a directory administrator will review your banner and set it live within the directory.<br /><br />\nSubmissions are reviewed within 2 working days following payment.<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Advertising Team</div>\n</body>\n</html>'),(13,'EDIRECTORY_TITLE Notification','Dear ACCOUNT_NAME,\n\nYou have just added one classified in our directory.\n\nWhat do I do next?\n\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your classified.\nDEFAULT_URL/MEMBERS_URL\n\nOnce this has been completed a directory administrator will review your classified and set it live within the directory.\n\nSubmissions are reviewed within 2 working days following payment.\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Advertising Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYou have just added one classified in our directory.<br /><br />\nWhat do I do next? <br /><br />\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your classified. <br />\n<a href=\"DEFAULT_URL/MEMBERS_URL\" class=\"email_style_settings\">DEFAULT_URL/MEMBERS_URL</a> <br /><br />\nOnce this has been completed a directory administrator will review your classified and set it live within the directory.<br /><br />\nSubmissions are reviewed within 2 working days following payment.<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Advertising Team</div>\n</body>\n</html>'),(14,'EDIRECTORY_TITLE Notification','Dear ACCOUNT_NAME,\n\nYou have just added one article in our directory.\n\nWhat do I do next?\n\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your article.\nDEFAULT_URL/MEMBERS_URL\n\nOnce this has been completed a directory administrator will review your article and set it live within the directory.\n\nSubmissions are reviewed within 2 working days following payment.\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Advertising Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYou have just added one article in our directory.<br /><br />\nWhat do I do next? <br /><br />\nPlease login to the directory at the link below and click on Make your Payment link on the left menu options to pay for your article. <br />\n<a href=\"DEFAULT_URL/MEMBERS_URL\" class=\"email_style_settings\">DEFAULT_URL/MEMBERS_URL</a> <br /><br />\nOnce this has been completed a directory administrator will review your article and set it live within the directory.<br /><br />\nSubmissions are reviewed within 2 working days following payment.<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Advertising Team</div>\n</body>\n</html>'),(15,'[EDIRECTORY_TITLE] Invoice','Dear ACCOUNT_NAME,\r\n\r\nYour invoice is ready for payment at the following link:\r\n\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php\r\n\r\nAmount Due: CUSTOM_INVOICE_AMOUNT CUSTOM_INVOICE_TAX\r\n\r\nEDIRECTORY_TITLE\r\n','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour invoice is ready for payment at the following link:<br /><br />\r\nDEFAULT_URL/MEMBERS_URL/billing/index.php<br /><br />\r\nAmount Due: CUSTOM_INVOICE_AMOUNT CUSTOM_INVOICE_TAX<br /><br />\r\nEDIRECTORY_TITLE</div>\r\n</body>\r\n</html>'),(16,'EDIRECTORY_TITLE Activation Notification','Dear ACCOUNT_NAME,\n\nYour listing is live and active on EDIRECTORY_TITLE\n\nLISTING_DEFAULT_URL/\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour listing is live and active on EDIRECTORY_TITLE<br /><br />\nLISTING_DEFAULT_URL/<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Team</div>\n</body>\n</html>'),(17,'EDIRECTORY_TITLE Activation Notification','Dear ACCOUNT_NAME,\n\nYour event is live and active on EDIRECTORY_TITLE\n\nEVENT_DEFAULT_URL/\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour event is live and active on EDIRECTORY_TITLE<br /><br />\nEVENT_DEFAULT_URL/<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Team</div>\n</body>\n</html>'),(18,'EDIRECTORY_TITLE Activation Notification','Dear ACCOUNT_NAME,\n\nYour banner is live and active on EDIRECTORY_TITLE\n\nDEFAULT_URL/\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour banner is live and active on EDIRECTORY_TITLE<br /><br />\nDEFAULT_URL/<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Team</div>\n</body>\n</html>'),(19,'EDIRECTORY_TITLE Activation Notification','Dear ACCOUNT_NAME,\n\nYour classified is live and active on EDIRECTORY_TITLE\n\nCLASSIFIED_DEFAULT_URL/\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour classified is live and active on EDIRECTORY_TITLE<br /><br />\nCLASSIFIED_DEFAULT_URL/<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Team</div>\n</body>\n</html>'),(20,'EDIRECTORY_TITLE Activation Notification','Dear ACCOUNT_NAME,\n\nYour article is live and active on EDIRECTORY_TITLE\n\nARTICLE_DEFAULT_URL/\n\nThank you for being a member of the EDIRECTORY_TITLE!\n\nRegards\nEDIRECTORY_TITLE Team\n','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nYour article is live and active on EDIRECTORY_TITLE<br /><br />\nARTICLE_DEFAULT_URL/<br /><br />\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Team</div>\n</body>\n</html>'),(22,'EDIRECTORY_TITLE Signup Notification','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).<br />\nLogin to manage your account with the information below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\nYou can see:<br />\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.<br />\nAnd<br />\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\n</div>\n</body>\n</html>'),(23,'EDIRECTORY_TITLE Signup Notification','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).<br />\nLogin to manage your account with the information below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\nYou can see:<br />\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.<br />\nAnd<br />\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\n</div>\n</body>\n</html>'),(24,'EDIRECTORY_TITLE Signup Notification','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).<br />\nLogin to manage your account with the information below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\nYou can see:<br />\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.<br />\nAnd<br />\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\n</div>\n</body>\n</html>'),(25,'EDIRECTORY_TITLE Signup Notification','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).<br />\nLogin to manage your account with the information below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\nYou can see:<br />\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.<br />\nAnd<br />\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\n</div>\n</body>\n</html>'),(26,'EDIRECTORY_TITLE Signup Notification','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see:\r\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\r\nAnd\r\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).<br />\nLogin to manage your account with the information below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\nYou can see:<br />\nYour account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.<br />\nAnd<br />\nYour item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\n</div>\n</body>\n</html>'),(27,'EDIRECTORY_TITLE Claimer Signup Notification','Dear ACCOUNT_NAME,\r\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).\r\nLogin to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nYou can see your account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for signing up for an account in EDIRECTORY_TITLE (DEFAULT_URL).<br />\nLogin to manage your account with the information below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\nYou can see your account in DEFAULT_URL/MEMBERS_URL/ \"Account\" link.\n</div>\n</body>\n</html>'),(28,'EDIRECTORY_TITLE Claim Approved Notification','Dear ACCOUNT_NAME,\r\nYour claim to the item \"LISTING_TITLE\" was \"automatically approved\". \r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br />\r\nYour claim to the item \"LISTING_TITLE\" was \"automatically approved\".<br />\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\r\n</div>\r\n</body>\r\n</html>'),(29,'EDIRECTORY_TITLE Claim Approved Notification','Dear ACCOUNT_NAME,\r\nYour claim to the item \"LISTING_TITLE\" was \"approved\" by site manager.\r\nYou can see your item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br />\r\nYour claim to the item \"LISTING_TITLE\" was \"approved\" by site manager.<br />\r\nYou can see your item in DEFAULT_URL/MEMBERS_URL/ \"Dashboard\" link.\r\n</div>\r\n</body>\r\n</html>'),(30,'EDIRECTORY_TITLE Claim Denied Notification','Dear ACCOUNT_NAME,\r\nYour claim to the item \"LISTING_TITLE\" from DEFAULT_URL was \"denied\" by site manager.','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br />\r\nYour claim to the item \"LISTING_TITLE\" from DEFAULT_URL was \"denied\" by site manager.\r\n</div>\r\n</body>\r\n</html>'),(31,'[EDIRECTORY_TITLE] Reply Approved Notification','Your reply was approved by site manager.\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ \r\n  \r\nThank you for being a member of the EDIRECTORY_TITLE! \r\n  \r\nRegards \r\nEDIRECTORY_TITLE Team\r\n','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nYour reply was approved by site manager.<br />\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/<br /><br />\r\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>'),(32,'[EDIRECTORY_TITLE] Review Approved Notification','Dear ACCOUNT_NAME,\r\n\r\nYour item has a new review approved by site manager.\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour item has a new review approved by site manager.<br />\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>'),(33,'[EDIRECTORY_TITLE] New Review Notification','Dear ACCOUNT_NAME,\r\n\r\nYour item on EDIRECTORY_TITLE has a new review. \r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n  \r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team\r\n','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour item on EDIRECTORY_TITLE has a new review.<br />\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ <br /><br />\r\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>'),(34,'[EDIRECTORY_TITLE] Invoice Notification','Dear ACCOUNT_NAME, \r\n\r\nYou can see your invoice in DEFAULT_URL\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\"> .default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif; \r\nfont-size: 8pt; \r\ncolor: #003365; \r\nmargin: 0; \r\npadding: 5px; \r\nbackground: #FBFBFB; \r\nborder: 1px solid #E9E9E9; \r\ntext-align: justify; \r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\"> \r\nDear ACCOUNT_NAME, <br />\r\nYou can see your invoice in DEFAULT_URL <br /><br /> Regards<br /> EDIRECTORY_TITLE Team\r\n</div>\r\n</body>\r\n</html>'),(35,'EDIRECTORY_TITLE Profile','Dear ACCOUNT_NAME,\r\nThank you for creating your profile in EDIRECTORY_TITLE.\r\nClick on the link below to activate your account.\r\n\r\nLINK_ACTIVATE_ACCOUNT\r\n\r\nAfter that, you can login to manage your account with the information below.\r\n\r\nACCOUNT_LOGIN_INFORMATION\r\n\r\nRegards \r\nEDIRECTORY_TITLE Team','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br />\nThank you for creating your profile in EDIRECTORY_TITLE.<br />\nClick on the link below to activate your account.<br />\nLINK_ACTIVATE_ACCOUNT<br />\nAfter that, you can login to manage your account with the e-mail and password below.<br /><br />\nACCOUNT_LOGIN_INFORMATION<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\n</html>'),(36,'Activity for your listing on EDIRECTORY_TITLE','Dear ACCOUNT_NAME, \r\n\r\nHere is the activity for LISTING_TITLE for the last 30 days:\r\n\r\n[TABLE_STATS]\r\n\r\nUpdate your listing and get more visibility by signing in here:\r\n\r\nDEFAULT_URL/MEMBERS_URL/\r\n\r\nRegards,\r\n\r\nThe EDIRECTORY_TITLE Team\r\n\r\nTo stop receiving this email please login and change your email settings, or send an email to SITEMGR_EMAIL','<html>\n<head>\n<style type=\"text/css\">\n.default_text_settings {\nfont-family: Verdana, Arial, Helvetica, sans-serif;\nfont-size: 8pt;\ncolor: #003365;\nmargin: 0;\npadding: 5px;\nbackground: #FBFBFB;\nborder: 1px solid #E9E9E9;\ntext-align: justify;\n};\n</style>\n</head>\n<body>\n<div class=\"default_text_settings\">\nDear ACCOUNT_NAME,<br /><br />\nHere is the activity for LISTING_TITLE for the last 30 days:<br /><br />\n[TABLE_STATS]<br /><br />\nUpdate your listing and get more visibility by signing in here:<br /><br />\nDEFAULT_URL/MEMBERS_URL/<br /><br />\nRegards<br />\nEDIRECTORY_TITLE Team<br /><br />To stop receiving this email please login and change your email settings, or send an email to SITEMGR_EMAIL</div>\n</body>\n</html>'),(37,'[EDIRECTORY_TITLE] Deal Redeemed Notification','Dear ACCOUNT_NAME,\r\n\r\nYour deal on EDIRECTORY_TITLE was redeemed. \r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n  \r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\nEDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour deal on EDIRECTORY_TITLE was redeemed.<br />\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ <br /><br />\r\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>'),(38,'[EDIRECTORY_TITLE] Deal Redeemed','Dear ACCOUNT_NAME,\r\n\r\nThank you for redeeming a deal in EDIRECTORY_TITLE (DEFAULT_URL).\r\nYou can see it by logging in your visitor area.\r\n\r\nYour code: REDEEM_CODE\r\n\r\nRegards \r\nEDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br />\r\nThank you for redeeming a deal in EDIRECTORY_TITLE (DEFAULT_URL).<br />\r\nYou can see it by logging in your visitor area.<br /><br />\r\nYour code: REDEEM_CODE<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>'),(39,'[EDIRECTORY_TITLE] Account Activation','Dear ACCOUNT_NAME,\r\n\r\nTo activate your account, please click on the link below.\r\n\r\nLINK_ACTIVATE_ACCOUNT\r\n\r\nFor further assistance please contact SITEMGR_EMAIL.\r\n\r\nRegards\r\n\r\nEDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nTo activate your account, please click on the link below.<br />\r\nLINK_ACTIVATE_ACCOUNT<br />\r\nFor further assistance please contact SITEMGR_EMAIL.<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>'),(40,'[EDIRECTORY_TITLE] New Lead Notification','Dear ACCOUNT_NAME,\r\n\r\nYour item on EDIRECTORY_TITLE received the following lead.\r\n\r\nLEAD_MESSAGE\r\n\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/\r\n\r\nThank you for being a member of the EDIRECTORY_TITLE!\r\n\r\nRegards\r\n\r\nEDIRECTORY_TITLE Team','<html>\r\n<head>\r\n<style type=\"text/css\">\r\n.default_text_settings {\r\nfont-family: Verdana, Arial, Helvetica, sans-serif;\r\nfont-size: 8pt;\r\ncolor: #003365;\r\nmargin: 0;\r\npadding: 5px;\r\nbackground: #FBFBFB;\r\nborder: 1px solid #E9E9E9;\r\ntext-align: justify;\r\n};\r\n</style>\r\n</head>\r\n<body>\r\n<div class=\"default_text_settings\">\r\nDear ACCOUNT_NAME,<br /><br />\r\nYour item on EDIRECTORY_TITLE received the following lead.<br /><br />\r\nLEAD_MESSAGE<br /><br />\r\nYou can see it in DEFAULT_URL/MEMBERS_URL/ <br /><br />\r\nThank you for being a member of the EDIRECTORY_TITLE!<br /><br />\r\nRegards<br />\r\nEDIRECTORY_TITLE Team</div>\r\n</body>\r\n</html>');
/*!40000 ALTER TABLE `Email_Notification_Default` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `importID` int(11) NOT NULL,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) NOT NULL DEFAULT '0',
  `location_1` int(11) NOT NULL DEFAULT '0',
  `location_2` int(11) NOT NULL DEFAULT '0',
  `location_3` int(11) NOT NULL DEFAULT '0',
  `location_4` int(11) NOT NULL DEFAULT '0',
  `location_5` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `has_start_time` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `has_end_time` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `zip5` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `latitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `suspended_sitemgr` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `cat_1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_1_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_2_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_3_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_4_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_4_level4_id` int(11) NOT NULL DEFAULT '0',
  `cat_5_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level1_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level2_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level3_id` int(11) NOT NULL DEFAULT '0',
  `parcat_5_level4_id` int(11) NOT NULL DEFAULT '0',
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `video_snippet` text COLLATE utf8_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `recurring` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `day` int(3) NOT NULL DEFAULT '0',
  `dayofweek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `week` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `month` int(3) NOT NULL DEFAULT '0',
  `until_date` date DEFAULT '0000-00-00',
  `repeat_event` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `number_views` int(11) NOT NULL DEFAULT '0',
  `map_zoom` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `custom_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `friendly_url_2` (`friendly_url`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`),
  KEY `account_id` (`account_id`),
  KEY `latitude` (`latitude`),
  KEY `longitude` (`longitude`),
  KEY `country_id` (`location_1`),
  KEY `state_id` (`location_2`),
  KEY `region_id` (`location_3`),
  KEY `status` (`status`),
  KEY `level` (`level`),
  KEY `city_id` (`location_4`),
  KEY `area_id` (`location_5`),
  KEY `title` (`title`),
  KEY `friendly_url` (`friendly_url`),
  KEY `random_number` (`random_number`),
  KEY `cat_1_id` (`cat_1_id`),
  KEY `parcat_1_level1_id` (`parcat_1_level1_id`),
  KEY `cat_2_id` (`cat_2_id`),
  KEY `parcat_2_level1_id` (`parcat_2_level1_id`),
  KEY `cat_3_id` (`cat_3_id`),
  KEY `parcat_3_level1_id` (`parcat_3_level1_id`),
  KEY `cat_4_id` (`cat_4_id`),
  KEY `parcat_4_level1_id` (`parcat_4_level1_id`),
  KEY `cat_5_id` (`cat_5_id`),
  KEY `parcat_5_level1_id` (`parcat_5_level1_id`),
  FULLTEXT KEY `fulltextsearch_keyword` (`fulltextsearch_keyword`),
  FULLTEXT KEY `fulltextsearch_where` (`fulltextsearch_where`),
  FULLTEXT KEY `fulltextsearch_title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event`
--

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
/*!40000 ALTER TABLE `Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EventCategory`
--

DROP TABLE IF EXISTS `EventCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EventCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `summary_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `active_event` int(11) NOT NULL DEFAULT '0',
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `count_sub` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `active_event` (`active_event`),
  KEY `title1` (`title`),
  KEY `friendly_url1` (`friendly_url`),
  FULLTEXT KEY `keywords` (`keywords`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EventCategory`
--

LOCK TABLES `EventCategory` WRITE;
/*!40000 ALTER TABLE `EventCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `EventCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EventLevel`
--

DROP TABLE IF EXISTS `EventLevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EventLevel` (
  `value` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaultlevel` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `detail` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `images` int(3) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `popular` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`value`,`theme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EventLevel`
--

LOCK TABLES `EventLevel` WRITE;
/*!40000 ALTER TABLE `EventLevel` DISABLE KEYS */;
INSERT INTO `EventLevel` VALUES (50,'silver','n','n',0,0.00,'y','','','','default'),(30,'gold','n','n',0,25.00,'y','','','','default'),(10,'diamond','y','y',3,50.00,'y','y','y','','default');
/*!40000 ALTER TABLE `EventLevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EventLevel_Field`
--

DROP TABLE IF EXISTS `EventLevel_Field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EventLevel_Field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(3) NOT NULL,
  `field` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `theme` (`theme`,`level`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EventLevel_Field`
--

LOCK TABLES `EventLevel_Field` WRITE;
/*!40000 ALTER TABLE `EventLevel_Field` DISABLE KEYS */;
INSERT INTO `EventLevel_Field` VALUES (71,'default',10,'summary_description'),(70,'default',30,'summary_description'),(64,'default',10,'email'),(65,'default',10,'url'),(73,'default',10,'contact_name'),(77,'default',10,'end_time'),(76,'default',10,'start_time'),(75,'default',30,'end_time'),(74,'default',30,'start_time'),(72,'default',10,'long_description'),(79,'default',10,'main_image'),(78,'default',30,'main_image'),(68,'default',10,'phone'),(67,'default',30,'phone'),(66,'default',50,'phone'),(69,'default',10,'video');
/*!40000 ALTER TABLE `EventLevel_Field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event_LocationCounter`
--

DROP TABLE IF EXISTS `Event_LocationCounter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event_LocationCounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_level` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `full_friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_LocationCounter`
--

LOCK TABLES `Event_LocationCounter` WRITE;
/*!40000 ALTER TABLE `Event_LocationCounter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Event_LocationCounter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FAQ`
--

DROP TABLE IF EXISTS `FAQ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FAQ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitemgr` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `member` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `frontend` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `answer` text COLLATE utf8_unicode_ci NOT NULL,
  `editable` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `keyword` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `keyword` (`keyword`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FAQ`
--

LOCK TABLES `FAQ` WRITE;
/*!40000 ALTER TABLE `FAQ` DISABLE KEYS */;
INSERT INTO `FAQ` VALUES (1,'y','n','n','When is the \"Claim this ad\" link available?','Listings without a sponsor account (No Owner) associated with a listing can use the claim feature (\"Claim this ad\" link will show up on the front of the directory for listings with no owner).','n',''),(2,'y','n','n','Who can \"Claim this ad\"?','If the \"Claim this ad\" link is available on the front area, any sponsor, visitor or new user can claim the listing. After a user claims a listing the sitemgr can either deny their claim to the listing or approve it. The sitemgr\'s approval gives the user full control over the listing.','n',''),(3,'y','n','n','Can I turn off \"Claim this ad\" for a listing?','If the listing does not have an account and it is not available to claim, you can edit the listing and check the box \"Disable claim feature for this listing\". The \"Claim this ad\" link will be turned off for this listing.','n',''),(4,'y','n','n','What is Default Image? And Where is it used?','If the sponsor or sitemgr forgets to upload an image to an item, to the gallery or another image field, the Default Image is used.','n',''),(5,'y','n','n','My .csv file must have the same columns as the .csv sample file?','Make sure that your data columns match the sample .csv format provided. All fields are required (even if they have no data in them) for the import to function correctly.','n',''),(6,'y','n','n','Can I delete any column on the .csv file import?','The same as above, if any columns are missing from the .csv file the import will not function correctly, please leave them all intact.','n',''),(7,'y','n','n','Do I have to put my .csv file on the same order as the import .csv sample file?','Yes, you must use the format of the sample .csv. The data fields in the .csv that you upload must be in the same order as the sample template format. If the data is not in the correct order your data will not be imported correctly.','n',''),(8,'y','n','n','Can I make imports with the same account? And different accounts?','If you want each item to have its own account then each item (row) in the .csv file will need a different account username entered. If multiple items have the same account associated with them in the .csv file they will be imported to the same account. If you plan on uploading many items into a single account we suggest doing a separate import for those imports and using the import settings to set the import to single account import.','n',''),(9,'y','n','n','What happens if I misspell location on the import?','Please be specific when you are spelling text for your location fields. For example, if you import two items for the State of New York, and on a item you write NewYork, and on the other one you write New York, both States will appear in the advanced search dropdowns in the directory and each would need to be updated with your meta information for each location.','n',''),(10,'y','n','n','What happens if I misspell a category on import?','Please be specific when you are spelling text for your category fields. If an item has the Arts & Entertainment category and the other one has Arts and Entertainment, both categories will appear in the item search dropdown fields, in the item browse by category area, and in the browse categories area on your item results pages.','n',''),(11,'y','n','n','How many categories can I import?','Each item can have up to 5 categories imported. It will not import more than 5 categories.','n',''),(12,'y','n','n','Can I import any username/password?','Invalid Usernames/Passwords will not be imported. Usernames need to be a valid e-mail between 4 and 80 characters with no spaces. Passwords need to have a minimum of 4 characters and maximum of 50 characters, we do not allow special character. If you are trying to import multiple items to the same account but are using different passwords for each row in your .csv file the import for the additional items will have problems. You may find it easier to use the Import Settings to upload multiple items to the same account.','n',''),(13,'y','n','n','Do I have to import all items with an account?','If the username field is empty, the item will be imported without an account. That means that the item has no owner. If you are importing listings, this is a quick and easy way to use the claim feature on listings.','n',''),(14,'y','n','n','What happens if I import more than one item with the same title?','The import will add the new items to database without deleting existing items. The friendly url will be different for each new item. <br />\r\nNOTE: If you want the data to be updated instead of creating new rows, you must check the option \"Overwrite matching items\" from within the import settings. The field Listing ID (or Event ID) in your CSV file must match with the value in your eDirectory database.','n',''),(15,'y','n','n','What information is required to make the import work?','The minimum amount of information that is required is the \"Title\". All other fields can be blank in your .csv file.','n',''),(16,'y','n','n','How can I import listings to have the \"claim this ad\" link for the claim feature?','To use the claim listing feature, do not assign a listing to a specific account. When doing the .csv import leave the columns related to member account information blank.','n',''),(18,'y','n','n','Can I rollback an import?','You can roll back a finished or stopped import. All the accounts and items imported will be removed, but for security reasons the categories and locations imported will remain in the directory database. A task will be scheduled to roll back your data.','n',''),(19,'y','n','n','How can I rollback imported data?','To rollback imported data, click on the Rollback button on the Import Log tab and follow the rollback process. <br />\r\nNote: Be sure to click on the Rollback button and not the delete icon (this just removes the import log record, not the data. Once the log file is removed, the data can not be rolled back, so be careful here).','n',''),(20,'y','n','n','Can I delete an imported data log?','When using Delete Log button, data will not be removed from the directory. The specific log will be removed, but the data from the import will remain in the directory database.','n',''),(21,'y','n','n','What is \"Badge\"?','Listing Badges allow you to designate listings with certain images of your choice. For example, if you want to mark a listing as \"Editor\'s Choice\", you can upload your own icon, and mark (on the listing form) the listings you want to display the icon. You can also give members access to select the badges themselves by checking the box. For example you may want a \"Pet Friendly\" option that members can use to add to their listings.','n',''),(22,'y','n','n','What are the listing types?','With the listing types you can modify the listings detail styles.<br /> PS: This feature isn\'t available for themes Real Estate and Dining Guide.','n',''),(71,'y','n','n','I am using the multi-domain feature, how can I see the items of the sites at the site manager area?','At the site manager area you can see the general data (related to all sites) at the top menu. And the data for each specific site you can see at the left menu, by changing the site at the drop-down list.','n',''),(23,'y','n','n','Which type of modifications the listing types support?','You can charge an additional price per listing type, select the detail layout,  rename common fields (example: \"Restaurant Name\" instead of \"Listing Title\"), add new fields (checkboxes, dropdowns, text fields, short description fields and long descritpion fields) and select which of them will be required.<br /> PS: This feature isn\'t available for themes Real Estate and Dining Guide.','n',''),(26,'y','n','n','How do the Import Settings work?','On the \"Import Settings\" tab in the Settings area of the sitemgr, you can setup some import options:\r\n<br /> \r\n1. Import CSV comes from an Export: If you previously did an export from the import / exporter on your eDirectory installation - please check this box. \r\n<br />\r\n2. Enable all imported items as Active: Rather than having imported item in pending mode (so you can check them over and add data) this check box will make all imported items instantly active on the site. \r\n<br />\r\n3. Overwrite matching items: If you want to update an existing item in your eDirectory you must check this option.  For an item to be considered a match the following field must be identical on the imported .csv file and the database: Listing ID/Event ID.\r\n<br />\r\n4. Update friendly URL\'s for matching items: It is strongly recommended that this option be left unchecked. If we find a record in the .csv file with a matching Listing ID/Event ID when compared to an existing record in the database, we will update that item with the new data (as detailed above), but with this option on we will also rewrite the URL based on the item title. If you have content that has been indexed by google, this content will cease to be reachable from the search engines until they update their data - this can take a day or months. Use Carefully. \r\n<br />\r\n5. All new categories set to featured: All categories that are imported will be automatically set to featured. \r\n<br />\r\n6. Default level for items without level specified: For all items with no level specified in the .csv file, you can choose a level here..\r\n<br />\r\n7. Import all items to the same user account: Everything in the .csv file will be attached to a single user account. After ticking this box, a dropdown will appear só that an account can be selected.','n',''),(27,'y','n','n','How can I disable an Email Notification?','Go to the Email Notifications section and click on the active icon of the email you want to disable.','n',''),(29,'n','y','y','How does the \"Sign me in automatically\" work?','The \"Sign me in automatically\" is optional, it saves your username and password on your computer and every time you access the page you will be automatically logged in.','y',''),(30,'y','y','y','What happens if I forget my password?','If you forget your password, please click on the \'Forgot your Password?\' link of the front of the directory or on the sponsor login page. The password recovery email will be sent to the email address provided from your Contact Information. The email will contain a link which will redirect the user to the \'Manage Account\' section, where the password can be updated.','y',''),(31,'n','y','y','How can I change my password?','After you are logged in, click on \'Account Settings\' link, you will see the \"Current Password\" field, type your current password in this field and your new password on the fields \"Password\" and \"Retype Password\", then hit the submit button.','y',''),(32,'n','y','n','Can I change my username?','Yes, you can do that by going to \'Manage account\' > \'Account Settings\' and typing your new e-mail.','y',''),(34,'n','y','n','Can I change my item level?','Yes, you can. After your item is expired you can choose the level (if it is free you can change the level anytime) and pay for it.','y',''),(35,'n','y','n','Can I add categories to my deal?','No, you cannot. The deal is related to the listing categories you choose.','y',''),(81,'y','n','n','What is the \"Click to Call & Send to Phone\" feature and how the Twilio api works?','With the \"Click to Call & Send to Phone\" feature your directory can send text messages to the users with the main information about your listing. Also, the users can contact directly the listing owners just clicking in the \"Click to Call\" button. You just need to create a Twilio account and upgrade it after you finish your free credits.','n',''),(37,'n','n','y','Am I required to have an account to add items to the site?','Yes. In order to add any item, including Free items, to the directory you must have an account.','y',''),(38,'n','n','y','How can I sign up for an account?','To sign up as a sponsor go to the \'Advertise With Us\' link at top menu, select an item and level and click in \'SIGN UP\' button. Fill out all fields, write down your username and password for future reference, choose the best payment gateway for you and follow the steps to finish the process. To sign up as a visitor go to \'Sign up | Login\' link at top menu, fill out all fields and click in \'Create Account\'.','y',''),(45,'y','y','y','Why am I receiving an \'Account Locked\' message?','If you attempt to access your account and type in an incorrect password 5 times the account will lock for 1 hour. This is for security reasons.','y',''),(46,'y','n','n','How can I setup Facebook App ID and Facebook App Secret?','If you don\'t already have a Facebook App ID and App Secret for your site, create an application with the Facebook Developer application. Note: Even if you have created an application and received an App Secret, you should review steps 4 through 7 and make sure your application settings are appropriate.<br />\r\n1. Go to https://developers.facebook.com/apps and click in + Create New App to create a new application.<br />\r\n2. Enter a name for your application in the App Display Name field.<br />\r\n3. Agree to the Facebook Platform Policies, then click Continue.<br />\r\n4. Enter the Security Check words, then click Submit.<br />\r\n5. On the Settings tab > Basic, take note of the App ID and App Secret, you\'ll need this shortly.<br />\r\n6. Still on the Settings tab, click on Website and set Site URL to the top-level directory of the site which will be implementing Facebook Connect (this is usually your domain, e.g. http://www.example.com , but could also be a subdirectory). If your site is going to implement Facebook Connect across a number of subdomains of your site (for example, http://foo.example.com and bar.example.com), you need to enter a App Domain (which would be example.com in this case).<br />\r\n7. You can include a logo that appears on the Facebook Connect dialog. On the Settings tab > Basic, click Edit on the image next your App Name and browse to choose an image file. Your logo must be in JPG, GIF, or PNG format. If the image is larger than 75x75 pixels, it will be resized and converted, then click Save Changes.<br />\r\n8. Copy the App ID and App Secret and paste it on Setting > Sign In Options of your directory.','n',''),(86,'y','n','n','Como habilito o PagSeguro no meu diretório?','Para habilitar o PagSeguro no seu diretório, você precisa de uma conta de vendedor ou empresarial no PagSeguro. Siga os passos abaixo para criar e configurar sua conta.<br /><br /> 1. Vá até a página de cadastro do PagSeguro em https://pagseguro.uol.com.br/registration/registration.jhtml;<br /> 2. Digite seu e-mail e senha e escolha um tipo de conta (Vendedor ou Empresarial);<br /> 3. Informe seus dados pessoais/empresariais, verifique os termos de contrato do PagSeguro e clique em \'Continuar\';<br /> 4. Você receberá um e-mail para confirmar sua conta;<br /> 5. Após a confirmação da conta, você precisa configurá-la para integrá-la ao seu diretório. Faça login e clique no menu <b>\'Integrações\'</b> - <b>\'Token de segurança\'</b>;<br /> 6. Clique em <b>\'Gerar novo Token\'</b> e tome nota do código;<br /> 7. Vá até o menu <b>\'Integrações\'</b> - <b>\'Página de redirecionamento\'</b>, selecione a opção <b>\'Ativado\'</b> e ative a URL: http://www.meudiretorio.com.br/<b>members/billing/processpayment.php?payment_method=pagseguro</b> , substituindo www.meudiretorio.com.br para a URL do seu diretório. Essa é a URL onde os usuários serão redirecionados após um pagamento;<br /> 8. Vá até o menu <b>\'Integrações\'</b> - <b>\'Notificação de transações\'</b>, selecione a opção <b>\'Ativado\'</b> e ative a URL: http://www.meudiretorio.com.br/<b>members/billing/pagseguroreturn.php</b> , substituindo www.meudiretorio.com.br para a URL do seu diretório. Certifique-se que a URL foi informada corretamente, caso contrário o PagSeguro não irá retornar os dados das transações para seu diretório;<br /> 9. Volte à interface administrativa do seu diretório e informe sua Conta (seu e-mail cadastrado no PagSeguro) e Token. Lembre-se de atualizar o campo \'Símbolo da moeda\' para <b>R$</b> e \'Moeda de Pagamento\' para <b>BRL</b>.<br /> 10. Clique em \'Enviar\' para habilitar o PagSeguro no seu diretório.<br /><br /> Obs: <br/ > -Lembre-se de atualizar o token de segurança no seu diretório sempre que gerar um novo token no Pagseguro;<br /> -Para que seus usuários possam fazer pagamentos com cartão de crédito, sua conta no PagSeguro precisa ser verificada. Leia mais em https://pagseguro.uol.com.br/account/viewCheck.jhtml ;<br /> -O PagSeguro envia os dados de uma transação para o diretório sempre que o status é alterado. Note que as formas de pagamento (cartão, boleto bancário, etc), possuem diferentes prazos para liberação do pagamento.','n',''),(68,'y','n','n','What happens with the items when I disable a level?','In banner level cases, all items already registered of this level will keep showing on the front of the directory until their expiration. Otherwise these items will be treated as the \'default level\', however, the search order priority and the featured area priviliges will be the same as the disabled level.','n',''),(54,'y','n','n','How does the \"Featured Categories\" work?','If you enable featured category on \"Setting - Featured categories\", only the selected module will show the featured checkbox when adding or editing a category. This box enable the category to be seen in Browse by category and it\'s only available for the levels that appear on front - category and subcategory. When adding a category through import all new categories will come checked if this option is turned on in Import Settings.<br />PS: This feature isn\'t available for the theme Dining Guide.','n',''),(53,'y','n','n','Can I edit the maintenance page?','Yes. There\'s a feature on Site Content in the General Section so you can edit how maintenance page will show up when the Maintenance Mode is on. ','n',''),(52,'y','n','n','What happens when I enable maintenance mode?','When you turn on maintenance mode, all the front pages are redirected to the maintenance page.','n',''),(67,'y','n','n','Can I change my Locations Options all the time?','No. If the directory already has items assigned to a level, it can´t be disabled. You also can´t choose a Default Location if there are items from different locations for that level.  Also, you can´t enable a Location Level if there are child levels enabled and non assigned items to that level you are trying to enable. For example: if the directory is using country, state and city, and there are items registered, you can enable neighborhood, but you can´t enable region because in this case the system will not have regions and states assigned. So, is extremely important decide your locations options before inserting data in directory. ','n',''),(66,'y','n','n','My directory is using a Default Locations but now I want to use other locations. What should I do?','In setting locations, choose the option “No Default” in the select box that is holding the Default Location you don´t want anymore.','n',''),(65,'y','n','n','What is the option “Show default” in Setting Locations?','When a default location is chosen, the option “show default” becomes available. When you enable it, the default location will be shown in all places that locations are shown, for example, in the summary and detail views for items. Otherwise the default location will be hidden. ','n',''),(62,'y','n','n','What is Setting Locations?','This is where you choose the location levels you want to use within the directory. With this form you will also have the option to choose default locations and whether or not they will be illustrated on the front of the directory.','n',''),(63,'y','n','n','How do I choose the locations levels I want to use?','There are five Locations Levels available: Country, Region, State, City and Neighborhood. Select which you want to use by checking the “enable” checkboxes for each level.','n',''),(64,'y','n','n','What are Default Locations?','The locations chosen as default are automatically assigned to all items that will be registered in the directory. The member will not have the option to choose a different one. Example: select a default location if your directory will always show data in a specific location, e.g selecting United States as a default country will prevent you from adding Canada locations to your directory.','n',''),(69,'y','n','n','What happens if I delete a site?','Be sure that the site you are deleting is no longer accessible, because once it been deleted, the home page, members and site manager areas do not work anymore.\r\nAfter delete the site, your data base will be preserved for one week, so you can recover it if you want. After that, all data base and files related to your site will be deleted.','n',''),(70,'y','n','n','What I have to do after I create a new site?','After you create a new site an email will be sent to the eDirectory support team. \r\nAfter that the support team will prepare the site to work correctly in the front. \r\nThe new site only will be completed after you buy a new eDirectory licence with a discounted rate and finish the registration process for all these sites. \r\nIn the \"Sites Management Page\" has a column in the table to indicate the activation status of your sites. \r\nActive means the registration process was finished and the site has been activated. \r\nPending means the registration process is waiting for the licence and activation.','n',''),(72,'y','n','n','I am using the multi-domain feature, can I use different locations levels for each site?','Yes, you can configure the location levels for each site, e.g. Country > State > City for the site 1, State > City for the site 2 and just City for the site 3.','n',''),(73,'y','n','n','I am using the multi-domain feature, can I add different locations for each site?','Yes, you can add different location for each site (but first you must configure the locations levels for each site).','n',''),(77,'y','n','n','How can I enable the Twitter Widget on my Home Page?','1. Login on twitter and go to https://twitter.com/settings/widgets.<br />\r\n2. Click on \'\'Create New\'\'.<br />\r\n3. Customize your Widget and click on \'\'Create widget\'\'. We suggest you don\'t change the options Height, Theme and Link Color. These will be done automatically according to your eDirectory theme in use.<br>\r\n4. Copy the code and paste on your eDirectory administration area (Site Content > General > Home Page > Twitter Widget).','n',''),(75,'y','n','n','I am using the multi-domain feature, how will the import work?','You have to import different files for each site. When you make an import, the items and categories will be imported into the selected site; the account will be imported to a general database, which means that the member can login using the account on all sites. The locations will be imported and will appear for the selected site.','n',''),(76,'y','n','n','I want to use the multi-domain feature, how can I enable it?','If you want to have different sites you can use the multi-domain feature and create a new site. Click on Sites > Add, fill out the new site information and click on the Submit button.','n',''),(79,'y','n','n','What is the field Listing ID/Event ID?','If your CSV file comes from Export Section, this field will be filled with the values in your eDirectory database. Items that match (with the same Listing ID/Event ID) on import can be overwritten / replaced during the import process. This setting can be found on the import settings tab.','n',''),(80,'y','n','n','What is the recommended size of my CSV file?','If you want to upload a CSV, we recommend small files with default maximum of 5mb. For bigger files, you must send your file to the import folder by FTP first and use the Select File by FTP option on the import window. Notice that when you use the FTP option, a task will be scheduled to prepare your file before the import, depending on your server configuration this can take some time.','n',''),(83,'y','n','n','What are the fields Start Time Mode and End Time Mode?','If you are importing events which have start time or end time, you must fill in these fields. Use \"AM\" or \"PM\" if your clock type is 12 hours or just put \"24\" if you use a 24 hours clock.','n',''),(85,'y','n','n','What is Favicon? And where is it used?','A favicon (short for favorites icon) is a file containing one small icon, most commonly 16×16 pixels, associated with a particular Web site. Browsers that provide favicon support typically display a page\'s favicon in the browser\'s address bar and next to the page\'s name in a list of bookmarks. Also, the ones that support a tabbed document interface typically show a page\'s favicon next to the page\'s title on the tab. By using a favicon your users can identify your directory web site in a list of others web sites.','n',''),(82,'y','n','n','How can I setup my Twilio API?','Go to http://www.twilio.com/pricing/ and click in \"Get started\". In the next page, fill in your First Name, Last Name, Email and Password and click in \"Get started\". You will be logged in and in the following page you will see your Account SID, Auth Token and Sandbox Number. Just copy these informations to your site manager and click in \"Submit\".','n',''),(87,'y','n','n','O que significam os status das transações do PagSeguro?','O PagSeguro retorna diferentes status de transações para o diretório durante o processo de pagamento. Veja abaixo os detalhes de cada status:<br /><br />\r\n<b>-Aguardando pagamento/aprovação: </b>O comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento;<br />\r\n<b>-Em análise: </b>O comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação;<br />\r\n<b>-Pago: </b>A transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento;<br />\r\n<b>-Disponível: </b>A transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta;<br />\r\n<b>-Em disputa: </b>O comprador, dentro do prazo de liberação da transação, abriu uma disputa;<br />\r\n<b>-Devolvido: </b>O valor da transação foi devolvido para o comprador;<br />\r\n<b>-Cancelado: </b>A transação foi cancelada sem ter sido finalizada.<br />','n',''),(88,'y','n','n','How do I signup for a Google Maps API?','Follow the steps below to create your API key.<br />\r\n1. Go to https://code.google.com/apis/console/ ;<br />\r\n2. On the Services Tab, enable the Google Maps API v3 option;<br />\r\n3. On the API Access Tab, take note of the API key in the Simple API Access option;<br />\r\n4. You can limit this API to specific domains by informing them in the \'Create new Browser key...\' option;<br />\r\n5. After save your API key on your site manager interface, you can track your API usage on the Reports tab.','n','');
/*!40000 ALTER TABLE `FAQ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Gallery`
--

DROP TABLE IF EXISTS `Gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Gallery`
--

LOCK TABLES `Gallery` WRITE;
/*!40000 ALTER TABLE `Gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `Gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Gallery_Image`
--

DROP TABLE IF EXISTS `Gallery_Image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gallery_Image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `image_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `thumb_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_default` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Gallery_Image`
--

LOCK TABLES `Gallery_Image` WRITE;
/*!40000 ALTER TABLE `Gallery_Image` DISABLE KEYS */;
/*!40000 ALTER TABLE `Gallery_Image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Gallery_Item`
--

DROP TABLE IF EXISTS `Gallery_Item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gallery_Item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `gallery_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `item_type` (`item_type`),
  KEY `item_id` (`item_id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Gallery_Item`
--

LOCK TABLES `Gallery_Item` WRITE;
/*!40000 ALTER TABLE `Gallery_Item` DISABLE KEYS */;
/*!40000 ALTER TABLE `Gallery_Item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Gallery_Temp`
--

DROP TABLE IF EXISTS `Gallery_Temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gallery_Temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `image_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb_id` int(11) NOT NULL,
  `thumb_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_default` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `sess_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Gallery_Temp`
--

LOCK TABLES `Gallery_Temp` WRITE;
/*!40000 ALTER TABLE `Gallery_Temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `Gallery_Temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Image`
--

DROP TABLE IF EXISTS `Image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` set('JPG','GIF','SWF','PNG') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'JPG',
  `width` smallint(6) NOT NULL DEFAULT '0',
  `height` smallint(6) NOT NULL DEFAULT '0',
  `prefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Image`
--

LOCK TABLES `Image` WRITE;
/*!40000 ALTER TABLE `Image` DISABLE KEYS */;
/*!40000 ALTER TABLE `Image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ImportLog`
--

DROP TABLE IF EXISTS `ImportLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ImportLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linesadded` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phisicalname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `action` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `progress` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `totallines` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `errorlines` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `itens_added` int(11) NOT NULL,
  `accounts_added` int(11) NOT NULL,
  `history` longtext COLLATE utf8_unicode_ci NOT NULL,
  `update_itens` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `from_export` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `active_item` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `update_friendlyurl` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `featured_categs` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `default_level` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `same_account` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `account_id` int(11) NOT NULL,
  `delimiter` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `mysqlerror` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'listing',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ImportLog`
--

LOCK TABLES `ImportLog` WRITE;
/*!40000 ALTER TABLE `ImportLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `ImportLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ImportTemporary`
--

DROP TABLE IF EXISTS `ImportTemporary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ImportTemporary` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `import_log_id` int(11) NOT NULL DEFAULT '0',
  `account_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_id` int(11) DEFAULT '0',
  `listing_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location1_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location2_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location3_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location4_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_location5_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_latitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_longitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_long_description` text COLLATE utf8_unicode_ci,
  `listing_seo_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_renewal_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_level` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_category_1` text COLLATE utf8_unicode_ci,
  `listing_category_2` text COLLATE utf8_unicode_ci,
  `listing_category_3` text COLLATE utf8_unicode_ci,
  `listing_category_4` text COLLATE utf8_unicode_ci,
  `listing_category_5` text COLLATE utf8_unicode_ci,
  `listing_template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_line_number` int(11) NOT NULL DEFAULT '0',
  `inserted` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `error` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ImportTemporary`
--

LOCK TABLES `ImportTemporary` WRITE;
/*!40000 ALTER TABLE `ImportTemporary` DISABLE KEYS */;
/*!40000 ALTER TABLE `ImportTemporary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ImportTemporary_Event`
--

DROP TABLE IF EXISTS `ImportTemporary_Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ImportTemporary_Event` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `import_log_id` int(11) NOT NULL DEFAULT '0',
  `account_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_id` int(11) DEFAULT '0',
  `event_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_locationname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_contactname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_startdate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_enddate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_starttime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_starttime_mode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_endtime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_endtime_mode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location1_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location2_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location3_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location4_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location5_abbreviation` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_latitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_longitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_long_description` text COLLATE utf8_unicode_ci,
  `event_seo_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_renewal_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_level` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_category_1` text COLLATE utf8_unicode_ci,
  `event_category_2` text COLLATE utf8_unicode_ci,
  `event_category_3` text COLLATE utf8_unicode_ci,
  `event_category_4` text COLLATE utf8_unicode_ci,
  `event_category_5` text COLLATE utf8_unicode_ci,
  `custom_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_line_number` int(11) NOT NULL DEFAULT '0',
  `inserted` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `error` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ImportTemporary_Event`
--

LOCK TABLES `ImportTemporary_Event` WRITE;
/*!40000 ALTER TABLE `ImportTemporary_Event` DISABLE KEYS */;
/*!40000 ALTER TABLE `ImportTemporary_Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice`
--

DROP TABLE IF EXISTS `Invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtotal_amount` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` date DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `hidden` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `date` (`date`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice`
--

LOCK TABLES `Invoice` WRITE;
/*!40000 ALTER TABLE `Invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_Article`
--

DROP TABLE IF EXISTS `Invoice_Article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_Article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `article_id` int(11) NOT NULL DEFAULT '0',
  `article_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_Article`
--

LOCK TABLES `Invoice_Article` WRITE;
/*!40000 ALTER TABLE `Invoice_Article` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_Article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_Banner`
--

DROP TABLE IF EXISTS `Invoice_Banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_Banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `banner_id` int(11) NOT NULL DEFAULT '0',
  `banner_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date DEFAULT NULL,
  `impressions` mediumint(9) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `banner_id` (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_Banner`
--

LOCK TABLES `Invoice_Banner` WRITE;
/*!40000 ALTER TABLE `Invoice_Banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_Banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_Classified`
--

DROP TABLE IF EXISTS `Invoice_Classified`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_Classified` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `classified_id` int(11) NOT NULL DEFAULT '0',
  `classified_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `classified_id` (`classified_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_Classified`
--

LOCK TABLES `Invoice_Classified` WRITE;
/*!40000 ALTER TABLE `Invoice_Classified` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_Classified` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_CustomInvoice`
--

DROP TABLE IF EXISTS `Invoice_CustomInvoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_CustomInvoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `custom_invoice_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `items_price` text COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `custom_invoice_id` (`custom_invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_CustomInvoice`
--

LOCK TABLES `Invoice_CustomInvoice` WRITE;
/*!40000 ALTER TABLE `Invoice_CustomInvoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_CustomInvoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_Event`
--

DROP TABLE IF EXISTS `Invoice_Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_Event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `event_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_Event`
--

LOCK TABLES `Invoice_Event` WRITE;
/*!40000 ALTER TABLE `Invoice_Event` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_Listing`
--

DROP TABLE IF EXISTS `Invoice_Listing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_Listing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `listing_id` int(11) NOT NULL DEFAULT '0',
  `listing_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date DEFAULT NULL,
  `categories` tinyint(4) NOT NULL,
  `extra_categories` tinyint(4) NOT NULL DEFAULT '0',
  `listingtemplate_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `listing_id` (`listing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_Listing`
--

LOCK TABLES `Invoice_Listing` WRITE;
/*!40000 ALTER TABLE `Invoice_Listing` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_Listing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice_Package`
--

DROP TABLE IF EXISTS `Invoice_Package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice_Package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `package_id` int(11) NOT NULL DEFAULT '0',
  `package_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `items_price` text COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `package_id` (`package_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice_Package`
--

LOCK TABLES `Invoice_Package` WRITE;
/*!40000 ALTER TABLE `Invoice_Package` DISABLE KEYS */;
/*!40000 ALTER TABLE `Invoice_Package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ItemStatistic`
--

DROP TABLE IF EXISTS `ItemStatistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemStatistic` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemStatistic`
--

LOCK TABLES `ItemStatistic` WRITE;
/*!40000 ALTER TABLE `ItemStatistic` DISABLE KEYS */;
/*!40000 ALTER TABLE `ItemStatistic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lang`
--

DROP TABLE IF EXISTS `Lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lang` (
  `id_number` int(11) NOT NULL AUTO_INCREMENT,
  `id` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang_enabled` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `lang_default` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `lang_order` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_number`),
  KEY `name` (`name`),
  KEY `enabled` (`lang_enabled`),
  KEY `default` (`lang_default`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lang`
--

LOCK TABLES `Lang` WRITE;
/*!40000 ALTER TABLE `Lang` DISABLE KEYS */;
INSERT INTO `Lang` VALUES (1,'en_us','English','y','y',0),(2,'pt_br','Português','n','n',1),(3,'es_es','Español','n','n',3),(4,'fr_fr','Français','n','n',4),(5,'it_it','Italiano','n','n',2),(6,'ge_ge','Deutsch','n','n',5),(7,'tr_tr','Türkçe','n','n',6);
/*!40000 ALTER TABLE `Lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Leads`
--

DROP TABLE IF EXISTS `Leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'listing/event/classified/general',
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reply_date` datetime DEFAULT '0000-00-00 00:00:00',
  `forward_date` datetime DEFAULT '0000-00-00 00:00:00',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P' COMMENT 'A : read / P: unread',
  `new` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y' COMMENT 'y/n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Leads`
--

LOCK TABLES `Leads` WRITE;
/*!40000 ALTER TABLE `Leads` DISABLE KEYS */;
/*!40000 ALTER TABLE `Leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Listing`
--

DROP TABLE IF EXISTS `Listing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Listing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) NOT NULL DEFAULT '0',
  `promotion_id` int(11) NOT NULL DEFAULT '0',
  `location_1` int(11) NOT NULL DEFAULT '0',
  `location_2` int(11) NOT NULL DEFAULT '0',
  `location_3` int(11) NOT NULL DEFAULT '0',
  `location_4` int(11) NOT NULL DEFAULT '0',
  `location_5` int(11) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `discount_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `show_email` enum('y','n') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `zip5` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `latitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `features` text COLLATE utf8_unicode_ci NOT NULL,
  `price` int(10) DEFAULT NULL COMMENT 'price range (1-4)',
  `facebook_page` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `suspended_sitemgr` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `reminder` tinyint(4) NOT NULL DEFAULT '0',
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `video_snippet` text COLLATE utf8_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `video_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `importID` int(11) NOT NULL DEFAULT '0',
  `hours_work` text COLLATE utf8_unicode_ci NOT NULL,
  `locations` text COLLATE utf8_unicode_ci NOT NULL,
  `claim_disable` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `listingtemplate_id` int(11) DEFAULT NULL,
  `custom_checkbox0` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox1` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox2` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox3` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox4` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox5` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox6` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox7` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox8` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox9` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc0` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc1` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc2` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc3` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc4` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc5` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc6` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc7` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc8` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc9` text COLLATE utf8_unicode_ci NOT NULL,
  `number_views` int(11) NOT NULL DEFAULT '0',
  `avg_review` int(11) NOT NULL DEFAULT '0',
  `map_zoom` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `backlink` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `backlink_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clicktocall_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clicktocall_extension` int(5) DEFAULT NULL,
  `clicktocall_date` date DEFAULT NULL,
  `last_traffic_sent` date NOT NULL,
  `custom_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `friendly_url_2` (`friendly_url`),
  KEY `title` (`title`),
  KEY `random_number` (`random_number`),
  KEY `country_id` (`location_1`),
  KEY `state_id` (`location_2`),
  KEY `region_id` (`location_3`),
  KEY `account_id` (`account_id`),
  KEY `renewal_date` (`renewal_date`),
  KEY `status` (`status`),
  KEY `promotion_id` (`promotion_id`),
  KEY `latitude` (`latitude`),
  KEY `longitude` (`longitude`),
  KEY `level` (`level`),
  KEY `city_id` (`location_4`),
  KEY `area_id` (`location_5`),
  KEY `zip_code` (`zip_code`),
  KEY `friendly_url` (`friendly_url`),
  KEY `listingtemplate_id` (`listingtemplate_id`),
  KEY `image_id` (`image_id`),
  KEY `thumb_id` (`thumb_id`),
  KEY `idx_fulltextsearch_keyword` (`fulltextsearch_keyword`(3)),
  KEY `idx_fulltextsearch_where` (`fulltextsearch_where`(3)),
  KEY `updated_date` (`updated`),
  KEY `clicktocall_number` (`clicktocall_number`),
  KEY `Listing_Promotion` (`level`,`promotion_id`,`account_id`,`title`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Listing`
--

LOCK TABLES `Listing` WRITE;
/*!40000 ALTER TABLE `Listing` DISABLE KEYS */;
/*!40000 ALTER TABLE `Listing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ListingCategory`
--

DROP TABLE IF EXISTS `ListingCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ListingCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root_id` int(11) DEFAULT '0',
  `left` int(11) DEFAULT '0',
  `right` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `summary_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `active_listing` int(11) NOT NULL DEFAULT '0',
  `full_friendly_url` text COLLATE utf8_unicode_ci,
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `count_sub` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `active_listing` (`active_listing`),
  KEY `title1` (`title`),
  KEY `friendly_url1` (`friendly_url`),
  KEY `right` (`right`),
  KEY `root_id` (`root_id`),
  KEY `left` (`left`),
  KEY `cat_tree` (`root_id`,`left`,`right`),
  KEY `category_id_2` (`category_id`,`active_listing`),
  FULLTEXT KEY `keywords` (`keywords`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ListingCategory`
--

LOCK TABLES `ListingCategory` WRITE;
/*!40000 ALTER TABLE `ListingCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `ListingCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ListingLevel`
--

DROP TABLE IF EXISTS `ListingLevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ListingLevel` (
  `value` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaultlevel` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `detail` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `images` int(3) NOT NULL DEFAULT '0',
  `has_promotion` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `has_review` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `has_sms` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `has_call` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `backlink` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `free_category` int(3) NOT NULL DEFAULT '0',
  `category_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `popular` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `featured` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`value`,`theme`),
  KEY `active_value` (`active`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ListingLevel`
--

LOCK TABLES `ListingLevel` WRITE;
/*!40000 ALTER TABLE `ListingLevel` DISABLE KEYS */;
INSERT INTO `ListingLevel` VALUES (70,'bronze','n','n',0,'n','y','n','n','n',0.00,1,5.00,'y','','','','default'),(50,'silver','n','n',0,'n','y','n','n','n',99.00,1,10.00,'y','','','','default'),(30,'gold','n','n',0,'n','y','n','n','n',199.00,2,15.00,'y','','','','default'),(10,'diamond','y','y',9,'y','y','y','y','y',299.00,3,20.00,'y','y','y','','default');
/*!40000 ALTER TABLE `ListingLevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ListingLevel_Field`
--

DROP TABLE IF EXISTS `ListingLevel_Field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ListingLevel_Field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(3) NOT NULL,
  `field` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `theme` (`theme`,`level`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ListingLevel_Field`
--

LOCK TABLES `ListingLevel_Field` WRITE;
/*!40000 ALTER TABLE `ListingLevel_Field` DISABLE KEYS */;
INSERT INTO `ListingLevel_Field` VALUES (115,'default',10,'summary_description'),(102,'default',10,'email'),(105,'default',10,'url'),(111,'default',10,'fax'),(112,'default',10,'video'),(113,'default',10,'attachment_file'),(116,'default',10,'long_description'),(117,'default',10,'hours_of_work'),(120,'default',10,'locations'),(119,'default',10,'badges'),(121,'default',10,'main_image'),(114,'default',30,'summary_description'),(101,'default',30,'email'),(104,'default',30,'url'),(110,'default',30,'fax'),(118,'default',30,'badges'),(100,'default',50,'email'),(103,'default',50,'url'),(109,'default',10,'phone'),(108,'default',30,'phone'),(107,'default',50,'phone'),(106,'default',70,'phone'),(122,'default',10,'fbpage'),(123,'default',10,'features');
/*!40000 ALTER TABLE `ListingLevel_Field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ListingTemplate`
--

DROP TABLE IF EXISTS `ListingTemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ListingTemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime NOT NULL,
  `entered` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `editable` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `theme` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ListingTemplate`
--

LOCK TABLES `ListingTemplate` WRITE;
/*!40000 ALTER TABLE `ListingTemplate` DISABLE KEYS */;
INSERT INTO `ListingTemplate` VALUES (1,0,'Listing','0000-00-00 00:00:00','0000-00-00 00:00:00','enabled',0.00,'','n','default');
/*!40000 ALTER TABLE `ListingTemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ListingTemplate_Field`
--

DROP TABLE IF EXISTS `ListingTemplate_Field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ListingTemplate_Field` (
  `listingtemplate_id` int(11) NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fieldvalues` text COLLATE utf8_unicode_ci NOT NULL,
  `instructions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `required` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `search` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `searchbykeyword` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `searchbyrange` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `show_order` int(11) NOT NULL DEFAULT '0',
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`listingtemplate_id`,`field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ListingTemplate_Field`
--

LOCK TABLES `ListingTemplate_Field` WRITE;
/*!40000 ALTER TABLE `ListingTemplate_Field` DISABLE KEYS */;
/*!40000 ALTER TABLE `ListingTemplate_Field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Listing_Category`
--

DROP TABLE IF EXISTS `Listing_Category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Listing_Category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_root_id` int(11) NOT NULL,
  `category_node_left` int(11) NOT NULL,
  `category_node_right` int(11) NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `listing_id` (`listing_id`),
  KEY `category_id` (`category_id`),
  KEY `status` (`status`),
  KEY `category_status` (`category_id`,`status`),
  KEY `category_listing_id` (`category_id`,`category_root_id`,`listing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Listing_Category`
--

LOCK TABLES `Listing_Category` WRITE;
/*!40000 ALTER TABLE `Listing_Category` DISABLE KEYS */;
/*!40000 ALTER TABLE `Listing_Category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Listing_Choice`
--

DROP TABLE IF EXISTS `Listing_Choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Listing_Choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_choice_id` int(11) NOT NULL DEFAULT '0',
  `listing_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `EditorChoice_has_Listing_FKIndex1` (`editor_choice_id`),
  KEY `EditorChoice_has_Listing_FKIndex2` (`listing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Listing_Choice`
--

LOCK TABLES `Listing_Choice` WRITE;
/*!40000 ALTER TABLE `Listing_Choice` DISABLE KEYS */;
/*!40000 ALTER TABLE `Listing_Choice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Listing_FeaturedTemp`
--

DROP TABLE IF EXISTS `Listing_FeaturedTemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Listing_FeaturedTemp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NOT NULL,
  `listing_level` int(11) NOT NULL,
  `random_number` bigint(15) NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Listing_FeaturedTemp` (`listing_level`,`status`,`listing_id`,`random_number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Listing_FeaturedTemp`
--

LOCK TABLES `Listing_FeaturedTemp` WRITE;
/*!40000 ALTER TABLE `Listing_FeaturedTemp` DISABLE KEYS */;
/*!40000 ALTER TABLE `Listing_FeaturedTemp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Listing_LocationCounter`
--

DROP TABLE IF EXISTS `Listing_LocationCounter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Listing_LocationCounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_level` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `full_friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Listing_LocationCounter`
--

LOCK TABLES `Listing_LocationCounter` WRITE;
/*!40000 ALTER TABLE `Listing_LocationCounter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Listing_LocationCounter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Listing_Summary`
--

DROP TABLE IF EXISTS `Listing_Summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Listing_Summary` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `location_1` int(11) NOT NULL,
  `location_1_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_1_abbreviation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location_1_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_2` int(11) NOT NULL,
  `location_2_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_2_abbreviation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location_2_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_3` int(11) NOT NULL,
  `location_3_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_3_abbreviation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location_3_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_4` int(11) NOT NULL,
  `location_4_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_4_abbreviation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location_4_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_5` int(11) NOT NULL,
  `location_5_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location_5_abbreviation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location_5_friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(11) NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `show_email` enum('y','n') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `zip5` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `latitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `maptuning` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `claim_disable` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `locations` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox0` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox1` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox2` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox3` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox4` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox5` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox6` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox7` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox8` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_checkbox9` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_dropdown9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_text9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_short_desc9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc0` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc1` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc2` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc3` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc4` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc5` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc6` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc7` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc8` text COLLATE utf8_unicode_ci NOT NULL,
  `custom_long_desc9` text COLLATE utf8_unicode_ci NOT NULL,
  `number_views` int(11) NOT NULL DEFAULT '0',
  `avg_review` int(11) NOT NULL DEFAULT '0',
  `price` int(10) DEFAULT NULL COMMENT 'price range (1-4)',
  `promotion_start_date` date NOT NULL DEFAULT '0000-00-00',
  `promotion_end_date` date NOT NULL DEFAULT '0000-00-00',
  `thumb_id` int(11) NOT NULL,
  `thumb_type` set('JPG','GIF','SWF','PNG') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'JPG',
  `thumb_width` smallint(6) NOT NULL DEFAULT '0',
  `thumb_height` smallint(6) NOT NULL DEFAULT '0',
  `listingtemplate_id` int(11) NOT NULL DEFAULT '0',
  `template_layout_id` int(11) NOT NULL DEFAULT '0',
  `template_cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `updated` datetime NOT NULL,
  `entered` datetime NOT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `backlink` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `clicktocall_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clicktocall_extension` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `title_keywords_seokeywords` (`status`,`title`(100)),
  KEY `id_status` (`id`,`status`),
  KEY `clicktocall_number` (`clicktocall_number`),
  KEY `Listing_Promotion` (`level`,`promotion_id`,`account_id`,`title`,`id`),
  KEY `rating_filter` (`level`,`status`,`avg_review`),
  KEY `price_filter` (`level`,`status`,`price`),
  FULLTEXT KEY `fulltextsearch_keyword` (`fulltextsearch_keyword`),
  FULLTEXT KEY `fulltextsearch_where` (`fulltextsearch_where`),
  FULLTEXT KEY `fulltextsearch_title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Listing_Summary`
--

LOCK TABLES `Listing_Summary` WRITE;
/*!40000 ALTER TABLE `Listing_Summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `Listing_Summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MailAppList`
--

DROP TABLE IF EXISTS `MailAppList`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MailAppList` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `module` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) CHARACTER SET utf8 DEFAULT NULL COMMENT 'P=Pending, F=Finished, R=Running, E=Error',
  `filename` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `categories` text CHARACTER SET utf8,
  `progress` int(11) DEFAULT NULL,
  `total_item_exported` int(11) NOT NULL DEFAULT '0',
  `last_account_exported` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MailAppList`
--

LOCK TABLES `MailAppList` WRITE;
/*!40000 ALTER TABLE `MailAppList` DISABLE KEYS */;
/*!40000 ALTER TABLE `MailAppList` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MailApp_Subscribers`
--

DROP TABLE IF EXISTS `MailApp_Subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MailApp_Subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `subscriber_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subscriber_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subscriber_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `list_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MailApp_Subscribers`
--

LOCK TABLES `MailApp_Subscribers` WRITE;
/*!40000 ALTER TABLE `MailApp_Subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `MailApp_Subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Article_Log`
--

DROP TABLE IF EXISTS `Payment_Article_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Article_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `article_id` int(11) NOT NULL DEFAULT '0',
  `article_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Article_Log`
--

LOCK TABLES `Payment_Article_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Article_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Article_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Banner_Log`
--

DROP TABLE IF EXISTS `Payment_Banner_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Banner_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `banner_id` int(11) NOT NULL DEFAULT '0',
  `banner_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `impressions` mediumint(9) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `banner_id` (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Banner_Log`
--

LOCK TABLES `Payment_Banner_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Banner_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Banner_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Classified_Log`
--

DROP TABLE IF EXISTS `Payment_Classified_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Classified_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `classified_id` int(11) NOT NULL DEFAULT '0',
  `classified_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `classified_id` (`classified_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Classified_Log`
--

LOCK TABLES `Payment_Classified_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Classified_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Classified_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_CustomInvoice_Log`
--

DROP TABLE IF EXISTS `Payment_CustomInvoice_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_CustomInvoice_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `custom_invoice_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `items_price` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `custom_invoice_id` (`custom_invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_CustomInvoice_Log`
--

LOCK TABLES `Payment_CustomInvoice_Log` WRITE;
/*!40000 ALTER TABLE `Payment_CustomInvoice_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_CustomInvoice_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Event_Log`
--

DROP TABLE IF EXISTS `Payment_Event_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Event_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `event_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Event_Log`
--

LOCK TABLES `Payment_Event_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Event_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Event_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Listing_Log`
--

DROP TABLE IF EXISTS `Payment_Listing_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Listing_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `listing_id` int(11) NOT NULL DEFAULT '0',
  `listing_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `level_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `renewal_date` date NOT NULL DEFAULT '0000-00-00',
  `categories` tinyint(4) NOT NULL DEFAULT '0',
  `extra_categories` tinyint(4) NOT NULL DEFAULT '0',
  `listingtemplate_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `listing_id` (`listing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Listing_Log`
--

LOCK TABLES `Payment_Listing_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Listing_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Listing_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Log`
--

DROP TABLE IF EXISTS `Payment_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `transaction_subtotal` decimal(10,2) NOT NULL,
  `transaction_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transaction_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transaction_currency` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `system_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recurring` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `return_fields` text COLLATE utf8_unicode_ci NOT NULL,
  `hidden` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Log`
--

LOCK TABLES `Payment_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment_Package_Log`
--

DROP TABLE IF EXISTS `Payment_Package_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment_Package_Log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_log_id` int(11) NOT NULL DEFAULT '0',
  `package_id` int(11) NOT NULL DEFAULT '0',
  `package_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `items_price` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `payment_log_id` (`payment_log_id`),
  KEY `package_id` (`package_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment_Package_Log`
--

LOCK TABLES `Payment_Package_Log` WRITE;
/*!40000 ALTER TABLE `Payment_Package_Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Payment_Package_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Post`
--

DROP TABLE IF EXISTS `Post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friendly_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumb_caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_abstract` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `number_views` int(11) NOT NULL DEFAULT '0',
  `legacy_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `legacy_id` (`legacy_id`(7)),
  KEY `title` (`title`),
  KEY `status` (`status`),
  KEY `friendly_url` (`friendly_url`),
  KEY `entered` (`entered`),
  KEY `updated` (`updated`),
  FULLTEXT KEY `fulltextsearch_keyword` (`fulltextsearch_keyword`),
  FULLTEXT KEY `fulltextsearch_where` (`fulltextsearch_where`),
  FULLTEXT KEY `fulltextsearch_title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Post`
--

LOCK TABLES `Post` WRITE;
/*!40000 ALTER TABLE `Post` DISABLE KEYS */;
/*!40000 ALTER TABLE `Post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Promotion`
--

DROP TABLE IF EXISTS `Promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `thumb_id` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `entered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seo_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_keyword` text COLLATE utf8_unicode_ci NOT NULL,
  `fulltextsearch_where` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `random_number` bigint(15) NOT NULL DEFAULT '0',
  `conditions` text COLLATE utf8_unicode_ci NOT NULL,
  `number_views` int(11) NOT NULL DEFAULT '0',
  `visibility_start` int(11) NOT NULL,
  `visibility_end` int(11) NOT NULL,
  `realvalue` double(8,2) NOT NULL,
  `dealvalue` double(8,2) NOT NULL,
  `deal_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'monetary value' COMMENT 'percentage/monetary value',
  `amount` int(8) NOT NULL,
  `avg_review` int(11) NOT NULL,
  `friendly_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `listing_id` int(11) NOT NULL,
  `listing_status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `listing_level` tinyint(3) NOT NULL,
  `listing_location1` int(11) DEFAULT NULL,
  `listing_location2` int(11) DEFAULT NULL,
  `listing_location3` int(11) DEFAULT NULL,
  `listing_location4` int(11) DEFAULT NULL,
  `listing_location5` int(11) DEFAULT NULL,
  `listing_address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_address2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_zipcode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `listing_zip5` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `listing_latitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `listing_longitude` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`),
  KEY `name` (`name`),
  KEY `random_number` (`random_number`),
  KEY `listing_level` (`listing_level`),
  KEY `listing_id` (`listing_id`,`listing_status`),
  FULLTEXT KEY `fulltextsearch_keyword` (`fulltextsearch_keyword`),
  FULLTEXT KEY `fulltextsearch_where` (`fulltextsearch_where`),
  FULLTEXT KEY `fulltextsearch_title` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Promotion`
--

LOCK TABLES `Promotion` WRITE;
/*!40000 ALTER TABLE `Promotion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Promotion_LocationCounter`
--

DROP TABLE IF EXISTS `Promotion_LocationCounter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Promotion_LocationCounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_level` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `full_friendly_url` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Promotion_LocationCounter`
--

LOCK TABLES `Promotion_LocationCounter` WRITE;
/*!40000 ALTER TABLE `Promotion_LocationCounter` DISABLE KEYS */;
/*!40000 ALTER TABLE `Promotion_LocationCounter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Promotion_Redeem`
--

DROP TABLE IF EXISTS `Promotion_Redeem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Promotion_Redeem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `profile_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `promotion_id` int(11) NOT NULL,
  `twittered` int(11) NOT NULL,
  `facebooked` int(11) NOT NULL,
  `network_response` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `redeem_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `used` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `promotion_info` (`account_id`,`promotion_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Promotion_Redeem`
--

LOCK TABLES `Promotion_Redeem` WRITE;
/*!40000 ALTER TABLE `Promotion_Redeem` DISABLE KEYS */;
/*!40000 ALTER TABLE `Promotion_Redeem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Quicklist`
--

DROP TABLE IF EXISTS `Quicklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Quicklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Quicklist`
--

LOCK TABLES `Quicklist` WRITE;
/*!40000 ALTER TABLE `Quicklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `Quicklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Article`
--

DROP TABLE IF EXISTS `Report_Article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`article_id`,`report_type`,`date`),
  KEY `article_id` (`article_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Article`
--

LOCK TABLES `Report_Article` WRITE;
/*!40000 ALTER TABLE `Report_Article` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Article_Daily`
--

DROP TABLE IF EXISTS `Report_Article_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Article_Daily` (
  `article_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Article_Daily`
--

LOCK TABLES `Report_Article_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Article_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Article_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Article_Monthly`
--

DROP TABLE IF EXISTS `Report_Article_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Article_Monthly` (
  `article_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Article_Monthly`
--

LOCK TABLES `Report_Article_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Article_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Article_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Banner`
--

DROP TABLE IF EXISTS `Report_Banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`banner_id`,`report_type`,`date`),
  KEY `banner_id` (`banner_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Banner`
--

LOCK TABLES `Report_Banner` WRITE;
/*!40000 ALTER TABLE `Report_Banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Banner_Daily`
--

DROP TABLE IF EXISTS `Report_Banner_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Banner_Daily` (
  `banner_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `view` int(11) NOT NULL DEFAULT '0',
  `click_thru` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Banner_Daily`
--

LOCK TABLES `Report_Banner_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Banner_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Banner_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Banner_Monthly`
--

DROP TABLE IF EXISTS `Report_Banner_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Banner_Monthly` (
  `banner_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `click_thru` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Banner_Monthly`
--

LOCK TABLES `Report_Banner_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Banner_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Banner_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Classified`
--

DROP TABLE IF EXISTS `Report_Classified`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Classified` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classified_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`classified_id`,`report_type`,`date`),
  KEY `classified_id` (`classified_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Classified`
--

LOCK TABLES `Report_Classified` WRITE;
/*!40000 ALTER TABLE `Report_Classified` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Classified` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Classified_Daily`
--

DROP TABLE IF EXISTS `Report_Classified_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Classified_Daily` (
  `classified_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`classified_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Classified_Daily`
--

LOCK TABLES `Report_Classified_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Classified_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Classified_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Classified_Monthly`
--

DROP TABLE IF EXISTS `Report_Classified_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Classified_Monthly` (
  `classified_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`classified_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Classified_Monthly`
--

LOCK TABLES `Report_Classified_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Classified_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Classified_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Event`
--

DROP TABLE IF EXISTS `Report_Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`event_id`,`report_type`,`date`),
  KEY `event_id` (`event_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Event`
--

LOCK TABLES `Report_Event` WRITE;
/*!40000 ALTER TABLE `Report_Event` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Event_Daily`
--

DROP TABLE IF EXISTS `Report_Event_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Event_Daily` (
  `event_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Event_Daily`
--

LOCK TABLES `Report_Event_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Event_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Event_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Event_Monthly`
--

DROP TABLE IF EXISTS `Report_Event_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Event_Monthly` (
  `event_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Event_Monthly`
--

LOCK TABLES `Report_Event_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Event_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Event_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Listing`
--

DROP TABLE IF EXISTS `Report_Listing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Listing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`listing_id`,`report_type`,`date`),
  KEY `listing_id` (`listing_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Listing`
--

LOCK TABLES `Report_Listing` WRITE;
/*!40000 ALTER TABLE `Report_Listing` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Listing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Listing_Daily`
--

DROP TABLE IF EXISTS `Report_Listing_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Listing_Daily` (
  `listing_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  `click_thru` int(11) NOT NULL DEFAULT '0',
  `email_sent` int(11) NOT NULL DEFAULT '0',
  `phone_view` int(11) NOT NULL DEFAULT '0',
  `fax_view` int(11) NOT NULL DEFAULT '0',
  `send_phone` int(11) NOT NULL DEFAULT '0',
  `click_call` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`listing_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Listing_Daily`
--

LOCK TABLES `Report_Listing_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Listing_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Listing_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Listing_Monthly`
--

DROP TABLE IF EXISTS `Report_Listing_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Listing_Monthly` (
  `listing_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  `click_thru` int(11) NOT NULL DEFAULT '0',
  `email_sent` int(11) NOT NULL DEFAULT '0',
  `phone_view` int(11) NOT NULL DEFAULT '0',
  `fax_view` int(11) NOT NULL DEFAULT '0',
  `send_phone` int(11) NOT NULL DEFAULT '0',
  `click_call` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`listing_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Listing_Monthly`
--

LOCK TABLES `Report_Listing_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Listing_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Listing_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Login`
--

DROP TABLE IF EXISTS `Report_Login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Login`
--

LOCK TABLES `Report_Login` WRITE;
/*!40000 ALTER TABLE `Report_Login` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Post`
--

DROP TABLE IF EXISTS `Report_Post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`post_id`,`report_type`,`date`),
  KEY `post_id` (`post_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Post`
--

LOCK TABLES `Report_Post` WRITE;
/*!40000 ALTER TABLE `Report_Post` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Post_Daily`
--

DROP TABLE IF EXISTS `Report_Post_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Post_Daily` (
  `post_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Post_Daily`
--

LOCK TABLES `Report_Post_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Post_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Post_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Post_Monthly`
--

DROP TABLE IF EXISTS `Report_Post_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Post_Monthly` (
  `post_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Post_Monthly`
--

LOCK TABLES `Report_Post_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Post_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Post_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Promotion`
--

DROP TABLE IF EXISTS `Report_Promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) NOT NULL DEFAULT '0',
  `report_type` tinyint(1) NOT NULL DEFAULT '0',
  `report_amount` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_info` (`promotion_id`,`report_type`,`date`),
  KEY `promotion_id` (`promotion_id`),
  KEY `report_type` (`report_type`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Promotion`
--

LOCK TABLES `Report_Promotion` WRITE;
/*!40000 ALTER TABLE `Report_Promotion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Promotion_Daily`
--

DROP TABLE IF EXISTS `Report_Promotion_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Promotion_Daily` (
  `promotion_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL DEFAULT '0000-00-00',
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`promotion_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Promotion_Daily`
--

LOCK TABLES `Report_Promotion_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Promotion_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Promotion_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Promotion_Monthly`
--

DROP TABLE IF EXISTS `Report_Promotion_Monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Promotion_Monthly` (
  `promotion_id` int(11) NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `summary_view` int(11) NOT NULL DEFAULT '0',
  `detail_view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`promotion_id`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Promotion_Monthly`
--

LOCK TABLES `Report_Promotion_Monthly` WRITE;
/*!40000 ALTER TABLE `Report_Promotion_Monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Promotion_Monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Statistic`
--

DROP TABLE IF EXISTS `Report_Statistic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_date` datetime NOT NULL,
  `module` char(1) CHARACTER SET utf8 NOT NULL,
  `keyword` varchar(50) CHARACTER SET utf8 NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `location_1` int(11) NOT NULL DEFAULT '0',
  `location_2` int(11) NOT NULL DEFAULT '0',
  `location_3` int(11) NOT NULL DEFAULT '0',
  `location_4` int(11) NOT NULL DEFAULT '0',
  `location_5` int(11) NOT NULL DEFAULT '0',
  `search_where` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `search_date` (`search_date`),
  KEY `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Statistic`
--

LOCK TABLES `Report_Statistic` WRITE;
/*!40000 ALTER TABLE `Report_Statistic` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Statistic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Report_Statistic_Daily`
--

DROP TABLE IF EXISTS `Report_Statistic_Daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Report_Statistic_Daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL,
  `module` char(1) CHARACTER SET utf8 NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `module` (`module`),
  KEY `day` (`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Report_Statistic_Daily`
--

LOCK TABLES `Report_Statistic_Daily` WRITE;
/*!40000 ALTER TABLE `Report_Statistic_Daily` DISABLE KEYS */;
/*!40000 ALTER TABLE `Report_Statistic_Daily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Review`
--

DROP TABLE IF EXISTS `Review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `member_id` int(11) NULL DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `review_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `review` text COLLATE utf8_unicode_ci,
  `reviewer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reviewer_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reviewer_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` tinyint(2) NOT NULL DEFAULT '0',
  `approved` int(1) NOT NULL DEFAULT '0',
  `response` text COLLATE utf8_unicode_ci,
  `responseapproved` int(1) NOT NULL DEFAULT '0',
  `like` int(11) NOT NULL DEFAULT '0',
  `dislike` int(11) NOT NULL DEFAULT '0',
  `like_ips` text COLLATE utf8_unicode_ci,
  `dislike_ips` text COLLATE utf8_unicode_ci,
  `new` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y' COMMENT 'y/n',
  PRIMARY KEY (`id`),
  KEY `approved` (`approved`),
  KEY `item_info` (`item_type`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Review`
--

LOCK TABLES `Review` WRITE;
/*!40000 ALTER TABLE `Review` DISABLE KEYS */;
/*!40000 ALTER TABLE `Review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting`
--

DROP TABLE IF EXISTS `Setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting`
--

LOCK TABLES `Setting` WRITE;
/*!40000 ALTER TABLE `Setting` DISABLE KEYS */;
INSERT INTO `Setting` VALUES ('custom_classified_feature','on'),('custom_blog_feature','on'),('custom_banner_feature','on'),('default_url','demodirectory.com'),('custom_article_feature','on'),('todo_theme','yes'),('todo_paymentgateway','yes'),('todo_pricing','yes'),('todo_invoice','yes'),('todo_email','yes'),('todo_emailnotification','yes'),('todo_googleads','yes'),('todo_googlemaps','yes'),('todo_googleanalytics','yes'),('todo_headerlogo','yes'),('todo_noimage','yes'),('todo_claim','yes'),('todo_langcenter','yes'),('todo_levels','yes'),('todo_emailconfig','yes'),('sitemgr_email',''),('sitemgr_send_email','on'),('sitemgr_listing_email',''),('sitemgr_event_email',''),('sitemgr_banner_email',''),('sitemgr_classified_email',''),('sitemgr_article_email',''),('sitemgr_account_email',''),('sitemgr_contactus_email',''),('sitemgr_support_email',''),('sitemgr_payment_email',''),('sitemgr_rate_email',''),('sitemgr_claim_email',''),('review_listing_enabled','on'),('review_article_enabled','on'),('review_approve','on'),('review_manditory','on'),('claim_approve','on'),('claim_deny','on'),('claim_approveemail','on'),('claim_denyemail','on'),('import_enable_listing_active',''),('import_defaultlevel','10'),('import_sameaccount',''),('import_account_id',''),('import_from_export',''),('last_report_rollup','0000-00-00'),('blog_featuredcategory',''),('import_featured_categs','1'),('last_listing_reminder','0'),('edir_default_language','en_us'),('edir_languages','en_us'),('edir_languagenames','English'),('edir_language','en_us'),('emailconf_method','smtp'),('emailconf_host',''),('emailconf_port','465'),('emailconf_auth','secure'),('emailconf_email',''),('emailconf_username',''),('emailconf_password',''),('foreignaccount_facebook',''),('foreignaccount_facebook_apikey',''),('last_datetime_cronmgr','0000-00-00 00:00:00'),('last_datetime_dailymaintenance','0000-00-00 00:00:00'),('last_datetime_import','0000-00-00 00:00:00'),('last_datetime_randomizer','0000-00-00 00:00:00'),('last_datetime_renewalreminder','0000-00-00 00:00:00'),('last_datetime_reportrollup','0000-00-00 00:00:00'),('last_datetime_sitemap','0000-00-00 00:00:00'),('last_datetime_statisticreport','0000-00-00 00:00:00'),('last_cronmgr_run','0'),('featuredcategory','on'),('listing_featuredcategory',''),('article_featuredcategory',''),('classified_featuredcategory',''),('event_featuredcategory',''),('article_approve_free','on'),('article_approve_paid','on'),('listing_approve_updated','on'),('banner_approve_paid','on'),('event_approve_updated','on'),('classified_approve_paid','on'),('banner_approve_free','on'),('classified_approve_updated','on'),('event_approve_free','on'),('event_approve_paid','on'),('article_approve_updated','on'),('classified_approve_free','on'),('banner_approve_updated','on'),('new_listing_email','on'),('update_listing_email','on'),('new_event_email','on'),('update_event_email','on'),('new_classified_email','on'),('update_classified_email','on'),('new_article_email','on'),('update_article_email','on'),('new_banner_email','on'),('update_banner_email','on'),('todo_approvalconfig','yes'),('foreignaccount_facebook_apisecret',''),('todo_locations','yes'),('percentage_todo','100'),('emailconf_protocol','ssl'),('payment_tax_status','on'),('payment_tax_value','10'),('maintenance_mode','off'),('custom_event_feature','on'),('custom_promotion_feature','on'),('last_listing_randomizer_domain','0'),('last_listing_traffic','0'),('last_promotion_randomizer_domain','0'),('last_event_randomizer_domain','0'),('last_banner_randomizer_domain','0'),('last_classified_randomizer_domain','0'),('last_article_randomizer_domain','0'),('custom_has_promotion','on'),('foreignaccount_facebook_apiid',''),('import_account_id_event',''),('listing_approve_paid','on'),('listing_approve_free','on'),('twitter_account',''),('setting_linkedin_link',''),('setting_facebook_link',''),('twilio_enabled_call',''),('twilio_account_sid',''),('twilio_auth_token',''),('twilio_clicktocall_message','You are currently dialing [ITEM_TITLE], please hold while we connect you.'),('email_traffic_listing_10','on'),('commenting_edir','on'),('commenting_fb',''),('slider_feature','on'),('commenting_fb_user_id',''),('commenting_fb_number_comments',''),('import_automatic_start','1'),('import_automatic_start_event','1'),('last_favicon_id','2'),('foreignaccount_google','on'),('import_sameaccount_event',''),('import_update_listings',''),('import_update_friendlyurl',''),('import_from_export_event',''),('import_update_events',''),('import_update_friendlyurl_event',''),('import_featured_categs_event','1'),('import_enable_event_active',''),('import_defaultlevel_event','10'),('button_share_facebook',''),('button_share_google',''),('button_share_pinterest',''),('pendingReviews_per_page','2'),('sitemgr_blog_email',''),('sitemgr_import_email',''),('contact_address',''),('contact_zipcode',''),('contact_country',''),('contact_state',''),('contact_city',''),('contact_phone',''),('contact_email',''),('contact_mapzoom',''),('contact_latitude',''),('contact_longitude',''),('arcamailer_customer_id',''),('arcamailer_customer_name',''),('arcamailer_customer_email',''),('arcamailer_customer_country',''),('arcamailer_customer_timezone',''),('arcamailer_enable_list',''),('arcamailer_list_label',''),('arcamailer_customer_listname',''),('arcamailer_customer_listid',''),('mailapp_via_cron',''),('gmaps_scroll',''),('gmaps_max_markers','1000'),('edirectory_api_enabled','on'),('foreignaccount_google_clientid',''),('foreignaccount_google_clientsecret',''),('appbuilder_previewpassword',''),('appbuilder_logo_id',''),('appbuilder_logo_extension',''),('appbuilder_about_email',''),('appbuilder_about_phone',''),('appbuilder_about_website',''),('appbuilder_about_text',''),('appbuilder_percentage',''),('appbuilder_step_2',''),('contact_company',''),('contact_fax',''),('appbuilder_step_4','');
/*!40000 ALTER TABLE `Setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting_Google`
--

DROP TABLE IF EXISTS `Setting_Google`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting_Google` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting_Google`
--

LOCK TABLES `Setting_Google` WRITE;
/*!40000 ALTER TABLE `Setting_Google` DISABLE KEYS */;
INSERT INTO `Setting_Google` VALUES (1,'google_ad_client',''),(2,'google_maps_key',''),(3,'google_analytics_account',''),(4,'google_analytics_front',''),(5,'google_analytics_members',''),(6,'google_analytics_sitemgr',''),(7,'google_ad_channel',''),(8,'google_ad_status','off'),(9,'google_maps_status','on'),(10,'google_ad_type','text_image'),(11,'google_tag_status','off'),(12,'google_tag_client',''),(13,'ad_client',''),(14,'maps_key',''),(15,'analytics_account',''),(16,'analytics_front',''),(17,'analytics_members',''),(18,'analytics_sitemgr',''),(19,'ad_channel',''),(20,'ad_status',''),(21,'maps_status','on'),(22,'ad_type',''),(23,'tag_status',''),(24,'tag_client',''),(25,'recaptcha_status',''),(26,'recaptcha_sitekey',''),(27,'recaptcha_secretkey',''),(28,'google_ad_client',''),(29,'google_maps_key',''),(30,'google_analytics_account',''),(31,'google_analytics_front',''),(32,'google_analytics_members',''),(33,'google_analytics_sitemgr',''),(34,'google_ad_channel',''),(35,'google_ad_status','off'),(36,'google_maps_status','on'),(37,'google_ad_type','text_image'),(38,'google_tag_status','off'),(39,'google_tag_client',''),(40,'ad_client','pub-1254273197347725'),(41,'maps_key',''),(42,'analytics_account',''),(43,'analytics_front',''),(44,'analytics_members',''),(45,'analytics_sitemgr',''),(46,'ad_channel',''),(47,'ad_status','on'),(48,'maps_status','on'),(49,'ad_type','3'),(50,'tag_status',''),(51,'tag_client',''),(52,'recaptcha_status',''),(53,'recaptcha_sitekey',''),(54,'recaptcha_secretkey',''),(55,'google_ad_client',''),(56,'google_maps_key',''),(57,'google_analytics_account',''),(58,'google_analytics_front',''),(59,'google_analytics_members',''),(60,'google_analytics_sitemgr',''),(61,'google_ad_channel',''),(62,'google_ad_status','off'),(63,'google_maps_status','on'),(64,'google_ad_type','text_image'),(65,'google_tag_status','off'),(66,'google_tag_client','');
/*!40000 ALTER TABLE `Setting_Google` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting_Location`
--

DROP TABLE IF EXISTS `Setting_Location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting_Location` (
  `id` tinyint(4) NOT NULL,
  `default_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_plural` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `show` char(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting_Location`
--

LOCK TABLES `Setting_Location` WRITE;
/*!40000 ALTER TABLE `Setting_Location` DISABLE KEYS */;
INSERT INTO `Setting_Location` VALUES (1,0,'COUNTRY','COUNTRIES','y','n'),(2,0,'REGION','REGIONS','n','b'),(3,0,'STATE','STATES','y','b'),(4,0,'CITY','CITIES','y','b'),(5,0,'NEIGHBORHOOD','NEIGHBORHOODS','n','b');
/*!40000 ALTER TABLE `Setting_Location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting_Navigation`
--

DROP TABLE IF EXISTS `Setting_Navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting_Navigation` (
  `order` int(11) NOT NULL,
  `label` varchar(100) CHARACTER SET utf8 NOT NULL,
  `link` varchar(255) CHARACTER SET utf8 NOT NULL,
  `area` varchar(20) CHARACTER SET utf8 NOT NULL,
  `custom` char(1) CHARACTER SET utf8 NOT NULL,
  `theme` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`order`,`area`,`theme`),
  KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting_Navigation`
--

LOCK TABLES `Setting_Navigation` WRITE;
/*!40000 ALTER TABLE `Setting_Navigation` DISABLE KEYS */;
INSERT INTO `Setting_Navigation` VALUES (0,'Home','NON_SECURE_URL','header','n','default'),(1,'Listings','LISTING_DEFAULT_URL','header','n','default'),(2,'Events','EVENT_DEFAULT_URL','header','n','default'),(3,'Classifieds','CLASSIFIED_DEFAULT_URL','header','n','default'),(4,'Articles','ARTICLE_DEFAULT_URL','header','n','default'),(5,'Deals','PROMOTION_DEFAULT_URL','header','n','default'),(6,'Blog','BLOG_DEFAULT_URL','header','n','default'),(7,'Advertise With Us','ALIAS_ADVERTISE_URL_DIVISOR','header','n','default'),(8,'Contact Us','ALIAS_CONTACTUS_URL_DIVISOR','header','n','default'),(9,'Enquire','ALIAS_LEAD_URL_DIVISOR','header','n','default'),(10,'My Account','account','tabbar','n','default'),(9,'My Favorites','favorites','tabbar','n','default'),(8,'Advertise With Us','cp_1','tabbar','n','default'),(7,'Blog','blog','tabbar','n','default'),(6,'Classifieds','classifieds','tabbar','n','default'),(5,'Articles','articles','tabbar','n','default'),(4,'Events','events','tabbar','n','default'),(3,'Reviews','reviews','tabbar','n','default'),(2,'Deals','deals','tabbar','n','default'),(1,'Nearby','nearby','tabbar','n','default'),(0,'Listings','listings','tabbar','n','default'),(11,'About Us','about','tabbar','n','default'),(0,'Home','NON_SECURE_URL','footer','n','default'),(1,'Listings','LISTING_DEFAULT_URL','footer','n','default'),(2,'Events','EVENT_DEFAULT_URL','footer','n','default'),(3,'Classifieds','CLASSIFIED_DEFAULT_URL','footer','n','default'),(4,'Articles','ARTICLE_DEFAULT_URL','footer','n','default'),(5,'Deals','PROMOTION_DEFAULT_URL','footer','n','default'),(6,'Blog','BLOG_DEFAULT_URL','footer','n','default'),(7,'Advertise','ALIAS_ADVERTISE_URL_DIVISOR','footer','n','default'),(8,'Contact Us','ALIAS_CONTACTUS_URL_DIVISOR','footer','n','default'),(9,'Enquire','ALIAS_LEAD_URL_DIVISOR','footer','n','default'),(10,'FAQ','ALIAS_FAQ_URL_DIVISOR','footer','n','default'),(11,'Sitemap','ALIAS_SITEMAP_URL_DIVISOR','footer','n','default'),(12,'Terms of Use','ALIAS_TERMS_URL_DIVISOR','footer','n','default'),(13,'Privacy Policy','ALIAS_PRIVACY_URL_DIVISOR','footer','n','default');
/*!40000 ALTER TABLE `Setting_Navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting_Payment`
--

DROP TABLE IF EXISTS `Setting_Payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting_Payment` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting_Payment`
--

LOCK TABLES `Setting_Payment` WRITE;
/*!40000 ALTER TABLE `Setting_Payment` DISABLE KEYS */;
INSERT INTO `Setting_Payment` VALUES ('PAYPAL_ACCOUNT',''),('PAYPALAPI_USERNAME',''),('PAYPALAPI_PASSWORD',''),('PAYPALAPI_SIGNATURE',''),('PAYFLOW_LOGIN',''),('PAYFLOW_PARTNER',''),('TWOCHECKOUT_LOGIN',''),('PSIGATE_STOREID',''),('PSIGATE_PASSPHRASE',''),('WORLDPAY_INSTID',''),('ITRANSACT_VENDORID',''),('AUTHORIZE_LOGIN',''),('AUTHORIZE_TXNKEY',''),('LINKPOINT_CONFIGFILE',''),('LINKPOINT_KEYFILE',''),('SIMPLEPAY_ACCESSKEY',''),('SIMPLEPAY_SECRETKEY',''),('PAYPAL_STATUS','off'),('PAYPALAPI_STATUS','off'),('PAYFLOW_STATUS','off'),('TWOCHECKOUT_STATUS','off'),('PSIGATE_STATUS','off'),('WORLDPAY_STATUS','off'),('ITRANSACT_STATUS','off'),('AUTHORIZE_STATUS','off'),('LINKPOINT_STATUS','off'),('SIMPLEPAY_STATUS','off'),('SIMPLEPAY_RECURRING','off'),('PAYPAL_RECURRING','off'),('LINKPOINT_RECURRING','off'),('AUTHORIZE_RECURRING','off'),('SIMPLEPAY_RECURRINGCYCLE',' '),('SIMPLEPAY_RECURRINGUNIT',' '),('SIMPLEPAY_RECURRINGTIMES',' '),('PAYPAL_RECURRINGCYCLE',' '),('PAYPAL_RECURRINGTIMES',' '),('PAYPAL_RECURRINGUNIT',' '),('LINKPOINT_RECURRINGTYPE',''),('AUTHORIZE_RECURRINGLENGTH',' '),('AUTHORIZE_RECURRINGUNIT','months'),('CURRENCY_SYMBOL','$'),('LISTING_RENEWAL_PERIOD','1Y'),('EVENT_RENEWAL_PERIOD','1M'),('BANNER_RENEWAL_PERIOD','1Y'),('CLASSIFIED_RENEWAL_PERIOD','30D'),('ARTICLE_RENEWAL_PERIOD','1Y'),('INVOICEPAYMENT_FEATURE','on'),('MANUALPAYMENT_FEATURE','on'),('PAYMENT_CURRENCY','USD'),('PAGSEGURO_STATUS','off'),('PAGSEGURO_EMAIL',''),('PAGSEGURO_TOKEN','');
/*!40000 ALTER TABLE `Setting_Payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting_Search_Tag`
--

DROP TABLE IF EXISTS `Setting_Search_Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting_Search_Tag` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting_Search_Tag`
--

LOCK TABLES `Setting_Search_Tag` WRITE;
/*!40000 ALTER TABLE `Setting_Search_Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `Setting_Search_Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting_Social_Network`
--

DROP TABLE IF EXISTS `Setting_Social_Network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting_Social_Network` (
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting_Social_Network`
--

LOCK TABLES `Setting_Social_Network` WRITE;
/*!40000 ALTER TABLE `Setting_Social_Network` DISABLE KEYS */;
INSERT INTO `Setting_Social_Network` VALUES ('general_see_profile','no','LANG_SITEMGR_SN_SEE_PROFILE'),('listing_rate','yes','LANG_SITEMGR_SN_RATE'),('article_rate','yes','LANG_SITEMGR_SN_RATE');
/*!40000 ALTER TABLE `Setting_Social_Network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Slider`
--

DROP TABLE IF EXISTS `Slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alternative_text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title_text` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slide_order` int(11) NOT NULL,
  `target` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT 'self',
  PRIMARY KEY (`id`),
  KEY `order` (`slide_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Slider`
--

LOCK TABLES `Slider` WRITE;
/*!40000 ALTER TABLE `Slider` DISABLE KEYS */;
/*!40000 ALTER TABLE `Slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Timeline`
--

DROP TABLE IF EXISTS `Timeline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `item_id` int(11) NOT NULL,
  `action` set('new','edit') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `datetime` datetime NOT NULL,
  `new` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`id`),
  KEY `item_type` (`item_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Timeline`
--

LOCK TABLES `Timeline` WRITE;
/*!40000 ALTER TABLE `Timeline` DISABLE KEYS */;
/*!40000 ALTER TABLE `Timeline` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-28 18:22:12
