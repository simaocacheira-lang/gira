<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    // 1. Recolha
    $equipamento_id = $_POST['equipamento_id'] ?? '';
    $tipo_manutencao = $_POST['tipo_manutencao'] ?? '';
    $prioridade = $_POST['prioridade'] ?? '';
    $descricao_avaria = $_POST['descricao_avaria'] ?? '';

    // 2. Validações de Domínio
    if ($e = validar_selecao_equipamento($equipamento_id)) $erros[] = $e;
    if ($e = validar_descricao_avaria($descricao_avaria)) $erros[] = $e;

    // 3. Devolver Erros à Interface
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalAbrirOT';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php");
        exit;
    }

    // 4. Gravação
    $numero_ot = 'OT-2026-' . strtoupper(substr(uniqid(), -4));
    $sql = "INSERT INTO ordens_trabalho (numero_ot, equipamento_id, tipo_manutencao, prioridade, descricao_avaria) 
            VALUES (:numero, :equipamento, :tipo, :prioridade, :descricao)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':numero'      => $numero_ot,
            ':equipamento' => (int) $equipamento_id,
            ':tipo'        => $tipo_manutencao,
            ':prioridade'  => $prioridade,
            ':descricao'   => $descricao_avaria
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Emitiu a Ordem de Trabalho $numero_ot para o equipamento ID: " . (int)$equipamento_id, "Manutenção");
        }
        header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php?sucesso=ot_criada");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro crítico na base de dados: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalAbrirOT';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php");
    exit;
}
