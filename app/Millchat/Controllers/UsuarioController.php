<?php
namespace Millchat\Controllers;

/**
 *
 * @author Juan Manuel Zullo
 *
 */
use Millchat\Core\Route;
use Millchat\Core\View;
use Millchat\Models\Usuarios;
use Millchat\Validation\Validator;

class UsuarioController extends MasterController
{

    /**
     * Recupera el id de la url.
     * Busca los datos con la funcion getUsuarioById.
     * Devuelve el Json con loss datos.
     */
    public function verUsuarios()
    {
        $id = Route::getUrlParameters()['id'];
        $usuario = (new Usuarios());
        if ($usuario->getUsuarioById($id)) {
            View::renderJson('Usuario/ver', compact('usuario'));
        } else {
            View::renderJson([
                'error' => 'no se encontro el usuario'
            ]);
        }
    }

    public function recuperarPaises()
    {
        $usr = new Usuarios();

        View::renderJson([
            'data' => $usr->recuperarPaises()
        ]);
    }

    /**
     * Recupero la informacion del Json enviado.
     * Recupero el valor de la url del parametro id y se lo asigno al dato id_usuario_posteo.
     * Compruebo la validez de los datos que son nombre_usuario,email y password_usuario.
     * Creo un nuevo texto_posteo y llamo a la funcion insertarPosteo pasandole el $data como parametro.
     * Perimete registrar a los nuevos usuarios.
     */
    public function registrarUsuarios()
    {
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $usr = explode("@", $data['email_usuario']);
        $data['nombre_usuario'] = $usr[0];

        //print_r($data);

        $validation = new Validator($data, [

            'email_usuario' => [
                'required'
            ],
            'password_usuario' => [
                'required'

            ]
        ]);

        if (! $validation->passes()) {
            View::renderJson([
                'error' => 'error no se pudieron validar los datos'
            ]);

            return false;
        }

        $usuario = new Usuarios();
        $usuario->setnombre_usuario($data['nombre_usuario']);
        $usuario->setemail($data['email_usuario']);
        $usuario->setpassword_usuario(password_hash($data['password_usuario'], PASSWORD_DEFAULT));

        if ($usuario->insertUsuarios()) {
            View::renderJson([
                'data' => 'alta de usuario'
            ]);
            return true;
        } else {
            View::renderJson([
                'error' => 'no se pudo de dar de alta'
            ]);
            return false;
        }
    }
}

