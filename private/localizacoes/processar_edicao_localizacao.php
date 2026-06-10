<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['id_localizacao'])) {
        die("Erro Crítico: O ID da localização desapareceu.");
    }

    $sql = "UPDATE localizacoes SET 
                cod_sala = :cod,
                nome = :nome,
                detalhe = :detalhe,
                piso = :piso,
                bloco = :bloco
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':id'      => (int) $_POST['id_localizacao'],
            ':cod'     => $_POST['cod_sala'],
            ':nome'    => $_POST['nome'],
            ':detalhe' => !empty($_POST['detalhe']) ? $_POST['detalhe'] : null,
            ':piso'    => !empty($_POST['piso']) ? $_POST['piso'] : null,
            ':bloco'   => !empty($_POST['bloco']) ? $_POST['bloco'] : null
        ]);

        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Alterou as configurações da sala/serviço: " . $_POST['cod_sala'], "Localizações");
        }

        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?sucesso=editado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar a localização: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
    exit;
}
