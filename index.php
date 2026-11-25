<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

// Control de acceso general
if (!isset($_SESSION['user_id']) && $action != 'login') {
    header("Location: index.php?action=login");
    exit();
}

switch ($action) {
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'dashboard':
        include_once 'views/dashboard/index.php';
        break;
        
    case 'productos':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $resultado = $controller->listar();
        include_once 'views/products/index.php';
        break;

    case 'crear_producto':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->crear();
        break;

    case 'editar_producto':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->editar();
        break;

    case 'eliminar_producto':
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        $controller->eliminar();
        break;

    case 'categorias':
        require_once 'controllers/CategoryController.php';
        $controller = new CategoryController();
        $resultado = $controller->listar();
        include_once 'views/categories/index.php';
        break;

    case 'crear_categoria':
        require_once 'controllers/CategoryController.php';
        $controller = new CategoryController();
        $controller->crear();
        break;

    case 'eliminar_categoria':
        require_once 'controllers/CategoryController.php';
        $controller = new CategoryController();
        $controller->eliminar();
        break;

    case 'pos':
        require_once 'controllers/SaleController.php';
        $controller = new SaleController();
        $controller->pos();
        break;

    case 'confirmar_venta':
        require_once 'controllers/SaleController.php';
        $controller = new SaleController();
        $controller->confirmarVenta();
        break;

    case 'limpiar_carrito':
        require_once 'controllers/SaleController.php';
        $controller = new SaleController();
        $controller->limpiarCarrito();
        break;
        
    default:
        include_once 'views/dashboard/index.php';
        break;
}
?>