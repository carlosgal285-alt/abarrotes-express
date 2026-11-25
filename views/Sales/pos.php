<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Punto de Venta - Abarrotes Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-4 py-3">
        <a class="navbar-brand fw-bold" href="index.php?action=dashboard">🛒 Abarrotes Express - POS</a>
        <div>
            <span class="text-white me-3">Tipo de Cambio USD/MXN: <strong>$<?php echo number_format($tipo_cambio, 2); ?></strong></span>
            <a href="index.php?action=dashboard" class="btn btn-outline-light btn-sm">Regresar al Panel</a>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">¡Venta registrada con éxito! Stock descontado automáticamente.</div>
        <?php endif; ?>

        <div class="row">
            <!-- Selector de Productos -->
            <div class="col-md-6">
                <div class="card shadow p-4 bg-white mb-4">
                    <h4 class="fw-bold mb-3">Seleccionar Productos</h4>
                    <form action="index.php?action=pos" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <select name="producto_id" class="form-select" required>
                                <option value="">Seleccione un artículo</option>
                                <?php while($p = $productos->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $p['id']; ?>">
                                        <?php echo $p['nombre']; ?> - $<?php echo $p['precio']; ?> (Stock: <?php echo $p['stock']; ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" value="1" min="1" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">+ Agregar a la Venta</button>
                    </form>
                </div>
            </div>

            <!-- Resumen del Carrito / Ticket -->
            <div class="col-md-6">
                <div class="card shadow p-4 bg-white">
                    <h4 class="fw-bold mb-3">Ticket de Compra</h4>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Cant</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_mxn = 0;
                            if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): 
                                foreach($_SESSION['carrito'] as $item): 
                                    $sub = $item['precio'] * $item['cantidad'];
                                    $total_mxn += $sub;
                            ?>
                                <tr>
                                    <td><?php echo $item['nombre']; ?></td>
                                    <td><?php echo $item['cantidad']; ?></td>
                                    <td>$<?php echo number_format($sub, 2); ?></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="3" class="text-center text-muted">El carrito está vacío</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h5>Total (MXN): <span class="text-success fw-bold">$<?php echo number_format($total_mxn, 2); ?></span></h5>
                        <h5>Total (USD): <span class="text-primary fw-bold">$<?php echo number_format($total_mxn / $tipo_cambio, 2); ?></span></h5>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="index.php?action=limpiar_carrito" class="btn btn-outline-danger w-50">Cancelar / Limpiar</a>
                        <a href="index.php?action=confirmar_venta" class="btn btn-success w-50 fw-bold">Confirmar Venta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>