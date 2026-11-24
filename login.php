<?php
session_start();
require 'config/conexion.php';

if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        // Guardar estado en la sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DevTrack | Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="justify-content: center; align-items: center;">
    <div class="panel" style="width: 380px;">
        <div class="panel-header"><h3>DevTrack | Acceso al Sistema</h3></div>
        <div class="panel-body">
            <?php if ($error): ?>
                <div style="background: #ffebe6; color: #bf2600; padding: 10px; margin-bottom: 15px; border: 1px solid #ff5630; font-size: 0.85rem;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" required placeholder="admin@devtrack.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-primary full-width">Ingresar</button>
            </form>
        </div>
    </div>
</body>
</html>