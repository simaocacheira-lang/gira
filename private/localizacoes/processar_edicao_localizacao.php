<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_localizacao = (int) $_POST['id_localizacao'];
    $erros = [];
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/localizacoes/localizacoes.php';

    $cod_sala = trim($_POST['cod_sala'] ?? '');
    $nome = trim($_POST['nome'] ?? '');

    if ($e = validar_nome_localizacao($nome)) $erros[] = $e;
    if ($e = validar_codigo_sala($cod_sala)) $erros[] = $e;

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalEditarLocalizacao';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
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
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
        header("Location: " . $url_origem . $separador . "sucesso=editado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro: O Código de Sala já existe no sistema."];
        $_SESSION['modal_aberto'] = 'modalEditarLocalizacao';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
}
