<?php
// Ligar à base de dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_equipamento = (int) $_POST['id_equipamento'];
    $fim_garantia = $_POST['fim_garantia'];

    try {
        // Atualizar APENAS a data de fim de garantia deste equipamento
        $sql = "UPDATE equipamentos SET fim_garantia = :fim_garantia WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fim_garantia' => $fim_garantia,
            ':id' => $id_equipamento
        ]);

        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Atualizou a data de garantia do equipamento (ID: $id_equipamento) para $fim_garantia", "Garantias");
        }

        // Redirecionar DE VOLTA para a página das Garantias!
        header("Location: /gira/private/garantias/garantias.php?sucesso=garantia_atualizada");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar a garantia: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/garantias/garantias.php");
    exit;
}
