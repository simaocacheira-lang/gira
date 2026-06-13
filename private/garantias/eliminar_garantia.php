<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar se recebemos um ID válido do equipamento
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id_equipamento = (int) $_GET['id'];

    try {
        // 3. Ir buscar os dados para o Log de Auditoria
        $stmt_info = $pdo->prepare("SELECT nome, codigo_ativo FROM equipamentos WHERE id = :id");
        $stmt_info->execute([':id' => $id_equipamento]);
        $eq = $stmt_info->fetch();

        if ($eq) {
            // 4. ELIMINAÇÃO LÓGICA: Limpar o campo fim_garantia (colocar a NULL)
            $sql = "UPDATE equipamentos SET fim_garantia = NULL WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id_equipamento]);

            // 5. Transmissor de Log de Auditoria
            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Removeu o registo de garantia do equipamento: " . $eq['codigo_ativo'] . " - " . $eq['nome'], "Garantias");
            }

            // 6. Redirecionamento Inteligente
            $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/garantias/garantias.php';

            // Limpar mensagens de sucesso anteriores do URL
            $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
            $url_origem = rtrim($url_origem, '?&');

            // Redirecionar com a nova flag de sucesso
            $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
            header("Location: " . $url_origem . $separador . "sucesso=garantia_eliminada");
            exit;
        } else {
            header("Location: /sibdas/1241251/gira/private/garantias/garantias.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao eliminar a garantia: " . $e->getMessage());
    }
} else {
    // Acesso inválido
    header("Location: /sibdas/1241251/gira/private/garantias/garantias.php");
    exit;
}
