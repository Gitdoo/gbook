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
		ob_start();
		include 'views/layout/main_header.tpl';
		ob_end_flush();
			
			if( empty($_SESSION['id']) )
			{	
				if($content_view!=="registration.tpl"){
				ob_start();
				include 'views/guestbook/logform.tpl';
				ob_end_flush();
				}
				
			}
			else
			{	
				echo("<a href='/add'><h3>Додоти новий запис</h3></a>");
				ob_start();
				include 'views/guestbook/outform.tpl';
				ob_end_flush();
			}
		include 'views/layout/'.$template_view;	
		
		ob_start();
		include 'views/layout/main_footer.tpl';
		ob_end_flush();
	}
}

?>
