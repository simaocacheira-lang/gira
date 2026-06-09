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
            ':nome'        => trim($_POST['nome']),
            ':modelo'      => trim($_POST['marca']),
            ':serie'       => trim($_POST['sn']),
            ':estado'      => $_POST['estado_operacional'],
            ':localizacao' => (int) $_POST['localizacao_id'],
            ':fornecedor'  => (int) $_POST['fornecedor_id'],
            ':data'        => $_POST['data_aquisicao']
        ]);

        // --> O NOSSO NOVO TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            $nome_eq = trim($_POST['nome']);
            registar_log($pdo, $_SESSION['user_id'], "Registou o equipamento: $nome_eq ($codigo_gerado)", "Equipamentos");
        }

        header("Location: /gira/private/equipamentos/equipamentos.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        die("Erro ao registar equipamento: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/equipamentos/equipamentos.php");
    exit;
}
