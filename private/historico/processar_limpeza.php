<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. APANHAR A ORIGEM
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/historico/historico.php';

    try {
        // O comando TRUNCATE apaga tudo instantaneamente e reinicia os IDs
        $pdo->exec("TRUNCATE TABLE logs_auditoria");

        // O TOQUE DE MESTRE: Após limparmos, deixamos um único log a registar quem limpou!
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Efetuou a purga total do histórico do sistema", "Auditoria");
        }

        // 2. REDIRECIONAMENTO COM SUCESSO
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';

        header("Location: " . $url_origem . $separador . "sucesso=limpeza");
        exit;
    } catch (PDOException $e) {
        die("Erro ao limpar os logs: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/historico/historico.php");
    exit;
}
