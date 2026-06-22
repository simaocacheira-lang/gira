<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id_para_apagar = (int) $_POST['id'];

    try {
        // 2. DEFESA 1: É um perfil de Administração (Nível 3+)?
        $stmt_nivel = $pdo->prepare("SELECT nivel_acesso FROM perfis_acesso WHERE id = :id");
        $stmt_nivel->execute([':id' => $id_para_apagar]);
        $nivel = $stmt_nivel->fetchColumn();

        if ($nivel >= 3) {
            // Tentativa de apagar um perfil de sistema! Expulsar.
            header("Location: /sibdas/1241251/gira/private/perfis/perfis.php?erro=perfil_bloqueado");
            exit;
        }

        // 3. DEFESA 2: Quantos utilizadores têm este perfil ativo?
        $stmt_verificar = $pdo->prepare("SELECT COUNT(*) FROM utilizadores WHERE perfil_id = :id");
        $stmt_verificar->execute([':id' => $id_para_apagar]);
        $utilizadores_associados = $stmt_verificar->fetchColumn();

        if ($utilizadores_associados > 0) {
            // O perfil está em uso! Devolver à página com o erro (que já programámos no perfis.php)
            header("Location: /sibdas/1241251/gira/private/perfis/perfis.php?erro=perfil_ocupado");
            exit;
        } else {
            // O perfil não é de sistema e está vazio. Eliminação autorizada!
            $sql_apagar = "UPDATE perfis_acesso SET apagado_em = NOW() WHERE id = :id";
            $stmt_apagar = $pdo->prepare($sql_apagar);
            $stmt_apagar->execute([':id' => $id_para_apagar]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Eliminou o perfil de acesso (ID: $id_para_apagar)", "Perfis", "perfis_acesso", $id_para_apagar);
            }
            header("Location: /sibdas/1241251/gira/private/perfis/perfis.php?sucesso=eliminado");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro na base de dados ao eliminar perfil: " . $e->getMessage());
    }
} else {
    // Acesso direto pelo URL sem ID
    header("Location: /sibdas/1241251/gira/private/perfis/perfis.php");
    exit;
}
