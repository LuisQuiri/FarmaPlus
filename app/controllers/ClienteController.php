<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Cliente.php';

class ClienteController extends Controller
{
    public function index()
{
    $cliente = new Cliente();

    $resultado = $cliente->contar();

    $data = [
        'title' => 'Clientes',
        'message' => 'Total de clientes registrados: ' . $resultado['total']
    ];

    $this->view('home/index', $data);
}
}