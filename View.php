<?php
/**
 * базовий клас View
 */
class View
{
	/**
	 * метод який генерує шаблони сторінок до даних data
	 * $content_view - вид сторінок залежно від контенту;
	 * $template_view - загальний для всіх сторінок шаблон;
	 * $data - массив,елементів контенту сторінки.
	 */
	function generate($content_view, $template_view, $data = null)
	{			
			if( empty($_SESSION['user']) )
			{	
				if($content_view!=="registration.tpl")
				{
				ob_start();
				include 'views/user/logform.tpl';
				$logform=ob_get_contents();
				ob_end_clean();	
				}
			}
			else
			{	
				ob_start();
				echo("<a href='/guestbook/add'><h3>Додоти новий запис</h3></a>");
				include 'views/user/outform.tpl';
				$logform=ob_get_contents();
				ob_end_clean();
			}
		
		
		$controller_name="guestbook";
		$url = explode('/', $_SERVER['REQUEST_URI']);
		if ( !empty($url[1]) )
		{
			$controller_name = $url[1];
		}
		
		ob_start();
		include 'views/'.$controller_name.'/'.$content_view;
		$content=ob_get_contents();
		ob_end_clean();	
		
		ob_start();
		include 'views/layout/'.$template_view;	
		ob_end_flush();
	}
	
}
?>
