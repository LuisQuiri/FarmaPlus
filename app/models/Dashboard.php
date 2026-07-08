<?php

require_once __DIR__ . '/../Core/Model.php';

class Dashboard extends Model
{
    public function totalProductosActivos()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM productos 
                WHERE estado = 1";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalVentasRealizadas()
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM ventas 
                WHERE estado = 'PAGADA'";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalVendido()
    {
        $sql = "SELECT COALESCE(SUM(total), 0) AS total 
                FROM ventas 
                WHERE estado = 'PAGADA'";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function productosBajoStock()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos p
                INNER JOIN inventario i 
                    ON p.id_producto = i.id_producto
                WHERE p.estado = 1
                AND i.stock_actual <= i.stock_minimo";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function productosVencidos()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                WHERE estado = 1
                AND fecha_vencimiento < CURDATE()";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function productosPorVencer()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM productos
                WHERE estado = 1
                AND fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ordenesPendientes()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM ordenes_producto
                WHERE estado = 'Solicitada'";

        $stmt = $this->db->query($sql);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ultimasVentas()
    {
        $sql = "SELECT 
                    id_venta,
                    fecha_venta,
                    total,
                    estado
                FROM ventas
                ORDER BY fecha_venta DESC
                LIMIT 5";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}