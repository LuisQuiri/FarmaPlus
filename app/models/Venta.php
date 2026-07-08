<?php

require_once __DIR__ . '/../Core/Model.php';

class Venta extends Model
{
    public function contar()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

        public function buscarMedicamentos($texto)
    {
        $sql = "SELECT 
                    p.id_producto,
                    p.codigo_producto,
                    p.nombre_producto,
                    p.id_categoria,
                    p.precio_venta,
                    p.fecha_vencimiento,
                    i.stock_actual
                FROM productos p
                INNER JOIN inventario i ON p.id_producto = i.id_producto
                WHERE p.estado = 1
                AND i.stock_actual > 0
                AND (
                    p.nombre_producto LIKE :texto
                    OR p.codigo_producto LIKE :texto
                )
                ORDER BY p.nombre_producto ASC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':texto' => '%' . $texto . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        public function registrarVenta($data)
    {
        try {
            $this->db->beginTransaction();

            $idProducto = (int) $data['id_producto'];
            $cantidad = (int) $data['cantidad'];
            $precioUnitario = (float) $data['precio_unitario'];
            $idUsuario = (int) $data['id_usuario'];

            $sqlStock = "SELECT stock_actual 
                         FROM inventario 
                         WHERE id_producto = :id_producto 
                         FOR UPDATE";

            $stmtStock = $this->db->prepare($sqlStock);
            $stmtStock->execute([
                ':id_producto' => $idProducto
            ]);

            $stock = $stmtStock->fetch(PDO::FETCH_ASSOC);

            if (!$stock) {
                $this->db->rollBack();
                return [
                    'estado' => false,
                    'mensaje' => 'El producto no tiene registro de inventario.'
                ];
            }

            if ((int) $stock['stock_actual'] < $cantidad) {
                $this->db->rollBack();
                return [
                    'estado' => false,
                    'mensaje' => 'Stock insuficiente para realizar la venta.'
                ];
            }

            $subtotal = $precioUnitario * $cantidad;
            $descuento = 0;
            $total = $subtotal - $descuento;

            $sqlVenta = "INSERT INTO ventas 
                            (id_cliente, id_usuario, subtotal, descuento, total, estado, observacion)
                         VALUES 
                            (NULL, :id_usuario, :subtotal, :descuento, :total, 'PAGADA', :observacion)";

            $stmtVenta = $this->db->prepare($sqlVenta);
            $stmtVenta->execute([
                ':id_usuario' => $idUsuario,
                ':subtotal' => $subtotal,
                ':descuento' => $descuento,
                ':total' => $total,
                ':observacion' => $data['observacion']
            ]);

            $idVenta = $this->db->lastInsertId();

            $sqlDetalle = "INSERT INTO detalle_ventas
                            (id_venta, id_producto, cantidad, precio_unitario, descuento, subtotal)
                           VALUES
                            (:id_venta, :id_producto, :cantidad, :precio_unitario, :descuento, :subtotal)";

            $stmtDetalle = $this->db->prepare($sqlDetalle);
            $stmtDetalle->execute([
                ':id_venta' => $idVenta,
                ':id_producto' => $idProducto,
                ':cantidad' => $cantidad,
                ':precio_unitario' => $precioUnitario,
                ':descuento' => $descuento,
                ':subtotal' => $subtotal
            ]);

            $sqlDescontar = "UPDATE inventario
                             SET stock_actual = stock_actual - :cantidad
                             WHERE id_producto = :id_producto";

            $stmtDescontar = $this->db->prepare($sqlDescontar);
            $stmtDescontar->execute([
                ':cantidad' => $cantidad,
                ':id_producto' => $idProducto
            ]);

            $this->db->commit();

            return [
                'estado' => true,
                'mensaje' => 'Venta registrada correctamente.',
                'id_venta' => $idVenta
            ];

        } catch (Exception $e) {
            $this->db->rollBack();

            return [
                'estado' => false,
                'mensaje' => 'Error al registrar la venta.'
            ];
        }
    }
}