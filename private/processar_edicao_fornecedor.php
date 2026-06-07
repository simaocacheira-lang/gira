<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Segurança: Confirmar que o ID não se perdeu
    if (empty($_POST['id_fornecedor'])) {
        die("Erro Crítico: O ID do fornecedor desapareceu.");
    }

    // 2. Comando UPDATE
    $sql = "UPDATE fornecedores SET 
                nome_empresa = :nome,
                nif = :nif,
                especialidade = :esp,
                estado = :estado,
                email_suporte = :email,
                telefone_suporte = :telefone
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        // 3. Injetar as alterações na base de dados
        $stmt->execute([
            ':id'       => (int) $_POST['id_fornecedor'],
            ':nome'     => $_POST['nome_empresa'],
            ':nif'      => $_POST['nif'],
            ':esp'      => $_POST['especialidade'],
            ':estado'   => $_POST['estado'],
            ':email'    => !empty($_POST['email_suporte']) ? $_POST['email_suporte'] : null,
            ':telefone' => !empty($_POST['telefone_suporte']) ? $_POST['telefone_suporte'] : null
        ]);

        // 4. Sucesso! Recarregar a página
        header("Location: /gira/private/fornecedores.php?sucesso=editado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar o fornecedor: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/fornecedores.php");
    exit;
}
