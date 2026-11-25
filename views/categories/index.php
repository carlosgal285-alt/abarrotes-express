<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías - Abarrotes Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }</style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-4 py-3">
        <a class="navbar-brand fw-bold" href="index.php?action=dashboard">🛒 Abarrotes Express</a>
        <a href="index.php?action=dashboard" class="btn btn-outline-light btn-sm">Regresar al Panel</a>
    </nav>
    <div class="container mt-5">
        <div class="card shadow-lg p-4 bg-white">
            <h3 class="fw-bold mb-3">Gestión de Categorías</h3>
            <form action="index.php?action=crear_categoria" method="POST" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre de categoría" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">+ Agregar</button>
                </div>
            </form>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre_categoria']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td>
                            <a href="index.php?action=eliminar_categoria&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar categoría?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>