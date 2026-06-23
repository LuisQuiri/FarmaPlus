<div class="usuarios-header">
    <div>
        <h2>Gestión de Usuarios</h2>
        <p>Administración de usuarios registrados en FarmaPlus</p>
    </div>

    <button class="btn-nuevo-usuario" id="btnNuevoUsuario">+ Nuevo usuario</button>
</div>

<div class="usuarios-cards">

    <div class="usuario-card">
        <p>Usuarios totales</p>
        <h3><?= $totalUsuarios ?></h3>
    </div>

    <div class="usuario-card">
        <p>Usuarios activos</p>
        <h3><?= $usuariosActivos ?></h3>
    </div>

    <div class="usuario-card roles-card">
        <p>Distribución de roles</p>

        <?php foreach ($distribucionRoles as $rol): ?>
        <span>
            <?= $rol['nombre_rol'] ?>: <?= $rol['total'] ?>
        </span>
        <?php endforeach; ?>
    </div>

</div>

<div class="card">
    <h2>Buscar usuario</h2>

    <div class="search-box">
        <input type="text" id="buscarUsuario" placeholder="Buscar por apellido del trabajador">
        <button id="btnBuscarUsuario">Buscar</button>
    </div>
</div>

<div class="card">
    <h2>Lista de usuarios</h2>

    <div class="usuarios-table-container">
        <table class="usuarios-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Última sesión iniciada</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                <tr class="fila-usuario" data-apellido="<?= strtolower($usuario['apellidos']) ?>">
                    <td><?= $usuario['nombres'] ?></td>
                    <td><?= $usuario['apellidos'] ?></td>
                    <td><?= $usuario['telefono'] ?></td>
                    <td><?= $usuario['correo'] ?></td>
                    <td><?= $usuario['nombre_rol'] ?></td>
                    <td>
                        <?php if ($usuario['estado'] == 1): ?>
                        <span class="estado activo">Activo</span>
                        <?php else: ?>
                        <span class="estado inactivo">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $usuario['ultimo_acceso'] ?? 'Sin acceso' ?>
                    </td>
                    <td>
                        <button class="btn-edit" data-id="<?= $usuario['id_usuario'] ?>"
                            data-nombres="<?= $usuario['nombres'] ?>" data-apellidos="<?= $usuario['apellidos'] ?>"
                            data-telefono="<?= $usuario['telefono'] ?>" data-correo="<?= $usuario['correo'] ?>"
                            data-usuario="<?= $usuario['usuario'] ?>" data-rol="<?= $usuario['nombre_rol'] ?>"
                            data-estado="<?= $usuario['estado'] == 1 ? 'Activo' : 'Inactivo' ?>">
                            Edit
                        </button>

                        <form
    method="POST"
    action="/farmaplus/index.php?url=usuarios/eliminar"
    style="display:inline;"
    onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">

    <input
        type="hidden"
        name="id_usuario"
        value="<?= $usuario['id_usuario'] ?>">

    <button class="btn-delete">
        Delet
    </button>

</form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8">No hay usuarios registrados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="modalUsuario">
    <form class="modal-box usuario-modal" id="formUsuario" method="POST"
        action="/farmaplus/index.php?url=usuarios/guardar">
        <h2>Nuevo / Editar usuario</h2>

        <input type="hidden" id="idUsuario" name="id_usuario">

        <label>Nombres</label>
        <input type="text" id="usuarioNombres" name="nombres" placeholder="Ingrese nombres">

        <label>Apellidos</label>
        <input type="text" id="usuarioApellidos" name="apellidos" placeholder="Ingrese apellidos">

        <label>Teléfono</label>
        <input type="text" id="usuarioTelefono" name="telefono" placeholder="Ingrese teléfono">

        <label>Correo</label>
        <input type="email" id="usuarioCorreo" name="correo" placeholder="Ingrese correo">

        <label>Usuario</label>
        <input type="text" id="usuarioLogin" name="usuario" placeholder="Ingrese nombre de usuario">

        <label>usuarioPassword</label>
        <input type="text" id="usuarioPassword" name="password" placeholder="Ingrese nombre de usuario">

        <label>Rol</label>
        <select id="usuarioRol" name="id_rol">
            <option value="">Seleccione rol</option>
            <option value="1">Administrador</option>
            <option value="2">Vendedor</option>
            <option value="3">Encargado de almacén</option>
        </select>

        <label>Estado</label>
        <select id="usuarioEstado" name="estado">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <label>Contraseña</label>
        <input type="password" id="usuarioPassword" placeholder="Ingrese contraseña">

        <div class="usuario-modal-buttons">
            <button class="btn-success" id="btnGuardarUsuario">Guardar</button>
            <button class="btn-cancelar" id="btnCancelarUsuario">Cancelar</button>
        </div>
</div>
</div>