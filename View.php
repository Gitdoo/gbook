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
			
			if( empty($_SESSION['user']) )
			{	
				if($content_view!=="registration.tpl"){
				ob_start();
				include 'views/guestbook/logform.tpl';
				$logform=ob_get_contents();
				ob_end_clean();	
				}
				
			}
			else
			{	
				ob_start();
				echo("<a href='/guestbook/add'><h3>Додоти новий запис</h3></a>");
				include 'views/guestbook/outform.tpl';
				$logform=ob_get_contents();
				ob_end_clean();
			}
		ob_start();
		include 'views/guestbook/'.$content_view;;
		$content=ob_get_contents();
		ob_end_clean();	
		
		ob_start();
		include 'views/layout/'.$template_view;	
		ob_flush();
		include 'views/layout/main_footer.tpl';
		ob_end_flush();
	}
}
//git push -u origin master
?>
