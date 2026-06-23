<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Proveedor.php';

class ProveedorController extends Controller
{
        public function index()
    {
        $proveedor = new Proveedor();

        $resultado = $proveedor->contar();
        $proveedores = $proveedor->listar();

        $data = [
            'title' => 'Proveedores',
            'total_proveedores' => $resultado['total'],
            'ordenes_pendientes' => 0,
            'envios_retraso' => 0,
            'proveedores' => $proveedores
        ];

        $this->view('proveedores/index', $data);
    }

        public function guardar()
    {
        $proveedor = new Proveedor();

        $data = [
            'razon_social' => $_POST['razon_social'],
            'contacto' => $_POST['contacto'],
            'ruc' => $_POST['ruc'],
            'telefono' => $_POST['telefono'],
            'correo' => $_POST['correo'],
            'categoria' => $_POST['categoria'],
            'direccion' => $_POST['direccion']
        ];

        $proveedor->guardar($data);

        header('Location: index.php?url=proveedores');
        exit;
    }

        public function actualizar()
    {
        $proveedor = new Proveedor();

        $data = [
            'id_proveedor' => $_POST['id_proveedor'],
            'razon_social' => $_POST['razon_social'],
            'contacto' => $_POST['contacto'],
            'telefono' => $_POST['telefono'],
            'correo' => $_POST['correo'],
            'categoria' => $_POST['categoria']
        ];

        $proveedor->actualizar($data);

        header('Location: index.php?url=proveedores');
        exit;
    }

        public function eliminar()
    {
        $proveedor = new Proveedor();

        $proveedor->eliminar($_POST['id_proveedor']);

        header('Location: index.php?url=proveedores');
        exit;
    }
}