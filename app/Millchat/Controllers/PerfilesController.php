<?php
namespace Millchat\Controllers;

use Exception;
use Millchat\Core\Route;
use Millchat\Core\View;
use Millchat\Models\Perfiles;
use Millchat\Models\Usuarios;
use Millchat\Validation\Validator;

class PerfilesController extends MasterController
{

    /**
     * Recupera el id de la url.
     * Busca los datos con la funcion getUsuarioById.
     * Devuelve el Json con esos datos
     */
    public function verUsuarios()
    {
        $id = Route::getUrlParameters()['id'];
        $usuario = (new Usuarios())->getUsuarioById($id);

        View::renderJson([
            'data' => $usuario
        ]);
    }

    /**
     * Permite ver el perfil del usurario y retorna el objeto.
     */
    public function verPerfilId($id_usuario)
    {
        $perfil = (new Perfiles())->getByUsuario($id_usuario);
        View::renderJson([
            'data' => $perfil
        ]);
    }

    /**
     * Permite ver el perfil del usurario y retorna el objeto.
     */
    public function verPerfilJson()
    {
        try {
            $Json = file_get_contents('php://input');
            $data = json_decode($Json, true);

            $p = new Perfiles();
            $perfil = $p->getByUsuario($data['id_usuario']);

            $paises = $p->paisPersona($perfil->getpais_Usuarios());

            View::renderJson([
                'data' => $perfil,
                'pais' => $paises
            ]);
        } catch (Exception $e) {
            View::renderJson([
                $e
            ]);
        }
    }

    /**
     * Permite ver el perfil del usurario y retorna el objeto.
     */
    public function verPerfil()
    {
        $id = Route::getUrlParameters()['id'];
        $perfil = (new Perfiles())->getByUsuario($id);
        View::renderJson([
            'data' => $perfil
        ]);
    }

    /**
     * Verifico la autorizacion
     * Recupero la informacion del Json enviado
     * Convierte los datos en Json.
     * Recupera los datos del usuario actual.
     * Valida el id, nombre_usuario, apellido_usuario, pais_usuario, edad_usuario.
     * Crea un nuevo objeto perfil
     */
    public function editarPerfil()
    {
        $this->requireAuth();
        $Json = file_get_contents('php://input');
        $data = json_decode($Json, true);

        $validation = new Validator($data, [
            'id_usuario' => [
                'required',
                'numeric'
            ],
            'nombre_usuario' => [
                'required'
            ],
            'apellido_usuario' => [
                'required'
            ],
            'pais_usuario' => [
                'required',
                'numeric'
            ],
            'edad_usuario' => [
                'required',
                'numeric'
            ]
        ]);

        if (! $validation->passes()) {

            View::renderJson([
                'error' => 'No se pudo editar el perfil'
            ]);
            exit();
        }

        $perfil = new Perfiles();

        if ($perfil->editarPerfilDatos($data)) {
            View::renderJson([
                'data' => 'se edito exitosamente el perfil'
            ]);
            return true;
        } else {
            View::renderJson([
                'error' => 'no se pudo editar el perfil'
            ]);
            return false;
        }
    }
}
