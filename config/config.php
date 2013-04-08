<?php
	$host="localhost";
	$username="root";
	$password="";
	$db="db";
	mysql_connect($host,$username,$password);
	mysql_select_db($db);
	
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
/*
 *
 * CREATE TABLE IF NOT EXISTS `group_user`(
     `id` INT NOT NULL,
   `login` VARCHAR(15),
  FOREIGN KEY (`id`) REFERENCES `users`(`id`)

)ENGINE=MyISAM  DEFAULT CHARSET=utf8;
* 
* 
*  
 CREATE TABLE IF NOT EXISTS `users`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `family` VARCHAR(25),
  `name` VARCHAR(15),
  `email` VARCHAR(30),
  `password` TEXT,
  `create_time` INT NOT NULL,
  `last_time` INT ,
  PRIMARY KEY(id)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;
 * 
 *
 * */

?>
