<div class="productos-contenedor">

    <?php
    $categorias = $categorias ?? [];
    $proveedores = $proveedores ?? [];
    $tipos_medicamento = $tipos_medicamento ?? [];
    $codigo_producto = $codigo_producto ?? '';
    ?>
    <h1>Productos</h1>

    <?php if (isset($_GET['orden']) && $_GET['orden'] === 'ok'): ?>
        <div class="alerta-exito-orden">
            Orden realizada con éxito
        </div>
    <?php endif; ?>
    <div class="productos-alertas">
        <div class="producto-alerta alerta-bajo-stock" id="btnBajoStock">
            <h3>Bajo stock</h3>
            <p><?= $bajo_stock['total'] ?? 0 ?></p>
        </div>

        <div class="producto-alerta alerta-por-vencer" id="btnPorVencer">
            <h3>Por vencer</h3>
            <p><?= $por_vencer['total'] ?? 0 ?></p>
        </div>
    </div>

    <div class="productos-acciones-superiores">
        <button type="button" class="btn-agregar" id="btnAbrirModalProducto">Agregar producto</button>


        <button type="button" class="btn-ordenar" onclick="abrirModalOrdenProducto()">
            Ordenar Producto
        </button>
    </div>

    <div class="productos-categorias">
        <button type="button" class="btnCategoriaProducto" data-categoria="todos">
            Todos
        </button>

        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $categoria): ?>
                <button
                    type="button"
                    class="btnCategoriaProducto"
                    data-categoria="<?= $categoria['nombre_categoria'] ?>">
                    <?= $categoria['nombre_categoria'] ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="productos-tabla-contenedor">
        <table class="productos-tabla">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre del producto</th>
                    <th>Categoría</th>
                    <th>Unidades</th>
                    <th>Fecha de vencimiento</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody id="tablaProductos">
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr
                            data-categoria="<?= $producto['nombre_categoria'] ?>"
                            data-stock="<?= $producto['stock_actual'] ?? 0 ?>"
                            data-vencimiento="<?= $producto['fecha_vencimiento'] ?>">
                            <td><?= $producto['codigo_producto'] ?></td>
                            <td><?= $producto['nombre_producto'] ?></td>
                            <td><?= $producto['nombre_categoria'] ?></td>
                            <td><?= $producto['stock_actual'] ?? 0 ?></td>
                            <td><?= $producto['fecha_vencimiento'] ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-editar btnEditarProducto"
                                    data-id="<?= $producto['id_producto'] ?>"
                                    data-codigo="<?= htmlspecialchars($producto['codigo_producto']) ?>"
                                    data-nombre="<?= htmlspecialchars($producto['nombre_producto']) ?>"
                                    data-categoria="<?= $producto['id_categoria'] ?>"
                                    data-tipo="<?= $producto['id_tipo_medicamento'] ?? '' ?>"
                                    data-proveedor="<?= $producto['id_proveedor'] ?>"
                                    data-laboratorio="<?= htmlspecialchars($producto['laboratorio'] ?? '') ?>"
                                    data-presentacion="<?= htmlspecialchars($producto['presentacion'] ?? '') ?>"
                                    data-precio="<?= $producto['precio_venta'] ?? 0 ?>"
                                    data-vencimiento="<?= $producto['fecha_vencimiento'] ?>"
                                    data-stock="<?= $producto['stock_actual'] ?? 0 ?>"
                                    data-stock-minimo="<?= $producto['stock_minimo'] ?? 0 ?>">
                                    Editar
                                </button>

                                <button
                                    type="button"
                                    class="btn-eliminar btn-abrir-modal-eliminar"
                                    data-id="<?= $producto['id_producto']; ?>"
                                    data-nombre="<?= htmlspecialchars($producto['nombre_producto']); ?>">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL AGREGAR PRODUCTO -->
<div class="modal-producto" id="modalAgregarProducto">
    <div class="modal-producto-contenido">

        <div class="modal-producto-header">
            <h2>Agregar producto</h2>
            <button type="button" class="modal-producto-cerrar" id="btnCerrarModalProducto">&times;</button>
        </div>

        <form id="formAgregarProducto" method="POST" action="/farmaplus/productos/guardar">
            <div class="form-producto-grid">

                <div class="form-grupo">
                    <label>Código del producto</label>
                    <input
                        type="text"
                        name="codigo_producto"
                        value="<?= htmlspecialchars($codigo_producto ?? '') ?>"
                        readonly>
                </div>

                <div class="form-grupo">
                    <label>Nombre del producto</label>
                    <input
                        type="text"
                        name="nombre_producto"
                        placeholder="Ejemplo: Paracetamol 500mg"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Categoría</label>
                    <select name="id_categoria" id="selectCategoriaProducto" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option
                                value="<?= $categoria['id_categoria'] ?>"
                                data-nombre="<?= htmlspecialchars($categoria['nombre_categoria']) ?>">
                                <?= htmlspecialchars($categoria['nombre_categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo" id="grupoTipoMedicamento" style="display: none;">
                    <label>Tipo de medicamento</label>
                    <select name="id_tipo_medicamento" id="selectTipoMedicamento">
                        <option value="">Seleccione un tipo</option>
                        <?php foreach ($tipos_medicamento as $tipo): ?>
                            <option value="<?= $tipo['id_tipo_medicamento'] ?>">
                                <?= htmlspecialchars($tipo['nombre_tipo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo">
                    <label>Proveedor</label>
                    <select name="id_proveedor" required>
                        <option value="">Seleccione un proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <option value="<?= $proveedor['id_proveedor'] ?>">
                                <?= htmlspecialchars($proveedor['razon_social']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo">
                    <label>Laboratorio</label>
                    <input
                        type="text"
                        name="laboratorio"
                        placeholder="Ejemplo: Genfar">
                </div>

                <div class="form-grupo">
                    <label>Presentación</label>
                    <input
                        type="text"
                        name="presentacion"
                        placeholder="Ejemplo: Caja x 10 tabletas">
                </div>


                <div class="form-grupo">
                    <label>Precio venta</label>
                    <input
                        type="number"
                        name="precio_venta"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        required>
                </div>


                <div class="form-grupo">
                    <label>Fecha de vencimiento</label>
                    <input
                        type="date"
                        name="fecha_vencimiento"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Stock actual</label>
                    <input
                        type="number"
                        name="stock_actual"
                        min="0"
                        placeholder="Ejemplo: 20"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Stock mínimo</label>
                    <input
                        type="number"
                        name="stock_minimo"
                        min="0"
                        placeholder="Ejemplo: 3"
                        required>
                </div>



            </div>

            <div class="modal-producto-footer">
                <button type="button" class="btn-cancelar-modal" id="btnCancelarModalProducto">Cancelar</button>
                <button type="submit" class="btn-guardar-modal">Guardar producto</button>
            </div>

        </form>
    </div>
</div>

<!-- MODAL EDITAR PRODUCTO -->
<div class="modal-producto" id="modalEditarProducto">
    <div class="modal-producto-contenido">

        <div class="modal-producto-header">
            <h2>Editar producto</h2>
            <button type="button" class="modal-producto-cerrar" id="btnCerrarModalEditarProducto">&times;</button>
        </div>

        <form id="formEditarProducto" method="POST" action="/farmaplus/productos/actualizar">

            <input type="hidden" name="id_producto" id="editar_id_producto">

            <div class="form-producto-grid">

                <div class="form-grupo">
                    <label>Código del producto</label>
                    <input
                        type="text"
                        name="codigo_producto"
                        id="editar_codigo_producto"
                        readonly>
                </div>

                <div class="form-grupo">
                    <label>Nombre del producto</label>
                    <input
                        type="text"
                        name="nombre_producto"
                        id="editar_nombre_producto"
                        placeholder="Ejemplo: Paracetamol 500mg"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Categoría</label>
                    <select name="id_categoria" id="editar_id_categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option
                                value="<?= $categoria['id_categoria'] ?>"
                                data-nombre="<?= htmlspecialchars($categoria['nombre_categoria']) ?>">
                                <?= htmlspecialchars($categoria['nombre_categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo" id="grupoEditarTipoMedicamento" style="display: none;">
                    <label>Tipo de medicamento</label>
                    <select name="id_tipo_medicamento" id="editar_id_tipo_medicamento">
                        <option value="">Seleccione un tipo</option>
                        <?php foreach ($tipos_medicamento as $tipo): ?>
                            <option value="<?= $tipo['id_tipo_medicamento'] ?>">
                                <?= htmlspecialchars($tipo['nombre_tipo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo">
                    <label>Proveedor</label>
                    <select name="id_proveedor" id="editar_id_proveedor" required>
                        <option value="">Seleccione un proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <option value="<?= $proveedor['id_proveedor'] ?>">
                                <?= htmlspecialchars($proveedor['razon_social']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo">
                    <label>Laboratorio</label>
                    <input
                        type="text"
                        name="laboratorio"
                        id="editar_laboratorio"
                        placeholder="Ejemplo: Genfar">
                </div>

                <div class="form-grupo">
                    <label>Presentación</label>
                    <input
                        type="text"
                        name="presentacion"
                        id="editar_presentacion"
                        placeholder="Ejemplo: Caja x 10 tabletas">
                </div>

                <div class="form-grupo">
                    <label>Precio venta</label>
                    <input
                        type="number"
                        name="precio_venta"
                        id="editar_precio_venta"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Fecha de vencimiento</label>
                    <input
                        type="date"
                        name="fecha_vencimiento"
                        id="editar_fecha_vencimiento"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Stock actual</label>
                    <input
                        type="number"
                        name="stock_actual"
                        id="editar_stock_actual"
                        min="0"
                        placeholder="Ejemplo: 20"
                        required>
                </div>

                <div class="form-grupo">
                    <label>Stock mínimo</label>
                    <input
                        type="number"
                        name="stock_minimo"
                        id="editar_stock_minimo"
                        min="0"
                        placeholder="Ejemplo: 3"
                        required>
                </div>

            </div>

            <div class="modal-producto-footer">
                <button type="button" class="btn-cancelar-modal" id="btnCancelarModalEditarProducto">Cancelar</button>
                <button type="submit" class="btn-guardar-modal">Actualizar producto</button>
            </div>

        </form>
    </div>
</div>

<!-- MODAL ELIMINAR PRODUCTO -->
<div id="modalEliminarProducto" class="modal-producto">
    <div class="modal-contenido-producto modal-eliminar-producto">

        <span class="cerrar-modal" id="cerrarModalEliminar">&times;</span>

        <h2>Eliminar producto</h2>

        <p>
            ¿Estás seguro de que deseas eliminar el producto
            <strong id="nombreProductoEliminar"></strong>?
        </p>

        <p class="texto-advertencia">
            Esta acción no borrará el producto de la base de datos, solo lo ocultará del sistema.
        </p>

        <form action="/farmaplus/productos/eliminar" method="POST">
            <input type="hidden" name="id_producto" id="idProductoEliminar">

            <div class="acciones-modal">
                <button type="button" class="btn-cancelar" id="cancelarEliminarProducto">
                    Cancelar
                </button>

                <button type="submit" class="btn-confirmar-eliminar">
                    Sí, eliminar
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Ordenar Producto -->
<div id="modalOrdenProducto" class="modal">
    <div class="modal-content">
        <h2>Ordenar Producto</h2>

        <form action="/farmaplus/productos/ordenar" method="POST">

            <div class="form-group">
                <label for="orden_id_categoria">Categoría</label>
                <select name="id_categoria" id="orden_id_categoria" required>
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria'] ?>">
                            <?= $categoria['nombre_categoria'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" id="grupo_tipo_medicamento_orden" style="display: none;">
                <label for="orden_id_tipo_medicamento">Tipo de medicamento</label>
                <select name="id_tipo_medicamento" id="orden_id_tipo_medicamento">
                    <option value="">Seleccione tipo de medicamento</option>
                    <?php foreach ($tipos_medicamento as $tipo): ?>
                        <option value="<?= $tipo['id_tipo_medicamento'] ?>">
                            <?= $tipo['nombre_tipo'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="orden_id_proveedor">Proveedor</label>
                <select name="id_proveedor" id="orden_id_proveedor" required>
                    <option value="">Seleccione un proveedor</option>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option
                            value="<?= $proveedor['id_proveedor'] ?>"
                            data-categoria="<?= $proveedor['id_categoria'] ?>"
                            data-correo="<?= $proveedor['correo'] ?>">
                            <?= $proveedor['razon_social'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="orden_correo_proveedor">Correo del proveedor</label>
                <input type="email" name="correo_proveedor" id="orden_correo_proveedor" readonly required>
            </div>

            <div class="form-group">
                <label for="orden_nombre_producto">Producto o medicina solicitada</label>
                <input type="text" name="nombre_producto" id="orden_nombre_producto" required>
            </div>

            <div class="form-group">
                <label for="orden_cantidad_solicitada">Cantidad solicitada</label>
                <input type="number" name="cantidad_solicitada" id="orden_cantidad_solicitada" min="1" required>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancelar" onclick="cerrarModalOrdenProducto()">Cancelar</button>
                <button type="submit" class="btn-guardar">Solicitar</button>
            </div>

        </form>
    </div>
</div>
<script>
    const botonesCategoriaProducto = document.querySelectorAll('.btnCategoriaProducto');
    const filasProductos = document.querySelectorAll('#tablaProductos tr');
    const btnBajoStock = document.getElementById('btnBajoStock');
    const btnPorVencer = document.getElementById('btnPorVencer');

    botonesCategoriaProducto.forEach(function(boton) {
        boton.addEventListener('click', function() {
            const categoriaSeleccionada = this.dataset.categoria;

            filasProductos.forEach(function(fila) {
                const categoriaFila = fila.dataset.categoria;

                if (categoriaSeleccionada === 'todos' || categoriaFila === categoriaSeleccionada) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });

    btnBajoStock.addEventListener('click', function() {
        filasProductos.forEach(function(fila) {
            const stock = parseInt(fila.dataset.stock);

            if (stock < 3) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    btnPorVencer.addEventListener('click', function() {
        const hoy = new Date();
        const limite = new Date();
        limite.setDate(hoy.getDate() + 30);

        filasProductos.forEach(function(fila) {
            const fechaTexto = fila.dataset.vencimiento;

            if (!fechaTexto) {
                fila.style.display = 'none';
                return;
            }

            const fechaVencimiento = new Date(fechaTexto);

            if (fechaVencimiento >= hoy && fechaVencimiento <= limite) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    const btnAbrirModalProducto = document.getElementById('btnAbrirModalProducto');
    const modalAgregarProducto = document.getElementById('modalAgregarProducto');
    const btnCerrarModalProducto = document.getElementById('btnCerrarModalProducto');
    const btnCancelarModalProducto = document.getElementById('btnCancelarModalProducto');

    const selectCategoriaProducto = document.getElementById('selectCategoriaProducto');
    const grupoTipoMedicamento = document.getElementById('grupoTipoMedicamento');
    const selectTipoMedicamento = document.getElementById('selectTipoMedicamento');

    if (btnAbrirModalProducto && modalAgregarProducto) {
        btnAbrirModalProducto.addEventListener('click', function() {
            modalAgregarProducto.classList.add('activo');
        });
    }

    if (btnCerrarModalProducto && modalAgregarProducto) {
        btnCerrarModalProducto.addEventListener('click', function() {
            modalAgregarProducto.classList.remove('activo');
        });
    }

    if (btnCancelarModalProducto && modalAgregarProducto) {
        btnCancelarModalProducto.addEventListener('click', function() {
            modalAgregarProducto.classList.remove('activo');
        });
    }

    if (modalAgregarProducto) {
        modalAgregarProducto.addEventListener('click', function(event) {
            if (event.target === modalAgregarProducto) {
                modalAgregarProducto.classList.remove('activo');
            }
        });
    }

    if (selectCategoriaProducto && grupoTipoMedicamento && selectTipoMedicamento) {
        selectCategoriaProducto.addEventListener('change', function() {
            const opcionSeleccionada = selectCategoriaProducto.options[selectCategoriaProducto.selectedIndex];
            const nombreCategoria = opcionSeleccionada.getAttribute('data-nombre');

            if (nombreCategoria === 'Medicamentos') {
                grupoTipoMedicamento.style.display = 'block';
                selectTipoMedicamento.setAttribute('required', 'required');
            } else {
                grupoTipoMedicamento.style.display = 'none';
                selectTipoMedicamento.removeAttribute('required');
                selectTipoMedicamento.value = '';
            }
        });
    }

    const modalEditarProducto = document.getElementById('modalEditarProducto');
    const btnCerrarModalEditarProducto = document.getElementById('btnCerrarModalEditarProducto');
    const btnCancelarModalEditarProducto = document.getElementById('btnCancelarModalEditarProducto');

    const editarIdProducto = document.getElementById('editar_id_producto');
    const editarCodigoProducto = document.getElementById('editar_codigo_producto');
    const editarNombreProducto = document.getElementById('editar_nombre_producto');
    const editarCategoria = document.getElementById('editar_id_categoria');
    const editarTipoMedicamento = document.getElementById('editar_id_tipo_medicamento');
    const editarProveedor = document.getElementById('editar_id_proveedor');
    const editarLaboratorio = document.getElementById('editar_laboratorio');
    const editarPresentacion = document.getElementById('editar_presentacion');
    const editarPrecioVenta = document.getElementById('editar_precio_venta');
    const editarFechaVencimiento = document.getElementById('editar_fecha_vencimiento');
    const editarStockActual = document.getElementById('editar_stock_actual');
    const editarStockMinimo = document.getElementById('editar_stock_minimo');
    const grupoEditarTipoMedicamento = document.getElementById('grupoEditarTipoMedicamento');

    document.querySelectorAll('.btnEditarProducto').forEach(function(boton) {
        boton.addEventListener('click', function() {

            editarIdProducto.value = boton.dataset.id || '';
            editarCodigoProducto.value = boton.dataset.codigo || '';
            editarNombreProducto.value = boton.dataset.nombre || '';
            editarCategoria.value = boton.dataset.categoria || '';
            editarTipoMedicamento.value = boton.dataset.tipo || '';
            editarProveedor.value = boton.dataset.proveedor || '';
            editarLaboratorio.value = boton.dataset.laboratorio || '';
            editarPresentacion.value = boton.dataset.presentacion || '';
            editarPrecioVenta.value = boton.dataset.precio || '';
            editarFechaVencimiento.value = boton.dataset.vencimiento || '';
            editarStockActual.value = boton.dataset.stock || '';
            editarStockMinimo.value = boton.dataset.stockMinimo || '';

            const opcionCategoria = editarCategoria.options[editarCategoria.selectedIndex];
            const nombreCategoria = opcionCategoria ? opcionCategoria.getAttribute('data-nombre') : '';

            if (nombreCategoria === 'Medicamentos') {
                grupoEditarTipoMedicamento.style.display = 'block';
                editarTipoMedicamento.setAttribute('required', 'required');
            } else {
                grupoEditarTipoMedicamento.style.display = 'none';
                editarTipoMedicamento.removeAttribute('required');
                editarTipoMedicamento.value = '';
            }

            modalEditarProducto.classList.add('activo');
        });
    });

    if (btnCerrarModalEditarProducto && modalEditarProducto) {
        btnCerrarModalEditarProducto.addEventListener('click', function() {
            modalEditarProducto.classList.remove('activo');
        });
    }

    if (btnCancelarModalEditarProducto && modalEditarProducto) {
        btnCancelarModalEditarProducto.addEventListener('click', function() {
            modalEditarProducto.classList.remove('activo');
        });
    }

    if (modalEditarProducto) {
        modalEditarProducto.addEventListener('click', function(event) {
            if (event.target === modalEditarProducto) {
                modalEditarProducto.classList.remove('activo');
            }
        });
    }

    if (editarCategoria && grupoEditarTipoMedicamento && editarTipoMedicamento) {
        editarCategoria.addEventListener('change', function() {
            const opcionSeleccionada = editarCategoria.options[editarCategoria.selectedIndex];
            const nombreCategoria = opcionSeleccionada.getAttribute('data-nombre');

            if (nombreCategoria === 'Medicamentos') {
                grupoEditarTipoMedicamento.style.display = 'block';
                editarTipoMedicamento.setAttribute('required', 'required');
            } else {
                grupoEditarTipoMedicamento.style.display = 'none';
                editarTipoMedicamento.removeAttribute('required');
                editarTipoMedicamento.value = '';
            }
        });
    }

    // MODAL ELIMINAR PRODUCTO
    const modalEliminarProducto = document.getElementById('modalEliminarProducto');
    const botonesAbrirModalEliminar = document.querySelectorAll('.btn-abrir-modal-eliminar');
    const cerrarModalEliminar = document.getElementById('cerrarModalEliminar');
    const cancelarEliminarProducto = document.getElementById('cancelarEliminarProducto');
    const idProductoEliminar = document.getElementById('idProductoEliminar');
    const nombreProductoEliminar = document.getElementById('nombreProductoEliminar');

    botonesAbrirModalEliminar.forEach(function(boton) {
        boton.addEventListener('click', function() {
            const id = boton.getAttribute('data-id');
            const nombre = boton.getAttribute('data-nombre');

            idProductoEliminar.value = id;
            nombreProductoEliminar.textContent = nombre;

            modalEliminarProducto.classList.add('activo');
        });
    });

    if (cerrarModalEliminar && modalEliminarProducto) {
        cerrarModalEliminar.addEventListener('click', function() {
            modalEliminarProducto.classList.remove('activo');
        });
    }

    if (cancelarEliminarProducto && modalEliminarProducto) {
        cancelarEliminarProducto.addEventListener('click', function() {
            modalEliminarProducto.classList.remove('activo');
        });
    }

    if (modalEliminarProducto) {
        modalEliminarProducto.addEventListener('click', function(event) {
            if (event.target === modalEliminarProducto) {
                modalEliminarProducto.classList.remove('activo');
            }
        });
    }

    const btnAbrirModalOrden = document.getElementById('btnAbrirModalOrden');
    const modalOrdenProducto = document.getElementById('modalOrdenProducto');
    const btnCancelarOrden = document.getElementById('btnCancelarOrden');

    const ordenCategoria = document.getElementById('orden_id_categoria');
    const grupoTipoMedicamentoOrden = document.getElementById('grupo_tipo_medicamento_orden');
    const ordenTipoMedicamento = document.getElementById('orden_id_tipo_medicamento');

    const ordenProveedor = document.getElementById('orden_id_proveedor');
    const ordenCorreoProveedor = document.getElementById('orden_correo_proveedor');

    if (btnAbrirModalOrden && modalOrdenProducto) {
        btnAbrirModalOrden.addEventListener('click', function() {
            modalOrdenProducto.classList.add('show');
        });
    }

    if (btnCancelarOrden && modalOrdenProducto) {
        btnCancelarOrden.addEventListener('click', function() {
            modalOrdenProducto.classList.remove('show');
        });
    }

    if (ordenCategoria) {
        ordenCategoria.addEventListener('change', function() {
            const categoriaSeleccionada = this.value;
            const categoriaTexto = this.options[this.selectedIndex].text.trim();

            ordenProveedor.value = '';
            ordenCorreoProveedor.value = '';

            Array.from(ordenProveedor.options).forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }

                if (option.dataset.categoria === categoriaSeleccionada) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });

            if (categoriaTexto === 'Medicamentos') {
                grupoTipoMedicamentoOrden.style.display = 'block';
                ordenTipoMedicamento.setAttribute('required', 'required');
            } else {
                grupoTipoMedicamentoOrden.style.display = 'none';
                ordenTipoMedicamento.removeAttribute('required');
                ordenTipoMedicamento.value = '';
            }
        });
    }

    if (ordenProveedor) {
        ordenProveedor.addEventListener('change', function() {
            const correo = this.options[this.selectedIndex].dataset.correo || '';
            ordenCorreoProveedor.value = correo;
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnAbrirModalOrden = document.getElementById('btnAbrirModalOrden');
        const modalOrdenProducto = document.getElementById('modalOrdenProducto');
        const btnCancelarOrden = document.getElementById('btnCancelarOrden');

        if (btnAbrirModalOrden && modalOrdenProducto) {
            btnAbrirModalOrden.addEventListener('click', function() {
                modalOrdenProducto.style.display = 'flex';
            });
        }

        if (btnCancelarOrden && modalOrdenProducto) {
            btnCancelarOrden.addEventListener('click', function() {
                modalOrdenProducto.style.display = 'none';
            });
        }
    });
</script>
<script>
    function abrirModalOrdenProducto() {
        const modal = document.getElementById('modalOrdenProducto');

        if (modal) {
            modal.style.display = 'flex';
            modal.classList.add('show');
        } else {
            alert('No se encontró el modal Ordenar Producto');
        }
    }

    function cerrarModalOrdenProducto() {
        const modal = document.getElementById('modalOrdenProducto');

        if (modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    }
</script>