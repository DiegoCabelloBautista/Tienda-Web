<?php
class Connection
{
    public static function connect()
    {
        $connect = new mysqli("localhost", "root", "", "tienda");
        if ($connect->connect_error) {
            die("Error de conexión: " . $connect->connect_error);
        }
        $connect->query("SET NAMES 'utf8'");
        return $connect;
    }
}
?>
