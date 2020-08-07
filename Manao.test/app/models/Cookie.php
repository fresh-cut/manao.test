<?php

class Cookie
{
   
    const COOKIE_TIME = 60 * 60 * 24; //срок жизни куки

    /**
     * Создаём куки
     * @param  $db QueryBuilder
     * @param  $login - логин пользователя
     * @param  $id - id пользователя
     * @return nothing
     */
    public static function set($db, $login, $id)
    {
       $key = uniqid();
        $db->addKey('cookie_key', $id, $key); // добавляем куки в базу
        setcookie("login", $login, time() + self::COOKIE_TIME, '/');
        setcookie("cookie_key", $key, time() + self::COOKIE_TIME, '/');
        //header("Refresh:0");
    }

    /**
     * Удаляем куки
     * @return nothing
     */
    public static function delete()
    {
        setcookie("login", '', time(), '/');
        setcookie("cookie_key", '', time(), '/');
    }
}