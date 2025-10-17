<?php
require_once("Carrito.php");
require_once("Product.php");

class CarritoRepository
{
    private $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function createOrGetCarrito(int $userId): Carrito
    {
        $stmt = $this->db->prepare("SELECT id FROM carrito WHERE userid = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $carritoId = $result->fetch_column();

        if (!$carritoId) {
            $stmt = $this->db->prepare("INSERT INTO carrito (userid) VALUES (?)");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $carritoId = $this->db->insert_id;
        }

        return $this->getCarritoById($carritoId);
    }

    public function getCarritoById(int $carritoId): Carrito
    {
        $stmt = $this->db->prepare("SELECT c.id as carrito_id, c.userid, cp.product_id, cp.quantity, p.name, p.price, p.description FROM carrito c LEFT JOIN carrito_producto cp ON c.id = cp.carrito_id LEFT JOIN product p ON cp.product_id = p.id WHERE c.id = ?");
        $stmt->bind_param("i", $carritoId);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        $userId = 0;
        while ($row = $result->fetch_assoc()) {
            $userId = $row["userid"];
            if ($row["product_id"]) {
                $products[] = new Product($row["product_id"], $row["name"], $row["price"], $row["description"], $row["quantity"]);
            }
        }
        return new Carrito($carritoId, $userId, $products);
    }

    public function addProductToCarrito(int $carritoId, int $productId, int $quantity = 1)
    {
        $stmt = $this->db->prepare("SELECT quantity FROM carrito_producto WHERE carrito_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $carritoId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingQuantity = $result->fetch_column();

        if ($existingQuantity) {
            $newQuantity = $existingQuantity + $quantity;
            $stmt = $this->db->prepare("UPDATE carrito_producto SET quantity = ? WHERE carrito_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $newQuantity, $carritoId, $productId);
        } else {
            $stmt = $this->db->prepare("INSERT INTO carrito_producto (carrito_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $carritoId, $productId, $quantity);
        }
        $stmt->execute();
    }

    public function removeProductFromCarrito(int $carritoId, int $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM carrito_producto WHERE carrito_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $carritoId, $productId);
        $stmt->execute();
    }

    public function clearCarrito(int $carritoId)
    {
        $stmt = $this->db->prepare("DELETE FROM carrito_producto WHERE carrito_id = ?");
        $stmt->bind_param("i", $carritoId);
        $stmt->execute();
    }
}
?>
