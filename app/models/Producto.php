<?php

require_once __DIR__ . '/../Core/Model.php';

class Producto extends Model
{
    public function contar()
    {
        $sql = "SELECT COUNT(*) AS total FROM productos";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}