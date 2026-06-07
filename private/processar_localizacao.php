<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. O comando SQL preparado com todas as colunas novas
    $sql = "INSERT INTO localizacoes (cod_sala, nome, detalhe, piso, bloco) 
            VALUES (:cod, :nome, :detalhe, :piso, :bloco)";

    try {
        $stmt = $pdo->prepare($sql);

        // 3. Mapear os dados que vieram do formulário
        $stmt->execute([
            ':cod'     => $_POST['cod_sala'],
            ':nome'    => $_POST['nome'],
            ':detalhe' => !empty($_POST['detalhe']) ? $_POST['detalhe'] : null,
            ':piso'    => !empty($_POST['piso']) ? $_POST['piso'] : null,
            ':bloco'   => !empty($_POST['bloco']) ? $_POST['bloco'] : null
        ]);

        // 4. Sucesso! Volta à página com os dados atualizados
        header("Location: /gira/private/localizacoes.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        die("Erro ao guardar localização na base de dados: " . $e->getMessage());
    }
} else {
    // Se acederem por link direto, recambiamos de volta
    header("Location: /gira/private/localizacoes.php");
    exit;
}
