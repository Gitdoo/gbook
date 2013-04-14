<div id="login" style="float:left;width:20%;height:auto;">
	<form action="/user/login" method="POST">
	<b>Логін(email)</b>
	<br>     
	<input type=text name="login">
	<br>
	<b>Пароль</b>
	<br>
	<input type=password name="password">
	<br>
	<input type=submit value="Увійти" >
</form>
<form action="/user/registration" method="POST">
	<input type=submit value="Реєстрація" >
</form>
<form action="/user/forgotpass" method="POST">
	<input type=submit value="Забув пароль" >
</form>

</div>
