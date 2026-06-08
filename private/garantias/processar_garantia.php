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

        // Voltar para a ficha do equipamento que estávamos a editar
        header("Location: /gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento . "&sucesso=garantia_atualizada&tab=comercial");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar a garantia: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/equipamentos/equipamentos.php");
    exit;
}
