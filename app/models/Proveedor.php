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
                    categoria
                FROM proveedores
                WHERE estado = 1
                ORDER BY id_proveedor DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function guardar($data)
    {
        $sql = "INSERT INTO proveedores 
                (razon_social, contacto, ruc, telefono, correo, categoria, direccion, estado)
                VALUES 
                (:razon_social, :contacto, :ruc, :telefono, :correo, :categoria, :direccion, 1)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':razon_social' => $data['razon_social'],
            ':contacto' => $data['contacto'],
            ':ruc' => $data['ruc'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':categoria' => $data['categoria'],
            ':direccion' => $data['direccion']
        ]);
    }

        public function actualizar($data)
    {
        $sql = "UPDATE proveedores SET
                    razon_social = :razon_social,
                    contacto = :contacto,
                    telefono = :telefono,
                    correo = :correo,
                    categoria = :categoria
                WHERE id_proveedor = :id_proveedor";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':razon_social' => $data['razon_social'],
            ':contacto' => $data['contacto'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':categoria' => $data['categoria'],
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
}