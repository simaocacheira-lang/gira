<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $id_equipamento = $_POST['id_equipamento'] ?? '';
    $fim_garantia = $_POST['fim_garantia'] ?? '';

    // Descobre qual foi o modal que ativou o formulário
    $modal_origem = isset($_POST['is_nova_garantia']) ? 'modalNovaGarantia' : 'modalAdicionarGarantia';

    // Validações de Domínio
    if ($e = validar_selecao_equipamento($id_equipamento)) $erros[] = $e;
    if ($e = validar_data_garantia($fim_garantia)) $erros[] = $e;

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = $modal_origem;
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/garantias/garantias.php");
        exit;
    }

    try {
        $sql = "UPDATE equipamentos SET fim_garantia = :fim_garantia WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fim_garantia' => $fim_garantia,
            ':id' => (int) $id_equipamento
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Atualizou a data de garantia do equipamento (ID: $id_equipamento) para $fim_garantia", "Garantias");
        }

        header("Location: /sibdas/1241251/gira/private/garantias/garantias.php?sucesso=garantia_atualizada");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro ao atualizar a garantia: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = $modal_origem;
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/garantias/garantias.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/garantias/garantias.php");
    exit;
}
