<?php
require_once("db.php");
require_once("User.php");

class UserRepository {
    private $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    public function getUserById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row) {
            return new User($row["id"], $row["username"], $row["password"], $row["rol"]);
        }
        return null;
    }

    public function getUserByUsername(string $username): ?User {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row) {
            return new User($row["id"], $row["username"], $row["password"], $row["rol"]);
        }
        return null;
    }

    public function login(string $username, string $password): ?User {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $hashedPassword = md5($password); // Asumiendo que las contraseñas están en MD5
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if($row) {
            return new User($row["id"], $row["username"], $row["password"], $row["rol"]);
        }
        return null;
    }

    public function register(string $username, string $password, int $rol = 1): bool {
        // Verificar si el usuario ya existe
        if ($this->getUserByUsername($username)) {
            return false; // El usuario ya existe
        }

        $stmt = $this->db->prepare("INSERT INTO user (username, password, rol) VALUES (?, ?, ?)");
        $hashedPassword = md5($password);
        $stmt->bind_param("ssi", $username, $hashedPassword, $rol);
        return $stmt->execute();
    }
}
?>
