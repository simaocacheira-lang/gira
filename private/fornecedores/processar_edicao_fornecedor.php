<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_fornecedor = (int) $_POST['id_fornecedor'];
    $erros = [];
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/fornecedores/fornecedores.php';

    $nome = trim($_POST['nome_empresa'] ?? '');
    $nif = trim($_POST['nif'] ?? '');
    $email = trim($_POST['email_suporte'] ?? '');
    $telefone = trim($_POST['telefone_suporte'] ?? '');
    $especialidade = $_POST['especialidade'] ?? '';
    $estado = $_POST['estado'] ?? 'Ativo';

    if ($e = validar_texto_obrigatorio($nome, 100, "Nome da Empresa")) $erros[] = $e;
    if ($e = validar_nif($nif)) $erros[] = $e;
    if ($e = validar_email_obrigatorio($email)) $erros[] = $e;
    if ($e = validar_telefone_obrigatorio($telefone)) $erros[] = $e;
    if (empty($especialidade)) $erros[] = "A Especialidade é obrigatória.";

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalEditarFornecedor';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
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
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
        header("Location: " . $url_origem . $separador . "sucesso=editado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro: O NIF inserido já pertence a outro fornecedor."];
        $_SESSION['modal_aberto'] = 'modalEditarFornecedor';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
}
