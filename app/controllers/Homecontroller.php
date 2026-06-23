<?php

require_once __DIR__ . '/../Core/Controller.php';

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Inicio',
            'message' => 'Arquitectura MVC de FarmaPlus funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }

    public function productos()
    {
        $data = [
            'title' => 'Productos',
            'message' => 'Ruta del módulo Productos funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }

    public function ventas()
    {
        $data = [
            'title' => 'Ventas',
            'message' => 'Ruta del módulo Ventas funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }

    public function clientes()
    {
        $data = [
            'title' => 'Clientes',
            'message' => 'Ruta del módulo Clientes funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }

    public function proveedores()
    {
        $data = [
            'title' => 'Proveedores',
            'message' => 'Ruta del módulo Proveedores funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }

    public function reportes()
    {
        $data = [
            'title' => 'Reportes',
            'message' => 'Ruta del módulo Reportes funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }
}