<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Venta.php';

class VentaController extends Controller
{
    public function index()
{
    $venta = new Venta();

    $resultado = $venta->contar();

    $data = [
        'title' => 'Ventas',
        'message' => 'Total de ventas registradas: ' . $resultado['total']
    ];

    $this->view('ventas/index', $data);
}
}