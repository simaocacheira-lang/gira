<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// Defesa Absoluta: Expulsar quem não for Administrador (Nível 3)
if (!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] < 3) {
    header("Location: /sibdas/1241251/gira/private/dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $erros = [];

    // 2. RECOLHER E VALIDAR OS DADOS
    $nome = trim($_POST['nome'] ?? '');
    $cedula = trim($_POST['cedula'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_limpa = $_POST['password'] ?? '';
    $perfil_id = $_POST['perfil_id'] ?? '';

    if ($e = validar_texto_obrigatorio($nome, 100, "Nome Completo")) $erros[] = $e;

    // Validação de E-mail Obrigatório
    if (empty($email)) {
        $erros[] = "O campo 'E-mail de Acesso' é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O formato do e-mail inserido é inválido.";
    }

    if ($e = validar_password_forte($password_limpa)) $erros[] = $e;

    if (empty($perfil_id)) $erros[] = "É obrigatório selecionar um Perfil de Acesso.";

    // 3. DECISÃO: Gravar ou Devolver Erros?
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalCriarUtilizador';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
        exit;
    }

    // 4. GRAVAÇÃO SEGURA NA BASE DE DADOS
    $password_encriptada = password_hash($password_limpa, PASSWORD_DEFAULT);
    $cedula = empty($cedula) ? null : $cedula;

    $sql = "INSERT INTO utilizadores (nome, cedula, email, password_hash, perfil_id) 
            VALUES (:nome, :cedula, :email, :password, :perfil)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':cedula' => $cedula,
            ':email' => $email,
            ':password' => $password_encriptada,
            ':perfil' => (int) $perfil_id
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Criou o utilizador: $nome ($email)", "Utilizadores");
        }

        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?sucesso=utilizador_criado");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['erros'] = ["O E-mail ou a Cédula inseridos já se encontram registados no sistema."];
            $_SESSION['modal_aberto'] = 'modalCriarUtilizador';
            $_SESSION['dados_form'] = $_POST;
        } else {
            $_SESSION['erros'] = ["Erro crítico na base de dados: " . $e->getMessage()];
        }
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
    exit;
}
