<?php
require_once('Database.class.php');
require_once('ImgInspector.class.pnp');
/*
* Базовый класс, является родительским
*/






class Base {

	public $lang = array(); 

	function __construct() {}

	public function index()
	{
		$content = $this->localization($this->lang);
		$content['title'] = $this->lang['AUTHORIZATION'];

		$this->view('auth',$content);
	}

	//автозагрузчик методов
	public static function __myAutoload($exp = array(), $lang = array())
	{
		require_once('User'.CLASS_EXT);
		$user = new User;
		$user->unsetGet($exp);

		$user->lang = $user->localization($lang);


		if(!empty($exp[2]) && !is_numeric($exp[2]))
		{	
			if(method_exists($user, $exp[2]))
			{
				$action = $exp[2];
				$user->$action();

				echo $POST;
			}
			else
			{
				$content['message'] = "Такой страницы не существует";
				$user->view('check',$content);
			}
		}
		elseif(!empty($exp[2]) && is_numeric($exp[2]))
		{
			$user->userPage($exp[2]);
		}
		elseif((empty($exp[0]) && $exp[1] == 'user'))
		{			
			if($user->getId())
				header( 'Location: /user/'.$user->getId(), true, 303 );
			else
				$user->index();
		}
		elseif(empty($exp[0]) && empty($exp[1]))
		{
			header( 'Location: /user', true, 303 );

			//$content['title'] = "Добро пожаловать";
			//$content['message'] = "<a href='user'>Войти</a> или <a href='user/add'>Зарегистрироваться</a>";
			$user->view('check',$content);
		}
		else
		{
			$content['message'] = "Такой страницы не существует";
			$user->view('check',$content);
		}
	}

	//Формирование контента страницы
	protected function view($tpl, $vars = array())
	{
		$page = array();

		if(!empty($vars))
		{
			foreach ($vars as $key => $value) 
			{
				if($key == 'title') {$page['title'] = $value;}
				if($key == 'page_title') {$page['page_title'] = $value;}
				if($key == 'CHOOSELANGUAGE') {$page['CHOOSELANGUAGE'] = $value;}						
				else {$$key = $value;}				
			}

			if(empty($page['page_title'])) {$page['page_title'] = $page['title']; }	
		}

		ob_start();
		require_once(TPL_PATH.$tpl.TPL_EXT);
		$page['content'] = ob_get_clean();

		
		$this->template($page);
	}

	//Общий шаблон страницы
	protected function template($page = array())
	{

		ob_start();
		require_once(TPL_PATH."page".TPL_EXT);
		echo ob_get_clean();
	}

	// Функция для генерации случайной строки
	protected function generateCode($length=6) 
	{
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
	    $code = "";
	    $clen = strlen($chars) - 1;
	    while (strlen($code) < $length) 
	    {
	            $code .= $chars[mt_rand(0,$clen)];
	    }

	    return $code;
	}

	//Удаление GET параметров с адресной строки
	private function unsetGet(&$exp)
	{
		$expCount = count($exp);
		for ($i=0; $i < $expCount; $i++) { 
			$var = preg_replace("/\?(.*)/", "", $exp[$i]);
			$exp[$i] = $var;
		}
		
	}

		//Тест массива
	public function localization($get_lang = array())
	{
		foreach ($get_lang as $key => $value) {
			$lang[$key] = $value;
		}

		return $lang;
	}


}
