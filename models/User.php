<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($correo, $password) {
        $query = "SELECT id, nombre, correo, password, rol FROM " . $this->table_name . " WHERE correo = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $correo);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validación directa para pruebas
        if($row && ($password === $row['password'] || password_verify($password, $row['password']))) {
            return $row;
        }
        return false;
    }
}
?>