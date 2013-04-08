<?php 
	if(!empty($data)){
		if(is_array($data)){
?>
<div>
	<h3>Інформація про користувача!!!</h3>
    <b><u>Прізвище:</u> </b> <?php echo $data['family'];?><br>
    <br><b><u>Ім'я:</u> </b><?php echo $data['name'];?><br>
    <br><b><u>Email:</u></b><?php echo $data['email']; ?><br>
    <br><b><u>Дата створення:</u></b><?php echo date("H:i:s  d-m-Y",$data['create_time']);?>
	
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


