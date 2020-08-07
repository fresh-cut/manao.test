<?php 
class RouteController
{
	private $url;
	private $allowedUrl=['guest'=>['/'=>'index.php',
									'/login'=>'login.php',
									'/register'=>'register.php',
									'/thankyou'=>'registration_success.php'],
						'user'=>['/profile'=>'profile.php']];
	private $systemUrl=['/checklogin','/checkform', '/logout'];
	public function __construct($url)
	{
		$this->url=$url;
	}

	/**
     * Валидация окна авторизации
     */
	public function goToChecklogin()
	{
		$form=new FormController(new QueryBuilder('users'));
		if($form->checkLogin())
 			$form->login();
	}

	/**
     * Обработка нажатия на выход из акаунта
     */
	public function goToLogout()
	{
		$form=new FormController(new QueryBuilder('users'));
		$form->logout();
	}

	/**
     * Валидация окна регистрации
     */
	public function goToCheckform()
	{
		$form=new FormController(new QueryBuilder('users'));
		if($form->checkform())
 			$form->createUser();
	}


	/**
     * Метод проверки кто сейчас пользуется сайтом
     * @return string 
     */
	public function whoUses()
	{
		if(IndexController::isGuest())
			return 'guest';
		return 'user';
	}

	/**
     * Стартовый метод обработки входящих запросов
     */
    public function goToUrl()
    {
    	if(in_array($this->url, $this->systemUrl)) //если это системные ссылки
    	{
    		if($this->url==='/checklogin')
    			$this->goToChecklogin();
    		if($this->url==='/logout')
    			$this->goToLogout();
    		if($this->url==='/checkform')
    			$this->goToCheckform();	
    		return true;
    	}
    	else
    	{    	
    		$uses=$this->whoUses(); // кто использует сайт
    		foreach($this->allowedUrl as $who=>$value)
    		{	
    			foreach($value as $newUrl=>$path)
    			{ 
    				if($newUrl===$this->url && $who===$uses)
    					return require_once 'app/views/'.$path;
    				elseif($newUrl===$this->url && $uses==='user' && $who!==$uses)
    					return header("Location:/profile");
    				elseif($newUrl===$this->url && $uses==='guest' && $who!==$uses)
    					return header("Location:/");
    			}
    		}
    	}
    	return require_once 'app/views/error.php';
    	
    }
}