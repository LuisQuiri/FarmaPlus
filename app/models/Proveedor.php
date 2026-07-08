<?php

require_once __DIR__ . '/../Core/Model.php';

class Proveedor extends Model
{
    public function contar()
    {
        $sql = "SELECT COUNT(*) AS total FROM proveedores WHERE estado = 1";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar()
    {
        $sql = "SELECT 
                    id_proveedor,
                    razon_social,
                    contacto,
                    telefono,
                    correo,
                    fecha_creacion,
                    categoria,
                    id_categoria
                FROM proveedores
                WHERE estado = 1
                ORDER BY id_proveedor DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerNombreCategoria($id_categoria)
    {
        $sql = "SELECT nombre_categoria 
            FROM categorias 
            WHERE id_categoria = :id_categoria 
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_categoria' => $id_categoria
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function guardar($data)
    {
        $id_categoria = $data['id_categoria'] ?? null;
        $categoria = '';

        if (!empty($id_categoria)) {
            $categoriaEncontrada = $this->obtenerNombreCategoria($id_categoria);
            $categoria = $categoriaEncontrada['nombre_categoria'] ?? '';
        }

        $sql = "INSERT INTO proveedores 
            (razon_social, contacto, ruc, telefono, correo, categoria, id_categoria, direccion, estado)
            VALUES 
            (:razon_social, :contacto, :ruc, :telefono, :correo, :categoria, :id_categoria, :direccion, 1)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':razon_social' => $data['razon_social'],
            ':contacto' => $data['contacto'],
            ':ruc' => $data['ruc'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':categoria' => $categoria,
            ':id_categoria' => $id_categoria,
            ':direccion' => $data['direccion']
        ]);
    }

    public function actualizar($data)
    {
        $id_categoria = $data['id_categoria'] ?? null;

        $sql = "UPDATE proveedores SET
                razon_social = :razon_social,
                contacto = :contacto,
                telefono = :telefono,
                correo = :correo,
                categoria = (
                    SELECT nombre_categoria 
                    FROM categorias 
                    WHERE id_categoria = :id_categoria_nombre 
                    LIMIT 1
                ),
                id_categoria = :id_categoria
            WHERE id_proveedor = :id_proveedor";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':razon_social' => $data['razon_social'],
            ':contacto' => $data['contacto'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':id_categoria_nombre' => $id_categoria,
            ':id_categoria' => $id_categoria,
            ':id_proveedor' => $data['id_proveedor']
        ]);
    }
    public function eliminar($id_proveedor)
    {
        $sql = "UPDATE proveedores 
                SET estado = 0 
                WHERE id_proveedor = :id_proveedor";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_proveedor' => $id_proveedor
        ]);
    }
    public function listarCategorias()
    {
        $sql = "SELECT id_categoria, nombre_categoria 
            FROM categorias 
            WHERE estado = 1 
            ORDER BY nombre_categoria ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarOrdenesPendientes()
    {
        $sql = "SELECT COUNT(*) AS total 
            FROM ordenes_producto 
            WHERE estado = 'Solicitada'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarOrdenesPendientes()
{
    $sql = "SELECT 
                op.id_orden,
                c.nombre_categoria,
                tm.nombre_tipo,
                p.razon_social,
                op.nombre_producto,
                op.cantidad_solicitada,
                op.correo_proveedor,
                op.estado,
                op.fecha_orden
            FROM ordenes_producto op
            INNER JOIN categorias c 
                ON op.id_categoria = c.id_categoria
            LEFT JOIN tipos_medicamento tm 
                ON op.id_tipo_medicamento = tm.id_tipo_medicamento
            INNER JOIN proveedores p 
                ON op.id_proveedor = p.id_proveedor
            WHERE op.estado = 'Solicitada'
            ORDER BY op.fecha_orden DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
