<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Abarrotes Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 12px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <div class="card shadow-lg p-4 bg-white">
        <h3 class="fw-bold text-center mb-3">🛒 Abarrotes Express</h3>
        <p class="text-muted text-center mb-4">Inicie sesión con su cuenta</p>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger py-2"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="index.php?action=login" method="POST">
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" class="form-control" placeholder="admin@abarrotes.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">Ingresar al Sistema</button>
        </form>
        <div class="mt-3 text-center text-muted small">
            Admin: admin@abarrotes.com / 123456<br>
            Empleado: empleado@abarrotes.com / 123456
        </div>
    </div>
</body>
</html>