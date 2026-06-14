<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    // 1. RECOLHER DADOS
    $artigo_id = (int) ($_POST['artigo_id'] ?? 0);
    $quantidade = (int) ($_POST['quantidade'] ?? 0);
    $data_prevista = $_POST['data_prevista'] ?? '';
    $notas = trim($_POST['notas'] ?? '');

    // 2. VALIDAÇÕES
    if ($artigo_id <= 0) {
        $erros[] = "Tem de selecionar um artigo válido do catálogo.";
    }
    if ($quantidade <= 0) {
        $erros[] = "A quantidade a encomendar tem de ser superior a zero.";
    }

    // Validação da Data (Não pode ser no passado comparado à meia-noite de hoje)
    if (empty($data_prevista)) {
        $erros[] = "A Data Prevista de Chegada é obrigatória.";
    } elseif (strtotime($data_prevista) < strtotime(date('Y-m-d'))) {
        $erros[] = "A data prevista de entrega não pode ser anterior ao dia de hoje.";
    }

    // 3. DECISÃO: Devolver Erros?
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalNovaEncomenda';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
        exit;
    }

    // 4. GRAVAR NA BD (Usando Transações para garantir segurança dupla)
    try {
        $pdo->beginTransaction();

        $sql_enc = "INSERT INTO encomendas_armazem (artigo_id, quantidade, data_prevista, notas) 
                VALUES (:artigo_id, :quantidade, :data_prevista, :notas)";
        $stmt_enc = $pdo->prepare($sql_enc);
        $stmt_enc->execute([
            ':artigo_id' => $artigo_id,
            ':quantidade' => $quantidade,
            ':data_prevista' => $data_prevista,
            ':notas' => $notas
        ]);

        $sql_upd = "UPDATE artigos_armazem SET quantidade_em_transito = quantidade_em_transito + :qtd WHERE id = :id";
        $stmt_upd = $pdo->prepare($sql_upd);
        $stmt_upd->execute([
            ':qtd' => $quantidade,
            ':id' => $artigo_id
        ]);

        $stmt_art = $pdo->prepare("SELECT nome, referencia FROM artigos_armazem WHERE id = :id");
        $stmt_art->execute([':id' => $artigo_id]);
        $artigo = $stmt_art->fetch();
        $nome_artigo = $artigo ? $artigo['referencia'] . ' - ' . $artigo['nome'] : "Artigo Desconhecido";

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Efetuou uma encomenda de $quantidade uni. para o artigo: $nome_artigo", "Armazém");
        }

        $pdo->commit();
        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php?sucesso=encomenda_criada");
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['erros'] = ["Erro crítico ao registar a encomenda: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalNovaEncomenda';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
    exit;
}
