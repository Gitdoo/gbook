<?php
/**
 * Class GuestbookModel
 * обробляє всі дії користувача 
 */
class GuestbookModel extends Model{

	
	private $error="";
	
	/**
	* метод insert(),який вставляє введені дані з форми у базу даних;
	* і робить незначну валідацію
	*/
	public function model_insert(){
		$flag=false;
		$times=time();	
		$_POST['name']=htmlspecialchars($_POST['name']);
		$_POST['short_text']=htmlspecialchars($_POST['short_text']);
		$_POST['long_text']=htmlspecialchars($_POST['long_text']);
		if( empty($_POST['name']) ) 
		{	
			$error.="Ви не ввели назву!<br>";
			$flag=true;
		}
		if (empty($_POST['short_text'])) 
		{	
			$error.="Ви не ввели короткий текст!<br>";
			$flag=true;
		}
		if (empty($_POST['long_text'])) 
		{	
			$error.="Ви не ввели повний текст!<br>";
			$flag=true;
		}
		if(!$flag)
		{
			if(mysql_query("insert into `guestbook` (`name`,`short_text`,`long_text`,`create_time`) values ('$_POST[name]','$_POST[short_text]','$_POST[long_text]','$times')")) 
			{	
				
				$error.="Запис додано успішно";
			}
			else
			{
				$error.="Помилка в підключенні до бази даних!";
			}
		}
		return $error; 
	}
	/**
	* видаляє дані з бази даних;
	*/
	public function model_delete(){
		if( isset( $_POST['submit'] ) ){
		mysql_query("DELETE FROM `guestbook` WHERE id=".$_POST['id'].";") or die("Не можливо видалити данi");
		return "Дані успішно видалені";
		}
	}
    /**
	* метод edit(),вибирає дані з бази даних,записує їх у форму;
	* і робить незначну валідацію
	*/        
	public function model_edit(){
		$times=time();
		$error="";
		$_POST['name']=htmlspecialchars($_POST['name']);
		$_POST['short_text']=htmlspecialchars($_POST['short_text']);
		$_POST['long_text']=htmlspecialchars($_POST['long_text']);              	
			if( empty($_POST['name']) ) 
			{	
				$error.="Ви не ввели назву!<br>";
				$flag=true;
			}
			if (empty($_POST['short_text'])) 
			{	
				$error.="Ви не ввели короткий текст!<br>";
				$flag=true;
			}
			if (empty($_POST['long_text'])) 
			{	
				$error.="Ви не ввели повний текстasdasd!<br><a href='/add'>Назад</a>";
				$flag=true;
				
			}
			if($error===""){
				$add=mysql_query("UPDATE `guestbook` SET `name`='{$_POST['name']}', `short_text`='{$_POST['short_text']}',
										 `long_text`='{$_POST['long_text']}',`edit_time`='$times' WHERE id='{$_POST['id']}';");
				if($add){
					$error.="дані редаговано";
				}
				else
				{
					$error.="При добавленні повідомлення сталася помилка! ".$_POST[$id];
				}
			}
		return $error;
	}
	/**
	* Вибирає дані з бази даних відповідно до $id
	*/
	public function model_view($id){
		if( !empty( $_POST['submit'] ) ){
			$query = mysql_query("SELECT * FROM `guestbook` WHERE id=".$id.";");
		    if (!$query) return "неможливо вибрати дані з таблиці!";	
			$data=mysql_fetch_assoc($query);
			return $data;
		}
		else 
		{ 
			return "Неможливо показати сторінку";
		}
	}
	/**
	* Вибирає усі дані з бази даних 
	*/
	public function model_lists(){
	 $query = mysql_query("SELECT * FROM `guestbook` order by 'create_time' DESC;");
	 if (!$query) return "неможливо вибрати дані з таблиці!";	
	 while ($data=mysql_fetch_assoc($query))
		$datas[]=$data;
	 return $datas;
	}
	function __destruct()
	{
		mysql_close();
		
	}
	
	
}
?>
