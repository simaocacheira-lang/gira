<?php
// Ligar à Base de Dados (está uma pasta atrás)
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['nome']);
    $cedula = trim($_POST['cedula']);
    $email = trim($_POST['email']);
    $password_limpa = $_POST['password'];
    $perfil_id = (int) $_POST['perfil_id'];

    // =======================================================
    // APLICAÇÃO DA FICHA 13: VALIDAÇÃO COM PREG_MATCH
    // =======================================================
    // Verificar se contém apenas números ou mistura de Letras com números
    if (preg_match('/\d/', $nome)) {
        // Encontrou um número! Abortar e devolver à página com erro específico
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?erro=nome_invalido");
        exit;
    }

    // 1. SEGURANÇA MÁXIMA: Encriptar a palavra-passe antes de guardar!
    $password_encriptada = password_hash($password_limpa, PASSWORD_DEFAULT);

    // Se a cédula estiver vazia, guardamos como NULL para não dar erro de "Duplicado"
    if (empty($cedula)) {
        $cedula = null;
    }

    $sql = "INSERT INTO utilizadores (nome, cedula, email, password_hash, perfil_id) 
            VALUES (:nome, :cedula, :email, :password, :perfil)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':cedula' => $cedula,
            ':email' => $email,
            ':password' => $password_encriptada,
            ':perfil' => $perfil_id
        ]);
        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Criou o utilizador: $nome ($email)", "Utilizadores");
        }
        // Sucesso! Volta para a página de utilizadores
        header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php?sucesso=utilizador_criado");
        exit;
    } catch (PDOException $e) {
        // Se o email já existir, a base de dados vai bloquear e dar erro (devido ao UNIQUE)
        if ($e->getCode() == 23000) {
            die("<h3>Erro de Registo</h3><p>Esse e-mail ou cédula já está registado no sistema.</p><a href='javascript:history.back()'>Voltar atrás</a>");
        }
        die("Erro ao criar utilizador: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/utilizadores/utilizadores.php");
    exit;
}
