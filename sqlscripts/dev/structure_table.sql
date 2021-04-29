USE epsi;

DROP TABLE IF EXISTS `data_file`;

CREATE TABLE `data_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_37D0FDF293CB796C` (`file_id`),
  CONSTRAINT `FK_37D0FDF293CB796C` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

