<?php
session_start();
require_once('./config.php');

//Подключение языкового файла
if(isset($_GET['language'])) 
{
	$lang = $_GET['language'];
	$_SESSION['lang'] = $lang;
}

if(isset($_SESSION['lang'])) 
{
	$lang_file = LANG_PATH.$_SESSION['lang'].LANG_EXT;
	if(file_exists($lang_file))
			require_once($lang_file);
	else
			require_once(LANG_PATH.'ru'.LANG_EXT);
}
else
{
	require_once(LANG_PATH.'ru'.LANG_EXT);
}



require_once('classes/Base.class.php');



	$rout = $_SERVER[REQUEST_URI];
	$exp = explode('/',$rout);


	Base::__myAutoload($exp, $lang);
