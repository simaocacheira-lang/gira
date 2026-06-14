<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $id = (int) ($_POST['id_perfil'] ?? 0);
    $nome = trim($_POST['nome_perfil'] ?? '');
    $nivel = $_POST['nivel_acesso'] ?? '';

    // Validações de Domínio
    if ($e = validar_nome_perfil($nome)) $erros[] = $e;
    if ($e = validar_nivel_acesso($nivel)) $erros[] = $e;

    // A regra de negócio dourada: proteger o ID 1
    if ($id === 1 && (int)$nivel < 3) {
        $erros[] = "Ação Bloqueada: Não podes despromover o perfil original de Administração.";
    }

    // Devolver à página em caso de erro
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalEditarPerfil';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
        exit;
    }

    $sql = "UPDATE perfis_acesso SET nome_perfil = :nome, nivel_acesso = :nivel WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nome' => $nome, ':nivel' => (int) $nivel, ':id' => $id]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Editou o perfil de acesso: " . $nome . " (Nível " . $nivel . ")", "Perfis");
        }
        header("Location: /sibdas/1241251/gira/private/perfis/perfis.php?sucesso=perfil_editado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro na base de dados: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalEditarPerfil';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
    exit;
}
