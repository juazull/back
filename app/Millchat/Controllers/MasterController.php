<?php
namespace Millchat\Controllers;

use Millchat\Auth\AuthToken;
use Millchat\Core\View;

/**
 * Class BaseController
 *
 * @package DaVinci\Controllers
 *
 *          Clase base para todos los controladores con métodos y funcionalidades útiles.
 */
class MasterController
{

    public function requireAuth()
    {
        // Requerimos que el usuario esté autenticado.
        $auth = new AuthToken();
        if (!$auth->estaAutenticado()) {
            View::renderJson([
                'status' => false,
                'error' => 'Tenés que iniciar sesión para poder acceder a esta pantalla.'
            ]);
            exit();
        }
    }
}
