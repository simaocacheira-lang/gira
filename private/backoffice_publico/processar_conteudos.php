<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Preparamos o comando SQL de atualização
    // Como temos a "chave", fazemos update onde a chave corresponder ao nome do campo
    $sql = "UPDATE conteudos_site SET texto = :texto WHERE chave = :chave";

    try {
        $stmt = $pdo->prepare($sql);

        // Iniciamos uma transação para gravar tudo de uma vez
        $pdo->beginTransaction();

        // Percorremos todos os campos que vieram do formulário (POST)
        // O $chave será o nome do input (ex: 'hero_titulo') e o $texto será o que o utilizador escreveu
        foreach ($_POST as $chave => $texto) {
            $stmt->execute([
                ':texto' => trim($texto),
                ':chave' => $chave
            ]);
        }

        $pdo->commit();

        // Voltar para o backoffice com mensagem de sucesso
        header("Location: /sibdas/1241251/gira/private/backoffice_publico/backoffice_publico.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Erro ao guardar os conteúdos do site: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/backoffice_publico/backoffice_publico.php");
    exit;
}
