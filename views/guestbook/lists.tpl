<?php 
if(!empty($data)){
	foreach($data as $temp)
	{
		$local=$temp['id'];
		if(time()-$temp['last_time']>60) $status=date("H:i:s  d-m-Y",$temp['last_time']);else $status="Online";
?>	
	
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
		 if(!empty($_SESSION['user']['id'])&&$_SESSION['user']['id']===$temp['id_user'] ){
		?>                                     
		<br><br><form action='guestbook/edit/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Редагувати'></form>
		<form action='guestbook/delete' method='post'><input type='submit' name='submit'value='Видалити'><input type='hidden'name='id' value=<?php echo $local;?>></form>
		<form action='guestbook/view/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Показати'></form>
		
<?php 
		}
	}
?>
		<div align='center'>
		<a href='/guestbook/lists/page/1'>Перша</a>&nbsp;&nbsp;
	
<?php	
		$page=1;
		
		if($_SESSION['pagenum']>1)
		echo "<a href='/guestbook/lists/page/".($_SESSION['pagenum']-1)."'>Попередня</a>&nbsp;&nbsp;";

		$page_count=ceil($_SESSION['post_count']/$_SESSION['show_posts']);
		while($page<=$page_count)
		{
			if($page==$_SESSION['pagenum']){ echo "$page &nbsp;&nbsp;";}
			else 
			{
			
			echo "<a href='/guestbook/lists/page/".$page."'>$page</a>&nbsp;&nbsp;";

			}
			$page++;
		}
		if($_SESSION['pagenum']<$page_count)

		echo "<a href='/guestbook/lists/page/".($_SESSION['pagenum']+1)."'>Наступна</a>&nbsp;&nbsp;";
		echo "<a href='/guestbook/lists/page/".$page_count."'>Остання</a></div>";

	}
	else
	{
	echo "Немає записів";
	}
?>
