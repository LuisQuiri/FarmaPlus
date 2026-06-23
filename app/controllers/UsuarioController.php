<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController extends Controller
{
    public function index()
    {
        $usuario = new Usuario();

        $totalUsuarios = $usuario->contar();
        $usuariosActivos = $usuario->contarActivos();
        $distribucionRoles = $usuario->contarPorRol();
        $listaUsuarios = $usuario->listar();

        $data = [
            'title' => 'Usuarios',
            'totalUsuarios' => $totalUsuarios['total'],
            'usuariosActivos' => $usuariosActivos['total'],
            'distribucionRoles' => $distribucionRoles,
            'usuarios' => $listaUsuarios
        ];

        $this->view('usuarios/index', $data);
    }

    public function guardar()
{
    $usuario = new Usuario();

    $datos = [
        'id_rol' => $_POST['id_rol'],
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'telefono' => $_POST['telefono'],
        'correo' => $_POST['correo'],
        'usuario' => $_POST['usuario'],
        'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'estado' => $_POST['estado']
    ];

    $usuario->guardar($datos);

    header('Location: /farmaplus/index.php?url=usuarios');
    exit;
}

public function actualizar()
{
    $usuario = new Usuario();

    $datos = [
        'id_usuario' => $_POST['id_usuario'],
        'id_rol' => $_POST['id_rol'],
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'telefono' => $_POST['telefono'],
        'correo' => $_POST['correo'],
        'usuario' => $_POST['usuario'],
        'estado' => $_POST['estado']
    ];

    $usuario->actualizar($datos);

    header('Location: /farmaplus/index.php?url=usuarios');
    exit;
}

public function eliminar()
{
    $usuario = new Usuario();

    $usuario->eliminar($_POST['id_usuario']);

    header('Location: /farmaplus/index.php?url=usuarios');
    exit;
}
}