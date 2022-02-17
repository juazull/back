<?php
namespace Millchat\Controllers;

use Millchat\Core\Route;
use Millchat\Core\View;
use Millchat\Models\Comentarios;
use Millchat\Validation\Validator;

/**
 *
 * @author Juan Manuel Zullo
 *
 */
class ComentariosController extends MasterController
{

    /**
     * Va a buscar el id de la url y a devolverte el comentario asociado del id.
     * Llama a la clase abstracta vue y convierte el comentario en un Json.
     */
    public function verComentario()
    {
        $id = Route::getUrlParameters()['id'];
        $comentario = (new Comentarios())->getByComentario($id);
        View::renderJson([
            'data' => $comentario
        ]);
    }

    public function verComentariosPosteo()
    {
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $comentarios = (new Comentarios())->listarComentarioPosteo($data['id_posteo']);
        View::renderJson([
            'data' => $comentarios
        ]);
    }

    /**
     * Verifico la autorizacion.
     * Recupero la informacion del Json enviado.
     * Recupero el valor de la url del parametro id y se lo asigno al dato id_posteo.
     * Asigno la variable fecha con la fecha de hoy, luego compruebo la validez de los datos que son comentario y id_posteo.
     * Creo un nuevo comentario y llamo a la funcion insertar comentario pasandole el $data como parametro.
     */
    public function nuevoComentario()
    {
        $this->requireAuth();
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $data['fecha'] = date("Y-m-d H:i:s");

        $validation = new Validator($data, [
            'comentario' => [
                'required',
                'min:5'
            ],
            'id_posteo' => [
                'required'
            ]
        ]);

        if (! $validation->passes()) {

            View::renderJson([
                'error' => 'No se pudo crear el comentario. no paso la validacion'
            ]);
            exit();
        }

        $comentario = new Comentarios();
        if ($comentario->insertComentario($data)) {
            View::renderJson([
                'success' => 'se realizo el comentario exitosamente'
            ]);
            return true;
        } else {
            View::renderJson([
                'error' => 'no se pudo realizar el comentario'
            ]);
            return false;
        }
    }

    /**
     * Verifico la autorizacion.
     * Recuperando el id de la url.
     * Llama a la funcion borrar_comentario.
     * Muestra un mensaje dependiendo del resultado de la funcion.
     */
    public function borrarComentario()
    {
        $this->requireAuth();

        $id = Route::getUrlParameters()['id'];
        if (Comentarios::borrar_comentario($id)) {

            View::renderJson([
                'data' => 'Este comentario fue eliminado'
            ]);
        } else {
            View::renderJson([
                'error' => 'No se pudo eliminar el comentario'
            ]);
        }
    }
}
