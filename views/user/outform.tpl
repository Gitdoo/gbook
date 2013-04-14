<div id="login" style="float:left;width:20%;height:auto;">
Вітаємо <?php 
echo $_SESSION['user']['login'];?>
<form action="/user/logout" method="POST">
	<input type=submit value="Вийти" >
</form>
<form action="/user/info" method="POST">
	<input type=submit value="Інформація про користувача" >
</form>

</div>
