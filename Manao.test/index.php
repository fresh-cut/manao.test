<?php
session_start();
require_once 'app/models/QueryBuilder.php';
require_once 'app/controllers/FormController.php';
require_once 'app/controllers/IndexController.php';
require_once 'app/controllers/RouteController.php';
require_once 'app/models/Cookie.php';
require_once 'app/models/Session.php';

$url=$_SERVER['REQUEST_URI'];
$route=new RouteController($url);
$route->goToUrl();
