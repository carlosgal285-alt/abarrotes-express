<?php
class Product {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $codigo_barras;
    public $nombre;
    public $precio;
    public $stock;
    public $categoria_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT p.id, p.codigo_barras, p.nombre, p.precio, p.stock, c.nombre_categoria 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN categorias c ON p.categoria_id = c.id 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET codigo_barras=:codigo_barras, nombre=:nombre, precio=:precio, stock=:stock, categoria_id=:categoria_id";
        $stmt = $this->conn->prepare($query);

        $this->codigo_barras = htmlspecialchars(strip_tags($this->codigo_barras));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));

        $stmt->bindParam(":codigo_barras", $this->codigo_barras);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":categoria_id", $this->categoria_id);

        return $stmt->execute();
    }

    public function readOne() {
        $query = "SELECT id, codigo_barras, nombre, precio, stock, categoria_id 
                  FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->codigo_barras = $row['codigo_barras'];
            $this->nombre = $row['nombre'];
            $this->precio = $row['precio'];
            $this->stock = $row['stock'];
            $this->categoria_id = $row['categoria_id'];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET codigo_barras = :codigo_barras, nombre = :nombre, precio = :precio, stock = :stock, categoria_id = :categoria_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->codigo_barras = htmlspecialchars(strip_tags($this->codigo_barras));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':codigo_barras', $this->codigo_barras);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':id', $this->id);

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