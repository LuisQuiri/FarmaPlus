<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'FarmaPlus' ?></title>

    <link rel="stylesheet" href="/farmaplus/public/assets/css/style.css">
</head>
<body>

    <div class="app-container">

        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>FarmaPlus</h2>
                <p>Sistema de Botica</p>
            </div>

            <?php
$urlActual = $_GET['url'] ?? '/';
?>

<nav class="sidebar-menu">
    <a href="index.php?url=/" class="<?= $urlActual == '/' ? 'active' : '' ?>">Inicio</a>
    <a href="index.php?url=productos" class="<?= $urlActual == 'productos' ? 'active' : '' ?>">Productos</a>
    <a href="index.php?url=ventas" class="<?= $urlActual == 'ventas' ? 'active' : '' ?>">Ventas</a>
    <a href="index.php?url=clientes" class="<?= $urlActual == 'clientes' ? 'active' : '' ?>">Clientes</a>
    <a href="index.php?url=proveedores" class="<?= $urlActual == 'proveedores' ? 'active' : '' ?>">Proveedores</a>
    <a href="index.php?url=reportes" class="<?= $urlActual == 'reportes' ? 'active' : '' ?>">Reportes</a>
    <a href="index.php?url=usuarios" class="<?= $urlActual == 'usuarios' ? 'active' : '' ?>">Usuarios</a>
</nav>
        </aside>

        <main class="main-content">

            <header class="topbar">
                <h1><?= $title ?? 'FarmaPlus' ?></h1>
            </header>

            <section class="content">
                <?= $content ?>
            </section>

        </main>

    </div>

    <script src="/farmaplus/public/assets/js/main.js"></script>
</body>
</html>