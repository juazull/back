<?php
switch ($_REQUEST['evento']) {
    case "iniciar-sesion":
        ;
        break;
    case "info":
        require_once '../../public/info.php';
        break;
    default:
        ;
        break;
}