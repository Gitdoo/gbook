<div id="login" style="float:left;width:20%;height:auto;">
Вітаємо <?php 
echo $_SESSION['login'];?>
<form action="logout" method="POST">
	<input type=submit value="Вийти" >
</form>
<form action="/info" method="POST">
	<input type=submit value="Інформація про користувача" >
</form>

</div>
