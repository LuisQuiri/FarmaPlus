<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Venta.php';
require_once __DIR__ . '/../core/Auth.php';

class VentaController extends Controller
{
    public function __construct()
    {
        Auth::verificarRol([1, 2]);
    }

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

        public function buscarMedicamento()
    {
        header('Content-Type: application/json');

        $texto = $_GET['texto'] ?? '';

        if (trim($texto) === '') {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'Debe ingresar un medicamento.',
                'data' => []
            ]);
            return;
        }

        $venta = new Venta();
        $productos = $venta->buscarMedicamentos($texto);

        echo json_encode([
            'estado' => true,
            'data' => $productos
        ]);
    }
        public function registrar()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'Datos inválidos.'
            ]);
            return;
        }

        $idProducto = $input['id_producto'] ?? null;
        $cantidad = $input['cantidad'] ?? null;
        $precioUnitario = $input['precio_unitario'] ?? null;

        if (!$idProducto || !$cantidad || !$precioUnitario) {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'Faltan datos de la venta.'
            ]);
            return;
        }

        if ((int) $cantidad <= 0) {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'La cantidad debe ser mayor a cero.'
            ]);
            return;
        }

        $dniCliente = trim($input['dni_cliente'] ?? '');
        $nombreCliente = trim($input['nombre_cliente'] ?? '');

        $observacion = 'Cliente: ' . $nombreCliente . ' - DNI: ' . $dniCliente;

        $venta = new Venta();

        $resultado = $venta->registrarVenta([
            'id_producto' => $idProducto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'id_usuario' => $_SESSION['usuario']['id_usuario'],
            'observacion' => $observacion
        ]);

        echo json_encode($resultado);
    }
}
