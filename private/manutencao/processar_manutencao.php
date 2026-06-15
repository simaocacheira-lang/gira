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

    // DESCOBRIR DE ONDE O UTILIZADOR VEIO
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/manutencao/manutencao.php';

    // 2. Validações de Domínio
    if ($e = validar_selecao_equipamento($equipamento_id)) $erros[] = $e;
    if ($e = validar_descricao_avaria($descricao_avaria)) $erros[] = $e;

    // 3. Devolver Erros à Interface (Voltando para onde estava!)
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalAbrirOT';
        $_SESSION['dados_form'] = $_POST;
        // Volta dinamicamente para os detalhes do equipamento OU para a lista de manutenção
        header("Location: " . $url_origem);
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

        // ====================================================================
        // MAGIA DE REDIRECIONAMENTO COM SUCESSO
        // ====================================================================

        // 1. Limpamos lixo antigo do URL (se a pessoa já tinha lá um ?sucesso=... nós apagamos)
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');

        // 2. Descobrimos se adicionamos um '?' ou um '&' (se for detalhes.php?id=3 precisa de um '&')
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';

        // 3. Mandamos a pessoa de volta com a nova bandeira de sucesso (e abrimos a aba correta se for preciso)
        header("Location: " . $url_origem . $separador . "sucesso=ot_criada&tab=manutencao");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro crítico ao criar a O.T.: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalAbrirOT';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/dashboard.php");
    exit;
}
