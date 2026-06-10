<?php
require_once __DIR__ . '/../db.php';
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_para_apagar = (int) $_GET['id'];

    try {
        // 2. VERIFICAÇÃO DE SEGURANÇA: Quantos equipamentos estão nesta sala?
        $sql_verificar = "SELECT COUNT(*) FROM equipamentos WHERE localizacao_id = :id";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([':id' => $id_para_apagar]);
        $equipamentos_na_sala = $stmt_verificar->fetchColumn();

        if ($equipamentos_na_sala > 0) {
            header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?erro=sala_ocupada");
            exit;
        } else {
            // Ir buscar o código identificador da sala antes de a apagar para o Log
            $stmt_info = $pdo->prepare("SELECT cod_sala FROM localizacoes WHERE id = :id");
            $stmt_info->execute([':id' => $id_para_apagar]);
            $sala = $stmt_info->fetch();
            $cod_sala = $sala ? $sala['cod_sala'] : "Sala Desconhecida";

            // A sala está vazia. É seguro destruir.
            $sql_apagar = "DELETE FROM localizacoes WHERE id = :id";
            $stmt_apagar = $pdo->prepare($sql_apagar);
            $stmt_apagar->execute([':id' => $id_para_apagar]);

            // --> TRANSMISSOR DE LOG <--
            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Removeu a localização do mapa hospitalar: " . $cod_sala, "Localizações");
            }

            header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?sucesso=eliminado");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao processar eliminação: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
    exit;
}
