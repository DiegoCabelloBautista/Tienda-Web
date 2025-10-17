<?php

class User {
    private $id;
    private $username;
    private $password;
    private $rol;

    public function __construct($id, $username, $password, $rol) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getPassword() {
        return $this->password;
    }
    public function getRol() {
        return $this->rol;
    }
    public function isAdmin() {
        return $this->rol;
    }
}
?>