<?php

class User extends Base {

	private $table = "users";
	private $no_avatar = "no-avatar.jpg";
	//protected $userHash;

	function __construct() 
	{
		//$this->userHash = $_COOKIE['user_hash'];
	}

	public function add()
	{
		$content = $this->localization($this->lang);
		$content['title'] = $this->lang['REGISTRATION'];
		$this->view('reg',$content);
	}

	//Авторизация
	//$this->lang['AUTHORIZATION'];
	public function login()
	{
		if(isset($_POST['login'])) {$login = $_POST['login'];}
		if(isset($_POST['password'])) {$password = $_POST['password'];}
		if(isset($_POST['remember'])) {$remember = $_POST['remember'];}		
		
		//Удаление пробелов
		$login = trim($login); 
		$password = trim($password);

		//Проверка введенных данных
		if(empty($login))
		{
			$content['message'] = "Поле <b>Логин</b> обязательно для заполнения.";
			$content['class'] = "error";
		}
		elseif(empty($password))
		{
			$content['message'] = "Поле <b>Пароль</b> обязательно для заполнения.";
			$content['class'] = "error";
		}
		else
		{
			//Получаем пароль из базы
			$db = new SafeMySQL();
			$password_tab = $db->getOne('SELECT password FROM ?n WHERE login = ?s', $this->table,$login);
			//Шифруем введенный пароль
			$password = md5(md5($password));

			if((empty($password_tab)) || ($password_tab != $password))
			{
				$content['message'] = "<b>Логин</b> или <b>Пароль</b> указаны неверно.";
				$content['message_redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
				$content['class'] = "error";
			}
			else
			{
				$userId = $db->getOne('SELECT id FROM ?n WHERE login = ?s', $this->table,$login);

				$code = $this->generateCode(10);

				

				//Если отмечено "запомнить меня" то пишем в куки
				//В противном случае открываем сессию
				if($remember == 1)
				{					
					setcookie('user_hash',$code,time()+3600);
				}
				else
				{				
					session_start();
					$_SESSION['user_hash'] = $code;
				}
					$data = array('user_hash' => $code);
					$sql  = "INSERT INTO ?n SET id=?i, ?u ON DUPLICATE KEY UPDATE ?u";
	 				$db->query($sql,$this->table,$userId,$data,$data);				
				
				//header( 'Location: /user/'.$userId, true, 303 );
				
			}
		}

		
		$this->view('check',$content);
	}

	//Страница пользователя
	//Доступна только зарегистрированым
	public function userPage($userId)
	{
		
			if($this->accessControl($userId))
			{
				$db = new SafeMySQL();
				$users = $db->getAll('SELECT id,login,name,avatar FROM ?n WHERE id = ?i LIMIT ?i', $this->table,$userId,1);

				$user = array();

					if(!empty($users[0]['id']))
					{
						foreach ($users[0] as $key => $value) 
						{
							$user[$key] = $value;
						}
					}

				$userName = (empty($user['name'])) ? $user['login'] : $user['name'];
				$user['page_title'] = "Здравствуйте, ".$userName;
				$user['title'] = $userName;  
				$user['avatar'] = (empty($user['avatar'])) ? $this->no_avatar : $user['avatar'];


				$this->view('user',$user);
			}
			else
			{
				$content['title'] = "УПС!";
				$content['message'] = "У вас нет доступа к этой странице. Пожалуйста <a href='/user'>авторизируйтесь</a> чтобы войти!";
				$this->view('check',$content);
			}
	}


	//Регистрация
	//$this->lang['AUTHORIZATION'];
	public function registr()
	{
		if($_POST['login']) {$login = $_POST['login'];}
		if($_POST['name']) {$name = $_POST['name'];}
		if($_POST['password']) {$password = $_POST['password'];}
		if($_POST['password2']) {$password2 = $_POST['password2'];}

		$img = new ImgInspector;

		if(!empty($_FILES['avatar']['name'])) 
		{
			$tmp_name = $_FILES['avatar']['tmp_name'];
			$avatar = $_FILES['avatar']['name'];			
			
		}
		else {$avatar = "";}

		$login = trim($login); 
		$name = trim($name); 
		$password = trim($password);
		$password2 = trim($password2);

		//Проверка введенных данных
		if($this->checkUser($login))
		{
			$content['message'] = "Пользователь с таким именем уже существует.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "logintake";
		}		
		elseif(!preg_match("/^[a-zA-Z0-9_]{4,16}$/", $login))
		{
			$content['message'] = "Поле <b>Логин</b> должно состоять только из букв латинского алфавита, цифр, нижнего подчеркивания, быть не короче 4 и не длиннее 16 символов.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "login";
		}
		elseif(empty($login))
		{
			$content['message'] = "Поле <b>Логин</b> обязательно для заполнения.";			
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "login";
		}
		elseif(empty($name))
		{
			$content['message'] = "Поле <b>Имя</b> обязательно для заполнения.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "name";
		}
		elseif(!preg_match("/^[A-Za-zА-Яа-я]+/", $name))
		{
			$content['message'] = "Поле <b>Имя</b> должно состоять только из латинских букв и кирилицы, быть не короче 5 и не длиннее 50 символов <br> <em>Например: Иван Васильевич</em>.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "name";
		}
		elseif(empty($password))
		{
			$content['message'] = "Поле <b>Пароль</b> обязательно для заполнения.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "password";
		}
		elseif(empty($password2))
		{
			$content['message'] = "Пожалуйста введите <b>Пароль</b> дважды.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "password2";
		}
		elseif($password != $password2)
		{
			$content['message'] = "<b>Пароли</b> не совпадают.";
			$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
			$content['class'] = "password2";
		}
		elseif ($img->check_ext($avatar)) 
		{
				$content['message'] = "Неверный формат файла. Доступные форматы: *.jpg, *.png   ";
				$content['redirect'] = "Пожалуйста, вернитесь <a href='javascript:history.back(1)'>назад</a> и повторите попытку.";
				$content['class'] = "error-ext";
		}
		else
		{
			if(!empty($avatar))
			{				
				$img->move_to_tmp($tmp_name,$avatar,TMP_PATH);
				$img->load(TMP_PATH.$avatar);
				$img->resize(80,80);
				$img->save(IMG_PATH.$avatar);
				$img->delete_to_tmp($avatar,TMP_PATH);
			}


			$password = md5(md5($password));
			$code = $this->generateCode(10);
			setcookie("user_hash",$code,time()+3600);

			$db = new SafeMySQL();
			$data = array('login' => $login, 'name' => $name, 'password' => $password, 'avatar' => $avatar,'user_hash' => $code);
 			$sql  = "INSERT INTO users SET ?u";
 			$db->query($sql,$data);

 			$content['message'] = "Поздравляем, вы успешно зарегистрированы.";
 			$content['redirect'] = "Теперь вы можете <a class='btn btn-success' href='/user'>Bойти в свой кабинет <i class='fa fa-sign-in'></i></a> ";
 			$content['class'] = "final";
		}

		$this->view('check',$content);		

	}


	//Проверка на существование пользователя в базе при регистрации
	private  function checkUser($login)
	{
		$db = new SafeMySQL();
		$user_id = $db->getOne('SELECT id FROM ?n WHERE login = ?s', $this->table,$login);

		if($user_id>0) {return true;}
		else {return false;}		
	}

	//Контроль доступа к странице пользователя
	protected function accessControl($id)
	{	

		if($this->checkCookie() || $this->checkSession())
		{	
			
			$user_hash;
			
			if(isset($_SESSION['user_hash'])) 
			{				
				session_start();
				$user_hash = $_SESSION['user_hash'];
				//echo "сессия - ".$_SESSION['user_hash']."<br>"; 
			}

			

			if(isset($_COOKIE['user_hash']))
			{
				$user_hash = $_COOKIE['user_hash'];
				//echo "куки - ".$_COOKIE['user_hash'];
			}

			

			$db = new SafeMySQL();
			$userId = $db->getOne('SELECT id FROM ?n WHERE user_hash = ?s', $this->table,$user_hash);
			

			if($id == $userId) 
			{
				return true;
				exit;
			}
		}
		return false;
	}

	//Получение ID пользователя
	//Достает из бази по хешу в куках
	protected function getId()
	{
		$userId;
		if($this->checkCookie())
		{
			$db = new SafeMySQL();
			$userId = $db->getOne('SELECT id FROM ?n WHERE user_hash = ?s', $this->table,$_COOKIE['user_hash']);
		}

		if($this->checkSession())
		{
			$db = new SafeMySQL();
			$userId = $db->getOne('SELECT id FROM ?n WHERE user_hash = ?s', $this->table,$_SESSION['user_hash']);
		}

		return $userId;
	}

	//Проверка на существование элемнета $_COOKIE['user_hash']
	//А также не пустой ли он
	//Возвращает true или false
	protected function checkCookie()
	{
		if(isset($_COOKIE['user_hash']) && !empty($_COOKIE['user_hash']))
			return true;
		else
			return false;
	}

	//Проверка на существование элемнета $_SESSION['user_hash']
	//А также не пустой ли он
	//Возвращает true или false
	protected function checkSession()
	{
		if(isset($_SESSION['user_hash']) && !empty($_SESSION['user_hash']))
			return true;
		else
			return false;
	}

	//Выход из аккаунта
	public function logout()
	{
		
		if($this->checkCookie()) {setcookie ("user_hash",'');}
		if($this->checkSession()) {$_SESSION['user_hash'] = "";}		

		$content['title'] = "До свидания!";
		$content['message'] = "Заходите к нам почаще.";
		$content['redirect'] = "<a href='/'><i class='fa fa-chevron-circle-left'></i> Вернуться на главную</a>";
		$this->view('check',$content);

	}

	//Тест массива
	protected function testArray($vars = array())
	{
		echo "<pre>";
		var_dump($vars);
		echo "</pre>";
	}




}