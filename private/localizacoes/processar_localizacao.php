<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "INSERT INTO localizacoes (cod_sala, nome, detalhe, piso, bloco) 
            VALUES (:cod, :nome, :detalhe, :piso, :bloco)";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':cod'     => $_POST['cod_sala'],
            ':nome'    => $_POST['nome'],
            ':detalhe' => !empty($_POST['detalhe']) ? $_POST['detalhe'] : null,
            ':piso'    => !empty($_POST['piso']) ? $_POST['piso'] : null,
            ':bloco'   => !empty($_POST['bloco']) ? $_POST['bloco'] : null
        ]);

        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Mapeou uma nova localização hospitalar: " . $_POST['cod_sala'] . " (" . $_POST['nome'] . ")", "Localizações");
        }

        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?sucesso=registado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao guardar localização na base de dados: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
    exit;
}
