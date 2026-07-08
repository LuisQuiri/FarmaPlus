<?php
$proveedores = $proveedores ?? [];
$categorias = $categorias ?? [];

$total_proveedores = $total_proveedores ?? 0;
$ordenes_pendientes = $ordenes_pendientes ?? 0;
$envios_retraso = $envios_retraso ?? 0;
$lista_ordenes_pendientes = $lista_ordenes_pendientes ?? [];
?>

<div class="proveedores-contenedor">

    <h1>Proveedores</h1>

    <div class="proveedores-resumen">
        <div class="tarjeta-resumen">
            <h3>Total de proveedores</h3>
            <p><?= $total_proveedores ?></p>
        </div>

        <div class="tarjeta-resumen tarjeta-link" id="cardOrdenesPendientes" onclick="mostrarOrdenesPendientes()">
            <h3>Ordenes pendientes</h3>
            <p><?= $ordenes_pendientes ?></p>
        </div>


    </div>

    <div class="proveedores-barra">
        <input type="text" id="buscarProveedor" placeholder="Buscar proveedor por razón social...">

        <button type="button" id="btnNuevoProveedor">
            Nuevo proveedor
        </button>
    </div>

    <div class="proveedores-tabla-contenedor">
        <table class="proveedores-tabla">
            <thead>
                <tr>
                    <th>ID proveedor</th>
                    <th>Razón social</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Fecha</th>
                    <th>Categoría</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody id="tablaProveedores">
                <?php if (!empty($proveedores)): ?>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <tr>
                            <td><?= $proveedor['id_proveedor'] ?></td>
                            <td><?= $proveedor['razon_social'] ?></td>
                            <td><?= $proveedor['contacto'] ?></td>
                            <td><?= $proveedor['telefono'] ?></td>
                            <td><?= $proveedor['correo'] ?></td>
                            <td><?= $proveedor['fecha_creacion'] ?></td>
                            <td><?= $proveedor['categoria'] ?></td>
                            <td>
                                <button type="button" class="btn-editar btnEditarProveedor"
                                    data-id="<?= $proveedor['id_proveedor'] ?>"
                                    data-razon="<?= htmlspecialchars($proveedor['razon_social'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-contacto="<?= htmlspecialchars($proveedor['contacto'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-telefono="<?= htmlspecialchars($proveedor['telefono'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-correo="<?= htmlspecialchars($proveedor['correo'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-categoria="<?= htmlspecialchars($proveedor['categoria'], ENT_QUOTES, 'UTF-8') ?>"
                                    data-id-categoria="<?= $proveedor['id_categoria'] ?>">
                                    Editar
                                </button>

                                <button
                                    type="button"
                                    class="btn-eliminar btnEliminarProveedor"
                                    data-id="<?= $proveedor['id_proveedor'] ?>"
                                    data-razon="<?= $proveedor['razon_social'] ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay proveedores registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Órdenes Pendientes -->
<div id="modalOrdenesPendientes" class="modal-ordenes-pendientes">

    <div class="modal-ordenes-contenido">

        <div class="modal-ordenes-header">
            <h2>Órdenes pendientes</h2>
            <button type="button" class="btn-cerrar-ordenes" onclick="cerrarOrdenesPendientes()">×</button>
        </div>

        <div class="modal-ordenes-tabla">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Categoría</th>
                        <th>Tipo medicamento</th>
                        <th>Proveedor</th>
                        <th>Producto solicitado</th>
                        <th>Cantidad</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($lista_ordenes_pendientes)): ?>
                        <?php $contador = 1; ?>
                        <?php foreach ($lista_ordenes_pendientes as $orden): ?>
                            <tr>
                                <td><?= $contador++ ?></td>
                                <td><?= $orden['nombre_categoria'] ?></td>
                                <td><?= $orden['nombre_tipo'] ?? 'No aplica' ?></td>
                                <td><?= $orden['razon_social'] ?></td>
                                <td><?= $orden['nombre_producto'] ?></td>
                                <td><?= $orden['cantidad_solicitada'] ?></td>
                                <td><?= $orden['correo_proveedor'] ?></td>
                                <td><?= $orden['estado'] ?></td>
                                <td><?= $orden['fecha_orden'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No hay órdenes pendientes.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<div id="modalNuevoProveedor" class="modal-proveedor">
    <div class="modal-proveedor-contenido">

        <h2>Nuevo proveedor</h2>

        <form id="formNuevoProveedor" method="POST" action="index.php?url=proveedores/guardar">

            <label>Razón social</label>
            <input type="text" name="razon_social" required>

            <label>Contacto</label>
            <input type="text" name="contacto" required>

            <label>RUC</label>
            <input type="text" name="ruc" required>

            <label>Teléfono</label>
            <input type="text" name="telefono" required>

            <label>Correo</label>
            <input type="email" name="correo" required>

            <label>Categoría</label>
            <select name="id_categoria" id="id_categoria" required>
                <option value="">Seleccione una categoría</option>

                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>">
                        <?php echo htmlspecialchars($categoria['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Dirección</label>
            <input type="text" name="direccion" required>

            <div class="modal-proveedor-botones">
                <button type="submit" class="btn-guardar-proveedor">
                    Guardar
                </button>

                <button type="button" id="btnCancelarNuevoProveedor" class="btn-cancelar-proveedor">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</div>

<div id="modalEditarProveedor" class="modal-proveedor">
    <div class="modal-proveedor-contenido">

        <h2>Editar proveedor</h2>

        <form id="formEditarProveedor" method="POST" action="index.php?url=proveedores/actualizar">

            <input type="hidden" name="id_proveedor" id="editar_id_proveedor">

            <label>Razón social</label>
            <input type="text" name="razon_social" id="editar_razon_social" required>

            <label>Contacto</label>
            <input type="text" name="contacto" id="editar_contacto" required>

            <label>Teléfono</label>
            <input type="text" name="telefono" id="editar_telefono" required>

            <label>Correo</label>
            <input type="email" name="correo" id="editar_correo" required>

            <label>Categoría</label>

            <select name="id_categoria" id="editar_id_categoria" required>
                <option value="">Seleccione una categoría</option>

                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>">
                        <?php echo htmlspecialchars($categoria['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="modal-proveedor-botones">
                <button type="submit" class="btn-guardar-proveedor">
                    Guardar cambios
                </button>

                <button type="button" id="btnCancelarEditarProveedor" class="btn-cancelar-proveedor">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</div>

<div id="modalEliminarProveedor" class="modal-proveedor">
    <div class="modal-proveedor-contenido">

        <h2>Eliminar proveedor</h2>

        <p id="textoEliminarProveedor">
            ¿Está seguro de eliminar este proveedor?
        </p>

        <form method="POST" action="index.php?url=proveedores/eliminar">
            <input type="hidden" name="id_proveedor" id="eliminar_id_proveedor">

            <div class="modal-proveedor-botones">
                <button type="submit" class="btn-eliminar">
                    Sí, eliminar
                </button>

                <button type="button" id="btnCancelarEliminarProveedor" class="btn-cancelar-proveedor">
                    Cancelar
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    const btnNuevoProveedor = document.getElementById('btnNuevoProveedor');
    const modalNuevoProveedor = document.getElementById('modalNuevoProveedor');
    const btnCancelarNuevoProveedor = document.getElementById('btnCancelarNuevoProveedor');
    const modalEditarProveedor = document.getElementById('modalEditarProveedor');
    const btnCancelarEditarProveedor = document.getElementById('btnCancelarEditarProveedor');
    const botonesEditarProveedor = document.querySelectorAll('.btnEditarProveedor');
    const modalEliminarProveedor = document.getElementById('modalEliminarProveedor');
    const btnCancelarEliminarProveedor = document.getElementById('btnCancelarEliminarProveedor');
    const botonesEliminarProveedor = document.querySelectorAll('.btnEliminarProveedor');

    btnNuevoProveedor.addEventListener('click', function() {
        modalNuevoProveedor.style.display = 'flex';
    });

    btnCancelarNuevoProveedor.addEventListener('click', function() {
        modalNuevoProveedor.style.display = 'none';
    });

    botonesEditarProveedor.forEach(function(boton) {
        boton.addEventListener('click', function() {
            document.getElementById('editar_id_proveedor').value = this.dataset.id;
            document.getElementById('editar_razon_social').value = this.dataset.razon;
            document.getElementById('editar_contacto').value = this.dataset.contacto;
            document.getElementById('editar_telefono').value = this.dataset.telefono;
            document.getElementById('editar_correo').value = this.dataset.correo;
            document.getElementById('editar_id_categoria').value = this.dataset.idcategoria;

            modalEditarProveedor.style.display = 'flex';
        });
    });

    btnCancelarEditarProveedor.addEventListener('click', function() {
        modalEditarProveedor.style.display = 'none';
    });

    botonesEliminarProveedor.forEach(function(boton) {
        boton.addEventListener('click', function() {
            document.getElementById('eliminar_id_proveedor').value = this.dataset.id;
            document.getElementById('textoEliminarProveedor').textContent =
                '¿Está seguro de eliminar el proveedor "' + this.dataset.razon + '"?';

            modalEliminarProveedor.style.display = 'flex';
        });
    });

    btnCancelarEliminarProveedor.addEventListener('click', function() {
        modalEliminarProveedor.style.display = 'none';
    });
</script>
<script>
function mostrarOrdenesPendientes() {
    const modal = document.getElementById('modalOrdenesPendientes');

    if (modal) {
        modal.style.display = 'flex';
    } else {
        alert('No se encontró el modal de órdenes pendientes');
    }
}

function cerrarOrdenesPendientes() {
    const modal = document.getElementById('modalOrdenesPendientes');

    if (modal) {
        modal.style.display = 'none';
    }
}
</script>