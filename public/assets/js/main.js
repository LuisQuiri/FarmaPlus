document.addEventListener('DOMContentLoaded', function () {

    const medicamentos = [
        {
            codigo: 'ATB001',
            nombre: 'Azitromicina',
            categoria: 'Genérico',
            precio: 3.00,
            unidades: 30,
            vencimiento: '31/12/2027'
        },
        {
            codigo: 'ATB002',
            nombre: 'Ciprofloxacino',
            categoria: 'Genérico',
            precio: 2.80,
            unidades: 30,
            vencimiento: '30/11/2027'
        },
        {
            codigo: 'ATB003',
            nombre: 'Cefalexina',
            categoria: 'Sporidex',
            precio: 2.50,
            unidades: 5,
            vencimiento: '31/10/2027'
        }
    ];

    const inputBuscar = document.getElementById('buscarMedicamento');
    const btnBuscar = document.getElementById('btnBuscarMedicamento');
    const tablaResultados = document.getElementById('tablaResultados');
    const tablaRecomendados = document.getElementById('tablaRecomendados');

    const panelVacio = document.getElementById('panelVacio');
    const panelProducto = document.getElementById('panelProducto');
    const nombreSeleccionado = document.getElementById('nombreSeleccionado');
    const precioSeleccionado = document.getElementById('precioSeleccionado');
    const cantidadSeleccionada = document.getElementById('cantidadSeleccionada');
    const totalVenta = document.getElementById('totalVenta');

    const btnMenos = document.getElementById('btnMenos');
    const btnMas = document.getElementById('btnMas');
    const btnEfectuarCompra = document.getElementById('btnEfectuarCompra');
    const btnCancelarVenta = document.getElementById('btnCancelarVenta');

    const modalCliente = document.getElementById('modalCliente');
    const dniCliente = document.getElementById('dniCliente');
    const nombreCliente = document.getElementById('nombreCliente');
    const btnImprimirComprobante = document.getElementById('btnImprimirComprobante');
    const btnRegistrarSinImprimir = document.getElementById('btnRegistrarSinImprimir');
    const toastMensaje = document.getElementById('toastMensaje');

    let medicamentoSeleccionado = null;
    let cantidad = 1;

    if (!btnBuscar) {
        return;
    }

    btnBuscar.addEventListener('click', buscarMedicamento);

    inputBuscar.addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            buscarMedicamento();
        }
    });

    btnMas.addEventListener('click', function () {
        if (!medicamentoSeleccionado) return;

        if (cantidad < medicamentoSeleccionado.unidades) {
            cantidad++;
            actualizarTotal();
        }
    });

    btnMenos.addEventListener('click', function () {
        if (!medicamentoSeleccionado) return;

        if (cantidad > 1) {
            cantidad--;
            actualizarTotal();
        }
    });

    document.querySelectorAll('input[name="pago"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'si') {
                btnEfectuarCompra.disabled = false;
                btnCancelarVenta.disabled = true;
            }

            if (this.value === 'no') {
                btnEfectuarCompra.disabled = true;
                btnCancelarVenta.disabled = false;
            }
        });
    });

    btnEfectuarCompra.addEventListener('click', function () {
        modalCliente.style.display = 'flex';
    });

    btnCancelarVenta.addEventListener('click', function () {
        mostrarMensaje('Venta cancelada correctamente');
        limpiarFrame();
    });

    btnImprimirComprobante.addEventListener('click', finalizarCompra);
    btnRegistrarSinImprimir.addEventListener('click', finalizarCompra);

    function buscarMedicamento() {
        const texto = inputBuscar.value.trim().toLowerCase();

        if (texto === '') {
            tablaResultados.innerHTML = '<tr><td colspan="8">Debe ingresar un medicamento.</td></tr>';
            tablaRecomendados.innerHTML = '<tr><td colspan="8">Los recomendados aparecerán después de buscar.</td></tr>';
            return;
        }

        const resultados = medicamentos.filter(function (medicamento) {
            return medicamento.nombre.toLowerCase().includes(texto);
        });

        mostrarResultados(resultados);

        if (resultados.length > 0) {
            mostrarRecomendados(resultados[0]);
        } else {
            tablaRecomendados.innerHTML = '<tr><td colspan="8">No hay medicamentos recomendados.</td></tr>';
        }
    }

    function mostrarResultados(lista) {
        if (lista.length === 0) {
            tablaResultados.innerHTML = '<tr><td colspan="8">No se encontraron medicamentos.</td></tr>';
            return;
        }

        tablaResultados.innerHTML = '';

        lista.forEach(function (medicamento, index) {
            tablaResultados.innerHTML += crearFilaMedicamento(medicamento, index);
        });

        activarBotonesAgregar();
    }

    function mostrarRecomendados(medicamentoBuscado) {
        const recomendados = medicamentos.filter(function (medicamento) {
            return medicamento.codigo !== medicamentoBuscado.codigo;
        });

        tablaRecomendados.innerHTML = '';

        recomendados.forEach(function (medicamento, index) {
            tablaRecomendados.innerHTML += crearFilaMedicamento(medicamento, index);
        });

        activarBotonesAgregar();
    }

    function crearFilaMedicamento(medicamento, index) {
        return `
            <tr>
                <td>${index + 1}</td>
                <td>${medicamento.codigo}</td>
                <td>${medicamento.nombre}</td>
                <td>${medicamento.categoria}</td>
                <td>S/ ${medicamento.precio.toFixed(2)}</td>
                <td>${medicamento.unidades}</td>
                <td>${medicamento.vencimiento}</td>
                <td>
                    <button class="btn-small btn-agregar" data-codigo="${medicamento.codigo}">
                        Agregar
                    </button>
                </td>
            </tr>
        `;
    }

    function activarBotonesAgregar() {
        document.querySelectorAll('.btn-agregar').forEach(function (boton) {
            boton.addEventListener('click', function () {
                const codigo = this.getAttribute('data-codigo');

                medicamentoSeleccionado = medicamentos.find(function (medicamento) {
                    return medicamento.codigo === codigo;
                });

                cargarPanelVenta();
            });
        });
    }

    function cargarPanelVenta() {
        cantidad = 1;

        panelVacio.style.display = 'none';
        panelProducto.style.display = 'block';

        nombreSeleccionado.textContent = medicamentoSeleccionado.nombre;
        precioSeleccionado.textContent = medicamentoSeleccionado.precio.toFixed(2);

        document.querySelectorAll('input[name="pago"]').forEach(function (radio) {
            radio.checked = false;
        });

        btnEfectuarCompra.disabled = true;
        btnCancelarVenta.disabled = true;

        actualizarTotal();
    }

    function actualizarTotal() {
        cantidadSeleccionada.textContent = cantidad;

        const total = medicamentoSeleccionado.precio * cantidad;
        totalVenta.textContent = total.toFixed(2);
    }

    function finalizarCompra() {
        const dni = dniCliente.value.trim();
        const nombre = nombreCliente.value.trim();

        if (dni === '' || nombre === '') {
            mostrarMensaje('Debe completar DNI y nombres del cliente');
            return;
        }

        modalCliente.style.display = 'none';
        mostrarMensaje('Compra realizada exitosamente');

        limpiarFrame();
    }

    function limpiarFrame() {
        setTimeout(function () {
            inputBuscar.value = '';

            tablaResultados.innerHTML = '<tr><td colspan="8">Ingrese un medicamento y presione Buscar.</td></tr>';
            tablaRecomendados.innerHTML = '<tr><td colspan="8">Los recomendados aparecerán después de buscar.</td></tr>';

            panelVacio.style.display = 'block';
            panelProducto.style.display = 'none';

            medicamentoSeleccionado = null;
            cantidad = 1;

            dniCliente.value = '';
            nombreCliente.value = '';

            document.querySelectorAll('input[name="pago"]').forEach(function (radio) {
                radio.checked = false;
            });

            btnEfectuarCompra.disabled = true;
            btnCancelarVenta.disabled = true;
        }, 5000);
    }

    function mostrarMensaje(mensaje) {
        toastMensaje.textContent = mensaje;
        toastMensaje.style.display = 'block';

        setTimeout(function () {
            toastMensaje.style.display = 'none';
        }, 5000);
    }

});

document.addEventListener('DOMContentLoaded', function () {

    const btnNuevoUsuario = document.getElementById('btnNuevoUsuario');
    const modalUsuario = document.getElementById('modalUsuario');
    const btnGuardarUsuario = document.getElementById('btnGuardarUsuario');
    const formUsuario = document.getElementById('formUsuario');
    const idUsuario = document.getElementById('idUsuario');
    const btnCancelarUsuario = document.getElementById('btnCancelarUsuario');

    const usuarioNombres = document.getElementById('usuarioNombres');
    const usuarioApellidos = document.getElementById('usuarioApellidos');
    const usuarioTelefono = document.getElementById('usuarioTelefono');
    const usuarioCorreo = document.getElementById('usuarioCorreo');
    const usuarioLogin = document.getElementById('usuarioLogin');
    const usuarioRol = document.getElementById('usuarioRol');
    const usuarioEstado = document.getElementById('usuarioEstado');
    const usuarioPassword = document.getElementById('usuarioPassword');

    if (!btnNuevoUsuario) {
        return;
    }

    btnNuevoUsuario.addEventListener('click', function () {
        limpiarFormularioUsuario();
        formUsuario.action = '/farmaplus/index.php?url=usuarios/guardar';
        modalUsuario.style.display = 'flex';
    });

    document.querySelectorAll('.btn-edit').forEach(function (boton) {
        boton.addEventListener('click', function () {
            idUsuario.value = this.dataset.id;
            formUsuario.action = '/farmaplus/index.php?url=usuarios/actualizar';
            usuarioNombres.value = this.dataset.nombres;
            usuarioApellidos.value = this.dataset.apellidos;
            usuarioTelefono.value = this.dataset.telefono;
            usuarioCorreo.value = this.dataset.correo;
            usuarioLogin.value = this.dataset.usuario;
            if (this.dataset.rol === 'Administrador') {
                usuarioRol.value = '1';
            } else if (this.dataset.rol === 'Vendedor') {
                usuarioRol.value = '2';
            } else if (this.dataset.rol === 'Encargado de almacén') {
                usuarioRol.value = '3';
            }

            if (this.dataset.estado === 'Activo') {
                usuarioEstado.value = '1';
            } else {
                usuarioEstado.value = '0';
            }
            usuarioPassword.value = '';

            modalUsuario.style.display = 'flex';
        });
    });

    btnGuardarUsuario.addEventListener('click', function () {
        modalUsuario.style.display = 'none';
    });

    btnCancelarUsuario.addEventListener('click', function () {
        limpiarFormularioUsuario();
        modalUsuario.style.display = 'none';
    });

    modalUsuario.addEventListener('click', function (event) {
        if (event.target === modalUsuario) {
            limpiarFormularioUsuario();
            modalUsuario.style.display = 'none';
        }
    });

    function limpiarFormularioUsuario() {
        idUsuario.value = '';
        usuarioNombres.value = '';
        usuarioApellidos.value = '';
        usuarioTelefono.value = '';
        usuarioCorreo.value = '';
        usuarioLogin.value = '';
        usuarioRol.value = '';
        usuarioEstado.value = 'Activo';
        usuarioPassword.value = '';
    }

    const inputBuscarUsuario = document.getElementById('buscarUsuario');
    const btnBuscarUsuario = document.getElementById('btnBuscarUsuario');

    btnBuscarUsuario.addEventListener('click', function () {
        const texto = inputBuscarUsuario.value.trim().toLowerCase();
        const filas = document.querySelectorAll('.fila-usuario');

        filas.forEach(function (fila) {
            const apellido = fila.dataset.apellido;

            if (apellido.includes(texto)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });

    inputBuscarUsuario.addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            btnBuscarUsuario.click();
        }

        if (inputBuscarUsuario.value.trim() === '') {
            document.querySelectorAll('.fila-usuario').forEach(function (fila) {
                fila.style.display = '';
            });
        }
    });
});