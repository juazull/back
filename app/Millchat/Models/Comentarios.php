<?php
namespace Millchat\Models;

use Millchat\Core\DB;
use DateTime;
use Exception;
use JsonSerializable;
use PDO;


/**
 * clase Comentarios
 */
class Comentarios implements JsonSerializable
{

    /**
     * Identifica el comentario
     *
     * @var int
     */
    protected $id;

    /**
     * Nick del posteo
     *
     * @var int
     */
    protected $posteo;

    /**
     * Identifica el usuario que hiso el comentario
     *
     * @var int
     */
    protected $usuario;

    /**
     * Identifica la fecha del comentario
     *
     * @var DateTime
     */
    protected $fecha;

    /**
     *
     * @var string
     */
    protected $comentario;

    /**
     * Esta funcion recive un id comentario y retorna un objeto en la base.
     *
     * @param int $id_comentario
     * @throw Exception
     * @return Comentarios
     */
    public static function getByComentario($id_comentario)
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM comentarios WHERE id_Comentarios=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $id_comentario);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("el comentario no fue encontrado");
        }
        return $statement->fetchObject(self::class);
    }

    /**
     *
     * @return Array[]
     */
    public function jsonSerialize()
    {
        $array = array();
        $array['id_comentarios'] = $this->getid();
        $array['id_posteo'] = $this->getposteo();
        $array['id_usuario'] = $this->getUsuarios();
        $array['fecha'] = $this->getfecha();
        $array['comentario'] = $this->getcomentario();
        return $array;
    }

    /**
     * Inserta un comentario en la base de datos
     */
    public function insertComentario($data)
    {
        $db = DB::getConnection();
        $query = "INSERT INTO comentarios (id_posteo,id_usuario,fecha,comentario) VALUES (?,?,?,?)";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $data['id_posteo']);
        $statement->bindParam(2, $data['id_usuario']);
        $statement->bindParam(3, $data['fecha']);
        $statement->bindParam(4, $data['comentario']);
        if ($statement->execute()){
            return true;
        }else {
            echo "\nPDOStatement::errorInfo():\n";
            $arr = $statement->errorInfo();
            print_r($arr);
            
            return false;
        }
    }

    /**
     * Hace una lista con los comentarios de un posteo
     *
     * @param int $idPosteo
     * @throw Exception
     * @return array
     */
    public function listarComentarioPosteo($id_posteo)
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM comentarios Where id_posteo=? ORDER BY fecha DESC";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $id_posteo);
        $statement->execute();

        
        while ($fila = $statement->fetch(PDO::FETCH_OBJ)) {
            $coment[] = $fila;
        }
        return $coment;
    }

    /**
     * Borra el comentario de la base
     *
     * @param int $id
     * @return boolean
     */
    public static function borrar_comentario($id)
    {
        $db = DB::getConnection();
        $query = "DELETE FROM comentarios WHERE id_comentarios =?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $id);
        if ($statement->excecute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @return int
     */
    public function getid()
    {
        return $this->id;
    }

    /**
     * Devuelve la variable posteo
     */
    public function getposteo()
    {
        return $this->posteo;
    }

    /**
     * Devuelve la variable usuarios
     */
    public function getUsuarios()
    {
        return $this->usuario;
    }

    /**
     * Devuelve la variable fecha
     */
    public function getfecha()
    {
        return $this->fecha;
    }

    /**
     *Devuelve la variable comentario
     * @return String
     */
    public function getcomentario()
    {
        return $this->comentario;
    }

    /**
     *Setea la variable id
     * @param int $id
     */
    public function setid($id)
    {
        $this->id = $id;
    }

    /**
     *Setea la variable id del posteo
     * @param int $posteo
     */
    public function setposteo($posteo)
    {
        $this->posteo = $posteo;
    }

    /**
     *Setea la variable id del usuario
     * @param int $usuario
     */
    public function setusuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     *Setea la variable id del fecha
     * @param DateTime $fecha
     */
    public function setfecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     *Setea la variable id del comentario
     *@param String $comentario
     */
    public function setcomentario($comentario)
    {
        $this->perfil = $comentario;
    }
}

?>
