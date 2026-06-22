<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id_para_apagar = (int) $_POST['id'];
    
    // 2. DEFESA CRÍTICA: Não podes apagar a tua própria conta!
    if ($id_para_apagar === (int)$_SESSION['user_id']) {
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?erro=auto_eliminacao");
        exit;
    }

    try {
        // Ir buscar o nome e email antes de apagar para o Log
        $stmt_info = $pdo->prepare("SELECT nome, email FROM utilizadores WHERE id = :id");
        $stmt_info->execute([':id' => $id_para_apagar]);
        $user = $stmt_info->fetch();
        $identificador = $user ? $user['nome'] . " (" . $user['email'] . ")" : "ID Desconhecido";


        // Apagar o utilizador
        $sql_apagar = "UPDATE utilizadores SET apagado_em = NOW() WHERE id = :id";
        $stmt_apagar = $pdo->prepare($sql_apagar);
        $stmt_apagar->execute([':id' => $id_para_apagar]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Eliminou o utilizador: " . $identificador, "Utilizadores", "utilizadores", $id_para_apagar);
        }

        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?sucesso=utilizador_eliminado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao eliminar utilizador: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
    exit;
}
