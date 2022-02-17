<?php
namespace Millchat\Models;

use DaVinci\Utilities\Str;
use Millchat\Core\DB;
use PDO;


require_once (__DIR__ . "/../Utilities/Str.php");

/**
 * Class Modelo
 * Base de los modelos tipo ActiveRecord del sistema.
 * Ofrece todas las acciones básicas de un ABM (traer todos, traer por PK, crear, editar, eliminar)
 * a través de unas propiedades configurables.
 *
 * @package Millchat\Models
 */
class Modelo
{

    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = '';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [];

    /**
     * Asigna todos los valores de $data que referencien a atributos definidos en self::$attributes.
     *
     * @param array $data
     */
    public function cargarDatosDeArray(array $data)
    {
        foreach ($this->attributes as $attribute) {
            // $attribute = 'nombre';
            // Preguntamos si existe una clave en $data para ese atributo.
            if (isset($data[$attribute])) {
                // Asignamos ese valor a la propiedad indicada en el atributo.
                // Primero probamos de hacerlo a través de un setter, si es que existe.
                $setter = 'set' . ucfirst(Str::snakeToCamel($attribute));
                if (method_exists($this, $setter)) {
                    $this->{$setter}($data[$attribute]);
                } else {
                    // Si no había un getter, probamos de asignarla directamente.
                    $this->{$attribute} = $data[$attribute];
                }
            }
        }
    }

    /**
     * Retorna todos los registros de la tabla.
     *
     * @return static[]
     */
    public function traerTodo(): array
    {
        $query = "SELECT * FROM " . $this->table;
        $db = DB::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute();

        // Variante 3: Usando setFetchMode.
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);

        return $stmt->fetchAll();

        // Variante 1: Haciendo un bucle para recorrer uno por uno los registros, crear el objeto,
        // cargarle los datos y agregarlo a la salida.
        // $salida = [];
        //
        // while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // // $salida[] = $fila;
        // // En cada vuelta, instanciamos un producto para almacenar los datos del registro.
        // // Cuando hacemos el "new self", estamos instanciando un nuevo "self". Donde "self"
        // // hace referencia a la clase en _donde estamos ubicados ahora_. Es decir, "Modelo".
        // // Nosotros no queremos instanciar Modelos, necesitamos que se instancien las clases
        // // que estén heredando de Modelo. Y esas clases son dinámicas: no sabemos de antemano
        // // cuál es el valor que corresponde.
        // // Para salvarnos, podemos usar en vez de "self", la keyword "static".
        // // Cuando usamos "static" en reemplazo de una clase, la keyword hace referencia a la
        // // clase que esté ejecutando el método _en tiempo de ejecución_.
        // $obj = new static();
        // $obj->cargarDatosDeArray($fila);
        //
        // $salida[] = $obj;
        // }
        //
        // return $salida;

        // Variante 2: Usando fetchObject.
        // $salida = [];
        //
        // while($obj = $stmt->fetchObject(static::class)) {
        // $salida[] = $obj;
        // }
        //
        // return $salida;
    }

    /**
     * Retorna el registro asociado a la PK.
     *
     * @param mixed $id
     * @return static|null
     */
    public function traerPorPK($id)
    {
        // echo "Modelo::traerPorPK | Haciendo una consulta a la base<br>";
        $db = DB::getConnection();
        $query = "SELECT * FROM " . $this->table . "
                WHERE " . $this->primaryKey . " = ?";
        $stmt = $db->prepare($query);
        if (! $stmt->execute([
            $id
        ])) {
            return null;
        }

        // Variante 1: Obteniendo el array e instanciando la clase.
        // $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        //
        // $obj = new static();
        // $obj->cargarDatosDeArray($fila);

        // Variante 2: Usando el método fetchObject.
        return $stmt->fetchObject(static::class);
    }

    /**
     *
     * @param array $data
     * @return bool
     */
    public function crear(array $data): bool
    {
        $db = DB::getConnection();
        $columns = $this->prepareInsertColumns($data);
        $holders = $this->prepareInsertHolders($columns);
        $data = $this->prepareInsertData($data, $columns);
        // echo "<pre>";
        // print_r($columns);
        // echo "</pre>";
        // exit;
        $query = "INSERT INTO " . $this->table . " (" . implode(',', $columns) . ")
                  VALUES (" . implode(',', $holders) . ")";
        // $query = "INSERT INTO {$this->table} ({implode(',', $columns)})
        // VALUES ({implode(',', $holders)})";
        $stmt = $db->prepare($query);

        if (! $stmt->execute($data)) {
            return false;
        }
        return true;
    }

    /**
     * Retorna un array con los nombres de las columnas para el INSERT.
     * Las columnas se detectan a partir de las claves de los valores en $data que coinciden con
     * atributos de $attributes.
     *
     * @param array $data
     * @return array
     */
    protected function prepareInsertColumns(array $data)
    {
        $salida = [];
        foreach ($data as $key => $value) {
            // Si existe la key de $data en los atributos, lo agregamos al INSERT.
            if (in_array($key, $this->attributes)) {
                $salida[] = $key;
            }
        }

        return $salida;
    }

    /**
     * Retorna un array con los holders.
     * Los holders van a ser los valores del array $columns con un ":" prefijado.
     *
     * @param array $columns
     * @return array
     */
    protected function prepareInsertHolders(array $columns): array
    {
        $salida = [];
        foreach ($columns as $column) {
            $salida[] = ":" . $column;
        }
        return $salida;
    }

    /**
     * Retorna un array con los valores para el execute del INSERT.
     * Va a contener las claves que coinciden con las columnas y los valores de $data ascoiados.
     *
     * @param array $data
     * @param array $columns
     * @return array
     */
    protected function prepareInsertData(array $data, array $columns): array
    {
        $salida = [];
        foreach ($columns as $column) {
            $salida[$column] = $data[$column];
        }
        return $salida;
    }
}
