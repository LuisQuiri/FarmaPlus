<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Producto.php';

class ProductoController extends Controller
{
    public function index()
    {
        $producto = new Producto();

        $resultado = $producto->contar();
        $productos = $producto->listar();
        $bajoStock = $producto->contarBajoStock();
        $porVencer = $producto->contarPorVencer();
        $categorias = $producto->listarCategorias();

        $data = [
            'title' => 'Productos',
            'total_productos' => $producto->contar(),
            'productos' => $producto->listar(),
            'bajo_stock' => $producto->contarBajoStock(),
            'por_vencer' => $producto->contarPorVencer(),
            'categorias' => $producto->listarCategorias(),
            'proveedores' => $producto->listarProveedores(),
            'tipos_medicamento' => $producto->listarTiposMedicamento(),
            'codigo_producto' => $producto->generarCodigoProducto()
        ];

        $this->view('productos/index', $data);
    }
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $producto = new Producto();

            $datos = [
                'codigo_producto' => $_POST['codigo_producto'] ?? '',
                'nombre_producto' => $_POST['nombre_producto'] ?? '',
                'id_categoria' => $_POST['id_categoria'] ?? '',
                'id_tipo_medicamento' => $_POST['id_tipo_medicamento'] ?? null,
                'id_proveedor' => $_POST['id_proveedor'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'laboratorio' => $_POST['laboratorio'] ?? '',
                'presentacion' => $_POST['presentacion'] ?? '',

                'precio_venta' => $_POST['precio_venta'] ?? 0,

                'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? '',
                'stock_actual' => $_POST['stock_actual'] ?? 0,
                'stock_minimo' => $_POST['stock_minimo'] ?? 0,

            ];

            $resultado = $producto->guardarProducto($datos);

            if ($resultado) {
                header('Location: /farmaplus/productos');
                exit;
            } else {
                echo "Error al guardar el producto.";
            }
        } else {
            header('Location: /farmaplus/productos');
            exit;
        }
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $producto = new Producto();

            $datos = [
                'id_producto' => $_POST['id_producto'] ?? '',
                'nombre_producto' => $_POST['nombre_producto'] ?? '',
                'id_categoria' => $_POST['id_categoria'] ?? '',
                'id_tipo_medicamento' => $_POST['id_tipo_medicamento'] ?? null,
                'id_proveedor' => $_POST['id_proveedor'] ?? '',
                'laboratorio' => $_POST['laboratorio'] ?? '',
                'presentacion' => $_POST['presentacion'] ?? '',
                'precio_venta' => $_POST['precio_venta'] ?? 0,
                'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? '',
                'stock_actual' => $_POST['stock_actual'] ?? 0,
                'stock_minimo' => $_POST['stock_minimo'] ?? 0
            ];

            $resultado = $producto->actualizarProducto($datos);

            if ($resultado) {
                header('Location: /farmaplus/productos');
                exit;
            } else {
                echo "Error al actualizar el producto.";
            }
        } else {
            header('Location: /farmaplus/productos');
            exit;
        }
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id_producto = $_POST['id_producto'] ?? null;

            if ($id_producto) {
                $producto = new Producto();
                $producto->eliminarproducto($id_producto);
            }

            header('Location: /farmaplus/productos');
            exit;
        }
    }
}
