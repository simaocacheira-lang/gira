<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/db.php';
session_start();

// 2. Verificar se a informação veio por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Proteção: Garantir que não perdemos o ID no caminho
    if (empty($_POST['id_localizacao'])) {
        die("Erro Crítico: O ID da localização desapareceu.");
    }

    // 3. O comando UPDATE
    $sql = "UPDATE localizacoes SET 
                cod_sala = :cod,
                nome = :nome,
                detalhe = :detalhe,
                piso = :piso,
                bloco = :bloco
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        // 4. Mapear os novos dados enviados pelo modal
        $stmt->execute([
            ':id'      => (int) $_POST['id_localizacao'],
            ':cod'     => $_POST['cod_sala'],
            ':nome'    => $_POST['nome'],
            ':detalhe' => !empty($_POST['detalhe']) ? $_POST['detalhe'] : null,
            ':piso'    => !empty($_POST['piso']) ? $_POST['piso'] : null,
            ':bloco'   => !empty($_POST['bloco']) ? $_POST['bloco'] : null
        ]);

        // 5. Missão cumprida! Voltar ao mapa de localizações.
        header("Location: /gira/private/localizacoes.php?sucesso=editado");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar a localização: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/localizacoes.php");
    exit;
}
