#Task 1

###Logger

<p>changed type of `type` column to int(11) NOT NULL</p>

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
);