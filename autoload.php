<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

// Definimos un autoload.
spl_autoload_register(function ($className) {
    // Cambiamos las \ a /
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    // Le agregamos la extensión de php, y la carpeta de
    // base "app/".
    $filepath = __DIR__ . '/app/' . $className . ".php";
 
    // Verificamos si existe, y en caso positivo,
    // incluimos la clase.
    
//     echo "Intentando cargar $filepath.\n";
    if (file_exists($filepath)) {
//         print_r(" Ok <Br/>");
        require_once $filepath;
        
    } else {
        throw new Exception("Imposible cargar $filepath.");
    }
});