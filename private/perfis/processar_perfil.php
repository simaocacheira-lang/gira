<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome_perfil']);
    $nivel = (int) $_POST['nivel_acesso'];

    $sql = "INSERT INTO perfis_acesso (nome_perfil, nivel_acesso) VALUES (:nome, :nivel)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nome' => $nome, ':nivel' => $nivel]);
        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Criou o novo perfil de acesso: " . $nome, "Perfis");
        }
        header("Location: /gira/private/perfis/perfis.php?sucesso=perfil_criado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao criar perfil: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/perfis/perfis.php");
    exit;
}
