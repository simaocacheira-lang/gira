<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_ot = (int) $_POST['id_ot'];
    $id_equipamento = (int) $_POST['id_equipamento'];
    $relatorio = $_POST['relatorio_tecnico'];
    $tempo = $_POST['tempo_gasto'];
    $novo_estado = $_POST['novo_estado_equipamento'];

    try {
        // Iniciar uma "Transação" (Se uma falhar, a outra também falha, garantindo que não há erros a meio)
        $pdo->beginTransaction();

        // 1. Atualizar a Ordem de Trabalho
        $sql_ot = "UPDATE ordens_trabalho SET 
                    estado = 'Concluída',
                    relatorio_tecnico = :relatorio,
                    tempo_gasto = :tempo,
                    data_fecho = NOW()
                   WHERE id = :id_ot";
        $stmt_ot = $pdo->prepare($sql_ot);
        $stmt_ot->execute([
            ':relatorio' => $relatorio,
            ':tempo' => $tempo,
            ':id_ot' => $id_ot
        ]);

        // 2. Atualizar o Estado do Equipamento na tabela principal
        $sql_eq = "UPDATE equipamentos SET estado = :novo_estado WHERE id = :id_equipamento";
        $stmt_eq = $pdo->prepare($sql_eq);
        $stmt_eq->execute([
            ':novo_estado' => $novo_estado,
            ':id_equipamento' => $id_equipamento
        ]);

        // Confirmar a transação
        $pdo->commit();
        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Encerrou a Ordem de Trabalho (ID: $id_ot) e definiu estado do equipamento (ID: $id_equipamento) como '$novo_estado'", "Manutenção");
        }
        header("Location: /gira/private/manutencoes/manutencao.php?sucesso=ot_fechada");
        exit;
    } catch (PDOException $e) {
        // Se houver erro, desfaz tudo
        $pdo->rollBack();
        die("Erro crítico ao fechar OT: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/manutencoes/manutencao.php");
    exit;
}
