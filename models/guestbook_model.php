<?php
/**
 * Class GuestbookModel
 * обробляє всі дії користувача 
 */
class GuestbookModel extends Model{
	private $error="";
	
	/**
	* метод update(),оновлює час останнього звернення до сторінок ГК;
	* і робить незначну валідацію
	*/
	private function update()
	{	$times=time();
		$sql="UPDATE `users` SET `last_time`='$times' WHERE `id`='$_SESSION[id]';";
		$query=mysql_query($sql);
		if(!$query) return $error="Помилка при підключенні до бази даних!!!";
	}
	/**
	* ВИводить інформацію про користувача
	*/
	public function model_info()
	{	session_start();
		$login=$_SESSION['id'];
		$sql="SELECT * FROM `users` WHERE `id`='$login'";
		$query=mysql_query($sql);
		if(!$query) return "Помилка при підключенні до бази даних";
		$data=mysql_fetch_assoc($query);
		$this->update();
		return $data;
	}
	/**
	* метод model_logout(),який здійснює вихід користувача в ГК;
	* і робить незначну валідацію
	*/
	public function model_logout()
	{	
		session_start();
		$flag=false;
		$times=time();
		if( ( !empty($_SESSION['id']) )&&( !empty($_SESSION['login']) ) )
		{
		session_destroy();
		$error="Ви вийшли";header("Location:/");
		$sql="UPDATE `users` SET `last_time`='$times' WHERE `id`='$_SESSION[id]';";
		$query=mysql_query($sql);
		if(!$query) return $error="Помилка при підключенні до бази даних!!!";
		header("Location:/");
		return $error;
		}
	}
	/**
	* метод model_login(),який здійснює вхід користувача в ГК;
	* і робить незначну валідацію
	*/
	public function model_login()
	{	$flag=false;
		session_start();
		$this->update();
		if (isset($_POST['login'])) 
		{ 
			$login = $_POST['login']; 
			if ($login == '') { unset($login);}
		} 
		if (isset($_POST['password']))
		{ 
			$password=$_POST['password']; 
			if ($password =='') { unset($password);} 
		}
		if (empty($login) or empty($password)) 
		{
			$error.="Ви ввели не всю Інформацію!";
			$flag=true;
		}
		$login = htmlspecialchars($login);
		$password = htmlspecialchars($password);
		$login = trim($login);
		$password = trim($password);
		$sql="SELECT * FROM `users` WHERE email='$login';";
		$query = mysql_query($sql);
		$myrow = mysql_fetch_assoc($query);
		if (empty($myrow['password']))
		{
			$error.="Вибачте, введений логін або пароль - невірний.";
			$flag=true;
		}
		if(!$flag)
		{
			if ($myrow['password']===md5($password)) {
				$_SESSION['login']=$myrow['email']; 
				$_SESSION['id']=$myrow['id'];
				$error.="Ви успішно зайшли! ";
				$flag=true;
			}
			else 
			{
				$error.="Вибачте, введений логін або пароль - невірний.";
				$flag=true;
			}
		}
		return $error;
	}
    /**
	* метод model_register(),який вставляє введені дані з форми у базу даних  для реєстрації користувачів;
	* і робить незначну валідацію
	*/
	public function model_register()
	{
		$times=time();
		$flag=false;
		$_POST['family']=htmlspecialchars($_POST['family']);
		$_POST['name']=htmlspecialchars($_POST['name']);
		$_POST['email']=htmlspecialchars($_POST['email']);
		$_POST['password']=htmlspecialchars($_POST['password']);
		$_POST['password2']=htmlspecialchars($_POST['password2']);
		$_POST['family']=trim($_POST['family']);
		$_POST['name']=trim($_POST['name']);
		$_POST['email']=trim($_POST['email']);
		$_POST['password']=trim($_POST['password']);
		$_POST['password2']=trim($_POST['password2']);
		if( empty($_POST['family']) ) 
		{	
			$error.="Ви не ввели прізвище!<br>";
			$flag=true;
		}
		if( empty($_POST['name']) ) 
		{	
			$error.="Ви не ввели імя!<br>";
			$flag=true;
		}
		if (empty($_POST['email'])) 
		{	
			$error.="Ви не ввели email!<br>";
			$flag=true;
		}
		if (empty($_POST['password'])) 
		{	
			$error.="Ви не ввели пароль <br>";
			$flag=true;
		}
		if (empty($_POST['password2'])) 
		{	
			$error.="Ви не ввели повторний пароль!<br>";
			$flag=true;
		}
		if ($_POST['password']!==$_POST['password2']) 
		{	
			$error.="Паролі не співпадають!<br>";
			$flag=true;
		}
		$login=$_POST['email'];
		$sql="SELECT `id` FROM `users` WHERE email='$login';";
		$query = mysql_query($sql);
		$data = mysql_fetch_assoc($query);
		if (!empty($data['id']))
		{
			$error.="Вибачте, введений логін вже існує, введіть інший";
			$flag=true;
		}
		
		$pass=md5($_POST['password']);
		if(!$flag)
		{	
			$sql="insert into `users` (`family`,`name`,`email`,`password`,`create_time`) values ('$_POST[family]','$_POST[name]','$_POST[email]','$pass','$times')";
			if(mysql_query($sql)) 
			{	
				
				$error.="Реєстрація пройшла успішно";
				mail($_POST['email'],"Реєстрація у гостьовій книзі","Вітамо ".$_POST['name']."  ".$_POST['family']. " Ви успішно зареєструвалися у гостьовій книзі ваш логін:".$_POST['email'].";  та пароль:".$_POST['password']."!!!!");
			}
			else
			{
				$error.="Помилка в підключенні до бази даних!";
			}
			$sql="SELECT `id`,`email` FROM `users` WHERE email='$login';";
			$query = mysql_query($sql);
			$data = mysql_fetch_assoc($query);
			$sql="insert into `group_user` (`id`,`login`) values ('$data[id]','$data[email]');";
			if(mysql_query($sql)){
				if($error==="Реєстрація пройшла успішно")
				return $error; 
			}
		}
		return $error; 		
	}
	/**
	* метод insert(),який вставляє введені дані з форми у базу даних;
	* і робить незначну валідацію
	*/
	public function model_insert(){
		session_start();
		$this->update();
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
			$login=$_SESSION['login'];
			$sql="SELECT `id` FROM `users` WHERE email='$login';";
			$query = mysql_query($sql);
			$data=mysql_fetch_assoc($query);
			$sql="insert into `guestbook` (`name`,`short_text`,`long_text`,`create_time`,`id_user`) values ('$_POST[name]','$_POST[short_text]','$_POST[long_text]','$times','$data[id]')";
			if(mysql_query($sql)) 
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
		session_start();
		$this->update();
		if( isset( $_POST['submit'] ) ){
			$sql="DELETE FROM `guestbook` WHERE id=".$_POST['id'].";";
			mysql_query($sql) or die("Не можливо видалити данi");
			return "Дані успішно видалені";
		}
	
	}
    /**
	* метод edit(),вибирає дані з бази даних,записує їх у форму;
	* і робить незначну валідацію
	*/        
	public function model_edit(){
		session_start();
		$this->update();
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
				$sql="UPDATE `guestbook` SET `name`='{$_POST['name']}', `short_text`='{$_POST['short_text']}',
										 `long_text`='{$_POST['long_text']}',`edit_time`='$times' WHERE id='{$_POST['id']}';";
				$add=mysql_query($sql);
				if($add){
					$error.="дані редаговано";
				}
				else
				{
					$error.="При добавленні повідомлення сталася помилка! ";
				}
			}
		return $error;
		
	}
	/**
	* Вибирає дані з бази даних відповідно до $id
	*/
	public function model_view($id){
		session_start();
		$this->update();
		if( !empty( $_POST['submit'] ) ){
			$sql="SELECT * FROM `guestbook` WHERE id=".$id.";";
			$query = mysql_query($sql);
		    if (!$query) return "неможливо вибрати дані з таблиці!";	
			$data=mysql_fetch_assoc($query);
			$login=$data['id_user'];
			$sql2="SELECT `email` FROM `users` WHERE `id`='$login';";	
			$query2 = mysql_query($sql2);
			if (!$query2) return "неможливо вибрати дані з таблиці!";
			$dat=mysql_fetch_assoc($query2);
			$data['email']=$dat['email'];	
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
		session_start();
		$this->update();
	 $sql="SELECT * FROM `guestbook` order by 'create_time' DESC;";	
	 $query = mysql_query($sql);
	 if (!$query) return "неможливо вибрати дані з таблиці!";	
	 while ($data=mysql_fetch_assoc($query))
	 {	
		 $login=$data['id_user'];
		 $sql2="SELECT `email`,`last_time` FROM `users` WHERE `id`='$login';";	
		 $query2 = mysql_query($sql2);
		 if (!$query2) return "неможливо вибрати дані з таблиці!";
		 $dat=mysql_fetch_assoc($query2);
		 $data['email']=$dat['email'];
		 $data['last_time']=$dat['last_time'];
		 $datas[]=$data;
		
	 }	
	 return $datas;
	 
	}
	function __destruct()
	{
		mysql_close();
		
	}
	
	
}
?>
