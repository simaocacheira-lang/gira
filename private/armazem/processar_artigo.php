<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    // 1. RECOLHER DADOS (Agora com a captura da categoria)
    $referencia = trim($_POST['referencia'] ?? '');
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $fornecedor_id = (int) ($_POST['fornecedor_id'] ?? 0);
    $quantidade_atual = (int) ($_POST['quantidade_atual'] ?? 0);
    $quantidade_minima = (int) ($_POST['quantidade_minima'] ?? 0);

    // 2. VALIDAÇÕES
    if ($e = validar_texto_obrigatorio($referencia, 50, "Referência / SKU")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($nome, 100, "Nome do Consumível")) $erros[] = $e;
    if (empty($categoria)) $erros[] = "A Categoria do artigo é obrigatória.";

    if ($fornecedor_id <= 0) $erros[] = "Tem de selecionar um fornecedor.";
    if ($quantidade_atual < 0) $erros[] = "A quantidade atual no armazém não pode ser negativa.";
    if ($quantidade_minima < 0) $erros[] = "O alerta de stock mínimo não pode ser negativo.";

    // 3. DECISÃO: Gravar ou Devolver Erros?
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalNovoArtigo';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
        exit;
    }

    // 4. GRAVAÇÃO NA BASE DE DADOS (Agora enviamos a categoria para a coluna correspondente)
    $sql = "INSERT INTO artigos_armazem (referencia, nome, categoria, fornecedor_id, quantidade_atual, quantidade_minima, quantidade_em_transito) 
            VALUES (:ref, :nome, :categoria, :forn, :qtd_atual, :qtd_min, 0)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ref' => $referencia,
            ':nome' => $nome,
            ':categoria' => $categoria,
            ':forn' => $fornecedor_id,
            ':qtd_atual' => $quantidade_atual,
            ':qtd_min' => $quantidade_minima
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Adicionou o artigo '$referencia - $nome' ao catálogo", "Armazém");
        }

        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php?sucesso=artigo_criado");
        exit;
    } catch (PDOException $e) {
        // Separação inteligente de erros da Base de Dados
        if ($e->getCode() == 23000) {
            $_SESSION['erros'] = ["Erro: Já existe um artigo com esta Referência/SKU no catálogo."];
        } else {
            $_SESSION['erros'] = ["Erro na base de dados: " . $e->getMessage()];
        }

        $_SESSION['modal_aberto'] = 'modalNovoArtigo';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
    exit;
}
