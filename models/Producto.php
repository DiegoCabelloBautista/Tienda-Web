<?php
public class Producto
{
    private $id;
    private $nombre;
    private $precio;
    private $descripcion;

    public function __construct($id, $nombre, $precio, $descripcion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
?>  