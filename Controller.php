<?php
/**
 * Class Base Controller
 * 
 */
class Controller {
	private $model;
	private $view;
	
	function __construct()
	{
		$this->view = new View();
	}	
}
?>

