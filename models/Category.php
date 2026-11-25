<?php
class Category {
    private $conn;
    private $table_name = "categorias";

    public $id;
    public $nombre_categoria;
    public $descripcion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT id, nombre_categoria, descripcion FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre_categoria=:nombre_categoria, descripcion=:descripcion";
        $stmt = $this->conn->prepare($query);
        $this->nombre_categoria = htmlspecialchars(strip_tags($this->nombre_categoria));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $stmt->bindParam(":nombre_categoria", $this->nombre_categoria);
        $stmt->bindParam(":descripcion", $this->descripcion);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
}
?>