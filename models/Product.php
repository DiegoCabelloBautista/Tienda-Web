<?php
class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $quantity;

    public function __construct($id, $name, $price, $description, $quantity = 1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }



   
}
?>  