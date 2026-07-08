<?php

class Auth
{
    public static function verificarSesion()
    {
        if (!isset($_SESSION['usuario'])) {
            self::redirigirLogin();
        }
    }

    public static function verificarRol(array $rolesPermitidos)
    {
        self::verificarSesion();

        $idRol = $_SESSION['usuario']['id_rol'] ?? null;

        if (!in_array($idRol, $rolesPermitidos)) {
            self::redirigirSegunRol();
        }
    }

    public static function redirigirSegunRol()
    {
        $config = require __DIR__ . '/../../config/app.php';
        $baseUrl = rtrim($config['base_url'], '/') . '/';

        $idRol = $_SESSION['usuario']['id_rol'] ?? null;

        if ($idRol == 1) {
            header('Location: ' . $baseUrl . 'productos');
        } elseif ($idRol == 2) {
            header('Location: ' . $baseUrl . 'ventas');
        } elseif ($idRol == 3) {
            header('Location: ' . $baseUrl . 'productos');
        } else {
            header('Location: ' . $baseUrl . 'login');
        }

        exit;
    }

    public static function redirigirLogin()
    {
        $config = require __DIR__ . '/../../config/app.php';
        $baseUrl = rtrim($config['base_url'], '/') . '/';

        header('Location: ' . $baseUrl . 'login');
        exit;
    }
}