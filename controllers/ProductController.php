<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    public function listar() {
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);
        return $product->read();
    }

    public function crear() {
        $database = new Database();
        $db = $database->getConnection();
        
        $queryCat = "SELECT id, nombre_categoria FROM categorias";
        $stmtCat = $db->prepare($queryCat);
        $stmtCat->execute();

        if ($_POST) {
            $product = new Product($db);
            $product->codigo_barras = $_POST['codigo_barras'];
            $product->nombre = $_POST['nombre'];
            $product->precio = $_POST['precio'];
            $product->stock = $_POST['stock'];
            $product->categoria_id = $_POST['categoria_id'];

            if ($product->create()) {
                header("Location: index.php?action=productos");
                exit();
            }
        }

        include_once 'views/products/create.php';
    }

    public function editar() {
        $database = new Database();
        $db = $database->getConnection();

        $product = new Product($db);
        $product->id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID no encontrado.');
        $product->readOne();

        $queryCat = "SELECT id, nombre_categoria FROM categorias";
        $stmtCat = $db->prepare($queryCat);
        $stmtCat->execute();

        if ($_POST) {
            $product->codigo_barras = $_POST['codigo_barras'];
            $product->nombre = $_POST['nombre'];
            $product->precio = $_POST['precio'];
            $product->stock = $_POST['stock'];
            $product->categoria_id = $_POST['categoria_id'];

            if ($product->update()) {
                header("Location: index.php?action=productos");
                exit();
            }
        }

        include_once 'views/products/edit.php';
    }

    public function eliminar() {
        $database = new Database();
        $db = $database->getConnection();

        $product = new Product($db);
        $product->id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID no encontrado.');

        if ($product->delete()) {
            header("Location: index.php?action=productos");
            exit();
        }
    }
}
?>