<?php 
class FormController
{
    private $db;
    private $user_name;
    private $login;
    private $password;
    private $emal;
    private $sault;
    private $error_fields=[];
    public function __construct($db)
    {
        $this->db=$db;
    }

    /**
     * Метод проверки пустое ли поле
     * @return bool 
     */
    public function emptyField($data)
    {
        foreach($data as $key=>$value)
        {
            if($value==='')
                $this->error_fields['empty_field'][]=$key;
        }
        return (empty($this->error_fields))?false:true;
    }

    /**
     * Проверяем сущеcтвует ли поле с таким значением
     * @param  $field string - поле для поиска
     * @return bool
     */
    public function fieldExists($field)
    {
        if($this->db->find($field,htmlspecialchars(strip_tags(trim($_POST[$field])))))
            return true;
        return false;
    }

    /**
     * Проверка данных на валидность, поступивших из формы регистрации пользователя
     * @return bool
     */
    public function checkForm()
    {
        if(!$this->emptyField($_POST))// если нету пустых строк
        {
            if($this->fieldExists('email')) //если такой email существует добавляем ошибку
               $this->error_fields['dublicate'][]='email';
            if($this->fieldExists('login')) //если такой login существует добавляем ошибку
               $this->error_fields['dublicate'][]='login';
            if($_POST['password']!=$_POST['confirm']) //если пароли не совпадают добавляем ошибку
                $this->error_fields['password_fail'][]=true;
        }
        if(!empty($this->error_fields)) //если были ошибки то записываем их в файл с ошибками и выводим пользователю на экран
        {
            $errorsList =['status'=>false,
    			'errors_message'=>['field_error'=>'Все поля должны быть заполнены!',
    								'password_error'=>'Пароли не совпадают!',
    								'dublicate_error'=>['login'=>'Такой логин уже существует!',
    													'email'=>'Такой e-mail уже существует!']],
    			'errors'=>$this->error_fields];
            echo json_encode($errorsList);  // Переводим массив в JSON
            return false;
        }
        return true;
    }

    /**
     * Добавление пользователя в бд
     * @return json
     */
    public function createUser()
    {
        $this->sault=uniqid();
        $this->password=md5(htmlspecialchars(strip_tags($_POST['password'])).$this->sault);
        $this->login=htmlspecialchars(strip_tags(trim($_POST['login'])));
        $this->email=htmlspecialchars(strip_tags(trim($_POST['email'])));
        $this->user_name=htmlspecialchars(strip_tags(trim($_POST['user_name'])));
        $new_user=['login'=>$this->login,
					'password'=>$this->password,
					'email'=>$this->email,
					'user_name'=>$this->user_name,
					'sault'=>$this->sault,
					'cookie_key'=>'',
					'session_key'=>''
				];
	    if($this->db->add($new_user))
	    	echo json_encode(['status'=>true]);
		else 
			echo json_encode(['status'=>false, 'errors_message'=>'не удалось подключиться к базе данных']);
	}

    /**
     * Проверка данных на валидность, поступивших из формы авторизации 
     * @return bool
     */
    public function checkLogin()
    {
        if(!$this->emptyField($_POST))// если нету пустых строк
        {
            if($this->fieldExists('login'))  //если такой пользователь существует?
            {
                $this->login=htmlspecialchars(strip_tags(trim($_POST['login'])));
                $this->password=htmlspecialchars(strip_tags($_POST['password']));
                $userData=$this->db->getData(['login'=>$this->login]);  // взять все данные(в какой таблице, по какому полю ищем(только уникальные поля-login, email)
                $this->user_name=$userData['user_name'];
                $this->email=$userData['email'];
                $this->id=$userData['id'];
                if(md5($this->password.$userData['sault'])!=$userData['password'])
                    $this->error_fields['notMatchPassword']=true;
            }
            else
                $this->error_fields['noMatchUser']=true;
        }
        if(!empty($this->error_fields)) //если были ошибки то записываем их в файл с ошибками и выводим пользователю на экран
        {
            $errorsList =['status'=>false,
	    			'errors_message'=>['field_error'=>'Все поля должны быть заполнены!',
	    							'login_error'=>'Неверный логин или пароль'],
	    			'errors'=>$this->error_fields];
	    	
            echo json_encode($errorsList); // Переводим массив в JSON
            return false;
        }
        return true;
    }

    /**
     * Вход на сайт - создание всех зависимостей куки сессий и бд
     * @return bool
     */
    public function login()
    {
        if ($_POST['check']==='true') // если чекбокс есть, то создаём куки, если нет то только сессию    
        {   	
            Cookie::set($this->db, $this->login, $this->id);
        }
        Session::set($this->db, $this->login, $this->user_name, $this->id); // создаем сессию, заносим ключ в базу
        echo json_encode(['status'=>true]); // успешная авторизация
    }

    /**
     * Выход из профиля, удаление всех зависимостей
     */
    public function logout()
    {
    	Cookie:: delete();
    	Session::delete();
    	header("Location:/");
    }
}