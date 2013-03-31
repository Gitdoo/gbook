<?php
	require_once 'Model.php';
	require_once 'View.php';
	require_once 'Controller.php';
	require_once 'models/guestbook_model.php';
	require_once 'controllers/guestbook_controller.php';
	require_once "config/config.php";
	$controller=new GuestbookController();

	$url = explode('/', $_SERVER['REQUEST_URI']);

		// получаємо імя методу
		if ( !empty($url[1]) )
		{
			$action = $url[1];
		}
		else
		{
		$action="lists";
		}
		// получаємо параметр для методу
		if ( !empty($url[2]) )
		{
			$value=$url[2];
			if(method_exists($controller, $action))
			{
				// викликаємо метод контроллера
				$controller->$action($value);
			}
			
		}
		else{
			if(method_exists($controller, $action))
			{
				// викликаємо метод контроллера
				$controller->$action();
			}
			else 
			{
				$controller->not_exist();
			}
		}
		unset($controller);
?>

