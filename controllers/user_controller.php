<?php
/**
 * Class GuestbookController
 * описує всі дії користувача 
 */
class UserController extends Controller{

	function __construct()
	{
		$this->model = new UserModel();
		$this->view = new View();
	}
	/**
	* записує новий пароль у таблицю users, і видаляє віповідний запис з таблиці pass_recovery;
 	*/
	function recovery()
	{
		$data=$this->model->model_recovery();
		$this->view->generate('view.tpl','main.tpl',$data);
	}
	/**
	* Генерує форму для введення паролю, або помилку.
 	*/
	function token($id)
	{
		$data=$this->model->model_token($id);
		if($data==="Ok")
		{
			$this->view->generate('recovery.tpl','main.tpl');
		}
		else
		{	
			$this->view->generate('view.tpl','main.tpl',$data);
		}
	}
	/**
	* відсилає повідомлення з посиланням про відновлення паролю
 	*/
	function sendpass()
	{
		$data=$this->model->model_sendpass();
		$this->view->generate('view.tpl','main.tpl',$data);
	}
	/**
	* Виводить форму для введення email-y на який буде відправлено посилання для відновлення паролю
 	*/
	function forgotpass()
	{
		$this->view->generate('forgotpass.tpl','main.tpl');
	}
	/**
	* ВИводить інформацію про користувача
	*/
	function info()
	{
		$data=$this->model->model_info();
		$this->view->generate('info.tpl','main.tpl',$data);
	}
	
	function logout()
	{	
		$data=$this->model->model_logout();
		$this->view->generate('view.tpl','main.tpl',$data);
		
	}
	function login()
	{	
		$data=$this->model->model_login();
		$this->view->generate('view.tpl','main.tpl',$data);
	}
	/**
	* метод registration(),який генерує форму для введення даних 
	*  
	*/
	function registration()
	{	
		$this->view->generate('registration.tpl','main.tpl');
	}
	/**
	* метод insert(),який вставляє введені дані з форми у базу даних при реєстрації
	*  
	*/
	function register()
	{	
		$data=$this->model->model_register();
		$this->view->generate('view.tpl','main.tpl',$data);
	}
	/**
	* показує повідомлення про те, що такої сторінки не існує
	*/
	function not_exist()
	{
		$this->view->generate('view.tpl', 'main.tpl', "Такої сторінки не знайдено");
	}
	function __destruct()
	{
		unset($this->model);
		unset($this->view);
	}
}
?>
