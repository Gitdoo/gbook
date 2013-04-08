<h3 >Додати запис</h3>
<form action="insert" method="POST">
 <b>Назва</b>
 <br>     
<input type=text name="name" value=<?php echo $data['name'];?> >
 <br>
<b>Короткий текст</b>
<br>
<textarea name="short_text" rows=5 cols=25 ><?php echo $data['short_text'];?></textarea>
<input type='hidden' name='id' value='<?php echo "".$data['id']."";?>'>
<br>
<b>Повний текст</b>
<br>
<textarea name="long_text" rows=8 cols=40  ><?php echo $data['long_text'];?></textarea>
<br>
<input type=submit value="Додати" id="addButton">
</form>
