CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `username` varchar(32) NOT NULL,
  `total` double NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
