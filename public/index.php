<?php

session_start();
// Antes que nada, requerimos el autoload.
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../app/helpers/routes.php';
require_once __DIR__ . '/../app/Millchat/Core/App.php';
require_once __DIR__ . '/../app/helpers/init.php';

// Guardamos la ruta absoluta de base del proyecto.
$rootPath = realpath(__DIR__ . '/../');

// Normalizamos las \ a /
$rootPath = str_replace('\\', '/', $rootPath);

// Requerimos las rutas de la aplicación. 
require $rootPath . '/app/routes.php';

// Instanciamos nuestra App.
$app = new \millchat\Core\App($rootPath);

// Arrancamos la App.
$app->run();

