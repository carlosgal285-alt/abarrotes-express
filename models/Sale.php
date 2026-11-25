<?php
class Sale {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarVenta($carrito) {
        try {
            $this->conn->beginTransaction();

            // 1. Calcular total y registrar venta principal
            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $queryVenta = "INSERT INTO ventas (total) VALUES (:total)";
            $stmtVenta = $this->conn->prepare($queryVenta);
            $stmtVenta->bindParam(":total", $total);
            $stmtVenta->execute();
            $venta_id = $this->conn->lastInsertId();

            // 2. Registrar detalles y descontar stock automáticamente
            foreach ($carrito as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                
                $queryDetalle = "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, subtotal) VALUES (:venta_id, :producto_id, :cantidad, :subtotal)";
                $stmtDetalle = $this->conn->prepare($queryDetalle);
                $stmtDetalle->bindParam(":venta_id", $venta_id);
                $stmtDetalle->bindParam(":producto_id", $item['id']);
                $stmtDetalle->bindParam(":cantidad", $item['cantidad']);
                $stmtDetalle->bindParam(":subtotal", $subtotal);
                $stmtDetalle->execute();

                // Descontar stock
                $queryStock = "UPDATE productos SET stock = stock - :cantidad WHERE id = :id";
                $stmtStock = $this->conn->prepare($queryStock);
                $stmtStock->bindParam(":cantidad", $item['cantidad']);
                $stmtStock->bindParam(":id", $item['id']);
                $stmtStock->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>