<?php

namespace App\Models;

use App\Core\Model;

class RegistroModel extends Model
{
    public function getAll()
    {
        try {
            $query = "SELECT r.*, l.nombre AS labor, lt.nombre AS lote 
                  FROM registros r
                  JOIN labores l ON r.labor_id = l.id
                  JOIN lotes lt ON r.lote_id = lt.id";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error al obtener todos los registros: " . $e->getMessage());
        }
    }

    public function getAllLabores()
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

    public function getAllLotes()
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

    public function find($id)
    {
        $query = "SELECT * FROM registros WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        try {
            $query = "INSERT INTO registros (labor_id, fecha, cantidad, tarifa, empleado, lote_id) 
                  VALUES (:labor_id, :fecha, :cantidad, :tarifa, :empleado, :lote_id)";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':labor_id', $data['labor_id'], \PDO::PARAM_INT);
            $stmt->bindValue(':fecha', $data['fecha'], \PDO::PARAM_STR);
            $stmt->bindValue(':cantidad', $data['cantidad'], \PDO::PARAM_STR);
            $stmt->bindValue(':tarifa', $data['tarifa'], \PDO::PARAM_STR);
            $stmt->bindValue(':empleado', $data['empleado'], \PDO::PARAM_STR);
            $stmt->bindValue(':lote_id', $data['lote_id'], \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error al registrar el registro: " . $e->getMessage());
        }
    }

    public function update($id, $data)
    {
        try {
            $query = "UPDATE registros 
                  SET labor_id = :labor_id, fecha = :fecha, cantidad = :cantidad, tarifa = :tarifa, empleado = :empleado, lote_id = :lote_id 
                  WHERE id = :id";

            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->bindValue(':labor_id', $data['labor_id'], \PDO::PARAM_INT);
            $stmt->bindValue(':fecha', $data['fecha'], \PDO::PARAM_STR);
            $stmt->bindValue(':cantidad', $data['cantidad'], \PDO::PARAM_STR);
            $stmt->bindValue(':tarifa', $data['tarifa'], \PDO::PARAM_STR);
            $stmt->bindValue(':empleado', $data['empleado'], \PDO::PARAM_STR);
            $stmt->bindValue(':lote_id', $data['lote_id'], \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error al actualizar el registro: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM registros WHERE id = :id";

            $stmt = $this->db->prepare($query);

            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            throw new \Exception("Error al eliminar el registro: " . $e->getMessage());
        }
    }
}
