<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_localizacao = (int) $_POST['id_localizacao'];
    $erros = [];

    $cod_sala = trim($_POST['cod_sala'] ?? '');
    $nome = trim($_POST['nome'] ?? '');

    if ($e = validar_texto_obrigatorio($nome, 100, "Nome da Localização")) $erros[] = $e;
    if (empty($cod_sala)) $erros[] = "O Código da Sala é obrigatório.";

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalEditarLocalizacao';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
        exit;
    }

    $sql = "UPDATE localizacoes SET cod_sala = :cod, nome = :nome, detalhe = :detalhe, piso = :piso, bloco = :bloco WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id_localizacao,
            ':cod' => $cod_sala,
            ':nome' => $nome,
            ':detalhe' => !empty($_POST['detalhe']) ? $_POST['detalhe'] : null,
            ':piso' => !empty($_POST['piso']) ? $_POST['piso'] : null,
            ':bloco' => !empty($_POST['bloco']) ? $_POST['bloco'] : null
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Alterou as configurações da sala/serviço: " . $cod_sala, "Localizações");
        }
        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php?sucesso=atualizado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro: O Código de Sala já existe no sistema."];
        $_SESSION['modal_aberto'] = 'modalEditarLocalizacao';
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/localizacoes/localizacoes.php");
        exit;
    }
}
