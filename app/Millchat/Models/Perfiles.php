<?php
namespace Millchat\Models;

use Millchat\Core\DB;
use Exception;
use JsonSerializable;
use PDO;
use DateTime;

/**
 * clase perfil
 */
class Perfiles implements JsonSerializable
{

    /**
     * Identifica el perfil
     *
     * @var int
     */
    protected $id_usuario;

    /**
     * Nombre de la persona
     *
     * @var string
     */
    protected $nombre_usuario;

    /**
     * Apellido de la persona
     *
     * @var string
     */
    protected $apellido_usuario;

    /**
     * Pais de la persona
     *
     * @var int
     */
    protected $pais_usuario;

    /**
     * edad de la persona *
     *
     * @var int
     */
    protected $edad_usuario;

    /**
     * Fecha de nacimiento de la persona *
     *
     * @var int
     */
    protected $fecha_nacimiento;



    
    /**
     * Esta funcion recive un id_usuario y retorna un objeto de perfil de la base.
     * *
     *
     * @param int $id_usuario
     * @throw Exception
     * @return Perfiles
     */
    public static function getByUsuario($id_usuario)
    {
        $db = DB::getConnection();
        $query = "SELECT * FROM perfil_usuario WHERE id_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $id_usuario);
        $statement->execute();

        if ($statement->rowCount() == 0) {
            throw new Exception("usuario no encontrado");
        }
        return $statement->fetchObject(self::class);
    }

    public function paisPersona($param) {
        
        $db = DB::getConnection();
        $query = "SELECT * FROM paises WHERE id_pais=?";
       
        $statement = $db->prepare($query);
        $statement->bindParam(1, $param);
        $statement->execute();
        
        $posteos = array();
        
        while ($fila = $statement->fetch(PDO::FETCH_OBJ)) {
            $posteos[] = $fila;
        }
        
        return $posteos;
    }
    /**
     * Inserta un perfil en la base de datos
     *
     * @return boolean
     */
    public function insertUsuarios()
    {
        $db = DB::getConnection();
        $query = "INSERT INTO usuarios (id_usuario,nombre_usuario,apellido_usuario,pais_usuario,edad_usuario) VALUES (?,?,?)";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $this->id_usuario_usuario);
        $statement->bindParam(2, $this->nombre_usuario);
        $statement->bindParam(3, $this->apellido_usuario);
        $statement->bindParam(4, $this->pais_usuario);
        $statement->bindParam(5, $this->edad_usuario);
        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Guarda la informacion del perfil en la base de datos.
     * *
     *
     * @throws Exception
     * @return boolean
     */
    /*public function editarPerfil()
    {
        $db = DB::getConnection();
        $query = "UPDATE perfil_usuario SET nombre_usuario=?, apellido_usuario=?, pais_usuario=?, edad_usuario=?, fecha_nacimiento=? WHERE id_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $this->nombre_usuario);
        $statement->bindParam(2, $this->apellido_usuario);
        $statement->bindParam(3, $this->pais_usuario);
        $statement->bindParam(4, $this->edad_usuario);
        $statement->bindParam(5, $this->id_usuario_usuario);
        

        if (! $statement->execute()) {
            throw new Exception('Nose pudo modificar el perfil');
        }
        return true;
    }*/
    
    /**
     * Guarda la informacion del perfil en la base de datos.
     * *
     *
     * @throws Exception
     * @return boolean
     */
    public function editarPerfilDatos($data)
    {
        $db = DB::getConnection();
        $query = "UPDATE perfil_usuario SET nombre_usuario=?, apellido_usuario=?, pais_usuario=?, edad_usuario=?, fecha_nacimiento=? WHERE id_usuario=?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $data['nombre_usuario']);
        $statement->bindParam(2, $data['apellido_usuario']);
        $statement->bindParam(3, $data['pais_usuario']);
        $statement->bindParam(4, $data['edad_usuario']);
        $statement->bindParam(5, $data['id_usuario']);
        
        
        if($data['fecha_nacimiento'] !== null && $data['fecha_nacimiento'] !== ""){
            $nueva_fecha = new DateTime($data['fecha_nacimiento']);
            $nueva_fecha = date_format($nueva_fecha,"Y-m-d H:i:s");
            $statement->bindParam(6, $data['fecha_nacimiento']); 
            
        }
        //var_dump($data); die();


        if (!$statement->execute()) {
            throw new Exception('Nose pudo modificar el perfil');
        }
        return true;
    }
    /**
     *
     * @return Mixed[]
     */
    public function jsonSerialize()
    {
        $array = array();
        $array['id_usuario'] = $this->getid();
        $array['nombre_usuario'] = $this->getnombre_Usuarios();
        $array['apellido_usuario'] = $this->getapellido_Usuarios();
        $array['pais_usuario'] = $this->getpais_Usuarios();
        $array['edad_Usuario'] = $this->getedad_Usuarios();

        return $array;
    }

    /**
     * Devuelve el id del perfil
     *
     * @return int
     */
    public function getid()
    {
        return $this->id_usuario;
    }

    /*
     * ¡No! [borrar] crear nombre del usuario
     */
    /**
     * Devuelve el nombre de la persona *
     *
     * @return string
     */
    public function getnombre_Usuarios()
    {
        return $this->nombre_usuario;
    }

    /**
     * Devuelve el apellido de la persona
     */
    public function getapellido_Usuarios()
    {
        return $this->apellido_usuario;
    }

    /**
     * Devuelve el pais de la persona
     */
    public function getpais_Usuarios()
    {
        return $this->pais_usuario;
    }

    /**
     * Devuelve la edad de la persona
     *
     * @return int
     */
    public function getedad_Usuarios()
    {
        return $this->edad_usuario;
    }


     /**
     * Devuelve la fecha denacimiento de la persona
     *
     * @return int
     */
    public function getfecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Setea el id
     *
     * @param int $id_usuario
     */
    public function setid($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * Setea el nombre de la persona
     *
     * @param String $nombre_usuario
     */
    public function setnombre_usuario($nombre_usuario)
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    /**
     * Setea el apellido de la persona
     *
     * @param String $apellido_usuario
     */
    public function setapellido_usuario($apellido_usuario)
    {
        $this->apellido_usuario = $apellido_usuario;
    }

    /**
     * Setea el pais de la persona
     *
     * @param int $pais_usuario
     */
    public function setpais_usuario($pais_usuario)
    {
        $this->pais_usuario = $pais_usuario;
    }

    /**
     * Setea la edad de la persona
     *
     * @param int $edad_usuario
     */
    public function setedad_usuario($edad_usuario)
    {
        $this->edad_usuario = $edad_usuario;
    }

    /**
     * Setea la fecha de nacimiento de la persona
     *
     * @param int $fecha_nacimiento
     */
    public function setfecha_nacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }
}

?>
