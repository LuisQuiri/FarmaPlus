<?php

require_once __DIR__ . '/../Core/Model.php';

class Producto extends Model
{
    public function contar()
    {
        $sql = "SELECT COUNT(*) AS total FROM productos WHERE estado = 1";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar()
    {
        $sql = "SELECT 
                p.id_producto,
                p.id_categoria,
                p.id_tipo_medicamento,
                p.id_proveedor,
                p.codigo_producto,
                p.nombre_producto,
                p.descripcion,
                p.laboratorio,
                p.presentacion,
                p.precio_venta,
                p.fecha_vencimiento,
                c.nombre_categoria,
                tm.nombre_tipo,
                pr.razon_social,
                i.stock_actual,
                i.stock_minimo
            FROM productos p
            INNER JOIN categorias c 
                ON p.id_categoria = c.id_categoria
            LEFT JOIN tipos_medicamento tm 
                ON p.id_tipo_medicamento = tm.id_tipo_medicamento
            INNER JOIN proveedores pr 
                ON p.id_proveedor = pr.id_proveedor
            LEFT JOIN inventario i 
                ON p.id_producto = i.id_producto
            WHERE p.estado = 1
            ORDER BY p.id_producto DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarBajoStock()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM productos p
                INNER JOIN inventario i ON p.id_producto = i.id_producto
                WHERE p.estado = 1
                AND i.stock_actual < 3";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarPorVencer()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                WHERE estado = 1
                AND fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarCategorias()
    {
        $sql = "SELECT 
                    id_categoria,
                    nombre_categoria
                FROM categorias
                WHERE estado = 1
                ORDER BY nombre_categoria ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarProveedores()
    {
        $sql = "SELECT 
                id_proveedor,
                razon_social
            FROM proveedores
            WHERE estado = 1
            ORDER BY razon_social ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTiposMedicamento()
    {
        $sql = "SELECT 
                id_tipo_medicamento,
                nombre_tipo
            FROM tipos_medicamento
            WHERE estado = 1
            ORDER BY nombre_tipo ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generarCodigoProducto()
    {
        $sql = "SELECT MAX(id_producto) AS ultimo_id FROM productos";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $siguienteId = 1;

        if ($resultado && $resultado['ultimo_id'] !== null) {
            $siguienteId = (int)$resultado['ultimo_id'] + 1;
        }

        return 'PROD' . str_pad($siguienteId, 4, '0', STR_PAD_LEFT);
    }

    public function guardarProducto($datos)
    {
        $datos['unidad_medida'] = $datos['unidad_medida'] ?? '';
        $datos['precio_compra'] = $datos['precio_compra'] ?? 0;
        $datos['requiere_receta'] = $datos['requiere_receta'] ?? 0;
        $datos['ubicacion'] = $datos['ubicacion'] ?? '';
        $datos['descripcion'] = $datos['descripcion'] ?? '';
        $datos['laboratorio'] = $datos['laboratorio'] ?? '';
        $datos['presentacion'] = $datos['presentacion'] ?? '';
        $datos['precio_venta'] = $datos['precio_venta'] ?? 0;
        try {
            $this->db->beginTransaction();

            $sqlProducto = "INSERT INTO productos (
                            id_categoria,
                            id_tipo_medicamento,
                            id_proveedor,
                            codigo_producto,
                            nombre_producto,
                            descripcion,
                            laboratorio,
                            presentacion,
                            unidad_medida,
                            precio_compra,
                            precio_venta,
                            requiere_receta,
                            fecha_vencimiento,
                            estado
                        ) VALUES (
                            :id_categoria,
                            :id_tipo_medicamento,
                            :id_proveedor,
                            :codigo_producto,
                            :nombre_producto,
                            :descripcion,
                            :laboratorio,
                            :presentacion,
                            :unidad_medida,
                            :precio_compra,
                            :precio_venta,
                            :requiere_receta,
                            :fecha_vencimiento,
                            1
                        )";

            $stmtProducto = $this->db->prepare($sqlProducto);

            $stmtProducto->bindValue(':id_categoria', $datos['id_categoria'], PDO::PARAM_INT);

            if (empty($datos['id_tipo_medicamento'])) {
                $stmtProducto->bindValue(':id_tipo_medicamento', null, PDO::PARAM_NULL);
            } else {
                $stmtProducto->bindValue(':id_tipo_medicamento', $datos['id_tipo_medicamento'], PDO::PARAM_INT);
            }

            $stmtProducto->bindValue(':id_proveedor', $datos['id_proveedor'], PDO::PARAM_INT);
            $stmtProducto->bindValue(':codigo_producto', $datos['codigo_producto']);
            $stmtProducto->bindValue(':nombre_producto', $datos['nombre_producto']);
            $stmtProducto->bindValue(':descripcion', $datos['descripcion'] ?? '');
            $stmtProducto->bindValue(':laboratorio', $datos['laboratorio'] ?? '');
            $stmtProducto->bindValue(':presentacion', $datos['presentacion'] ?? '');
            $stmtProducto->bindValue(':unidad_medida', $datos['unidad_medida']);
            $stmtProducto->bindValue(':precio_compra', $datos['precio_compra']);
            $stmtProducto->bindValue(':precio_venta', $datos['precio_venta']);
            $stmtProducto->bindValue(':requiere_receta', $datos['requiere_receta'], PDO::PARAM_INT);
            $stmtProducto->bindValue(':fecha_vencimiento', $datos['fecha_vencimiento']);

            $stmtProducto->execute();

            $idProducto = $this->db->lastInsertId();

            $sqlInventario = "INSERT INTO inventario (
                              id_producto,
                              stock_actual,
                              stock_minimo,
                              ubicacion
                          ) VALUES (
                              :id_producto,
                              :stock_actual,
                              :stock_minimo,
                              :ubicacion
                          )";

            $stmtInventario = $this->db->prepare($sqlInventario);
            $stmtInventario->bindValue(':id_producto', $idProducto, PDO::PARAM_INT);
            $stmtInventario->bindValue(':stock_actual', $datos['stock_actual'], PDO::PARAM_INT);
            $stmtInventario->bindValue(':stock_minimo', $datos['stock_minimo'], PDO::PARAM_INT);
            $stmtInventario->bindValue(':ubicacion', $datos['ubicacion'] ?? '');

            $stmtInventario->execute();

            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function obtenerPorId($id_producto)
    {
        $sql = "SELECT 
                p.id_producto,
                p.id_categoria,
                p.id_tipo_medicamento,
                p.id_proveedor,
                p.codigo_producto,
                p.nombre_producto,
                p.descripcion,
                p.laboratorio,
                p.presentacion,
                p.precio_venta,
                p.fecha_vencimiento,
                c.nombre_categoria,
                tm.nombre_tipo,
                pr.razon_social,
                i.stock_actual,
                i.stock_minimo
            FROM productos p
            INNER JOIN categorias c 
                ON p.id_categoria = c.id_categoria
            LEFT JOIN tipos_medicamento tm 
                ON p.id_tipo_medicamento = tm.id_tipo_medicamento
            INNER JOIN proveedores pr 
                ON p.id_proveedor = pr.id_proveedor
            LEFT JOIN inventario i 
                ON p.id_producto = i.id_producto
            WHERE p.id_producto = :id_producto
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_producto', $id_producto, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarProducto($datos)
    {
        try {
            $this->db->beginTransaction();

            $sqlProducto = "UPDATE productos SET
                            id_categoria = :id_categoria,
                            id_tipo_medicamento = :id_tipo_medicamento,
                            id_proveedor = :id_proveedor,
                            nombre_producto = :nombre_producto,
                            laboratorio = :laboratorio,
                            presentacion = :presentacion,
                            precio_venta = :precio_venta,
                            fecha_vencimiento = :fecha_vencimiento
                        WHERE id_producto = :id_producto";

            $stmtProducto = $this->db->prepare($sqlProducto);

            $stmtProducto->bindValue(':id_categoria', $datos['id_categoria'], PDO::PARAM_INT);

            if (empty($datos['id_tipo_medicamento'])) {
                $stmtProducto->bindValue(':id_tipo_medicamento', null, PDO::PARAM_NULL);
            } else {
                $stmtProducto->bindValue(':id_tipo_medicamento', $datos['id_tipo_medicamento'], PDO::PARAM_INT);
            }

            $stmtProducto->bindValue(':id_proveedor', $datos['id_proveedor'], PDO::PARAM_INT);
            $stmtProducto->bindValue(':nombre_producto', $datos['nombre_producto']);
            $stmtProducto->bindValue(':laboratorio', $datos['laboratorio'] ?? '');
            $stmtProducto->bindValue(':presentacion', $datos['presentacion'] ?? '');
            $stmtProducto->bindValue(':precio_venta', $datos['precio_venta'] ?? 0);
            $stmtProducto->bindValue(':fecha_vencimiento', $datos['fecha_vencimiento']);
            $stmtProducto->bindValue(':id_producto', $datos['id_producto'], PDO::PARAM_INT);

            $stmtProducto->execute();

            $sqlInventario = "UPDATE inventario SET
                              stock_actual = :stock_actual,
                              stock_minimo = :stock_minimo
                          WHERE id_producto = :id_producto";

            $stmtInventario = $this->db->prepare($sqlInventario);
            $stmtInventario->bindValue(':stock_actual', $datos['stock_actual'], PDO::PARAM_INT);
            $stmtInventario->bindValue(':stock_minimo', $datos['stock_minimo'], PDO::PARAM_INT);
            $stmtInventario->bindValue(':id_producto', $datos['id_producto'], PDO::PARAM_INT);

            $stmtInventario->execute();

            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function eliminarProducto($id_producto)
    {
        $sql = "UPDATE productos 
            SET estado = 0 
            WHERE id_producto = :id_producto";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
