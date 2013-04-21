<div align='center'>
		<a href='/guestbook/lists/page/1'>Перша</a>&nbsp;&nbsp;
	
<?php	
		$page=1;
		
		if($_SESSION['pagenum']>1)
		{
?>
		<a href='/guestbook/lists/page/<?php echo ($_SESSION['pagenum']-1)?>'>Попередня</a>&nbsp;&nbsp;
<?php
		}
		$page_count=ceil($_SESSION['post_count']/$_SESSION['show_posts']);
		while($page<=$page_count)
		{
			if($page==$_SESSION['pagenum']){ echo "$page &nbsp;&nbsp;";}
			else 
			{
?>			
			<a href='/guestbook/lists/page/<?php echo $page?>'><?php echo $page?></a>&nbsp;&nbsp;
<?php
			}
			$page++;
		}
		if($_SESSION['pagenum']<$page_count)
		{
?>
		<a href='/guestbook/lists/page/<?php echo ($_SESSION['pagenum']+1)?>'>Наступна</a>&nbsp;&nbsp;
	<?php	}?>
		<a href='/guestbook/lists/page/<?php echo $page_count?>'>Остання</a></div>
