<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $nome = trim($_POST['nome_perfil'] ?? '');
    $nivel = $_POST['nivel_acesso'] ?? '';

    // Validações de Domínio
    if ($e = validar_nome_perfil($nome)) $erros[] = $e;
    if ($e = validar_nivel_acesso($nivel)) $erros[] = $e;

    // Devolver à página em caso de erro
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalAdicionarPerfil';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
        exit;
    }

    $sql = "INSERT INTO perfis_acesso (nome_perfil, nivel_acesso) VALUES (:nome, :nivel)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nome' => $nome, ':nivel' => (int) $nivel]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Criou o novo perfil de acesso: " . $nome, "Perfis");
        }
        header("Location: /sibdas/1241251/gira/private/perfis/perfis.php?sucesso=perfil_criado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro na base de dados: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalAdicionarPerfil';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
    exit;
}
