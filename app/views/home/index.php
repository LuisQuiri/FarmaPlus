<?php
$title = $title ?? 'Dashboard';
$totalProductos = $totalProductos ?? ['total' => 0];
$totalVentas = $totalVentas ?? ['total' => 0];
$totalVendido = $totalVendido ?? ['total' => 0];
$bajoStock = $bajoStock ?? ['total' => 0];
$vencidos = $vencidos ?? ['total' => 0];
$porVencer = $porVencer ?? ['total' => 0];
$ordenesPendientes = $ordenesPendientes ?? ['total' => 0];
$ultimasVentas = $ultimasVentas ?? [];
?>
<section class="welcome-box">
    <h2><?= $title; ?></h2>
    <p>Resumen general del sistema FarmaPlus.</p>
</section>

<section class="dashboard-grid">

    <div class="dashboard-card">
        <h3>Productos activos</h3>
        <p><?= $totalProductos['total']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Ventas realizadas</h3>
        <p><?= $totalVentas['total']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Total vendido</h3>
        <p>S/ <?= number_format($totalVendido['total'], 2); ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Bajo stock</h3>
        <p><?= $bajoStock['total']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Productos vencidos</h3>
        <p><?= $vencidos['total']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Por vencer</h3>
        <p><?= $porVencer['total']; ?></p>
    </div>

    <div class="dashboard-card">
        <h3>Órdenes pendientes</h3>
        <p><?= $ordenesPendientes['total']; ?></p>
    </div>

</section>

<section class="dashboard-table-box">
    <h3>Últimas ventas</h3>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($ultimasVentas)): ?>
                <?php foreach ($ultimasVentas as $venta): ?>
                    <tr>
                        <td><?= $venta['id_venta']; ?></td>
                        <td><?= $venta['fecha_venta']; ?></td>
                        <td>S/ <?= number_format($venta['total'], 2); ?></td>
                        <td><?= $venta['estado']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay ventas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>