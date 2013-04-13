<?php
mysql_query("CREATE TABLE  IF NOT EXISTS `pass_recovery`(
                      `id_user` INT NOT NULL,
  		       `hashode` VARCHAR(60),
                       `time` INT,
 			 FOREIGN KEY (`id_user`) REFERENCES `users`(`id`)
                      )ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
?>
