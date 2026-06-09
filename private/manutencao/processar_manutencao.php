<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Gerar o número da OT automaticamente (Ex: OT-2026-B8F2)
    $numero_ot = 'OT-2026-' . strtoupper(substr(uniqid(), -4));

    // 3. Preparar o comando de Inserção
    $sql = "INSERT INTO ordens_trabalho (numero_ot, equipamento_id, tipo_manutencao, prioridade, descricao_avaria) 
            VALUES (:numero, :equipamento, :tipo, :prioridade, :descricao)";

    try {
        $stmt = $pdo->prepare($sql);

        // 4. Injetar os dados do formulário
        $stmt->execute([
            ':numero'      => $numero_ot,
            ':equipamento' => (int) $_POST['equipamento_id'],
            ':tipo'        => $_POST['tipo_manutencao'],
            ':prioridade'  => $_POST['prioridade'],
            ':descricao'   => $_POST['descricao_avaria']
        ]);
        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            $id_eq = (int)$_POST['equipamento_id'];
            registar_log($pdo, $_SESSION['user_id'], "Emitiu a Ordem de Trabalho $numero_ot para o equipamento ID: $id_eq", "Manutenção");
        }
        header("Location: /gira/private/manutencao/manutencao.php?sucesso=ot_criada");
        exit;
    } catch (PDOException $e) {
        die("Erro ao emitir Ordem de Trabalho: " . $e->getMessage());
    }
} else {
    // Redirecionamento de segurança alterado para manutenção também
    header("Location: /gira/private/manutencao/manutencao.php");
    exit;
}
