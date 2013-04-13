<?php
mysql_query("CREATE TABLE IF NOT EXISTS `group_user`(
     `id` INT NOT NULL,
   `login` VARCHAR(15),
  FOREIGN KEY (`id`) REFERENCES `users`(`id`)

)ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
?>
