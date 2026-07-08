<?php

require_once __DIR__ . '/../Core/Model.php';

class OrdenProducto extends Model
{
    public function guardar($datos)
    {
        $sql = "INSERT INTO ordenes_producto (
                    id_categoria,
                    id_tipo_medicamento,
                    id_proveedor,
                    nombre_producto,
                    cantidad_solicitada,
                    correo_proveedor
                ) VALUES (
                    :id_categoria,
                    :id_tipo_medicamento,
                    :id_proveedor,
                    :nombre_producto,
                    :cantidad_solicitada,
                    :correo_proveedor
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_categoria' => $datos['id_categoria'],
            ':id_tipo_medicamento' => $datos['id_tipo_medicamento'],
            ':id_proveedor' => $datos['id_proveedor'],
            ':nombre_producto' => $datos['nombre_producto'],
            ':cantidad_solicitada' => $datos['cantidad_solicitada'],
            ':correo_proveedor' => $datos['correo_proveedor']
        ]);
    }
}