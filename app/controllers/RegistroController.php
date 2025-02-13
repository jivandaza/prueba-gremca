<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\RegistroModel;

class RegistroController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new RegistroModel();
    }

    public function index()
    {
        $registros = $this->model->getAll();
        $labores = $this->model->getAllLabores();
        $lotes = $this->model->getAllLotes();

        $registroEdit = null;

        if (isset($_GET['edit'])) {
            $registroEdit = $this->model->find($_GET['edit']);
        }

        $this->render('registros/index', [
            'registros' => $registros,
            'labores' => $labores,
            'lotes' => $lotes,
            'registroEdit' => $registroEdit
        ]);
    }

    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                http_response_code(400);
                echo json_encode(['message' => 'Datos no recibidos']);
                exit;
            }

            $requiredFields = ['labor_id', 'fecha', 'cantidad', 'tarifa', 'empleado', 'lote_id'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty($data[$field])) {
                    http_response_code(400);
                    echo json_encode(['message' => "Campo '$field' no proporcionado"]);
                    exit;
                }
            }

            if (isset($data['id'])) {
                $this->model->update($data['id'], $data);
                echo json_encode(['message' => 'Registro actualizado exitosamente']);
            } else {
                $this->model->create($data);
                echo json_encode(['message' => 'Registro creado exitosamente']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => $e->getMessage()]);
        }
        exit;
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);

            echo json_encode(['message' => 'Registro eliminado exitosamente']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => $e->getMessage()]);
        }
        exit;
    }
}