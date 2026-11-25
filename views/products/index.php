<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - Abarrotes Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .navbar { box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-4 py-3">
        <a class="navbar-brand fw-bold" href="index.php?action=dashboard">🛒 Abarrotes Express</a>
        <a href="index.php?action=dashboard" class="btn btn-outline-light btn-sm">Regresar al Panel</a>
    </nav>
    <div class="container mt-5">
        <div class="card shadow-lg p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark">Inventario de Productos</h3>
                    <p class="text-muted mb-0">Gestión y control de artículos registrados en el sistema.</p>
                </div>
                <a href="index.php?action=crear_producto" class="btn btn-primary fw-semibold shadow-sm">+ Nuevo Producto</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($resultado) && $resultado->rowCount() > 0): ?>
                            <?php while ($row = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><span class="badge bg-secondary"><?php echo $row['codigo_barras']; ?></span></td>
                                    <td class="fw-semibold"><?php echo $row['nombre']; ?></td>
                                    <td class="text-success fw-bold">$<?php echo number_format($row['precio'], 2); ?></td>
                                    <td>
                                        <span class="badge <?php echo $row['stock'] > 5 ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $row['stock']; ?> unidades
                                        </span>
                                    </td>
                                    <td><?php echo $row['nombre_categoria']; ?></td>
                                    <td class="text-center">
                                        <a href="index.php?action=editar_producto&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm fw-semibold">Editar</a>
                                        <a href="index.php?action=eliminar_producto&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm fw-semibold" onclick="return confirm('¿Está seguro de eliminar este producto?');">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No hay productos registrados en la base de datos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>