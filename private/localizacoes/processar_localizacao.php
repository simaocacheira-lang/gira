<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    // 1. Recolher Dados
    $cod_sala = trim($_POST['cod_sala'] ?? '');
    $nome = trim($_POST['nome'] ?? '');
    $detalhe = $_POST['detalhe'] ?? '';
    $piso = $_POST['piso'] ?? '';
    $bloco = $_POST['bloco'] ?? '';

    // 2. Validações
    if ($e = validar_nome_localizacao($nome)) $erros[] = $e;
    if ($e = validar_codigo_sala($cod_sala)) $erros[] = $e;


    // 3. Devolver Erros se existirem
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalNovaLocalizacao';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
        exit;
    }

    // 4. Gravar na Base de Dados
    $sql = "INSERT INTO localizacoes (cod_sala, nome, detalhe, piso, bloco) 
            VALUES (:cod, :nome, :detalhe, :piso, :bloco)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cod'     => $cod_sala,
            ':nome'    => $nome,
            ':detalhe' => !empty($detalhe) ? $detalhe : null,
            ':piso'    => !empty($piso) ? $piso : null,
            ':bloco'   => !empty($bloco) ? $bloco : null
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Mapeou uma nova localização hospitalar: $cod_sala ($nome)", "Localizações");
        }

        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?sucesso=registado");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['erros'] = ["Erro: O Código de Sala '$cod_sala' já se encontra mapeado no sistema."];
        } else {
            $_SESSION['erros'] = ["Erro crítico na base de dados: " . $e->getMessage()];
        }
        $_SESSION['modal_aberto'] = 'modalNovaLocalizacao';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
    exit;
}
