<?php
require_once __DIR__ . '/../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /sibdas/1241251/gira/public/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST['acao'];
    $meu_id = $_SESSION['user_id'];

    try {
        if ($acao === 'dados') {
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $cedula = trim($_POST['cedula']);
            if (empty($cedula)) $cedula = null;

            if (preg_match('/\d/', $nome)) {
                header("Location: /sibdas/1241251/gira/private/meu_perfil/meu_perfil.php?erro=nome_invalido");
                exit;
            }

            $sql = "UPDATE utilizadores SET nome = :nome, email = :email, cedula = :cedula WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':email' => $email, ':cedula' => $cedula, ':id' => $meu_id]);

            $_SESSION['nome'] = $nome;

            if (function_exists('registar_log')) {
                registar_log($pdo, $meu_id, "Atualizou os dados do seu próprio perfil", "Conta Pessoal");
            }

            header("Location: /sibdas/1241251/gira/private/meu_perfil/meu_perfil.php?sucesso=1");
            exit;
        } elseif ($acao === 'password') {
            $nova_pass = $_POST['nova_pass'];
            $confirma_pass = $_POST['confirma_pass'];

            if ($nova_pass !== $confirma_pass) {
                header("Location: /sibdas/1241251/gira/private/meu_perfil/meu_perfil.php?erro=pass_mismatch");
                exit;
            }

            $hash = password_hash($nova_pass, PASSWORD_DEFAULT);
            $sql = "UPDATE utilizadores SET password_hash = :hash WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':hash' => $hash, ':id' => $meu_id]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $meu_id, "Alterou a sua palavra-passe", "Segurança");
            }

            header("Location: /sibdas/1241251/gira/private/logout.php");
            exit;
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header("Location: /sibdas/1241251/gira/private/meu_perfil/meu_perfil.php?erro=email_duplicado");
            exit;
        }
        die("Erro ao atualizar perfil: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/meu_perfil/meu_perfil.php");
    exit;
}
