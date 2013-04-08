<div id="content" style="float:left;width:80%;">
<a href="/" style="float:right;"><h4>Вернутися на головну</h4></a>
<h3>Записи </h3>
<?php 
ob_start();
include 'views/guestbook/'.$content_view;
ob_flush();
?>   
</div>


