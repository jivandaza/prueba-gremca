<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LaborModel;
use App\Models\LoteModel;
use App\Models\RegistroModel;

class RegistroController extends Controller
{
    private $model;
    private $laborModel;
    private $loteModel;

    public function __construct()
    {
        $this->model = new RegistroModel();
        $this->laborModel = new LaborModel();
        $this->loteModel = new LoteModel();
    }

    public function index()
    {
        $registros = $this->model->getAll();
        $labores = $this->laborModel->getAll();
        $lotes  = $this->loteModel->getAll();

        $registroEdit = null;

        if (isset($_GET['edit'])) {
            $registroEdit = $this->model->find($_GET['edit']);
        }

        $this->render('index', [
            'registros' => $registros,
            'labores' => $labores,
            'lotes' => $lotes,
            'registroEdit' => $registroEdit
        ]);
    }

    public function ValidateData($data){
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
    }

    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            ValidateData($data);

            $this->model->create($data);
            echo json_encode(['message' => 'Registro creado exitosamente']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => $e->getMessage()]);
        }
        exit;
    }

    public function update()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $this->model->update($data['id'], $data);
            echo json_encode(['message' => 'Registro actualizado exitosamente']);
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