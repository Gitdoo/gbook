<?php 

	if(!empty($data)){
		if(is_array($data)){
		$local=$data['id'];
?>
<div>
    <b><u>Назва:</u> </b> <?php echo $data['name'];?><br>
    <br><b><u>Короткий текст:</u> </b><?php echo $data['short_text'];?><br>
    <br><b><u>Повний текст:</u></b><?php echo $data['long_text']; ?><br>
    <br><b><u>Дата написання:</u></b><?php echo date("H:i:s  d-m-Y",$data['create_time']);?>
	<br><b><u>Запис додав:</u></b><?php echo $data['email'];?>
    <br><br><br>
	<form action='/guestbook/edit/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Редагувати'></form> 
    &nbsp;&nbsp;&nbsp;&nbsp;
    <form action='/guestbook/delete' method='post'><input type='hidden'name='id' value=<?php echo $local;?>><input type='submit' name='submit'value='Видалити'></form>
</div>
<?php 
		}
		else
		{
			echo $data;
		}
	}
	else
	{
	echo "Немає запису";
	}
	
	

	
?>

