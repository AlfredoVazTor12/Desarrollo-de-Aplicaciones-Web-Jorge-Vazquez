<?php
require 'includes/auth_guard.php';
require 'config/conexion.php';

// READ: Consultar proyectos activos
$stmt = $pdo->query("SELECT * FROM proyectos WHERE estado = 1 ORDER BY id DESC");
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$etiquetasTecnologia = [
    'js'   => 'JavaScript / Node.js',
    'py'   => 'Python / Django',
    'java' => 'Java / Spring'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack | Repositorios</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <header class="topbar">
            <h1>Gestión de Repositorios</h1>
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

        <div class="full-grid">
            <section class="panel">
                <div class="panel-header">
                    <h3>Proyectos y Repositorios Activos (<?= count($proyectos) ?>)</h3>
                    <button class="btn-primary" onclick="location.reload()">Actualizar Lista</button>
                </div>
                <div class="panel-body" style="padding: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre del Proyecto</th>
                                <th>Tecnología</th>
                                <th>Líder Técnico</th>
                                <th>Visibilidad</th>
                                <th>Progreso / Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($proyectos) === 0): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 25px; color: #5e6c84;">
                                        No hay proyectos activos registrados. Crea uno desde el Dashboard General.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($proyectos as $p): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                                        <td>
                                            <span class="badge">
                                                <?= htmlspecialchars($etiquetasTecnologia[$p['tecnologia']] ?? strtoupper($p['tecnologia'])) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($p['email_lider']) ?></td>
                                        <td><?= $p['repo_publico'] ? 'Público' : 'Privado' ?></td>
                                        <td>
                                            <span class="badge <?= $p['progreso'] == 100 ? 'status-done' : 'status-dev' ?>">
                                                <?= $p['progreso'] == 100 ? 'COMPLETADO (100%)' : 'EN PROGRESO (' . intval($p['progreso']) . '%)' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn-secondary" onclick="editarProyecto(<?= $p['id'] ?>, '<?= htmlspecialchars($p['nombre'], ENT_QUOTES) ?>', '<?= htmlspecialchars($p['tecnologia'], ENT_QUOTES) ?>', <?= intval($p['progreso']) ?>)">
                                                Editar
                                            </button>
                                            <button class="btn-secondary" style="background-color: #ffebe6; color: #bf2600; border-color: #ff5630;" onclick="eliminarProyecto(<?= $p['id'] ?>)">
                                                Desactivar
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
