<?php

require __DIR__ . "/../Models/ReceitasModel.php";

class ReceitasController
{
    public function listarReceitas()
    {
        $receitasModel = new ReceitasModel();
        $receitasModel->listarReceitas();

        $receitas = $receitasModel->listarReceitas();

        include __DIR__ . "/../Views/app.php";
    }

    public function criarNovaReceita()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $titulo = $data['titulo'] ?? '';
        $descricao = $data['descricao'] ?? '';
        $ingredientes = $data['ingredientes'] ?? '';
        $modo_preparo = $data['modo_preparo'] ?? '';

        $receitasModel = new ReceitasModel();
        $receitasModel->criarNovaReceita($titulo, $descricao, $ingredientes, $modo_preparo);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        http_response_code('success' ? 201 : 500);
    }

    public function atualizarReceita()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id'] ?? '';
        $titulo = $data['titulo'] ?? '';
        $descricao = $data['descricao'] ?? '';
        $ingredientes = $data['ingredientes'] ?? '';
        $modo_preparo = $data['modo_preparo'] ?? '';

        $receitasModel = new ReceitasModel();
        $receitasModel->atualizarReceita($id, $titulo, $descricao, $ingredientes, $modo_preparo);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        http_response_code('success' ? 201 : 500);
    }

    public function deletarReceita()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id'] ?? '';

        $receitasModel = new ReceitasModel();
        $receitasModel->deletarReceita($id);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        http_response_code('success' ? 201 : 500);
    }
}
