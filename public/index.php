<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Core\Router;
use App\Controllers\RegistroController;

$router = new Router();

// Rutas de la aplicación
$router->addRoute('GET', '/', 'RegistroController@index');
$router->addRoute('POST', '/store', 'RegistroController@store');
$router->addRoute('PUT', '/update', 'RegistroController@update');
$router->addRoute('DELETE', '/delete/([0-9]+)', 'RegistroController@delete');

$router->handleRequest();