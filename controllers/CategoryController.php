<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    public function listar() {
        $database = new Database();
        $db = $database->getConnection();
        $category = new Category($db);
        return $category->read();
    }

    public function crear() {
        if ($_POST) {
            $database = new Database();
            $db = $database->getConnection();
            $category = new Category($db);
            $category->nombre_categoria = $_POST['nombre_categoria'];
            $category->descripcion = $_POST['descripcion'];

            if ($category->create()) {
                header("Location: index.php?action=categorias");
                exit();
            }
        }
        include_once 'views/categories/create.php';
    }

    public function eliminar() {
        $database = new Database();
        $db = $database->getConnection();
        $category = new Category($db);
        $category->id = isset($_GET['id']) ? $_GET['id'] : die('Error');
        if ($category->delete()) {
            header("Location: index.php?action=categorias");
            exit();
        }
    }
}
?>