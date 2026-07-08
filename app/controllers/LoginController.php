<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Usuario.php';

class LoginController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/app.php';
        $this->baseUrl = rtrim($config['base_url'], '/') . '/';
    }
    public function index()
    {
        require_once __DIR__ . '/../views/login/index.php';
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->baseUrl . 'login');
            exit;
        }

        $usuarioInput = trim($_POST['usuario'] ?? '');
        $passwordInput = trim($_POST['password'] ?? '');

        if ($usuarioInput === '' || $passwordInput === '') {
            $_SESSION['login_error'] = 'Ingrese usuario y contraseña.';
            header('Location: ' . $this->baseUrl . 'login');
            exit;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarParaLogin($usuarioInput);

        if (!$usuario || !password_verify($passwordInput, $usuario['password_hash'])) {
            $_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
            header('Location: ' . $this->baseUrl . 'login');
            exit;
        }

        $_SESSION['usuario'] = [
            'id_usuario' => $usuario['id_usuario'],
            'nombres' => $usuario['nombres'],
            'apellidos' => $usuario['apellidos'],
            'usuario' => $usuario['usuario'],
            'correo' => $usuario['correo'],
            'id_rol' => $usuario['id_rol'],
            'nombre_rol' => $usuario['nombre_rol']
        ];

        if ($usuario['id_rol'] == 1) {
            header('Location: ' . $this->baseUrl . 'productos');
        } elseif ($usuario['id_rol'] == 2) {
            header('Location: ' . $this->baseUrl . 'ventas');
        } elseif ($usuario['id_rol'] == 3) {
            header('Location: ' . $this->baseUrl . 'productos');
        } else {
            header('Location: ' . $this->baseUrl . 'login');
        }

        exit;
    }

    public function salir()
    {
        session_destroy();
        header('Location: ' . $this->baseUrl . 'login');
        exit;
    }
}
