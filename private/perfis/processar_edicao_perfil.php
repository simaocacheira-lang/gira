<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST['id_perfil'];
    $nome = trim($_POST['nome_perfil']);
    $nivel = (int) $_POST['nivel_acesso'];

    try {
        // Bloqueio de segurança: Não deixar despromover o perfil original (ID 1)
        if ($id === 1 && $nivel < 3) {
            die("<div style='padding:20px; font-family:sans-serif;'><h3>Ação Bloqueada</h3><p>Não podes despromover o perfil original de Administração.</p><a href='javascript:history.back()'>Voltar atrás</a></div>");
        }

        $sql = "UPDATE perfis_acesso SET nome_perfil = :nome, nivel_acesso = :nivel WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nome' => $nome, ':nivel' => $nivel, ':id' => $id]);
        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Editou o perfil de acesso: " . $nome . " (Nível " . $nivel . ")", "Perfis");
        }
        header("Location: /gira/private/perfis/perfis.php?sucesso=perfil_editado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao editar o perfil: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/perfis/perfis.php");
    exit;
}
