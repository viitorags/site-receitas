<?php

require __DIR__ . "/../Config/db.php";

class ReceitasModel
{
    public function listarReceitas()
    {
        try {
            $db = new Database();
            $query = "SELECT * FROM receitas";
            $result = $db->prepare($query);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $err) {
            throw $err;
        }
    }

    public function criarNovaReceita($titulo, $descricao, $ingredientes, $modo_preparo)
    {
        try {
            $db = new Database();
            $query = "INSERT INTO receitas (titulo, descricao, ingredientes, modo_preparo) VALUES (?, ?, ?, ?, ?, ?)";
            $result = $db->prepare($query);
            $result->execute([$titulo, $descricao, $ingredientes, $modo_preparo]);
        } catch (Exception $err) {
            echo "Erro ao criar receita " . $err->getMessage();
        }
    }

    public function atualizarReceita($id, $titulo, $descricao, $ingredientes, $modo_preparo)
    {
        try {
            $db = new Database();
            $query = "UPDATE receitas 
                  SET titulo = ?, descricao = ?, ingredientes = ?, modo_preparo = ? 
                  WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->execute([$titulo, $descricao, $ingredientes, $modo_preparo, $id]);
        } catch (Exception $err) {
            echo "Erro ao atualizar receita: " . $err->getMessage();
        }
    }
}
