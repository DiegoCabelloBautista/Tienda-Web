<?php
require_once("Product.php");

class ProductRepository
{
    private $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function getAllProducts(): array
    {
        $stmt = $this->db->query("SELECT * FROM product");
        $products = [];
        while ($row = $stmt->fetch_assoc()) {
            $products[] = new Product($row["id"], $row["name"], $row["price"], $row["description"]);
        }
        return $products;
    }

    public function getProductById(int $id): ?Product
    {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            return new Product($row["id"], $row["name"], $row["price"], $row["description"]);
        }
        return null;
    }
}
?>
