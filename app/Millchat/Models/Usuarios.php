<?php
namespace Millchat\Models;

use Millchat\Core\DB;
use Exception;
use JsonSerializable;
use PDO;



/**
 * clase usuarios
 */
class Usuarios implements JsonSerializable
{

    /**
     * Identifica el usuario
     *
     * @var int
     */
    protected $id_usuario;

    /**
     * Nick del usuario
     *
     * @var string
     */
    protected $nombre_usuario;

    /**
     * Email del usuario
     *
     * @var string
     */
    protected $email_usuario;

    /**
     * Contraseña del usuario
     *
     * @var string
     */
    protected $password_usuario;

    /**
     * Esta funcion recive un id usuario y retorna un objeto en la base.
     *
     * @param string $usuario
     * @throw Exception
     * @return Usuarios
     */
    public static function getByUsuario($usuario)
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM usuarios WHERE nombre_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $usuario);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("usuario no encontrado");
        }
        return $statement->fetchObject(self::class);
    }

    /**
     * Retorna el usuario al que pertenece el $email.
     * Si no existe, retorna null.
     *
     * @param string $email
     * @return Usuarios|null
     */
    public function getByEmail(string $email)
    {
        $db = DB::getConnection();

        $query = "SELECT * FROM usuarios
                    WHERE email_usuario = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([
            $email
        ]);

        // Si no podemos obtener la fila, retornamos null.
        if (! $fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $this->id_usuario = $fila['id_usuario'];
        $this->nombre_usuario = $fila['nombre_usuario'];
        $this->password_usuario = $fila['password_usuario'];
        $this->email_usuario = $fila['email_usuario'];

        return $this;
    }

    /**
     * Esta funcion lo que hace busca en la base de datos los datos del usuario que estan definidos en el parametreo
     * nombre_usuario de las sesion
     *
     * @throw Exception
     * @return Usuarios
     *
     */
    public static function getCurrentUser()
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM usuarios WHERE nombre_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $_SESSION['nombre_usuario']);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("usuario no encontrado");
        }
        return $statement->fetchObject(self::class);
    }

    /**
     *
     * @return Mixed[]
     */
    public function jsonSerialize()
    {
        $array = array();
        $array['id_posteo'] = $this->getid();
        $array['nombre_usuario'] = $this->getnombre_Usuarios();
        $array['apellido_usuario'] = $this->getapellido_Usuarios();
        $array['email_usuario'] = $this->getemail_Usuarios();
        $array['password_usuario'] = $this->getpassword_Usuarios();
        return $array;
    }

    /**
     * Inserta un usuario en la base de datos
     */
    public function insertUsuarios()
    {
        $db = DB::getConnection();
        $query = "INSERT INTO usuarios (nombre_usuario,email_usuario,password_usuario) VALUES (?,?,?)";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $this->nombre_usuario);
        $statement->bindParam(2, $this->email_usuario);
        $statement->bindParam(3, $this->password_usuario);
        if ($statement->execute()) {

            $query1 = "INSERT INTO perfil_usuario(id_usuario) VALUES ((SELECT MAX(id_usuario) FROM usuarios))";
            $statement1 = $db->prepare($query1);
            
            if ($statement1->execute()) {

                return true;
            }
            
            $ttt = $statement1->errorInfo();
//             print_r($ttt);
//             print_r($query1);
        } else {
//             print_r("2");

//             $arr = $statement->errorInfo();
//             print_r($arr);
            return false;
        }
    }

    // FIXME VERIFICAR SI SE CARGAN DATOS
    /**
     * Recupera un perfil de usuario de la base de datos
     */
    /**
     * public function getPerfilUsuarios()
     * {
     * $this->perfil = new Perfiles();
     * $this->perfil->getByUsuario($this->id);
     * }
     */

    /**
     * Trae el usuario de la base de datos en base del "id"
     *
     * @throw Exception
     * @return Usuarios
     *
     */
    public function getUsuarioById($id)
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM usuarios WHERE id_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $id);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("usuario no encontrado");
        }
        return $statement->fetchObject(self::class);
    }

    /**
     * Trae la lista de posteo del usuario
     *
     * @throw Exception
     * @return array
     */
    public function listarPosteoUsuarios()
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM posteo Where id_usuario_posteo=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $this->id_usuario);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("el usuario no hiso ningun posteo");
        }
        return $statement->fetchArray();
    }

    /**
     * Funcion de listar comentario del susuario
     *
     * @throw Exception
     * @return array
     *
     */
    public function listarComentarioUsuarios()
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM comentario Where id_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $this->id_usuario);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("no se realizo ningun comentario para el usuario");
        }
        return $statement->fetchArray();
    }

    public function recuperarPaises(){
        $db = DB::getConnection();
        $query = "SELECT * FROM paises ORDER BY id_pais ASC";
        $statement = $db->prepare($query);
        $statement->execute();
        
        $posteos = array();
        
        while ($fila = $statement->fetch(PDO::FETCH_OBJ)) {
            
            $posteos[] = $fila;
        }
        
        return $posteos;
    }
    
    /**
     * Devuelve el id del usuario
     *
     * @return int
     */
    public function getid()
    {
        return $this->id_usuario;
    }

    /**
     * Devuelve el nombre de usuario
     *
     * @return String nombre del usuario
     */
    public function getnombre_Usuarios()
    {
        return $this->nombre_usuario;
    }

    /**
     * Devuelve el email del usuario
     *
     * @return String eMail del usuario
     */
    public function getemail()
    {
        return $this->email_usuario;
    }

    /**
     * Devuelve la contrase�a del usuario
     *
     * @return String contraseña del usuario
     */
    public function getpassword_Usuarios()
    {
        return $this->password_usuario;
    }

    /*
     * /**
     * Devuelve la el pe
     * @return Perfiles Perfil asociado a la cuenta
     *
     * public function getperfil()
     * {
     * return $this->perfil;
     * }
     */

    /**
     * Setea el id
     *
     * @param int $id
     */
    public function setid($id)
    {
        $this->id_usuario = $id;
    }

    /**
     * Setea el nombre del usuario
     *
     * @param String $nombre_usuario
     */
    public function setnombre_usuario($nombre_usuario)
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    /**
     * Setea el email del usuario
     *
     * @param String $email
     */
    public function setemail($email)
    {
        $this->email_usuario = $email;
    }

    /**
     * Setea la contrase�a del usuario
     *
     * @param String $password_usuario
     */
    public function setpassword_usuario($password_usuario)
    {
        $this->password_usuario = $password_usuario;
    }

/**
 *
 * @param Perfiles $perfil
 *            public function setperfil($perfil)
 *            {
 *            $this->perfil = $perfil;
 *            }
 */
}

?>
