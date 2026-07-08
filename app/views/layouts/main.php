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

            <?php
            $idRolSesion = $_SESSION['usuario']['id_rol'] ?? null;
            ?>

            <nav class="sidebar-menu">

                <?php if ($idRolSesion == 1): ?>
                    <a href="index.php?url=/" class="<?= $urlActual == '/' ? 'active' : '' ?>">Inicio</a>
                    <a href="index.php?url=productos" class="<?= $urlActual == 'productos' ? 'active' : '' ?>">Productos</a>
                    <a href="index.php?url=ventas" class="<?= $urlActual == 'ventas' ? 'active' : '' ?>">Ventas</a>
                    <a href="index.php?url=proveedores" class="<?= $urlActual == 'proveedores' ? 'active' : '' ?>">Proveedores</a>
                    <a href="index.php?url=usuarios" class="<?= $urlActual == 'usuarios' ? 'active' : '' ?>">Usuarios</a>
                <?php endif; ?>

                <?php if ($idRolSesion == 2): ?>
                    <a href="index.php?url=ventas" class="<?= $urlActual == 'ventas' ? 'active' : '' ?>">Ventas</a>
                <?php endif; ?>

                <?php if ($idRolSesion == 3): ?>
                    <a href="index.php?url=productos" class="<?= $urlActual == 'productos' ? 'active' : '' ?>">Productos</a>
                <?php endif; ?>

                <a href="index.php?url=logout" class="btn-salir">Salir</a>
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