<?php
namespace Millchat\Core;

use PDO;
use PDOException;

class DB
{

    /**
     * Host de la base de datos.
     *
     * @var string
     */
    const DB_HOST = "localhost";

    /**
     * Usuario de la base de datos.
     *
     * @var string
     */
    const DB_USUARIO = "root";

    /**
     * Contrase�a de la base de datos.
     *
     * @var string
     */
    const DB_PASSWORD = "";

    /**
     * Nombre de la base de datos
     *
     * @var string
     */
    const DB_NAME = "Millchat";

    /**
     * Puerto de acceso a la base.
     *
     * @var integer
     */
    const DB_PORT = 3306;

    protected static $base;

    /**
     * El singleton, hago que haya una unica forma de acceder a la conexion.
     */
    private function __construct()
    {}

    /**
     * Conecto a la base y guardamos la conexion en la propiedad y si no es null, tiene guardada la conexion.
     *
     * @return PDO
     */
    public static function getConnection()
    {
        if (is_null(self::$base)) {

            self::$base = self::connect();
        }

        return self::$base;
    }

    /**
     * La funcion connect establece la conexion con la base de datos.
     *
     * @return PDO
     */
    private static function connect()
    {
        $db_dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

        try {
            $base = new PDO($db_dsn, self::DB_USUARIO, self::DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $base;
    }
}