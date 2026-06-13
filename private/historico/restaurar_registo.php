<?php
require_once __DIR__ . '/../db.php';
session_start();

// Verifica se tem permissões e se recebeu a Tabela e o ID
if (isset($_GET['tabela']) && isset($_GET['id']) && is_numeric($_GET['id']) && $_SESSION['nivel_acesso'] >= 3) {

    $tabela = $_GET['tabela'];
    $id_registo = (int) $_GET['id'];

    // DEFESA CONTRA INJEÇÃO DE SQL (Lista Branca de tabelas permitidas)
    $tabelas_permitidas = ['equipamentos', 'utilizadores', 'perfis_acesso', 'ordens_trabalho', 'documentos_equipamento', 'fornecedores', 'localizacoes', 'artigos_armazem'];

    if (!in_array($tabela, $tabelas_permitidas)) {
        die("Ação não autorizada. Tabela inválida.");
    }

    try {
        // A MÁGICA: Colocar o apagado_em a NULL (trazendo o registo de volta à vida)
        $sql = "UPDATE $tabela SET apagado_em = NULL WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id_registo]);

        // Registar a ação no Log
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Restaurou o registo (ID: $id_registo) da área '$tabela'", "Auditoria");
        }

        header("Location: /sibdas/1241251/gira/private/historico/historico.php?sucesso=restaurado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao tentar restaurar o registo: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/historico/historico.php");
    exit;
}
