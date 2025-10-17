<?php
// PRIMERO cargar todas las clases necesarias
require_once("db.php");
require_once("models/User.php");
require_once("models/Carrito.php");
require_once("models/Product.php");
require_once("models/CarritoRepository.php");
require_once("models/UserRepository.php");
require_once("models/ProductRepository.php");

// LUEGO iniciar sesión
session_start();

// Inicializar la conexión a la base de datos y los repositorios
$db = Connection::connect();
$userRepository = new UserRepository($db);
$productRepository = new ProductRepository($db);
$carritoRepository = new CarritoRepository($db);

// ELIMINA esta parte que causa problemas:
// if(!isset($_SESSION["user"])) {
//     $_SESSION["user"] = false;
// }

// Lógica del controlador
if(isset($_GET["c"])) {
    $controller = $_GET["c"];
    $action = $_GET["a"] ?? "index";

    switch ($controller) {
        case "user":
            require_once("controllers/userControllers.php");
            break;
        case "product":
            require_once("controllers/productoControllers.php");
            break;
        case "carrito":
            require_once("controllers/carritoControllers.php");
            break;
        default:
            $products = $productRepository->getAllProducts();
            require_once("views/shopView.phtml");
            break;
    }
} else {
    $products = $productRepository->getAllProducts();
    require_once("views/shopView.phtml");
}
?>