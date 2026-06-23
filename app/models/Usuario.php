<?php

require_once __DIR__ . '/../Core/Model.php';

class Usuario extends Model
{
    public function contar()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar()
    {
        $sql = "SELECT 
                    u.id_usuario,
                    u.nombres,
                    u.apellidos,
                    u.telefono,
                    u.correo,
                    u.usuario,
                    u.estado,
                    u.ultimo_acceso,
                    r.nombre_rol
                FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarActivos()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE estado = 1";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarPorRol()
    {
        $sql = "SELECT 
                    r.nombre_rol,
                    COUNT(u.id_usuario) AS total
                FROM roles r
                LEFT JOIN usuarios u ON r.id_rol = u.id_rol
                GROUP BY r.id_rol, r.nombre_rol
                ORDER BY r.id_rol ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($datos)
{
    $sql = "INSERT INTO usuarios (
                id_rol,
                nombres,
                apellidos,
                telefono,
                correo,
                usuario,
                password_hash,
                estado
            ) VALUES (
                :id_rol,
                :nombres,
                :apellidos,
                :telefono,
                :correo,
                :usuario,
                :password_hash,
                :estado
            )";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute($datos);
}

public function actualizar($datos)
{
    $sql = "UPDATE usuarios SET
                id_rol = :id_rol,
                nombres = :nombres,
                apellidos = :apellidos,
                telefono = :telefono,
                correo = :correo,
                usuario = :usuario,
                estado = :estado
            WHERE id_usuario = :id_usuario";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute($datos);
}

public function eliminar($idUsuario)
{
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        'id_usuario' => $idUsuario
    ]);
}
}