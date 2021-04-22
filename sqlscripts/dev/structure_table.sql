DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `file_id` int DEFAULT NULL,
                        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `IDX_ADF3F36393CB796C` (`file_id`),
                        CONSTRAINT `FK_ADF3F36393CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
UNLOCK TABLES;

