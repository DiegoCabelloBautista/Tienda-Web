<?php

if (!isset($userRepository)) {
    die("Error: UserRepository no está inicializado.");
}

$action = $_GET["a"] ?? "login";

switch ($action) {
    case "login":
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";

            $user = $userRepository->login($username, $password);

            if ($user) {
                $_SESSION["user"] = $user;
                header("Location: index.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                require_once("views/loginView.phtml");
            }
        } else {
            require_once("views/loginView.phtml");
        }
        break;
   case "register":
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";
        $password2 = $_POST["password2"] ?? "";

        // Verificar que las contraseñas coincidan
        if ($password !== $password2) {
            $error = "Las contraseñas no coinciden.";
            require_once("views/registerView.phtml");
            break;
        }

        if ($userRepository->register($username, $password)) {
            $success = "Registro exitoso. Por favor, inicia sesión.";
            require_once("views/loginView.phtml");
        } else {
            $error = "Error al registrar el usuario o el usuario ya existe.";
            require_once("views/registerView.phtml");
        }
    } else {
        require_once("views/registerView.phtml");
    }
    break;
    case "logout":
        session_destroy();
        header("Location: index.php");
        exit();
        break;
    default:
        header("Location: index.php");
        exit();
        break;
}

?>
