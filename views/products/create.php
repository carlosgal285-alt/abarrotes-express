<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto - Abarrotes Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-4 py-3">
        <a class="navbar-brand fw-bold" href="index.php?action=productos">🛒 Abarrotes Express</a>
        <a href="index.php?action=productos" class="btn btn-outline-light btn-sm">Regresar</a>
    </nav>
    <div class="container mt-5">
        <div class="card shadow-lg p-5 col-md-8 mx-auto bg-white">
            <h3 class="fw-bold text-dark mb-2">Registrar Nuevo Producto</h3>
            <p class="text-muted mb-4">Complete la información requerida para dar de alta el artículo en el inventario.</p>
            
            <form action="index.php?action=crear_producto" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Código de Barras</label>
                    <input type="text" name="codigo_barras" class="form-control" placeholder="Ej. 7501003" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Frijol Negro 1kg" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Precio (MXN)</label>
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stock Inicial</label>
                        <input type="number" name="stock" class="form-control" placeholder="0" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Seleccione una categoría</option>
                        <?php while ($cat = $stmtCat->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['nombre_categoria']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="index.php?action=productos" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>