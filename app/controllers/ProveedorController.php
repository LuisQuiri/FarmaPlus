<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Proveedor.php';
require_once __DIR__ . '/../core/Auth.php';

class ProveedorController extends Controller
{
        public function __construct()
    {
        Auth::verificarRol([1]);
    }
    public function index()
    {
        $proveedor = new Proveedor();
        $ordenesPendientes = $proveedor->contarOrdenesPendientes();
        $listaOrdenesPendientes = $proveedor->listarOrdenesPendientes();
        $categorias = $proveedor->listarCategorias();

        $resultado = $proveedor->contar();
        $proveedores = $proveedor->listar();

        $data = [
            'title' => 'Proveedores',
            'total_proveedores' => $resultado['total'],
            'ordenes_pendientes' => $ordenesPendientes['total'], 
            'envios_retraso' => 0,
            'proveedores' => $proveedores,
            'categorias' => $categorias,
            'lista_ordenes_pendientes' => $listaOrdenesPendientes,
        ];

        $this->view('proveedores/index', $data);
    }

    public function guardar()
    {
        $proveedor = new Proveedor();

        $data = [
            'razon_social' => $_POST['razon_social'] ?? '',
            'contacto' => $_POST['contacto'] ?? '',
            'ruc' => $_POST['ruc'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'correo' => $_POST['correo'] ?? '',
            'id_categoria' => $_POST['id_categoria'] ?? null,
            'direccion' => $_POST['direccion'] ?? ''
        ];

        $proveedor->guardar($data);

        header('Location: index.php?url=proveedores');
        exit;
    }

    public function actualizar()
    {
        $proveedor = new Proveedor();

        $data = [
            'id_proveedor' => $_POST['id_proveedor'] ?? '',
            'razon_social' => $_POST['razon_social'] ?? '',
            'contacto' => $_POST['contacto'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'correo' => $_POST['correo'] ?? '',
            'id_categoria' => $_POST['id_categoria'] ?? null
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
