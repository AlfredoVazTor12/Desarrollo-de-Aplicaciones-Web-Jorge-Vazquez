<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <div class="sidebar-header"><h2>DevTrack</h2></div>
    <ul class="nav-links">
        <li><a href="index.php" class="<?= $pagina_actual === 'index.php' ? 'active' : '' ?>">Dashboard General</a></li>
        <li><a href="repositorios.php" class="<?= $pagina_actual === 'repositorios.php' ? 'active' : '' ?>">Repositorios</a></li>
        <li><a href="reportes.php" class="<?= $pagina_actual === 'reportes.php' ? 'active' : '' ?>">Reportes</a></li>
    </ul>
</aside>
