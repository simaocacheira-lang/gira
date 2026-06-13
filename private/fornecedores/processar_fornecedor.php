<?php
// 1. Ligar à Base de Dados e carregar as funções de validação
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $erros = []; // Inicializamos a nossa "cesta" de erros (Conceito Cap 0703)

    // 2. RECOLHER E VALIDAR OS DADOS
    $nome_empresa = $_POST['nome_empresa'] ?? '';
    $nif = $_POST['nif'] ?? '';
    $email = $_POST['email_suporte'] ?? '';
    $telefone = $_POST['telefone_suporte'] ?? '';
    $especialidade = $_POST['especialidade'] ?? '';
    $estado = $_POST['estado'] ?? 'Ativo';

    // Acumular TODOS os erros simultaneamente!
    if ($e = validar_texto_obrigatorio($nome_empresa, 100, "Nome da Empresa")) $erros[] = $e;
    if ($e = validar_nif($nif)) $erros[] = $e;
    if ($e = validar_email_opcional($email)) $erros[] = $e;
    if ($e = validar_telefone_opcional($telefone)) $erros[] = $e;

    if (empty($especialidade)) {
        $erros[] = "É obrigatório selecionar uma Especialidade / Equipamentos.";
    }

    // 3. DECISÃO: Gravar ou Devolver Erros?
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalRegistarFornecedor'; // <-- FALTAVA ISTO (Avisa qual modal abrir)
        $_SESSION['dados_form'] = $_POST;                      // <-- FALTAVA ISTO (Guarda o que estava escrito)
        header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php");
        exit;
    }

    // 4. GRAVAÇÃO NA BASE DE DADOS (Como não há erros, avança com segurança)
    $sql = "INSERT INTO fornecedores (nome_empresa, nif, especialidade, estado, email_suporte, telefone_suporte) 
            VALUES (:nome, :nif, :esp, :estado, :email, :telefone)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome'     => $nome_empresa,
            ':nif'      => $nif,
            ':esp'      => $especialidade,
            ':estado'   => $estado,
            ':email'    => !empty($email) ? $email : null,
            ':telefone' => !empty($telefone) ? $telefone : null
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Registou o novo fornecedor: " . $nome_empresa, "Fornecedores");
        }

        header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php?sucesso=registado");
        exit;
    } catch (PDOException $e) {
        // Se a BD der erro por duplicação (o NIF é UNIQUE na tua BD)
        $_SESSION['erros'] = ["Este NIF já se encontra registado noutro fornecedor do sistema."];
        $_SESSION['modal_aberto'] = 'modalRegistarFornecedor'; // <-- ADICIONAR AQUI TAMBÉM
        $_SESSION['dados_form'] = $_POST;                      // <-- ADICIONAR AQUI TAMBÉM
        header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php");
    exit;
}
