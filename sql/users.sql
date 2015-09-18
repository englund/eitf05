CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(32) PRIMARY KEY NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `address` varchar(255) DEFAULT NULL
);
