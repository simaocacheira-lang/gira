<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Comando INSERT
    $sql = "INSERT INTO fornecedores (nome_empresa, nif, especialidade, estado, email_suporte, telefone_suporte) 
            VALUES (:nome, :nif, :esp, :estado, :email, :telefone)";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nome'     => $_POST['nome_empresa'],
            ':nif'      => $_POST['nif'],
            ':esp'      => $_POST['especialidade'],
            ':estado'   => $_POST['estado'],
            ':email'    => !empty($_POST['email_suporte']) ? $_POST['email_suporte'] : null,
            ':telefone' => !empty($_POST['telefone_suporte']) ? $_POST['telefone_suporte'] : null
        ]);

        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Registou o novo fornecedor: " . $_POST['nome_empresa'], "Fornecedores");
        }

        // Sucesso! Volta ao ecrã dos fornecedores
        header("Location: /gira/private/fornecedores/fornecedores.php?sucesso=registado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao registar fornecedor (o NIF pode já existir): " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/fornecedores/fornecedores.php");
    exit;
}
