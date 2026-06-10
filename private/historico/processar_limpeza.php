<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // O comando TRUNCATE apaga tudo instantaneamente e reinicia os IDs
        $pdo->exec("TRUNCATE TABLE logs_auditoria");

        // O TOQUE DE MESTRE: Após limparmos, deixamos um único log a registar quem limpou!
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Efetuou a purga total do histórico do sistema", "Auditoria");
        }

        header("Location: /sibdas/1241251/gira/private/historico/historico.php?sucesso=limpeza");
        exit;
    } catch (PDOException $e) {
        die("Erro ao limpar os logs: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/historico/historico.php");
    exit;
}
