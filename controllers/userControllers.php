<?php
// Acción de registrarse
if(isset($_POST['usernameRegister']) && isset($_POST['passwordRegister']) && isset($_POST['passwordRegister2'])) {
    if($_POST['passwordRegister'] == $_POST['passwordRegister2']) {
        $db = Connection::connect();
        $q = 'INSERT INTO user VALUES(NULL, "' . $_POST['usernameRegister'] . '", "' . md5($_POST['passwordRegister']) . '", 0)';
        $db->query($q);
    }
}

// Acción login
if(isset($_POST["username"]) && isset($_POST["password"])) {
    UserRepository::login($_POST["username"], $_POST["password"]);
}

// Acción de mostrar registro
if(isset($_GET['register'])) {
    require_once('views/registerView.phtml');
    exit();
}

if($_SESSION['user'] === false) {
    require_once('views/loginView.phtml');
    exit();
}

// Acción logout
if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>