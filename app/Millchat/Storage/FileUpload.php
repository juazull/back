<?php
namespace Millchat\Storage;

class FileUpload
{

    /** @var array El archivo del array $_FILES. */
    protected $file;

    /** @var string */
    protected $tmpName;

    /** @var string */
    protected $originalName;

    /** @var string */
    protected $mimeType;

    /** @var int */
    protected $size;

    /** @var string El nombre del archivo con el que se va a guardar. */
    protected $filename;

    /** @var string La extensión del archivo. */
    protected $extension;

    /**
     * FileUpload constructor.
     *
     * @param array $file
     *            El archivo del array de $_FILES.
     */
    public function __construct(array $file)
    {
        $this->file = $file;
        $this->tmpName = $this->file['tmp_name'];
        $this->originalName = $this->file['name'];
        $this->mimeType = $this->file['type'];
        $this->size = $this->file['size'];
    }

    /**
     * Guarda el archivo en el $path indicado.
     * Retorna el nombre del archivo generado.
     *
     * @param string $path
     * @return string
     */
    public function guardar($path)
    {
        $this->filename = $this->generarNombre($this->originalName);
        move_uploaded_file($this->tmpName, $path . $this->filename);
        return $this->filename;
    }

    /**
     * Genera un nombre para el archivo.
     *
     * @param string $originalName
     * @return string
     */
    protected function generarNombre($originalName)
    {
        $this->extension = $this->obtenerExtension($originalName);
        // Generamos el nombre con la fecha y hora actual.
        $filename = date('Ymd_His') . "." . $this->extension;
        return $filename;
    }

    /**
     * Retorna la extensión del $nombre del archivo.
     *
     * @param
     *            $nombre
     * @return string
     */
    protected function obtenerExtension($nombre)
    {
        // La extensión es el string que sigue al último punto.
        // Por lo tanto buscamos la posición del último punto con la función strrpos() y obtener la
        // extensión con substr().
        $ultimoPunto = strrpos($nombre, '.');
        $extension = substr($nombre, $ultimoPunto + 1);
        return $extension;

        // return substr($nombre, (strrpos($nombre, '.') + 1) );
    }
}
