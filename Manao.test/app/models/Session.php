<?php

/**
 * Класс который устанавливает и удаляет данные в переменные сессии
 */
class Session
{
    /**
     * Создаём сессию
     * @param QueryBuilder $db  
     * @param $login string - логин пользователя
     * @param $user_name string - имя польователя
     * @param $id integer - ид пользователя
     * @return nothing
     */
    public static function set($db, $login,$user_name, $id)
    {
        
        $key = uniqid();
        $db->addKey('session_key', $id, $key); 

        //Пишем в сессию информацию о том, что мы авторизовались:
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $login;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['session_key'] = $key;
    }

    /**
     * Удаляем данные из сессии
     * @return nothing
     */
    public static function delete()
    {
        // сломать сессию и куки
        unset($_SESSION['auth']);
        unset($_SESSION['login']);
        unset($_SESSION['name']);
        unset($_SESSION['sessionKey']);
        session_destroy();
    }

}