<?php
require_once __DIR__ . '/../db.php';
session_start();

if (!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] < 3) {
    header("Location: /sibdas/1241251/gira/private/dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $nome = trim($_POST['nome'] ?? '');
    $cedula = trim($_POST['cedula'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_limpa = $_POST['password'] ?? '';
    $perfil_id = $_POST['perfil_id'] ?? '';

    // Chamada limpa das nossas funções de domínio
    if ($e = validar_nome_utilizador($nome)) $erros[] = $e;
    if ($e = validar_cedula_opcional($cedula)) $erros[] = $e;
    if ($e = validar_email_obrigatorio($email)) $erros[] = $e;
    if ($e = validar_password_forte($password_limpa)) $erros[] = $e;
    if ($e = validar_selecao_perfil($perfil_id)) $erros[] = $e;

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalCriarUtilizador';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
        exit;
    }

    $password_encriptada = password_hash($password_limpa, PASSWORD_DEFAULT);
    $cedula = empty($cedula) ? null : $cedula;

    $sql = "INSERT INTO utilizadores (nome, cedula, email, password_hash, perfil_id) VALUES (:nome, :cedula, :email, :password, :perfil)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nome' => $nome, ':cedula' => $cedula, ':email' => $email, ':password' => $password_encriptada, ':perfil' => (int) $perfil_id]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Criou o utilizador: $nome ($email)", "Utilizadores");
        }
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?sucesso=utilizador_criado");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['erros'] = ["Erro: O E-mail ou a Cédula inseridos já se encontram registados noutra conta."];
        } else {
            $_SESSION['erros'] = ["Erro na base de dados: " . $e->getMessage()];
        }
        $_SESSION['modal_aberto'] = 'modalCriarUtilizador';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
    exit;
}
