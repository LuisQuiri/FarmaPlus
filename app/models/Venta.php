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
}