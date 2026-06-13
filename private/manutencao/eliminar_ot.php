<?php
// Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// Verificar se recebemos um ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id_ot = (int) $_GET['id'];

    try {
        // 1. Descobrir qual é o número da OT para o Log de Auditoria
        $stmt_info = $pdo->prepare("SELECT numero_ot FROM ordens_trabalho WHERE id = :id");
        $stmt_info->execute([':id' => $id_ot]);
        $ot = $stmt_info->fetch();

        if ($ot) {
            // 2. Apagar a OT da base de dados
            $sql = "UPDATE ordens_trabalho SET apagado_em = NOW() WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id_ot]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Cancelou/Eliminou a Ordem de Trabalho: " . $ot['numero_ot'], "Manutenção", "ordens_trabalho", $id_ot);
            }
        }

        // 4. Voltar para a página de manutenção com a mensagem de sucesso
        header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php?sucesso=ot_eliminada");
        exit;
    } catch (PDOException $e) {
        die("Erro ao eliminar a Ordem de Trabalho: " . $e->getMessage());
    }
} else {
    // Se acederem diretamente ao ficheiro, expulsa de volta
    header("Location: /sibdas/1241251/gira/private/manutencao/manutencao.php");
    exit;
}
