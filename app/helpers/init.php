<?php
// # CORS
// Vamos a configurar para que nuestro backend (esta API) acepte peticiones de dominios diferentes
// al propio (ej: nuestra app de Vue).
// CORS se configura a través de unos headers de HTTP. En particular, los que empiezan con
// "Access-Control".
// Para empezar, va a haber 2 headers por lo menos que queremos configurar.
// 1. Access-Control-Allow-Origin
//      Este header define una lista de los dominios a los que permitimos que nos hagan peticiones.
//      Opcionalmente pueden poner "*" para permitir cualquier dominio (nota: dependiendo de otros
//      factores esto puede no permitirse).
//      Si estamos pidiendo en la petición del front (ej: via fetch) el uso de credenciales, entonces
//      tenemos que indicar los dominios desde los cuales se puede acceder.
header("Access-Control-Allow-Origin: http://localhost:8080");
// 2. Access-Control-Allow-Methods
//      Este header define una lista con los métodos de HTTP que permitimos que tengan las peticiones.
//      En una API REST, generalmente hay 6 que vamos a necesitar habilitar.
//      Esos 6 son los 5 de REST, y OPTIONS, que es necesario para ciertas funciones de CORS.
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
// 3. Access-Control-Allow-Headers
header("Access-Control-Allow-Headers: Content-Type");
// 4. Access-Control-Allow-Credentials
//      Indica si permitimos que las peticiones usen "credenciales" (permitan el uso de cookies).
header("Access-Control-Allow-Credentials: true");


// Para asegurarnos de que cualquier sistema que reciba la respuesta sepa que es un JSON, vamos a
// agregar el header correspondiente.
header("Content-Type: application/json");

// Antes de hacer nada, preguntamos si el usuario está autenticado para poder interactuar con este
// recurso.
//if(!isset($_SESSION['id'])) {
//    echo json_encode([
//        // Retornamos algún código arbitrario para que el front pueda consultar y detectar el error
//        // ocurrido.
//        'status' => -1,
//        'msg' => 'Se requiere haber iniciado sesión para realizar esta operación.'
//    ]);
//    exit;
//}

// $db = mysqli_connect('localhost', 'root', '', 'cwm');
$db = mysqli_connect('localhost', 'root', '', 'Millchat');

mysqli_set_charset($db, 'utf8mb4');
// TODO: Verificar que me haya conectado.
