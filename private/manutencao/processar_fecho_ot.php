<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/manutencao/manutencao.php';

    // 1. Recolha
    $id_ot = $_POST['id_ot'] ?? '';
    $id_equipamento = $_POST['id_equipamento'] ?? '';
    $relatorio = $_POST['relatorio_tecnico'] ?? '';
    $tempo = $_POST['tempo_gasto'] ?? '';
    $novo_estado = $_POST['novo_estado_equipamento'] ?? '';

    // 2. Validações de Domínio
    if ($e = validar_relatorio_tecnico($relatorio)) $erros[] = $e;
    if ($e = validar_tempo_gasto($tempo)) $erros[] = $e;

    // 3. Devolver Erros à Interface
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalFecharOT';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $sql_ot = "UPDATE ordens_trabalho SET estado = 'Concluída', relatorio_tecnico = :relatorio, tempo_gasto = :tempo, data_fecho = NOW() WHERE id = :id_ot";
        $stmt_ot = $pdo->prepare($sql_ot);
        $stmt_ot->execute([':relatorio' => $relatorio, ':tempo' => $tempo, ':id_ot' => (int) $id_ot]);

        $sql_eq = "UPDATE equipamentos SET estado = :novo_estado WHERE id = :id_equipamento";
        $stmt_eq = $pdo->prepare($sql_eq);
        $stmt_eq->execute([':novo_estado' => $novo_estado, ':id_equipamento' => (int) $id_equipamento]);

        $pdo->commit();

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Encerrou a Ordem de Trabalho (ID: $id_ot) e definiu estado do equipamento como '$novo_estado'", "Manutenção");
        }
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
        header("Location: " . $url_origem . $separador . "sucesso=ot_fechada");
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['erros'] = ["Erro crítico ao fechar OT: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalFecharOT';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php");
    exit;
}
