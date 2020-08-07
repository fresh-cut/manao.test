<?php

class IndexController
{

    /**
     * Проверяем есть ли сессия(авторизован ли пользователь)
     * @return bool
     */
    public static function isSession()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'])
        {
            $db= new QueryBuilder('users');
            $session_key=$db->getDataByAnything(['login'=>$_SESSION['login']], ['session_key']);
            if($session_key && $session_key['session_key']===$_SESSION['session_key']) // если получен сессионый ключ пользователя и он сущетсвует, а так же если ключ пользователя и ключ сессии совпадают, то сессия есть
                    return true;
        }
        return false;
    }

    /**
     * Проверяем кто зашел: гость или авторизованый пользователь
     * @return bool
     */
    public static function isGuest()
    {
        
        if (self::isSession()) //если сессия есть->значит не гость
        	return false;
        if (isset($_COOKIE['login']) && $_COOKIE['login'] != '') // если есть куки логина->проверим на совпадение ключа куки
        {
            $db= new QueryBuilder('users');
            $user=$db->getData(['login'=>$_COOKIE['login']]);
			if($user && $user['cookie_key']===$_COOKIE['cookie_key']) // если такой пользователь существует и его кука совпадает->создадим сессию->иначе гость
			{
                Session::set($db, $user['login'],$user['user_name'], $user['id']); //добавим данные в сессию
				return false;
			}
       }
    return true;
   }
}