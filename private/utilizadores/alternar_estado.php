<?php
// Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_utilizador = (int) $_GET['id'];

    try {
        // 1. Ir à base de dados ver qual é o estado atual do utilizador
        $stmt_check = $pdo->prepare("SELECT estado FROM utilizadores WHERE id = :id");
        $stmt_check->execute([':id' => $id_utilizador]);
        $user = $stmt_check->fetch();

        if ($user) {
            // 2. Inverter a lógica: Se está Ativo passa a Suspenso, e vice-versa
            $novo_estado = ($user['estado'] == 'Ativo') ? 'Suspenso' : 'Ativo';

            // 3. Atualizar na base de dados
            $stmt_update = $pdo->prepare("UPDATE utilizadores SET estado = :novo_estado WHERE id = :id");
            $stmt_update->execute([
                ':novo_estado' => $novo_estado,
                ':id' => $id_utilizador
            ]);
        }

        // Volta para a página com sucesso
        header("Location: /gira/private/utilizadores/utilizadores.php?sucesso=estado_alterado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao alterar o estado do utilizador: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/utilizadores/utilizadores.php");
    exit;
}
