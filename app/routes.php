<?php
use Millchat\Core\Route;
// // FIXME Esto no deberia estar pero tengo un problema con las direcciones de use
// require_once (__DIR__ . "/Millchat/Core/Route.php");
    
Route::add('GET', '/', 'HomeController@index');

Route::add('GET', '/perfil/{id}', 'UsuarioController@verUsuario');

Route::add('GET', '/iniciar-sesion', 'AuthController@loginForm');
// Route::add('POST', '/iniciar-sesion', 'AuthController@loginProcesar');
Route::add('POST', '/iniciar-sesion', 'AuthController@login');
Route::add('POST', '/cerrar-sesion', 'AuthController@logout');

Route::add('POST', '/traerPerfil', 'PerfilesController@verPerfilJson');
Route::add('POST', '/posteosUsuario', 'PosteoController@posteosUsuario');
Route::add('POST', '/recuPaises', 'UsuarioController@recuperarPaises');

Route::add('POST', '/crearComentario', 'ComentariosController@nuevoComentario');
Route::add('POST', '/traerComentarios', 'ComentariosController@verComentariosPosteo');
Route::add('POST', '/crearpublicacion', 'PosteoController@nuevoPosteo');
Route::add('POST', '/listarPosteos', 'PosteoController@listar');
Route::add('POST', '/traerPosteo', 'PosteoController@mostrar');
Route::add('POST', '/crearUsuario', 'UsuarioController@registrarUsuarios');
Route::add('POST', '/editarperfil', 'PerfilesController@editarPerfil');

