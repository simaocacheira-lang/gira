<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id_para_apagar = (int) $_POST['id'];

    try {
        // 2. VERIFICAÇÃO DE SEGURANÇA: Este fornecedor tem equipamentos associados?
        $sql_verificar = "SELECT COUNT(*) FROM equipamentos WHERE fornecedor_id = :id";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([':id' => $id_para_apagar]);
        $equipamentos_associados = $stmt_verificar->fetchColumn();

        // 3. LÓGICA DE DEFESA
        if ($equipamentos_associados > 0) {
            // O fornecedor tem equipamentos associados! Abortar.
            header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php?erro=fornecedor_ocupado");
            exit;
        } else {
            // Ir buscar o nome do fornecedor ANTES de o apagar, para podermos guardar no Log
            $stmt_nome = $pdo->prepare("SELECT nome_empresa FROM fornecedores WHERE id = :id");
            $stmt_nome->execute([':id' => $id_para_apagar]);
            $fornecedor = $stmt_nome->fetch();
            $nome_empresa = $fornecedor ? $fornecedor['nome_empresa'] : "Empresa Desconhecida";

            // O fornecedor está "limpo". É seguro apagar.
            $sql_apagar = "UPDATE fornecedores SET apagado_em = NOW() WHERE id = :id";
            $stmt_apagar = $pdo->prepare($sql_apagar);
            $stmt_apagar->execute([':id' => $id_para_apagar]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Removeu o contrato e o fornecedor: " . $nome_empresa, "Fornecedores", "fornecedores", $id_para_apagar);
            }

            header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php?sucesso=eliminado");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao processar eliminação: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/fornecedores/fornecedores.php");
    exit;
}
