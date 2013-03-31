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
		include 'views/'.$template_view;
	}
}

?>
