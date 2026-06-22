<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id_para_apagar = (int) $_POST['id'];

    try {
        // 2. A CORREÇÃO DE LÓGICA: Contar apenas os equipamentos que estão ATIVOS (apagado_em IS NULL)
        $sql_verificar = "SELECT COUNT(*) FROM equipamentos WHERE localizacao_id = :id AND apagado_em IS NULL";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([':id' => $id_para_apagar]);
        $equipamentos_na_sala = $stmt_verificar->fetchColumn();

        if ($equipamentos_na_sala > 0) {
            // A sala tem equipamentos reais, abortar eliminação!
            header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?erro=sala_ocupada");
            exit;
        } else {
            // Ir buscar o código identificador da sala antes de a apagar para o Log
            $stmt_info = $pdo->prepare("SELECT cod_sala FROM localizacoes WHERE id = :id");
            $stmt_info->execute([':id' => $id_para_apagar]);
            $sala = $stmt_info->fetch();
            $cod_sala = $sala ? $sala['cod_sala'] : "Sala Desconhecida";

            // A sala está realmente vazia. É seguro destruir logicamente.
            $sql_apagar = "UPDATE localizacoes SET apagado_em = NOW() WHERE id = :id";
            $stmt_apagar = $pdo->prepare($sql_apagar);
            $stmt_apagar->execute([':id' => $id_para_apagar]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Removeu a localização do mapa hospitalar: " . $cod_sala, "Localizações", "localizacoes", $id_para_apagar);
            }

            header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?sucesso=localizacao_eliminada");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro Crítico na BD: " . $e->getMessage());
    }
} else {
    // Se alguém tentar aceder via link direto, volta para a tabela
    header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
    exit;
}
