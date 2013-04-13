<?php
ob_start();
session_start();
	require_once 'Model.php';
	require_once 'View.php';
	require_once 'Controller.php';
	require_once 'models/guestbook_model.php';
	require_once 'controllers/guestbook_controller.php';
	
	require_once 'models/user_model.php';
	require_once 'controllers/user_controller.php';

	require_once "config/config.php";
	
	//��� � ����� ���������� �� �����������
	$controller_name = 'guestbook';
	$action = 'lists';

	$url = explode('/', $_SERVER['REQUEST_URI']);

		//�������� ��� ����������
		if ( !empty($url[1]) )
		{
			$controller_name = $url[1];
		}
		// �������� ��� ������
		if ( !empty($url[2]) )
		{
			$action= $url[2];
		}
		$controller_name=ucfirst($controller_name);
		$controller_name.="Controller";
		$controller = new $controller_name();
		
		
		// �������� �������� ��� ������
		if ( !empty($url[3]) )
		{
			$value=$url[3];
			if(method_exists($controller, $action))
			{
				// ��������� ����� �����������
				$controller->$action($value);
			}
			
		}
		else{
			if( method_exists($controller, $action) )
			{
				// ��������� ����� �����������
				$controller->$action();
			}
			else 
			{
				$controller->not_exist();
			}
		}
	unset($controller);
ob_flush();
?>

