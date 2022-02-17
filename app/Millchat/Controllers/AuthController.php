<?php
namespace Millchat\Controllers;

use Millchat\Auth\AuthToken;
use Millchat\Auth\Auth;
use Millchat\Core\App;
use Millchat\Core\View;
use Millchat\Validation\Validator;

class AuthController
{

    public function loginForm()
    {
        if (isset($_SESSION['old_data'])) {
            $oldData = $_SESSION['old_data'];
            unset($_SESSION['old_data']);
        } else {
            $oldData = [];
        }
        if (isset($_SESSION['errores'])) {
            $errores = $_SESSION['errores'];
            unset($_SESSION['errores']);
        } else {
            $errores = [];
        }
        if (isset($_SESSION['status_error'])) {
            $statusError = $_SESSION['status_error'];
            unset($_SESSION['status_error']);
        } else {
            $statusError = null;
        }
        View::render('auth/login', [
            'oldData' => $oldData,
            'errores' => $errores,
            'statusError' => $statusError
        ]);
    }

    public function loginProcesar()
    {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $validator = new Validator($postData, [
            'email' => [
                'required'
            ],
            'password' => [
                'required'
            ]
        ]);

        if (! $validator->passes()) {
            $_SESSION['errores'] = $validator->getErrores();
            $_SESSION['old_data'] = $postData;
            // App::redirect('iniciar-sesion');
            View::renderJson([
                'error' => 'Session sin iniciar. No paso la validacion.'
            ]);
        }

        $email = $postData['email'];
        $password = $postData['password'];

        $auth = new Auth();

        if (! $auth->login($email, $password)) {

            $_SESSION['status_error'] = 'Las credenciales ingresadas no coinciden con nuestros registros.';
            $_SESSION['old_data'] = $postData;

            View::renderJson([
                'error' => 'Session sin iniciar',
                'error_descripcion' => 'Las credenciales ingresadas no coinciden con nuestros registros.'
            ]);
        }

        $_SESSION['status_success'] = '¡Bienvenido/a al sitio!';

        View::renderJson([
            'success' => true,
            'data' => [
                'usuario' => [
                    'id' => $usuario->getid(),
                    'usuario' => $usuario->getnombre_Usuarios(),
                    'email' => $usuario->getemail()
                ]
            ]
        ]);
        
//         View::renderJson([
//             'success' => 'Session iniciada',
//             'id' => $_SESSION['id'],
//             'usuario' => $_SESSION['usuario']
//         ]);
    }

    /**
     * Se encarga de tratar de logear al usuario pre-validando la información
     * otorgada por el mismo y retornando resultados/errores en formato JSON.
     *
     * @return object
     */
    public function login()
    {
        // Obtenemos la informaciónj provista por el usuario
        $jsonData = file_get_contents('php://input');
        $postData = json_decode($jsonData, true);

        // Invocamos al authToken y tratamos de logear al usuario
        $auth = new AuthToken();
        if (! $auth->login($postData['email'], $postData['password'])) {
            View::renderJson([
                'success' => false,
                'error' => 'Las credenciales ingresadas no coinciden con nuestros registros.'
            ]);
            exit();
        }
        // Retornamos el resultado junto con la información pública del usuario.
        $usuario = $auth->getUsuario();
//         print_r($usuario);
        
        View::renderJson([
            'success' => true,
            'data' => [
                'usuario' => [
                    'id' => $usuario->getid(),
                    'usuario' => $usuario->getnombre_Usuarios(),
                    'email' => $usuario->getemail()
                ]
            ]
        ]);
    }

    public function logout()
    {
        // $auth = new Auth;
        // $auth->logout();
        (new Auth())->logout();
        $_SESSION['status_success'] = 'Cerraste sesión con éxito. ¡Te esperamos pronto!';
        App::redirect('iniciar-sesion');
    }
}
