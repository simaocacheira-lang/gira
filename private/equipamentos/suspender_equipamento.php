<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar se recebemos o ID e a ação
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id_equipamento = (int) $_GET['id'];
    $acao = $_GET['acao'] ?? 'suspender';

    // Se a ação for reativar, fica Operacional. Se for suspender, fica Inoperacional.
    $novo_estado = ($acao === 'reativar') ? 'Operacional' : 'Inoperacional';

    try {
        // 3. Atualizar o estado do equipamento
        $sql = "UPDATE equipamentos SET estado = :estado WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':estado' => $novo_estado, ':id' => $id_equipamento]);

        // 4. Transmissor de Log
        if (function_exists('registar_log')) {
            $texto_log = ($acao === 'reativar') ? "Reativou" : "Suspendeu";
            registar_log($pdo, $_SESSION['user_id'], "$texto_log o equipamento (ID: $id_equipamento). Estado atual: $novo_estado", "Equipamentos");
        }

        // 5. REDIRECIONAMENTO INTELIGENTE (Volta para a página de onde o botão foi clicado)
        $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/equipamentos/equipamentos.php';

        // Limpar mensagens de sucesso anteriores do URL
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');

        // Adiciona a nova mensagem e redireciona
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
        header("Location: " . $url_origem . $separador . "sucesso=estado_alterado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao alterar o estado do equipamento: " . $e->getMessage());
    }
} else {
    // Acesso inválido
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}
