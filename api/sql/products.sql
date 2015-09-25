CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
);
