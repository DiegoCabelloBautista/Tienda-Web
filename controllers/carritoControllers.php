<?php

if (!isset($carritoRepository) || !isset($productRepository)) {
    die("Error: Repositorios no inicializados.");
}

if (!isset($_SESSION["user"]) || !($_SESSION["user"] instanceof User)) {
    $error = "Debes iniciar sesión para ver o gestionar tu carrito.";
    require_once("views/loginView.phtml");
    exit();
}

$userId = $_SESSION["user"]->getId();
$carrito = $carritoRepository->createOrGetCarrito($userId);

$action = $_GET["a"] ?? "view";

switch ($action) {
    case "view":
        $productsInCart = $carrito->getProducts();
        require_once("views/carritoView.phtml");
        break;
    case "add":
        $productId = $_GET["id"] ?? null;
        if ($productId) {
            $carritoRepository->addProductToCarrito($carrito->getId(), $productId);
        }
        header("Location: index.php?c=carrito&a=view");
        exit();
        break;
    case "remove":
        $productId = $_GET["id"] ?? null;
        if ($productId) {
            $carritoRepository->removeProductFromCarrito($carrito->getId(), $productId);
        }
        header("Location: index.php?c=carrito&a=view");
        exit();
        break;
    case "clear":
        $carritoRepository->clearCarrito($carrito->getId());
        header("Location: index.php?c=carrito&a=view");
        exit();
        break;
    default:
        header("Location: index.php?c=carrito&a=view");
        exit();
        break;
}

?>
