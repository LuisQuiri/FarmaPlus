<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../Models/Dashboard.php';
class HomeController extends Controller
{
        public function __construct()
    {
        Auth::verificarRol([1]);
    }
    
    public function index()
{
    $dashboard = new Dashboard();

    $data = [
        'title' => 'Dashboard',
        'totalProductos' => $dashboard->totalProductosActivos(),
        'totalVentas' => $dashboard->totalVentasRealizadas(),
        'totalVendido' => $dashboard->totalVendido(),
        'bajoStock' => $dashboard->productosBajoStock(),
        'vencidos' => $dashboard->productosVencidos(),
        'porVencer' => $dashboard->productosPorVencer(),
        'ordenesPendientes' => $dashboard->ordenesPendientes(),
        'ultimasVentas' => $dashboard->ultimasVentas()
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