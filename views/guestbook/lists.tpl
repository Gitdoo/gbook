<?php 
if(!empty($data)){
	foreach($data as $temp)
	{
		$local=$temp['id'];
		if(time()-$temp['last_time']>60) $status=date("H:i:s  d-m-Y",$temp['last_time']);else $status="Online";
?>	
	<div>
		<hr>
		<b><u>Назва:</u> </b> <?php echo $temp['name']; ?><br>
		<br><b><u>Короткий текст:</u> </b><?php echo $temp['short_text'];?><br>
		<br><b><u>Повний текст:</u></b><?php echo $temp['long_text']; ?><br>
		<br><b><u>Дата написання:</u></b><?php echo date("H:i:s  d-m-Y",$temp['create_time']);?>
		<br><b><u>Запис додав:</u></b><?php echo $temp['email'];?>
		<b><u>Останній візит:</u></b><?php echo $status; ?>
		
		<?php
		 if(!empty($temp['edit_time'])){
		?>
		<div><br><b>Дата редагування:</b> <?php echo date("H:i:s  d-m-Y",$temp['edit_time']);?> </div> 
		 <?php
		 }
		 if(!empty($_SESSION['id'])&&$_SESSION['id']===$temp['id_user'] ){
		?>                                     
		<br><br><form action='guestbook/edit/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Редагувати'></form>
		<form action='guestbook/delete' method='post'><input type='submit' name='submit'value='Видалити'><input type='hidden'name='id' value=<?php echo $local;?>></form>
		<form action='guestbook/view/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Показати'></form>
		
<?php 
		}
	}
}
else
{
echo "Немає записів";
}
?>

