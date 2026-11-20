<?php
require 'includes/auth_guard.php';
require 'config/conexion.php';

$stmt = $pdo->query("SELECT * FROM proyectos WHERE estado = 1 ORDER BY id DESC");
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalActivos = count($proyectos);
$completados = 0;
$sumaProgreso = 0;

foreach ($proyectos as $p) {
    $sumaProgreso += intval($p['progreso']);
    if (intval($p['progreso']) === 100) {
        $completados++;
    }
}

$promedioAvance = $totalActivos > 0 ? round($sumaProgreso / $totalActivos) : 0;

$stmtInactivos = $pdo->query("SELECT COUNT(*) FROM proyectos WHERE estado = 0");
$totalDesactivados = $stmtInactivos->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack | Reportes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <h1>Reportes y Estadísticas</h1>
            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="font-weight: bold; font-size: 0.85rem; color: #5e6c84;">
                    FECHA DEL SISTEMA: <span id="fecha-actual">Cargando...</span>
                </div>
                <span style="font-weight: bold; font-size: 0.85rem; color: #0052cc;">
                    USUARIO: <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                </span>
                <a href="logout.php" class="btn-secondary" style="text-decoration: none;">Cerrar Sesión</a>
            </div>
        </header>

        <div class="dashboard-grid">
            <section class="panel">
                <div class="panel-header">
                    <h3>Progreso de Proyectos Activos</h3>
                </div>
                <div class="panel-body">
                    <?php if ($totalActivos === 0): ?>
                        <p style="color: #5e6c84;">No hay proyectos activos para mostrar métricas.</p>
                    <?php else: ?>
                        <?php foreach ($proyectos as $p): 
                            $prog = intval($p['progreso']);
                            $colorBarra = '#ff991f'; // Naranja por defecto
                            if ($prog === 100) {
                                $colorBarra = '#0052cc'; // Azul completado
                            } elseif ($prog >= 60) {
                                $colorBarra = '#36b37e'; // Verde avance alto
                            }
                        ?>
                            <p style="margin-bottom: 10px;">
                                <strong><?= htmlspecialchars($p['nombre']) ?></strong> 
                                <span style="font-size: 0.8rem; color: #5e6c84;">(<?= strtoupper(htmlspecialchars($p['tecnologia'])) ?>)</span>
                            </p>
                            <div style="width: 100%; background-color: #ebecf0; height: 20px; margin-bottom: 20px;">
                                <div style="width: <?= $prog ?>%; background-color: <?= $colorBarra ?>; height: 100%; text-align: center; color: white; font-size: 0.75rem; font-weight: bold; line-height: 20px; min-width: 28px;">
                                    <?= $prog ?>%
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
            
            <aside class="panel">
                <div class="panel-header">
                    <h3>Resumen General</h3>
                </div>
                <div class="panel-body">
                    <div style="margin-bottom: 15px; padding: 15px; background-color: #fafbfc; border: 1px solid #dfe1e6;">
                        <h4 style="color: #5e6c84; font-size: 0.8rem; text-transform: uppercase;">Proyectos Activos</h4>
                        <p style="font-size: 2rem; font-weight: bold; color: #172b4d;"><?= $totalActivos ?></p>
                    </div>
                    <div style="margin-bottom: 15px; padding: 15px; background-color: #fafbfc; border: 1px solid #dfe1e6;">
                        <h4 style="color: #5e6c84; font-size: 0.8rem; text-transform: uppercase;">Proyectos Completados</h4>
                        <p style="font-size: 2rem; font-weight: bold; color: #36b37e;"><?= $completados ?></p>
                    </div>
                    <div style="margin-bottom: 15px; padding: 15px; background-color: #fafbfc; border: 1px solid #dfe1e6;">
                        <h4 style="color: #5e6c84; font-size: 0.8rem; text-transform: uppercase;">Avance Promedio Global</h4>
                        <p style="font-size: 2rem; font-weight: bold; color: #0052cc;"><?= $promedioAvance ?>%</p>
                    </div>
                    <div style="padding: 15px; background-color: #fafbfc; border: 1px solid #dfe1e6;">
                        <h4 style="color: #5e6c84; font-size: 0.8rem; text-transform: uppercase;">Proyectos Desactivados</h4>
                        <p style="font-size: 2rem; font-weight: bold; color: #ff5630;"><?= $totalDesactivados ?></p>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
