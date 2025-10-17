<?php
class Carrito
{
    private $id;
    private $userId;
    private $products; // Array of Producto objects

    public function __construct($id, $userId, $products = [])
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->products = $products;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getProducts()
    {
        return $this->products;
    }


    public function getTotalPrecio()
    {
        $total = 0;
        foreach ($this->products as $producto) {
            $total += $producto->getPrice() * $producto->getQuantity();
        }
        return $total;
    }
}




?>