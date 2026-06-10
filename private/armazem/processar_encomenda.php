<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $artigo_id = (int) $_POST['artigo_id'];
    $quantidade = (int) $_POST['quantidade'];
    $data_prevista = $_POST['data_prevista'];
    $notas = trim($_POST['notas']);

    try {
        // Iniciar transação: ou grava tudo, ou não grava nada
        $pdo->beginTransaction();

        // 1. Inserir a encomenda na tabela de registos
        $sql_enc = "INSERT INTO encomendas_armazem (artigo_id, quantidade, data_prevista, notas) 
                VALUES (:artigo_id, :quantidade, :data_prevista, :notas)";
        $stmt_enc = $pdo->prepare($sql_enc);
        $stmt_enc->execute([
            ':artigo_id' => $artigo_id,
            ':quantidade' => $quantidade,
            ':data_prevista' => $data_prevista,
            ':notas' => $notas
        ]);

        // 2. ATUALIZAR A TABELA DO ARMAZÉM: Somar a quantidade "Em Trânsito"
        $sql_upd = "UPDATE artigos_armazem SET quantidade_em_transito = quantidade_em_transito + :qtd WHERE id = :id";
        $stmt_upd = $pdo->prepare($sql_upd);
        $stmt_upd->execute([
            ':qtd' => $quantidade,
            ':id' => $artigo_id
        ]);

        // 3. Preparar o texto para o Histórico de Auditoria
        $stmt_art = $pdo->prepare("SELECT nome, referencia FROM artigos_armazem WHERE id = :id");
        $stmt_art->execute([':id' => $artigo_id]);
        $artigo = $stmt_art->fetch();
        $nome_artigo = $artigo ? $artigo['referencia'] . ' - ' . $artigo['nome'] : "Artigo Desconhecido";

        // 4. --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Efetuou uma encomenda de $quantidade uni. para o artigo: $nome_artigo", "Armazém");
        }

        // Confirmar todas as alterações na base de dados
        $pdo->commit();

        header("Location: /sibdas/1241251/gira/private/armazem/armazem.php?sucesso=encomenda_criada");
        exit;
    } catch (PDOException $e) {
        // Se houver erro, desfaz a transação
        $pdo->rollBack();
        die("Erro ao registar a encomenda: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/armazem/armazem.php");
    exit;
}
