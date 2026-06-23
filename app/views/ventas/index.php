<div class="ventas-container">

    <div class="ventas-left">

        <div class="card">
            <h2>Buscar medicamento</h2>

            <div class="search-box">
                <input type="text" id="buscarMedicamento" placeholder="Digite el medicamento requerido">
                <button id="btnBuscarMedicamento">Buscar</button>
            </div>
        </div>

        <div class="card">
            <h2>Resultados de búsqueda</h2>

            <table class="ventas-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Unidades</th>
                        <th>Vencimiento</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tablaResultados">
                    <tr>
                        <td colspan="8">Ingrese un medicamento y presione Buscar.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Medicamentos recomendados</h2>

            <table class="ventas-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Unidades</th>
                        <th>Vencimiento</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tablaRecomendados">
                    <tr>
                        <td colspan="8">Los recomendados aparecerán después de buscar.</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="ventas-right">

        <div class="card panel-venta">
            <h2>Panel de venta</h2>

            <div id="panelVacio">
                <p>No hay medicamento seleccionado.</p>
            </div>

            <div id="panelProducto" style="display: none;">
                <div class="producto-seleccionado">
                    <p class="label">Medicamento seleccionado:</p>
                    <h3 id="nombreSeleccionado"></h3>
                    <p>Precio unitario: S/ <span id="precioSeleccionado">0.00</span></p>
                </div>

                <div class="cantidad-control">
                    <button id="btnMenos">-</button>
                    <span id="cantidadSeleccionada">1</span>
                    <button id="btnMas">+</button>
                </div>

                <div class="total-box">
                    <p>Total:</p>
                    <h3>S/ <span id="totalVenta">0.00</span></h3>
                </div>

                <div class="pago-box">
                    <p>¿Se realizó el pago?</p>

                    <label>
                        <input type="radio" name="pago" value="si"> Sí
                    </label>

                    <label>
                        <input type="radio" name="pago" value="no"> No
                    </label>
                </div>

                <button class="btn-success" id="btnEfectuarCompra" disabled>Efectuar compra</button>
                <button class="btn-danger" id="btnCancelarVenta" disabled>Cancelar venta</button>
            </div>
        </div>

    </div>

</div>

<div class="modal-overlay" id="modalCliente">
    <div class="modal-box">
        <h2>Datos del cliente</h2>

        <label>DNI</label>
        <input type="text" id="dniCliente" placeholder="Ingrese DNI">

        <label>Nombres y apellidos</label>
        <input type="text" id="nombreCliente" placeholder="Ingrese nombres y apellidos">

        <div class="modal-buttons">
            <button class="btn-success" id="btnImprimirComprobante">Imprimir comprobante</button>
            <button class="btn-secondary" id="btnRegistrarSinImprimir">Registrar venta sin imprimir</button>
        </div>
    </div>
</div>

<div class="toast-message" id="toastMensaje"></div>