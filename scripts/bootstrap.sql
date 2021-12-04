DROP TABLE IF EXISTS `subscribers`;

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscribers_email_unique` (`email`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cron_runs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sucessfulRuns` int(11) NOT NULL,
  `lastRuns` int(11) NOT NULL,
  PRIMARY KEY (`id`),
) AUTO_INCREMENT=1  DEFAULT CHARSET=utf8mb4;

INSERT INTO `cron_runs` (`id`, `sucessfulRuns`, `lastRuns`) VALUES ('1', '0', '0');