-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: 10.7.62.16    Database: africa
-- ------------------------------------------------------
-- Server version	10.4.34-MariaDB-log

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
-- Table structure for table `accommodation_rooms`
--

DROP TABLE IF EXISTS `accommodation_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accommodation_rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `accommodation_id` bigint(20) unsigned NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 2,
  `gender` varchar(255) NOT NULL DEFAULT 'any',
  `status` varchar(255) NOT NULL DEFAULT 'AVAILABLE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accommodation_rooms_accommodation_id_foreign` (`accommodation_id`),
  CONSTRAINT `accommodation_rooms_accommodation_id_foreign` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodation_rooms`
--

LOCK TABLES `accommodation_rooms` WRITE;
/*!40000 ALTER TABLE `accommodation_rooms` DISABLE KEYS */;
INSERT INTO `accommodation_rooms` VALUES (1,1,'101',2,'male','AVAILABLE','2026-08-19 16:21:34','2026-08-19 16:21:34'),(2,1,'102',2,'female','AVAILABLE','2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `accommodation_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accommodations`
--

DROP TABLE IF EXISTS `accommodations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accommodations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `total_capacity` int(11) NOT NULL DEFAULT 100,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accommodations_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodations`
--

LOCK TABLES `accommodations` WRITE;
/*!40000 ALTER TABLE `accommodations` DISABLE KEYS */;
INSERT INTO `accommodations` VALUES (1,'373cfbef-82d5-45a8-b254-91467aee2eef','فندق المهرجان الإفريقي - الجزائر العاصمة','Hôtel du Festival Africain - Alger','African Festival Hotel - Algiers','بن عكنون، الجزائر العاصمة','+213 21 000 111',150,'active','2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `accommodations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accreditation_zones`
--

DROP TABLE IF EXISTS `accreditation_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accreditation_zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `color_hex` varchar(255) NOT NULL DEFAULT '#0066FF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accreditation_zones_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accreditation_zones`
--

LOCK TABLES `accreditation_zones` WRITE;
/*!40000 ALTER TABLE `accreditation_zones` DISABLE KEYS */;
/*!40000 ALTER TABLE `accreditation_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) unsigned DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album_media`
--

DROP TABLE IF EXISTS `album_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) unsigned NOT NULL,
  `media_id` bigint(20) unsigned NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `album_media_album_id_foreign` (`album_id`),
  KEY `album_media_media_id_foreign` (`media_id`),
  CONSTRAINT `album_media_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `album_media_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_media`
--

LOCK TABLES `album_media` WRITE;
/*!40000 ALTER TABLE `album_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `album_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `edition_id` bigint(20) unsigned DEFAULT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description_ar` text DEFAULT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `cover_media_id` bigint(20) unsigned DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'PUBLISHED',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `albums_uuid_unique` (`uuid`),
  UNIQUE KEY `albums_slug_unique` (`slug`),
  KEY `albums_edition_id_foreign` (`edition_id`),
  KEY `albums_cover_media_id_foreign` (`cover_media_id`),
  CONSTRAINT `albums_cover_media_id_foreign` FOREIGN KEY (`cover_media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `albums_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albums`
--

LOCK TABLES `albums` WRITE;
/*!40000 ALTER TABLE `albums` DISABLE KEYS */;
INSERT INTO `albums` VALUES (1,'db789b4f-2029-480b-937d-dd238b69cb88',NULL,'ألبوم الصور للتصفيات الأولية بمؤسسات التكوين والتعليم المهنيين','Galerie photos des qualifications au niveau des établissements','Photo Gallery of Institutional Preliminary Qualifications','institutional-qualifications-gallery-2027','صور توثيقية لاختبارات المتربصين بورشات التركيب الكهربائي، اللحام، وتطوير تقنيات الويب.',NULL,NULL,NULL,0,'PUBLISHED','2026-08-19 16:21:34','2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_notifications`
--

DROP TABLE IF EXISTS `app_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `message_ar` text NOT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `severity` enum('INFO','SUCCESS','WARNING','DANGER') NOT NULL DEFAULT 'INFO',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_notifications`
--

LOCK TABLES `app_notifications` WRITE;
/*!40000 ALTER TABLE `app_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `event` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  KEY `audit_logs_event_index` (`event`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badge_zone_permissions`
--

DROP TABLE IF EXISTS `badge_zone_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badge_zone_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `badge_id` bigint(20) unsigned NOT NULL,
  `zone_id` bigint(20) unsigned NOT NULL,
  `valid_from` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `permission` varchar(255) NOT NULL DEFAULT 'ALLOW',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `badge_zone_permissions_zone_id_foreign` (`zone_id`),
  KEY `badge_zone_permissions_badge_id_zone_id_index` (`badge_id`,`zone_id`),
  CONSTRAINT `badge_zone_permissions_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `badge_zone_permissions_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `wsap_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badge_zone_permissions`
--

LOCK TABLES `badge_zone_permissions` WRITE;
/*!40000 ALTER TABLE `badge_zone_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `badge_zone_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `badge_uuid` char(36) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_title` varchar(255) NOT NULL DEFAULT 'PARTICIPANT',
  `allowed_zone_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_zone_ids`)),
  `status` enum('ACTIVE','EXPIRED','BLOCKED') NOT NULL DEFAULT 'ACTIVE',
  `valid_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `badges_badge_uuid_unique` (`badge_uuid`),
  UNIQUE KEY `badges_access_token_unique` (`access_token`),
  KEY `badges_user_id_foreign` (`user_id`),
  CONSTRAINT `badges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badges`
--

LOCK TABLES `badges` WRITE;
/*!40000 ALTER TABLE `badges` DISABLE KEYS */;
/*!40000 ALTER TABLE `badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('africa-skills-forum-cache-2089c3a561dc4622de4ad2893933c230','i:1;',1787160728),('africa-skills-forum-cache-2089c3a561dc4622de4ad2893933c230:timer','i:1787160728;',1787160728),('africa-skills-forum-cache-36d41688ef2a3affc04d3f59ecdc2d76','i:1;',1787160908),('africa-skills-forum-cache-36d41688ef2a3affc04d3f59ecdc2d76:timer','i:1787160908;',1787160908),('africa-skills-forum-cache-asf_homepage_statistics_v8','a:6:{s:9:\"countries\";i:54;s:9:\"ministers\";i:20;s:7:\"experts\";i:0;s:12:\"participants\";i:0;s:6:\"panels\";i:7;s:8:\"partners\";i:1;}',1787160869),('africa-skills-forum-cache-wsap_active_event','O:16:\"App\\Models\\Event\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:6:\"events\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:25:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"a5caa9c4-f5c3-4b2f-b99f-c8b298d2e955\";s:10:\"edition_id\";N;s:8:\"title_ar\";s:87:\"حفل الافتتاح الرسمي والانطلاق الوطني للمنافسات\";s:8:\"title_fr\";s:56:\"Cérémonie Officielle d\'Ouverture et Lancement National\";s:8:\"title_en\";s:57:\"Official Opening Ceremony and National Competition Launch\";s:4:\"slug\";s:30:\"national-opening-ceremony-2027\";s:10:\"summary_ar\";s:133:\"تجمع الوفود الوطنية والدولية بالمركز الدولي للمؤتمرات بالجزائر العاصمة.\";s:10:\"summary_fr\";s:81:\"Rassemblement des délégations au Centre International des Conférences d\'Alger.\";s:10:\"summary_en\";s:66:\"Assembly of national and international delegations at CIC Algiers.\";s:14:\"description_ar\";N;s:14:\"description_fr\";N;s:14:\"description_en\";N;s:8:\"start_at\";s:19:\"2026-09-18 16:21:34\";s:6:\"end_at\";N;s:5:\"venue\";s:73:\"المركز الدولي للمؤتمرات عبد اللطيف رحال\";s:7:\"address\";s:47:\"بن عكنون - الجزائر العاصمة\";s:9:\"wilaya_id\";N;s:14:\"cover_media_id\";N;s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:6:\"status\";s:9:\"PUBLISHED\";s:12:\"published_at\";s:19:\"2026-08-19 16:21:34\";s:10:\"created_at\";s:19:\"2026-08-19 16:21:34\";s:10:\"updated_at\";s:19:\"2026-08-19 16:21:34\";}s:11:\"\0*\0original\";a:25:{s:2:\"id\";i:1;s:4:\"uuid\";s:36:\"a5caa9c4-f5c3-4b2f-b99f-c8b298d2e955\";s:10:\"edition_id\";N;s:8:\"title_ar\";s:87:\"حفل الافتتاح الرسمي والانطلاق الوطني للمنافسات\";s:8:\"title_fr\";s:56:\"Cérémonie Officielle d\'Ouverture et Lancement National\";s:8:\"title_en\";s:57:\"Official Opening Ceremony and National Competition Launch\";s:4:\"slug\";s:30:\"national-opening-ceremony-2027\";s:10:\"summary_ar\";s:133:\"تجمع الوفود الوطنية والدولية بالمركز الدولي للمؤتمرات بالجزائر العاصمة.\";s:10:\"summary_fr\";s:81:\"Rassemblement des délégations au Centre International des Conférences d\'Alger.\";s:10:\"summary_en\";s:66:\"Assembly of national and international delegations at CIC Algiers.\";s:14:\"description_ar\";N;s:14:\"description_fr\";N;s:14:\"description_en\";N;s:8:\"start_at\";s:19:\"2026-09-18 16:21:34\";s:6:\"end_at\";N;s:5:\"venue\";s:73:\"المركز الدولي للمؤتمرات عبد اللطيف رحال\";s:7:\"address\";s:47:\"بن عكنون - الجزائر العاصمة\";s:9:\"wilaya_id\";N;s:14:\"cover_media_id\";N;s:11:\"is_featured\";i:0;s:9:\"is_active\";i:1;s:6:\"status\";s:9:\"PUBLISHED\";s:12:\"published_at\";s:19:\"2026-08-19 16:21:34\";s:10:\"created_at\";s:19:\"2026-08-19 16:21:34\";s:10:\"updated_at\";s:19:\"2026-08-19 16:21:34\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:8:\"start_at\";s:8:\"datetime\";s:6:\"end_at\";s:8:\"datetime\";s:11:\"is_featured\";s:7:\"boolean\";s:12:\"published_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:21:{i:0;s:4:\"uuid\";i:1;s:10:\"edition_id\";i:2;s:8:\"title_ar\";i:3;s:8:\"title_fr\";i:4;s:8:\"title_en\";i:5;s:4:\"slug\";i:6;s:10:\"summary_ar\";i:7;s:10:\"summary_fr\";i:8;s:10:\"summary_en\";i:9;s:14:\"description_ar\";i:10;s:14:\"description_fr\";i:11;s:14:\"description_en\";i:12;s:8:\"start_at\";i:13;s:6:\"end_at\";i:14;s:5:\"venue\";i:15;s:7:\"address\";i:16;s:9:\"wilaya_id\";i:17;s:14:\"cover_media_id\";i:18;s:11:\"is_featured\";i:19;s:6:\"status\";i:20;s:12:\"published_at\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}',1787164292),('africa-skills-forum-cache-wsap_global_settings','a:0:{}',1787247011);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `certificate_uuid` char(36) NOT NULL,
  `verification_token_hash` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `registration_id` bigint(20) unsigned DEFAULT NULL,
  `skill_id` bigint(20) unsigned DEFAULT NULL,
  `certificate_type` enum('PARTICIPATION','WINNER_GOLD','WINNER_SILVER','WINNER_BRONZE','MEDALLION_EXCELLENCE','EXPERT_JUDGE','DELEGATION_OFFICIAL') NOT NULL DEFAULT 'PARTICIPATION',
  `status` enum('VALID','REVOKED','EXPIRED') NOT NULL DEFAULT 'VALID',
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `revoked_at` timestamp NULL DEFAULT NULL,
  `revocation_reason` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificates_certificate_uuid_unique` (`certificate_uuid`),
  UNIQUE KEY `certificates_verification_token_hash_unique` (`verification_token_hash`),
  KEY `certificates_user_id_foreign` (`user_id`),
  KEY `certificates_registration_id_foreign` (`registration_id`),
  KEY `certificates_skill_id_foreign` (`skill_id`),
  CONSTRAINT `certificates_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `certificates_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE SET NULL,
  CONSTRAINT `certificates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communes`
--

DROP TABLE IF EXISTS `communes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `communes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wilaya_id` bigint(20) unsigned NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `communes_wilaya_id_foreign` (`wilaya_id`),
  CONSTRAINT `communes_wilaya_id_foreign` FOREIGN KEY (`wilaya_id`) REFERENCES `wilayas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communes`
--

LOCK TABLES `communes` WRITE;
/*!40000 ALTER TABLE `communes` DISABLE KEYS */;
/*!40000 ALTER TABLE `communes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competition_assessment_criteria`
--

DROP TABLE IF EXISTS `competition_assessment_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition_assessment_criteria` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) unsigned NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `type` enum('JUDGEMENT','MEASUREMENT') NOT NULL DEFAULT 'MEASUREMENT',
  `max_score` decimal(8,2) NOT NULL DEFAULT 10.00,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_assessment_criteria_module_id_foreign` (`module_id`),
  CONSTRAINT `competition_assessment_criteria_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `competition_assessment_modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competition_assessment_criteria`
--

LOCK TABLES `competition_assessment_criteria` WRITE;
/*!40000 ALTER TABLE `competition_assessment_criteria` DISABLE KEYS */;
INSERT INTO `competition_assessment_criteria` VALUES (1,1,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(2,1,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(3,2,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(4,2,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(5,3,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(6,3,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(7,4,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(8,4,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(9,5,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(10,5,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(11,6,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(12,6,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(13,7,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(14,7,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(15,8,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(16,8,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(17,9,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(18,9,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(19,10,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(20,10,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(21,11,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(22,11,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(23,12,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(24,12,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(25,13,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(26,13,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(27,14,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(28,14,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(29,15,'السلامة وتنظيم مكان العمل (Safety & Work Organization)','Safety & Organization','MEASUREMENT',10.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(30,15,'الدقة التقنية والامتثال للـ WSOS Standards','Technical Precision','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(31,16,'اختبارات الأداء الميدانية (Performance Measurements)','Performance Measurement','MEASUREMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(32,16,'تقييم الجودة والابتكار (Judgement Evaluation)','Quality & Innovation','JUDGEMENT',30.00,NULL,0,'2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `competition_assessment_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competition_assessment_modules`
--

DROP TABLE IF EXISTS `competition_assessment_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition_assessment_modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `skill_id` bigint(20) unsigned NOT NULL,
  `edition_id` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `max_score` decimal(8,2) NOT NULL DEFAULT 100.00,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_assessment_modules_skill_id_foreign` (`skill_id`),
  KEY `competition_assessment_modules_edition_id_foreign` (`edition_id`),
  CONSTRAINT `competition_assessment_modules_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `competition_assessment_modules_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competition_assessment_modules`
--

LOCK TABLES `competition_assessment_modules` WRITE;
/*!40000 ALTER TABLE `competition_assessment_modules` DISABLE KEYS */;
INSERT INTO `competition_assessment_modules` VALUES (1,1,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(2,1,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(3,2,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(4,2,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(5,3,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(6,3,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(7,4,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(8,4,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(9,5,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(10,5,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(11,6,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(12,6,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(13,7,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(14,7,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(15,8,1,'Module A','وحدة الإعداد والتنفيذ التقني (Module A)','Module A - Technical Preparation','Module A - Technical Preparation',40.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(16,8,1,'Module B','وحدة الجودة والنتيجة النهائية (Module B)','Module B - Quality & Final Output','Module B - Quality & Final Output',60.00,0,'2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `competition_assessment_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competition_assignments`
--

DROP TABLE IF EXISTS `competition_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition_assignments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `competition_id` bigint(20) unsigned DEFAULT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  `stage_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `assignment_type` varchar(255) NOT NULL,
  `assigned_by` bigint(20) unsigned NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `revoked_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `competition_assignments_uuid_unique` (`uuid`),
  KEY `competition_assignments_skill_id_foreign` (`skill_id`),
  KEY `competition_assignments_user_id_foreign` (`user_id`),
  KEY `competition_assignments_assigned_by_foreign` (`assigned_by`),
  CONSTRAINT `competition_assignments_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `competition_assignments_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  CONSTRAINT `competition_assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competition_assignments`
--

LOCK TABLES `competition_assignments` WRITE;
/*!40000 ALTER TABLE `competition_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `competition_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competition_equipment_requirements`
--

DROP TABLE IF EXISTS `competition_equipment_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition_equipment_requirements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  `edition_id` bigint(20) unsigned DEFAULT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit` varchar(255) NOT NULL DEFAULT 'pcs',
  `is_mandatory` tinyint(1) NOT NULL DEFAULT 1,
  `is_ppe` tinyint(1) NOT NULL DEFAULT 0,
  `provided_by` varchar(255) NOT NULL DEFAULT 'ORGANIZER',
  `technical_specifications` text DEFAULT NULL,
  `safety_notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `competition_equipment_requirements_uuid_unique` (`uuid`),
  KEY `competition_equipment_requirements_skill_id_foreign` (`skill_id`),
  KEY `competition_equipment_requirements_edition_id_foreign` (`edition_id`),
  CONSTRAINT `competition_equipment_requirements_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `competition_equipment_requirements_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competition_equipment_requirements`
--

LOCK TABLES `competition_equipment_requirements` WRITE;
/*!40000 ALTER TABLE `competition_equipment_requirements` DISABLE KEYS */;
INSERT INTO `competition_equipment_requirements` VALUES (1,'472e5f85-fb5a-449a-bbf0-8a95c9cd77d2',1,NULL,'حقيبة أدوات التركيب الكهربائي','Boîte d\'outils d\'installation électrique','Electrical Installation Tool Kit','مجموعة أدوات قياسية معزولة 1000V معتمد عليها للتركيبات الصناعية.',NULL,NULL,1,'set',1,0,'ORGANIZER',NULL,NULL,'active','2026-08-19 16:21:34','2026-08-19 16:21:34'),(2,'ecd4a932-4355-40e8-b1f8-5f03ad279748',1,NULL,'حذاء السلامة الصناعي المعزول','Chaussures de sécurité isolantes','Safety Shoes Insulated','حذاء سلامة مقاوم للصدمات والكهرباء.',NULL,NULL,1,'pair',1,1,'PARTICIPANT',NULL,NULL,'active','2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `competition_equipment_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competition_results`
--

DROP TABLE IF EXISTS `competition_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) unsigned NOT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  `final_score` decimal(8,2) NOT NULL DEFAULT 0.00,
  `rank` int(11) DEFAULT NULL,
  `award` enum('GOLD','SILVER','BRONZE','MEDALLION_FOR_EXCELLENCE','NONE') NOT NULL DEFAULT 'NONE',
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_results_registration_id_foreign` (`registration_id`),
  KEY `competition_results_skill_id_foreign` (`skill_id`),
  CONSTRAINT `competition_results_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `competition_results_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competition_results`
--

LOCK TABLES `competition_results` WRITE;
/*!40000 ALTER TABLE `competition_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `competition_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `iso2` varchar(2) NOT NULL,
  `iso3` varchar(3) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `nationality_ar` varchar(255) DEFAULT NULL,
  `nationality_fr` varchar(255) DEFAULT NULL,
  `nationality_en` varchar(255) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `is_african` tinyint(1) NOT NULL DEFAULT 1,
  `is_algeria` tinyint(1) NOT NULL DEFAULT 0,
  `requires_passport` tinyint(1) NOT NULL DEFAULT 1,
  `requires_national_id` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_uuid_unique` (`uuid`),
  UNIQUE KEY `countries_iso2_unique` (`iso2`),
  UNIQUE KEY `countries_iso3_unique` (`iso3`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'6a4f70eb-06e1-4732-a915-5e81af24f839','DZ','DZA','الجزائر','Algérie','Algeria','جزائري','Algérien','Algerian','+213','dz.png',1,1,0,1,1,'2026-08-19 16:20:43','2026-08-19 16:21:33'),(2,'d3a7d244-3c77-4665-965b-5e2685aa979d','AO','AGO','أنغولا','Angola','Angola','أنغولي','Angolais','Angolan','+244','ao.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:33'),(3,'03fd6960-2dce-4d33-85e1-5c46cdd4b682','BJ','BEN','بنين','Bénin','Benin','بنيني','Béninois','Beninese','+229','bj.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:33'),(4,'4a82d7bc-ddb1-480c-a563-6bed0d766574','BW','BWA','بوتسوانا','Botswana','Botswana','بوتسواني','Botswanais','Botswanan','+267','bw.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:33'),(5,'a060198d-1cad-47da-8471-6bebeb444411','BF','BFA','بوركينا فاسو','Burkina Faso','Burkina Faso','بوركيني','Burkinabè','Burkinabe','+226','bf.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(6,'144a00a2-9627-4693-986a-0da69e772088','BI','BDI','بوروندي','Burundi','Burundi','بوروندي','Burundais','Burundian','+257','bi.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(7,'c0f3cd52-a019-47b5-bd4a-1e19742f0a6d','CV','CPV','الرأس الأخضر','Cap-Vert','Cape Verde','رأس أخضري','Cap-Verdien','Cape Verdean','+238','cv.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(8,'4638454d-5008-4511-9a83-4c3e5263b223','CM','CMR','الكاميرون','Cameroun','Cameroon','كاميروني','Camerounais','Cameroonian','+237','cm.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(9,'5ec0bdfe-4d4f-497c-87b4-4142487536ac','CF','CAF','جمهورية أفريقيا الوسطى','République centrafricaine','Central African Republic','أفريقي أوسطي','Centrafricain','Central African','+236','cf.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(10,'2fa3f3b1-d5f3-42ab-a2cf-2d20cc492c0e','TD','TCD','تشاد','Tchad','Chad','تشادي','Tchadien','Chadian','+235','td.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(11,'8d1d208a-f938-4fc3-a646-1f26c1f21e5f','KM','COM','جزر القمر','Comores','Comoros','قمري','Comorien','Comorian','+269','km.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(12,'3d36e4d7-93b7-4bbb-8a6d-df8f26b99d1d','CG','COG','جمهورية الكونغو','République du Congo','Republic of the Congo','كونغولي','Congolais','Congolese','+242','cg.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(13,'1bd5e3a6-7014-4588-b7de-6077afabeb20','CD','COD','جمهورية الكونغو الديمقراطية','République démocratique du Congo','Democratic Republic of the Congo','كونغولي','Congolais','Congolese','+243','cd.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(14,'ab8ddc53-781f-4de9-98e8-c8bea8d8099b','CI','CIV','ساحل العاج','Côte d\'Ivoire','Côte d\'Ivoire','إيفواري','Ivoirien','Ivoirian','+225','ci.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(15,'05a0db74-b324-4ec7-9a9d-9037ebf75237','DJ','DJI','جيبوتي','Djibouti','Djibouti','جيبوتي','Djiboutien','Djiboutian','+253','dj.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(16,'98c95119-9793-45f0-927a-c6c4c1108cd1','EG','EGY','مصر','Égypte','Egypt','مصري','Égyptien','Egyptian','+20','eg.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(17,'40005918-afec-431c-af3a-97f42ab98889','GQ','GNQ','غينيا الاستوائية','Guinée équatoriale','Equatorial Guinea','غيني استوائي','Équato-guinéen','Equatorial Guinean','+240','gq.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(18,'bf134ab1-84c1-4394-8deb-a2cc522182eb','ER','ERI','إريتريا','Érythrée','Eritrea','إريتري','Érythréen','Eritrean','+291','er.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(19,'dd1702ed-f80d-4b91-a568-e1cc09b6129e','SZ','SWZ','إسواتيني','Eswatini','Eswatini','إسواتيني','Eswatinien','Swazi','+268','sz.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(20,'a9fc9ad7-8fd6-4b25-90db-7d4099e7de4e','ET','ETH','إثيوبيا','Éthiopie','Ethiopia','إثيوبي','Éthiopien','Ethiopian','+251','et.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(21,'de681eea-d6cc-4307-aab1-9df36168da85','GA','GAB','الغابون','Gabon','Gabon','غابوني','Gabonais','Gabonese','+241','ga.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(22,'e19d3b3e-bb8e-4d5b-8142-6fe5f538e88d','GM','GMB','غامبيا','Gambie','Gambia','غامبي','Gambien','Gambian','+220','gm.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(23,'6ee93caa-2718-461a-bedf-7e71a68a8f94','GH','GHA','غانا','Ghana','Ghana','غاني','Ghanéen','Ghanaian','+233','gh.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(24,'fe4675c8-c205-4f2f-8147-f64b310abe48','GN','GIN','غينيا','Guinée','Guinea','غيني','Guinéen','Guinean','+224','gn.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(25,'958d60c5-0e15-4751-a8e9-b1d8f5ea6b67','GW','GNB','غينيا بيساو','Guinée-Bissau','Guinea-Bissau','غيني بيساوي','Bissau-Guinéen','Bissau-Guinean','+245','gw.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(26,'68d5509e-69c4-4f14-9434-0a1c3f08d30f','KE','KEN','كينيا','Kenya','Kenya','كيني','Kényan','Kenyan','+254','ke.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(27,'a2d61c95-6736-4ebf-918a-de0843040cb7','LS','LSO','ليسوتو','Lesotho','Lesotho','ليسوتي','Lésothien','Basotho','+266','ls.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(28,'57366387-cbeb-4604-8296-b4da09856460','LR','LBR','ليبيريا','Libéria','Liberia','ليبيري','Libérien','Liberian','+231','lr.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(29,'ff1bcf99-d022-466e-a93a-0fbd525705b3','LY','LBY','ليبيا','Libye','Libya','ليبي','Libyen','Libyan','+218','ly.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(30,'913a2ee4-810c-4353-9b4c-ca8b38cf6a0f','MG','MDG','مدغشقر','Madagascar','Madagascar','مدغشقري','Malgache','Malagasy','+261','mg.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(31,'b9652c4f-8d55-4afb-9fce-5d5c7ad78ae1','MW','MWI','ملاوي','Malawi','Malawi','ملاوي','Malawite','Malawian','+265','mw.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(32,'d9ec6460-541d-4664-b3a6-bc4369a5973f','ML','MLI','مالي','Mali','Mali','مالي','Malien','Malian','+223','ml.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(33,'11b25011-25f2-49b4-9555-7aa6ad63917e','MR','MRT','موريتانيا','Mauritanie','Mauritania','موريتاني','Mauritanien','Mauritanian','+222','mr.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(34,'58194086-8dec-42e6-b392-e91db89f91b3','MU','MUS','موريشيوس','Maurice','Mauritius','موريشيوسي','Mauricien','Mauritian','+230','mu.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(35,'e8fd2d72-0ea1-430c-8d79-0c5dbd4e3f15','MA','MAR','المغرب','Maroc','Morocco','مغربي','Marocain','Moroccan','+212','ma.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(36,'d412fe57-be65-496d-832e-7c7057689c84','MZ','MOZ','موزمبيق','Mozambique','Mozambique','موزمبيقي','Mozambicain','Mozambican','+258','mz.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(37,'cf9463da-f13d-4755-9da2-3536a6e2a2fc','NA','NAM','ناميبيا','Namibie','Namibia','ناميبي','Namibien','Namibian','+264','na.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(38,'b65cd5a5-1d8c-47ec-a7e5-a4f971d4f004','NE','NER','النيجر','Niger','Niger','نيجيري','Nigérien','Nigerien','+227','ne.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(39,'c5177d13-c538-49a3-9490-c1764f9183fd','NG','NGA','نيجيريا','Nigéria','Nigeria','نيجيري','Nigérian','Nigerian','+234','ng.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(40,'10384de0-d261-4569-a6a6-2a24a9f56507','RW','RWA','رواندا','Rwanda','Rwanda','رواندي','Rwandais','Rwandan','+250','rw.png',1,0,1,0,1,'2026-08-19 16:20:43','2026-08-19 16:21:34'),(41,'ec4ef5fd-a25f-4339-af64-baece50cd078','ST','STP','ساو تومي وبرينسيبي','Sao Tomé-et-Principe','Sao Tome and Principe','ساو تومي','Santoméen','São Toméan','+239','st.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(42,'79d75cbd-1532-4bd4-a3fb-8182709ad3ca','SN','SEN','السنغال','Sénégal','Senegal','سنغالي','Sénégalais','Senegalese','+221','sn.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(43,'e89ba187-7adf-4ba4-a4ef-1e87de58d0b5','SC','SYC','سيشل','Seychelles','Seychelles','سيشيلي','Seychellois','Seychellois','+248','sc.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(44,'84b0c91c-60c2-4ce3-9e76-6048a81171ba','SL','SLE','سيراليون','Sierra Leone','Sierra Leone','سيراليوني','Sierra-Léonais','Sierra Leonean','+232','sl.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(45,'4b454b7d-d138-47f2-9412-cf49c7233ca3','SO','SOM','الصومال','Somalie','Somalia','صومالي','Somalien','Somali','+252','so.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(46,'dffe192f-853a-4913-9183-f75ee292f3a8','ZA','ZAF','جنوب أفريقيا','Afrique du Sud','South Africa','جنوب أفريقي','Sud-Africain','South African','+27','za.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(47,'6e5a5488-2d6d-45bc-8fc6-f8c39f02d48e','SS','SSD','جنوب السودان','Soudan du Sud','South Sudan','جنوب سوداني','Sud-Soudanais','South Sudanese','+211','ss.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(48,'ed9b8b40-08dc-49d4-9818-ff04a4ae38bc','SD','SDN','السودان','Soudan','Sudan','سوداني','Soudanais','Sudanese','+249','sd.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(49,'e4d83cab-6f0b-4745-9b67-8b713ea298bd','TZ','TZA','تنزانيا','Tanzanie','Tanzania','تنزاني','Tanzanien','Tanzanian','+255','tz.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(50,'09252891-c6ff-48f2-9a32-0b9f624743ed','TG','TGO','توغو','Togo','Togo','توغولي','Togolais','Togolese','+228','tg.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(51,'b55977ff-cba9-4a34-95eb-a851182ad96c','TN','TUN','تونس','Tunisie','Tunisia','تونسي','Tunisien','Tunisian','+216','tn.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(52,'b7caa598-1609-49a1-8153-3036f2079aa5','UG','UGA','أوغندا','Ouganda','Uganda','أوغندي','Ougandais','Ugandan','+256','ug.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(53,'bbbb2def-b6b8-495b-9660-f55a9b249082','ZM','ZMB','زامبيا','Zambie','Zambia','زامبي','Zambien','Zambian','+260','zm.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34'),(54,'65a1f8ff-dcce-47dc-8b8c-ad30622a91b8','ZW','ZWE','زيمبابوي','Zimbabwe','Zimbabwe','زيمبابوي','Zimbabwéen','Zimbabwean','+263','zw.png',1,0,1,0,1,'2026-08-19 16:20:44','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_delegations`
--

DROP TABLE IF EXISTS `country_delegations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_delegations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `edition_id` bigint(20) unsigned NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `head_of_delegation_user_id` bigint(20) unsigned DEFAULT NULL,
  `total_members_count` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'ACTIVE',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_delegations_edition_id_country_id_unique` (`edition_id`,`country_id`),
  UNIQUE KEY `country_delegations_uuid_unique` (`uuid`),
  KEY `country_delegations_country_id_foreign` (`country_id`),
  KEY `country_delegations_head_of_delegation_user_id_foreign` (`head_of_delegation_user_id`),
  CONSTRAINT `country_delegations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `country_delegations_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `country_delegations_head_of_delegation_user_id_foreign` FOREIGN KEY (`head_of_delegation_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_delegations`
--

LOCK TABLES `country_delegations` WRITE;
/*!40000 ALTER TABLE `country_delegations` DISABLE KEYS */;
INSERT INTO `country_delegations` VALUES (1,'a3a45180-d39a-4f58-a8de-28137076aeb0',1,1,4,3,'ACTIVE',NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35');
/*!40000 ALTER TABLE `country_delegations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_skill_selections`
--

DROP TABLE IF EXISTS `country_skill_selections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_skill_selections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `edition_id` bigint(20) unsigned NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `skill_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'DRAFT',
  `requested_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_skill_unique` (`edition_id`,`country_id`,`skill_id`),
  KEY `country_skill_selections_country_id_foreign` (`country_id`),
  KEY `country_skill_selections_skill_id_foreign` (`skill_id`),
  KEY `country_skill_selections_requested_by_foreign` (`requested_by`),
  KEY `country_skill_selections_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `country_skill_selections_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `country_skill_selections_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `country_skill_selections_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `country_skill_selections_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `country_skill_selections_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_skill_selections`
--

LOCK TABLES `country_skill_selections` WRITE;
/*!40000 ALTER TABLE `country_skill_selections` DISABLE KEYS */;
INSERT INTO `country_skill_selections` VALUES (1,1,1,1,'APPROVED',NULL,NULL,'2026-08-19 16:21:35',NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35'),(2,1,1,2,'REQUESTED',NULL,NULL,'2026-08-19 16:21:35',NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35'),(3,1,1,3,'APPROVED',NULL,NULL,'2026-08-19 16:21:35',NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35'),(4,1,1,4,'REQUESTED',NULL,NULL,'2026-08-19 16:21:35',NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35'),(5,1,1,5,'APPROVED',NULL,NULL,'2026-08-19 16:21:35',NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35');
/*!40000 ALTER TABLE `country_skill_selections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delegation_arrivals`
--

DROP TABLE IF EXISTS `delegation_arrivals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delegation_arrivals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` bigint(20) unsigned DEFAULT NULL,
  `arrival_date` date NOT NULL,
  `arrival_time` time NOT NULL,
  `airline_name` varchar(255) NOT NULL,
  `flight_number` varchar(255) NOT NULL,
  `arrival_airport` varchar(255) NOT NULL,
  `passenger_count` int(11) NOT NULL DEFAULT 1,
  `ticket_path` varchar(255) DEFAULT NULL,
  `ticket_filename` varchar(255) DEFAULT NULL,
  `ticket_type` varchar(255) NOT NULL DEFAULT 'pdf',
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `shuttle_assigned` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delegation_arrivals_country_id_foreign` (`country_id`),
  CONSTRAINT `delegation_arrivals_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delegation_arrivals`
--

LOCK TABLES `delegation_arrivals` WRITE;
/*!40000 ALTER TABLE `delegation_arrivals` DISABLE KEYS */;
/*!40000 ALTER TABLE `delegation_arrivals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delegation_members`
--

DROP TABLE IF EXISTS `delegation_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delegation_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `delegation_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `member_type` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'APPROVED',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `nin_number` varchar(255) DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `gender` varchar(10) NOT NULL DEFAULT 'male',
  `suit_size` varchar(20) DEFAULT NULL,
  `shoe_size` varchar(20) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `arrival_flight` varchar(255) DEFAULT NULL,
  `departure_flight` varchar(255) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `skill_id` bigint(20) unsigned DEFAULT NULL,
  `photo_hash` varchar(64) DEFAULT NULL,
  `document_hash` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delegation_members_uuid_unique` (`uuid`),
  KEY `delegation_members_delegation_id_foreign` (`delegation_id`),
  KEY `delegation_members_user_id_foreign` (`user_id`),
  KEY `delegation_members_skill_id_foreign` (`skill_id`),
  KEY `delegation_members_photo_hash_index` (`photo_hash`),
  KEY `delegation_members_document_hash_index` (`document_hash`),
  CONSTRAINT `delegation_members_delegation_id_foreign` FOREIGN KEY (`delegation_id`) REFERENCES `country_delegations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `delegation_members_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE SET NULL,
  CONSTRAINT `delegation_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delegation_members`
--

LOCK TABLES `delegation_members` WRITE;
/*!40000 ALTER TABLE `delegation_members` DISABLE KEYS */;
INSERT INTO `delegation_members` VALUES (1,'5e1979cd-fedd-41b1-a658-7d7daf7b665a',1,NULL,'PARTICIPANT','APPROVED','أحمد','بن علي','123456789',NULL,NULL,'male',NULL,NULL,'+213 555 123 456','ahmed.benali@mfep.gov.dz',NULL,NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35',NULL,NULL,NULL),(2,'dba7ad7a-48d6-4426-87b7-ee0ca1cbe885',1,NULL,'EXPERT','APPROVED','ياسين','قادري','987654321',NULL,NULL,'male',NULL,NULL,'+213 661 987 654','yassine.kadri@mfep.gov.dz',NULL,NULL,NULL,NULL,'2026-08-19 16:21:35','2026-08-19 16:21:35',NULL,NULL,NULL);
/*!40000 ALTER TABLE `delegation_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diplomatic_meeting_rooms`
--

DROP TABLE IF EXISTS `diplomatic_meeting_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diplomatic_meeting_rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 10,
  `location_zone` varchar(255) NOT NULL DEFAULT 'VIP Lounge',
  `status` varchar(255) NOT NULL DEFAULT 'AVAILABLE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diplomatic_meeting_rooms_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diplomatic_meeting_rooms`
--

LOCK TABLES `diplomatic_meeting_rooms` WRITE;
/*!40000 ALTER TABLE `diplomatic_meeting_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `diplomatic_meeting_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diplomatic_meetings`
--

DROP TABLE IF EXISTS `diplomatic_meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diplomatic_meetings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `host_minister_id` bigint(20) unsigned DEFAULT NULL,
  `guest_minister_id` bigint(20) unsigned DEFAULT NULL,
  `room_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `purpose` text DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'SCHEDULED',
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diplomatic_meetings_uuid_unique` (`uuid`),
  KEY `diplomatic_meetings_host_minister_id_foreign` (`host_minister_id`),
  KEY `diplomatic_meetings_guest_minister_id_foreign` (`guest_minister_id`),
  KEY `diplomatic_meetings_room_id_foreign` (`room_id`),
  KEY `diplomatic_meetings_created_by_foreign` (`created_by`),
  CONSTRAINT `diplomatic_meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `diplomatic_meetings_guest_minister_id_foreign` FOREIGN KEY (`guest_minister_id`) REFERENCES `ministerial_officials` (`id`) ON DELETE SET NULL,
  CONSTRAINT `diplomatic_meetings_host_minister_id_foreign` FOREIGN KEY (`host_minister_id`) REFERENCES `ministerial_officials` (`id`) ON DELETE SET NULL,
  CONSTRAINT `diplomatic_meetings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `diplomatic_meeting_rooms` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diplomatic_meetings`
--

LOCK TABLES `diplomatic_meetings` WRITE;
/*!40000 ALTER TABLE `diplomatic_meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `diplomatic_meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edition_countries`
--

DROP TABLE IF EXISTS `edition_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edition_countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `edition_id` bigint(20) unsigned NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `is_registration_open` tinyint(1) NOT NULL DEFAULT 1,
  `max_participants` int(11) NOT NULL DEFAULT 500,
  `status` varchar(255) NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `edition_countries_edition_id_country_id_unique` (`edition_id`,`country_id`),
  KEY `edition_countries_country_id_foreign` (`country_id`),
  CONSTRAINT `edition_countries_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `edition_countries_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edition_countries`
--

LOCK TABLES `edition_countries` WRITE;
/*!40000 ALTER TABLE `edition_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `edition_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edition_dates`
--

DROP TABLE IF EXISTS `edition_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `edition_dates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `edition_id` bigint(20) unsigned NOT NULL,
  `stage_id` bigint(20) unsigned DEFAULT NULL,
  `date_type` varchar(255) NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Africa/Algiers',
  `location_ar` varchar(255) DEFAULT NULL,
  `location_fr` varchar(255) DEFAULT NULL,
  `location_id` bigint(20) unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `edition_dates_edition_id_foreign` (`edition_id`),
  CONSTRAINT `edition_dates_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edition_dates`
--

LOCK TABLES `edition_dates` WRITE;
/*!40000 ALTER TABLE `edition_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `edition_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editions`
--

DROP TABLE IF EXISTS `editions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `editions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `year` int(11) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'DRAFT',
  `theme_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`theme_config`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `editions_uuid_unique` (`uuid`),
  UNIQUE KEY `editions_year_unique` (`year`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editions`
--

LOCK TABLES `editions` WRITE;
/*!40000 ALTER TABLE `editions` DISABLE KEYS */;
INSERT INTO `editions` VALUES (1,'9e05f9bb-cc30-4ccf-a5b0-c0259b7cdcec',2027,'منتدى المهارات الإفريقية 2026/2027','Africa Skills Forum 2026/2027','Africa Skills Forum 2026/2027',1,'ACTIVE',NULL,'2026-08-19 16:21:34','2026-08-19 16:21:35');
/*!40000 ALTER TABLE `editions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_categories`
--

DROP TABLE IF EXISTS `equipment_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_categories`
--

LOCK TABLES `equipment_categories` WRITE;
/*!40000 ALTER TABLE `equipment_categories` DISABLE KEYS */;
INSERT INTO `equipment_categories` VALUES (1,'معدات الحماية الشخصية (PPE)','Équipements de Protection Individuelle','Personal Protective Equipment',NULL,'2026-08-19 16:21:19','2026-08-19 16:21:19');
/*!40000 ALTER TABLE `equipment_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_items`
--

DROP TABLE IF EXISTS `equipment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `skill_id` bigint(20) unsigned DEFAULT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `item_type` varchar(255) NOT NULL,
  `specification_details` text DEFAULT NULL,
  `safety_level` varchar(255) NOT NULL DEFAULT 'standard',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipment_items_category_id_foreign` (`category_id`),
  KEY `equipment_items_skill_id_foreign` (`skill_id`),
  CONSTRAINT `equipment_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `equipment_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `equipment_items_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_items`
--

LOCK TABLES `equipment_items` WRITE;
/*!40000 ALTER TABLE `equipment_items` DISABLE KEYS */;
INSERT INTO `equipment_items` VALUES (1,1,NULL,'نظارات الحماية الشخصية','Lunettes de sécurité','Safety Glasses','ppe',NULL,'high','2026-08-19 16:21:19','2026-08-19 16:21:19'),(2,1,NULL,'حذاء السلامة الصناعي S3','Chaussures de sécurité S3','S3 Safety Shoes','ppe',NULL,'high','2026-08-19 16:21:19','2026-08-19 16:21:19');
/*!40000 ALTER TABLE `equipment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_schedule_items`
--

DROP TABLE IF EXISTS `event_schedule_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_schedule_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_schedule_items_event_id_foreign` (`event_id`),
  CONSTRAINT `event_schedule_items_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_schedule_items`
--

LOCK TABLES `event_schedule_items` WRITE;
/*!40000 ALTER TABLE `event_schedule_items` DISABLE KEYS */;
INSERT INTO `event_schedule_items` VALUES (1,1,'استقبال وتأكيد تسجيل الوفود والمشاركين','Accueil et vérification des délégations','Welcome and Delegation Registration Verification',NULL,NULL,NULL,'08:30','10:00',1,'2026-08-19 16:21:34','2026-08-19 16:21:34'),(2,1,'انطلاق المنافسات الفنية بورشات التكنولوجيا والمهن','Début des épreuves techniques','Commencement of Skill Technical Competitions',NULL,NULL,NULL,'10:15','13:00',2,'2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `event_schedule_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `edition_id` bigint(20) unsigned DEFAULT NULL,
  `title_ar` varchar(255) NOT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `summary_ar` text DEFAULT NULL,
  `summary_fr` text DEFAULT NULL,
  `summary_en` text DEFAULT NULL,
  `description_ar` text DEFAULT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `start_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_at` timestamp NULL DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `wilaya_id` bigint(20) unsigned DEFAULT NULL,
  `cover_media_id` bigint(20) unsigned DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(255) NOT NULL DEFAULT 'PUBLISHED',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_uuid_unique` (`uuid`),
  UNIQUE KEY `events_slug_unique` (`slug`),
  KEY `events_edition_id_foreign` (`edition_id`),
  KEY `events_wilaya_id_foreign` (`wilaya_id`),
  KEY `events_cover_media_id_foreign` (`cover_media_id`),
  CONSTRAINT `events_cover_media_id_foreign` FOREIGN KEY (`cover_media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `events_edition_id_foreign` FOREIGN KEY (`edition_id`) REFERENCES `editions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `events_wilaya_id_foreign` FOREIGN KEY (`wilaya_id`) REFERENCES `wilayas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'a5caa9c4-f5c3-4b2f-b99f-c8b298d2e955',NULL,'حفل الافتتاح الرسمي والانطلاق الوطني للمنافسات','Cérémonie Officielle d\'Ouverture et Lancement National','Official Opening Ceremony and National Competition Launch','national-opening-ceremony-2027','تجمع الوفود الوطنية والدولية بالمركز الدولي للمؤتمرات بالجزائر العاصمة.','Rassemblement des délégations au Centre International des Conférences d\'Alger.','Assembly of national and international delegations at CIC Algiers.',NULL,NULL,NULL,'2026-09-18 16:21:34',NULL,'المركز الدولي للمؤتمرات عبد اللطيف رحال','بن عكنون - الجزائر العاصمة',NULL,NULL,0,1,'PUBLISHED','2026-08-19 16:21:34','2026-08-19 16:21:34','2026-08-19 16:21:34');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
