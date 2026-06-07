<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/db.php';
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_para_apagar = (int) $_GET['id'];

    try {
        // 2. VERIFICAÇÃO DE SEGURANÇA: Quantos equipamentos estão nesta sala?
        $sql_verificar = "SELECT COUNT(*) FROM equipamentos WHERE localizacao_id = :id";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([':id' => $id_para_apagar]);
        $equipamentos_na_sala = $stmt_verificar->fetchColumn();

        // 3. A LÓGICA DE DEFESA
        if ($equipamentos_na_sala > 0) {
            // A sala tem máquinas! Abortar missão e devolver erro.
            header("Location: /gira/private/localizacoes.php?erro=sala_ocupada");
            exit;
        } else {
            // A sala está vazia. É seguro destruir.
            $sql_apagar = "DELETE FROM localizacoes WHERE id = :id";
            $stmt_apagar = $pdo->prepare($sql_apagar);
            $stmt_apagar->execute([':id' => $id_para_apagar]);

            header("Location: /gira/private/localizacoes.php?sucesso=eliminado");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao processar eliminação: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/localizacoes.php");
    exit;
}
