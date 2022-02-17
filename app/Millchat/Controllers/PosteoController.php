<?php
namespace Millchat\Controllers;

use Millchat\Auth\Auth;
use Millchat\Core\View;
use Millchat\Models\Posteos;
use Millchat\Validation\Validator;

/**
 *
 * @author Juan Manuel Zullo
 *
 */
class PosteoController extends MasterController
{

    /**
     * Llama a la clase abstracta vue y convierte el posteo en un Json
     */
    public function listar()
    {
        $posteos = (new Posteos())->traer_todos();
        View::renderJson([
            'data' => $posteos
        ]);
    }

    /**
     * Permite ver el posteo del usurario y retorna el objeto
     * Devuelve el Json con loss datos.
     * Llama a la clase abstracta vue y convierte el posteo en un Json.
     */
    public function mostrar()
    {
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $posteo = (new Posteos())->getById($data['id_posteo']);

        if (is_null($posteo) or empty($posteo)) {
            View::renderJson([
                'error' => 'No se encontro el posteo'
            ]);
        } else {
            View::renderJson([
                'data' => $posteo
            ]);
        }
    }

    public function posteosUsuario()
    {
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $p = new Posteos();
        $posteos = $p->traer_todos_usuario($data['id_usuario_posteo']);

        if (empty($posteos)) {
            View::renderJson([
                'error' => 'No se encontro posteo'
            ]);
        } else {
            View::renderJson([
                'data' => $posteos
            ]);
        }
    }

    /**
     * Verifico la autorizacion
     * Recupero la informacion del Json enviado.
     * Recupero el valor de la url del parametro id y se lo asigno al dato id_usuario_posteo.
     * Asigno la variable fecha con la fecha de hoy, luego compruebo la validez de los datos que son textos y id_usuario_posteo.
     * Creo un nuevo texto_posteo y llamo a la funcion insertarPosteo pasandole el $data como parametro.
     * Perimete realizar nuevo posteos
     */
    public function nuevoPosteo()
    {
        
        $this->requireAuth();
        
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $data['fecha'] = date("Y-m-d H:i:s");
        // $data['fecha'] = getdate();
        $data['contador_likes'] = 0;

        $validation = new Validator($data, [
            'texto_posteo' => [
                'required',
                'min:15'
            ],
            'id_usuario_posteo' => [
                'required'
            ]
        ]);
        $posteo = new Posteos();

        if (! $validation->passes()) {
            View::renderJson([
                'error' => 'error no se pudieron validar los datos',
                'descripcion' => $validation->getErrores()
            ]);
            return false;
        }

        if ($posteo->insertPosteo($data)) {
            View::renderJson([
                'success' => 'alta del posteo'
            ]);
            return true;
        } else {
            View::renderJson([
                'error' => 'no se pudo de dar de alta'
            ]);
            return false;
        }
    }

    /**
     * Verifico la autorizacion
     * Recupero la informacion del Json enviado.
     * Recupero el valor de la url del parametro id y se lo asigno al dato id_usuario_posteo.
     * Asigno la variable fecha con la fecha de hoy, luego compruebo la validez de los datos que son textos y id_usuario_posteo.
     * Creo un nuevo texto_posteo y llamo a la funcion insertarPosteo pasandole el $data como parametro.
     * Perimete editar los posteos
     */
    public function editarPosteo()
    {
        $this->requireAuth();
        $auth = new Auth(); // $auth = new Token();
        $usuario = $auth->getUsuarios();
        $Json = file_get_contents('php:://input');
        $data = Jsondecode($Json, TRUE);
        $data['id_usuario_posteo'] = $usuario->getid();
        $data['fecha'] = date("Y-m-d");
        $validation = new Validator($data, [
            'texto_posteo' => [
                'required',
                'min:15'
            ],
            'id_usuario_posteo' => [
                'required'
            ]
        ]);

        if (! $validation->passes()) {
            View::renderJson([
                'error' => 'error no se pudieron validar los datos'
            ]);
            return false;
        }

        $posteo = new Posteos();

        if ($posteo->editarPosteo($data)) {
            View::renderJson([
                'data' => 'se edito el posteo exitosamente'
            ]);
            return true;
        } else {
            View::renderJson([
                'error' => 'no se pudo editar el posteo'
            ]);
            return false;
        }
    }

    /**
     * Verifico la autorizacion
     * Recuperando el id de la url
     * Recupero la informacion del Json enviado.
     * Llama a la funcion borrar_posteo.
     * Muestra un mensaje dependiendo del resultado de la funcion.
     */
    public function borrarPosteo()
    {
        $this->requireAuth();

        $id = urlParam('id');
        $posteo = new Posteos();
        if (! $posteo->borrar_posteo($id)) {
            View::renderJson([
                'error' => 'Nose pudo borrar el posteo'
            ]);
        } else {
            View::renderJson([
                'data' => 'se elimino el posteo exitosamente'
            ]);
        }
    }
}

