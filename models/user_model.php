<?php
/**
 * Class UserModel
 * обробляє всі дії користувача 
 */
class UserModel extends Model{
	private $error="";
	/**
	* метод update(),оновлює час останнього звернення до сторінок ГК;
	* і робить незначну валідацію
	*/
	private function update()
	{	$times = time();
		$id = $_SESSION['user']['id'];
		$sql="UPDATE `users` SET `last_time`='$times' WHERE `id`='$id';";
		$query=mysql_query($sql);
		if(!$query) return $error="Помилка при підключенні до бази даних!!!";
	}
	/**
	* метод model_recovery(),який записує новий пароль у таблицю users, і видаляє віповідний запис з таблиці pass_recovery;
	* і робить незначну валідацію введених даних
	*/
	public function  model_recovery()
	{	
		$flag=false;
		$_POST['password']=htmlspecialchars($_POST['password']);
		$_POST['password2']=htmlspecialchars($_POST['password2']);
		
		$_POST['password']=trim($_POST['password']);
		$_POST['password2']=trim($_POST['password2']);
	
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
		
		if(!$flag)
		{	
			$hash=$_POST['hidden'];
	
			$sql="SELECT `id`,`family`,`name` FROM `users` WHERE `hashode`='$hash'";
			$query=mysql_query($sql);
			if(!$query) $error="Помилка при підключенні до бази даних";
			$data = mysql_fetch_assoc($query);
			$id=$data['id'];
			$pass=md5($_POST['password']);
			
			$sql="UPDATE `users` SET `password`='$pass',`hashode`='NULL',`expires_time`='NULL' WHERE `id`='$id'";
			$query=mysql_query($sql);
			if(!$query) $error="Помилка при підключенні до бази даних";
								
			$subject="Вітаємо {$data['family']} {$data['name']}, ваш новий пароль {$_POST['password']}";
			$header= "Content-type: text/html; charset=utf-8";
			
			mail($data['email'],"Новий пароль",$subject,$header);
			$error="Пароль змінено і новий пароль відправлено на Ваш email !!!";			
		}
		return $error;
	}
	/**
	* Метод який провіряє чи існує у таблиці заданий hash код  і чи час посилання є активним
	* відповідно якщо hash код є у таблиці і час є активним, то відкривається сторінка з формою для введення паролю,
	* в іншому випадку видає повідомлення про те що такої сторінки не знайдено, або що час вже вийшов
	*/
	public function  model_token($id)
	{
		$sql="SELECT `id`,`expires_time` FROM `users` WHERE `hashode`='$id'";
		$query=mysql_query($sql);
		if(!$query) return $error="Помилка при підключенні до бази даних";
		$myrow = mysql_fetch_assoc($query);
		$times=time();
		if( ( !empty( $myrow['id'] ) )&& ( $times<=$myrow['expires_time'] ) )
		{
			$error="Ok";
		}
		else
		{
			$id=$myrow['id'];
			$sql="UPDATE `users` SET `hashode`='',`expires_time`='0' WHERE id='$id'";
			$query=mysql_query($sql);
			if(!$query) return $error="Помилка при підключенні до бази даних";
			$error="Ваше посилання не валідне";
		}
	
	return $error;
	}
	/**
	* Відсилає hash код тобто посилання на вказаний email
	* Використовується нова таблиця для збереження id користувача, hash коду і часу
	*/
	public function  model_sendpass()
	{
		if( empty($_POST['login']) )
		{	
			$error="Ви нічого не ввели	<br> <a href='/user/forgotpass'>Назад</a>";
		}
		else
		{
			$login=$_POST['login'];
			$sql="SELECT `id` FROM `users` WHERE `email`='$login'";
			$query=mysql_query($sql);
			if(!$query) $error="Помилка при підключенні до бази даних";
			$myrow = mysql_fetch_assoc($query);
			if( empty($myrow['id']) )
			{
				$error="Вибачте, такого логіну не має.";
			}
			else
			{
				
				$times=time()+86400;
				$hash=md5($login);
				$sql="UPDATE `users` SET `hashode`='$hash',`expires_time`='$times' WHERE `email`='$login'";
				$query=mysql_query($sql);
				if(!$query) return $error="Помилка при підключенні до бази даних";
				$href=$_SERVER['SERVER_NAME']."/user/token/".$hash;
				
				return $subject="<a href='".$href."'>".$href."</a>";
				$header= "Content-type: text/html; charset=utf-8";
				mail($_POST['login'],"Відновлення паролю",$subject,$header);
				$error="Посилання на відновлення паролю відпавлено на ваш email!!";
			}
		}
	return $error;
	}
	/**
	* ВИводить інформацію про користувача
	*/
	public function model_info()
	{	
		$this->update();
		$login=$_SESSION['user']['id'];
		$sql="SELECT * FROM `users` WHERE `id`='$login'";
		$query=mysql_query($sql);
		if(!$query) return "Помилка при підключенні до бази даних";
		$data=mysql_fetch_assoc($query);
		return $data;
	}
	/**
	* метод model_logout(),який здійснює вихід користувача в ГК;
	* і робить незначну валідацію
	*/
	public function model_logout()
	{	
		
		$flag=false;
		$times=time();
		if( ( !empty($_SESSION['user']['id']) )&&( !empty($_SESSION['user']['login']) ) )
		{
		unset($_SESSION['user']);
		$error="Ви вийшли";
		$this->update();
		return $error;
		}
	}
	/**
	* метод model_login(),який здійснює вхід користувача в ГК;
	* і робить незначну валідацію
	*/
	public function model_login()
	{	
		$flag=false;
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
			if ($myrow['password']===md5($password)) 
			{
				$_SESSION['user']['login']=$myrow['email']; 
				$_SESSION['user']['id']=$myrow['id'];
				$error.="Ви успішно зайшли! ";
				
			}
			else 
			{
				$error.="Вибачте, введений логін або пароль - невірний.";
				
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
	function __destruct()
	{
		mysql_close();
		
	}
}
?>
