<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal - Abarrotes Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .card-menu { transition: transform 0.2s; border: none; border-radius: 12px; }
        .card-menu:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-4 py-3">
        <a class="navbar-brand fw-bold" href="#">🛒 Abarrotes Express - Panel (<?php echo $rol; ?>)</a>
        <div>
            <span class="text-white me-3">Bienvenido, <?php echo $_SESSION['nombre']; ?></span>
            <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row g-4 justify-content-center">
            
            <!-- Módulo Punto de Venta (Accesible para Administrador y Empleado) -->
            <div class="col-md-4">
                <div class="card card-menu shadow p-4 text-center bg-white">
                    <h3 class="mb-3">💰 Punto de Venta</h3>
                    <p class="text-muted">Registrar ventas, calcular totales y descontar stock.</p>
                    <a href="index.php?action=pos" class="btn btn-success fw-semibold">Acceder al POS</a>
                </div>
            </div>

            <!-- Módulos Exclusivos para Administrador (RF06) -->
            <?php if($rol === 'Administrador'): ?>
            <div class="col-md-4">
                <div class="card card-menu shadow p-4 text-center bg-white">
                    <h3 class="mb-3">📦 Productos</h3>
                    <p class="text-muted">Gestionar inventario (CRUD de artículos).</p>
                    <a href="index.php?action=productos" class="btn btn-primary fw-semibold">Gestionar Productos</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-menu shadow p-4 text-center bg-white">
                    <h3 class="mb-3">🏷️ Categorías</h3>
                    <p class="text-muted">Crear y administrar categorías de productos.</p>
                    <a href="index.php?action=categorias" class="btn btn-dark fw-semibold">Gestionar Categorías</a>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>