<?php

class UserRepository {
    public static function getUser($id) {
        $db = Connection::connect();
        $q = "SELECT * FROM user WHERE id=" . $id;
        $result = $db->query($q);

        if($row = $result->fetch_assoc()) {
            return new User($row['id'], $row['username'], $row['password'], $row['rol']);
        }
        return null;
    }

    public static function login($username, $password) {
        $db = Connection::connect();
        $q = 'SELECT * FROM user WHERE username="' . $username . '" AND password="' . md5($password) . '"';
        $result = $db->query($q);
        
        if($row = $result->fetch_assoc()) {
            $_SESSION['user'] = new User($row['id'], $row['username'], $row['password'], $row['rol']);
            header('Location: index.php');
            exit();
        }
    }
}
?>