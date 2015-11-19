<?php

/*
* Общая Конфигурация приложения 
*/

/*
* Настройки подключения к базе MSQL
*/
define('BASEPATH','/test_reg');
define('SITE_ROOT', str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/');

define('CLASS_PATH','classes/'); //Папка с классами
define('TPL_PATH','template/'); //Папка с шаблонами

define('CLASS_EXT','.class.php'); //Расширение файлов классов
define('TPL_EXT','.tpl.php'); //Расширение файлов шаблонов

define('DEFAULT_ACTION','index');

define('TMP_PATH','temp/');
define('IMG_PATH','img/');

define('LANG_PATH','lang/');
define('LANG_EXT','.php');


define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','test_reg');


