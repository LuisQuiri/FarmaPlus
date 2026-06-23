<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Producto.php';

class ProductoController extends Controller
{
    public function index()
{
    $producto = new Producto();

    $resultado = $producto->contar();

    $data = [
        'title' => 'Productos',
        'message' => 'Total de productos registrados: ' . $resultado['total']
    ];

    $this->view('home/index', $data);
}
}