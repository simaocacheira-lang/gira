<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar o ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id_para_apagar = (int) $_GET['id'];

    try {
        // IR BUSCAR O CÓDIGO DO EQUIPAMENTO ANTES DE O APAGAR PARA O LOG!
        $stmt_info = $pdo->prepare("SELECT codigo_ativo, nome FROM equipamentos WHERE id = :id");
        $stmt_info->execute([':id' => $id_para_apagar]);
        $eq = $stmt_info->fetch();
        $identificador_eq = $eq ? $eq['codigo_ativo'] . " - " . $eq['nome'] : "ID Desconhecido ($id_para_apagar)";

        // 3. Comando SQL de destruição
        $sql = "UPDATE equipamentos SET apagado_em = NOW() WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id_para_apagar]);
        
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Abateu do inventário o equipamento: " . $identificador_eq, "Equipamentos", "equipamentos", $id_para_apagar);
        }

        // 5. Missão cumprida
        header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php?sucesso=eliminado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao eliminar o equipamento na base de dados: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}
