<?php
require_once __DIR__ . '/../db.php';
session_start();

if (!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] < 3) {
    header("Location: /sibdas/1241251/gira/private/dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $id = (int) ($_POST['id_utilizador'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $cedula = trim($_POST['cedula'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $perfil_id = $_POST['perfil_id'] ?? '';
    $nova_password = $_POST['password'] ?? '';

    // Validações
    if ($e = validar_nome_utilizador($nome)) $erros[] = $e;
    if ($e = validar_cedula_opcional($cedula)) $erros[] = $e;
    if ($e = validar_email_obrigatorio($email)) $erros[] = $e;
    if ($e = validar_selecao_perfil($perfil_id)) $erros[] = $e;

    // Se o utilizador escreveu uma nova password, temos de a validar. Se estiver vazia, não há problema (não quer alterar).
    if (!empty($nova_password)) {
        if ($e = validar_password_forte($nova_password)) $erros[] = $e;
    }

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalEditarUtilizador';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
        exit;
    }

    $cedula = empty($cedula) ? null : $cedula;

    try {
        if (!empty($nova_password)) {
            $hash = password_hash($nova_password, PASSWORD_DEFAULT);
            $sql = "UPDATE utilizadores SET nome = :nome, cedula = :cedula, email = :email, perfil_id = :perfil, password_hash = :hash WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':cedula' => $cedula, ':email' => $email, ':perfil' => (int)$perfil_id, ':hash' => $hash, ':id' => $id]);
        } else {
            $sql = "UPDATE utilizadores SET nome = :nome, cedula = :cedula, email = :email, perfil_id = :perfil WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':cedula' => $cedula, ':email' => $email, ':perfil' => (int)$perfil_id, ':id' => $id]);
        }

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Atualizou os dados/acessos do utilizador: " . $nome, "Utilizadores");
        }
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?sucesso=utilizador_editado");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['erros'] = ["Erro: O E-mail ou a Cédula já estão a ser utilizados por outra pessoa."];
        } else {
            $_SESSION['erros'] = ["Erro na base de dados: " . $e->getMessage()];
        }
        $_SESSION['modal_aberto'] = 'modalEditarUtilizador';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
    exit;
}
