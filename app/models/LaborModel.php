<?php

namespace App\Models;

use App\Core\Database;

class LaborModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        try {
            $query = "SELECT id, nombre FROM labores";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error al obtener las labores: " . $e->getMessage());
        }
    }
}