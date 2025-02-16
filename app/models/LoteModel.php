<?php

namespace App\models;

use App\Core\Database;

class LoteModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        try {
            $query = "SELECT id, nombre FROM lotes";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error al obtener los lotes: " . $e->getMessage());
        }
    }
}