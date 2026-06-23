<?php

require_once __DIR__ . '/../Core/Model.php';

class Cliente extends Model
{
    public function contar()
    {
        $sql = "SELECT COUNT(*) AS total FROM clientes";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}