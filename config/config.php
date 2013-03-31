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
                      PRIMARY KEY (id)
                      )ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
?>
