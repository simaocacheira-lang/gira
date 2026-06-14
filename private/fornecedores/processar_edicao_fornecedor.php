<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_fornecedor = (int) $_POST['id_fornecedor'];
    $erros = [];

    $nome = trim($_POST['nome_empresa'] ?? '');
    $nif = trim($_POST['nif'] ?? '');
    $email = trim($_POST['email_suporte'] ?? '');
    $telefone = trim($_POST['telefone_suporte'] ?? '');
    $especialidade = $_POST['especialidade'] ?? '';
    $estado = $_POST['estado'] ?? 'Ativo';

    if ($e = validar_texto_obrigatorio($nome, 100, "Nome da Empresa")) $erros[] = $e;
    if ($e = validar_nif($nif)) $erros[] = $e;
    if ($e = validar_email_opcional($email)) $erros[] = $e;
    if ($e = validar_telefone_opcional($telefone)) $erros[] = $e;
    if (empty($especialidade)) $erros[] = "A Especialidade é obrigatória.";

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalEditarFornecedor';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php");
        exit;
    }

    $sql = "UPDATE fornecedores SET nome_empresa = :nome, nif = :nif, especialidade = :esp, 
            estado = :estado, email_suporte = :email, telefone_suporte = :telefone WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id_fornecedor,
            ':nome' => $nome,
            ':nif' => $nif,
            ':esp' => $especialidade,
            ':estado' => $estado,
            ':email' => !empty($email) ? $email : null,
            ':telefone' => !empty($telefone) ? $telefone : null
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Editou os dados do fornecedor: " . $nome, "Fornecedores");
        }
        header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php?sucesso=atualizado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro: O NIF inserido já pertence a outro fornecedor."];
        $_SESSION['modal_aberto'] = 'modalEditarFornecedor';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php");
        exit;
    }
}
