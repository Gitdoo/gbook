<h3 >Зміна паролю</h3>
<form action="/user/recovery" method="POST">
 <br>     
 <b>Введіть пароль</b>
 <br>
<input type=password name="password">
 <br>
  <b>Повторіть пароль</b>
 <br>     
<input type=password name="password2">
 <br>
<input type=hidden name="hidden" value=<?php $url = explode('/', $_SERVER['REQUEST_URI']);echo $url[3]; ?>>
<input type=submit value="Змінити">
</form>

