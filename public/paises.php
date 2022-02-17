<?php
use app\millchat\Core\View;

require_once __DIR__ . '/../app/helpers/init.php';


require_once (__DIR__ . "/../app/Millchat/DB/DB.php_bkp");
require_once (__DIR__ . "/../app/Millchat/Core/View.php");

$inputData = file_get_contents('php://input');
$postData = json_decode($inputData, true);

if($postData['accion']==1)
{
    $db = DB::getConnection();
    $query = "SELECT * FROM paises ORDER BY id_pais ASC";
    $statement = $db->prepare($query);
    $statement->execute();
    
    $posteos = array();
    
    while ($fila = $statement->fetch(PDO::FETCH_OBJ)) {
        
        $posteos[] = $fila;
    }
    
    $arr = $statement->errorInfo();
    
    View::renderJson([
        'data' => $posteos
    ]);
}
