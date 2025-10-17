<?php

if (!isset($productRepository) || !isset($carritoRepository)) {
    die("Error: Repositorios no inicializados.");
}

$action = $_GET["a"] ?? "list";

switch ($action) {
    case "list":
        $products = $productRepository->getAllProducts();
        require_once("views/shopView.phtml");
        break;
    case "add_to_cart":
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $userId = $_SESSION["user"]->getId();
            $productId = $_GET["id"] ?? null;

            if ($productId) {
                $carrito = $carritoRepository->createOrGetCarrito($userId);
                $carritoRepository->addProductToCarrito($carrito->getId(), $productId);
                header("Location: index.php?c=carrito&a=view");
                exit();
            } else {
                $error = "Producto no especificado.";
                // Redirigir a la vista de la tienda con un mensaje de error
                $products = $productRepository->getAllProducts();
                require_once("views/shopView.phtml");
            }
        } else {
            $error = "Debes iniciar sesión para añadir productos al carrito.";
            require_once("views/loginView.phtml");
        }
        break;
    default:
        header("Location: index.php");
        exit();
        break;
}

?>
