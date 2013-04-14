<?php
mysql_query(" CREATE TABLE IF NOT EXISTS `users`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `family` VARCHAR(25),
  `name` VARCHAR(15),
  `email` VARCHAR(30),
  `password` TEXT,
  `create_time` INT NOT NULL,
  `last_time` INT ,
  `hashode` VARCHAR(60),
  `expires_time` INT,
  PRIMARY KEY(id)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

?>
