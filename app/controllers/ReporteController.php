<?php

require_once __DIR__ . '/../Core/Controller.php';

class ReporteController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Reportes',
            'message' => 'Controlador de Reportes funcionando correctamente.'
        ];

        $this->view('home/index', $data);
    }
}