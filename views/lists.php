<div>
<?php 
	if(!empty($data)){
	foreach($data as $temp)
	{
		$local=$temp['id'];
?>	
	<div>
		<b><u>Назва:</u> </b> <?php echo $temp['name']; ?><br>
		<br><b><u>Короткий текст:</u> </b><?php echo $temp['short_text'];?><br>
		<br><b><u>Повний текст:</u></b><?php echo $temp['long_text']; ?><br>
		<br><b><u>Дата написання:</u></b><?php echo date("H:i:s  d-m-Y",$temp['create_time']);?>
		<?php
		 if(!empty($temp['edit_time'])){
		?>
		<div><br><b>Дата редагування:</b> <?php echo date("H:i:s  d-m-Y",$temp['edit_time']);?> </div> 
		 <?php
		 }
		?>                                     
		<br><br><form action='edit/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Редагувати'></form>
		<form action='delete' method='post'><input type='submit' name='submit'value='Видалити'><input type='hidden'name='id' value=<?php echo $local;?>></form>
		<form action='view/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Показати'></form>
		<hr>
	</div>
<?php 
	}
	}
	else{
	echo "Немає записів";
	}
?>
</div>
