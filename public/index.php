<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Core\Router;
use App\Controllers\RegistroController;

$router = new Router();

// Rutas de la aplicación
$router->addRoute('GET', '/', 'RegistroController@index');
$router->addRoute('GET', '/registros', 'RegistroController@index');
$router->addRoute('POST', '/registros/store', 'RegistroController@store');
$router->addRoute('DELETE', '/registros/delete/([0-9]+)', 'RegistroController@delete');

$router->handleRequest();