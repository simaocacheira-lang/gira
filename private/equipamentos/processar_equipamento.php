<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Gerar código automaticamente
    $codigo_gerado = 'EQ-2026-' . strtoupper(substr(uniqid(), -4));

    // SQL preparado para os nomes exatos do teu HTML
    $sql = "INSERT INTO equipamentos (codigo_ativo, nome, modelo, num_serie, estado, localizacao_id, fornecedor_id, data_aquisicao) 
            VALUES (:codigo, :nome, :modelo, :serie, :estado, :localizacao, :fornecedor, :data)";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':codigo'      => $codigo_gerado,
            ':nome'        => $_POST['nome'],             // Correspondente a name="nome"
            ':modelo'      => $_POST['marca'],            // Correspondente a name="marca"
            ':serie'       => $_POST['sn'],               // Correspondente a name="sn"
            ':estado'      => $_POST['estado_operacional'], // Correspondente a name="estado_operacional"
            ':localizacao' => $_POST['localizacao_id'],   // Correspondente a name="localizacao_id"
            ':fornecedor'  => $_POST['fornecedor_id'],    // Correspondente a name="fornecedor_id"
            ':data'        => $_POST['data_aquisicao']
        ]);

        header("Location: /gira/private/equipamentos/equipamentos.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        die("Erro ao guardar na base de dados: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/equipamentos/equipamentos.php");
    exit;
}
