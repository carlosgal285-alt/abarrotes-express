<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Sale.php';

class SaleController {
    public function pos() {
        $database = new Database();
        $db = $database->getConnection();
        
        // Obtener productos disponibles para el POS
        $product = new Product($db);
        $productos = $product->read();

        // Obtener Tipo de Cambio de API Externa (RF05)
        $tipo_cambio = 20.00; // Valor fallback por defecto
        @$api_data = file_get_contents("https://open.er-api.com/v6/latest/USD");
        if ($api_data) {
            $data = json_decode($api_data, true);
            if (isset($data['rates']['MXN'])) {
                $tipo_cambio = $data['rates']['MXN']; // 1 USD en MXN aprox
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
            session_start();
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            $id = $_POST['producto_id'];
            $cantidad = intval($_POST['cantidad']);

            // Buscar producto
            $query = "SELECT * FROM productos WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $prod = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($prod && $prod['stock'] >= $cantidad) {
                // Agregar al carrito en sesión
                $encontrado = false;
                foreach ($_SESSION['carrito'] as &$item) {
                    if ($item['id'] == $id) {
                        $item['cantidad'] += $cantidad;
                        $encontrado = true;
                        break;
                    }
                }
                if (!$encontrado) {
                    $_SESSION['carrito'][] = [
                        'id' => $prod['id'],
                        'nombre' => $prod['nombre'],
                        'precio' => $prod['precio'],
                        'cantidad' => $cantidad
                    ];
                }
            }
            header("Location: index.php?action=pos");
            exit();
        }

        include_once 'views/sales/pos.php';
    }

    public function confirmarVenta() {
        session_start();
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            $database = new Database();
            $db = $database->getConnection();
            $sale = new Sale($db);

            if ($sale->registrarVenta($_SESSION['carrito'])) {
                unset($_SESSION['carrito']);
                header("Location: index.php?action=pos&success=1");
                exit();
            }
        }
        header("Location: index.php?action=pos&error=1");
        exit();
    }

    public function limpiarCarrito() {
        session_start();
        unset($_SESSION['carrito']);
        header("Location: index.php?action=pos");
        exit();
    }
}
?>