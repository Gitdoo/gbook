<?php
mysql_query("CREATE TABLE  IF NOT EXISTS `guestbook`(
                      `id` INT AUTO_INCREMENT ,
                      `name` VARCHAR(100),
                     `short_text` TEXT NOT NULL,
                     `long_text` TEXT NOT NULL,
                     `create_time` INT NOT NULL,
						`edit_time` INT ,
						`id_user`INT NOT NULL,
                      PRIMARY KEY (id),
                      FOREIGN KEY (`id_user`) REFERENCES `users`(`id`)
                      )ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
?>
