<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = (int) $_POST['id_utilizador'];
    $nome = trim($_POST['nome']);
    $cedula = trim($_POST['cedula']);
    $email = trim($_POST['email']);
    $perfil_id = (int) $_POST['perfil_id'];
    $nova_password = $_POST['password'];

    if (empty($cedula)) $cedula = null;

    try {
        if (!empty($nova_password)) {
            // O utilizador escreveu uma password nova! Vamos encriptá-la e guardá-la.
            $hash = password_hash($nova_password, PASSWORD_DEFAULT);
            $sql = "UPDATE utilizadores SET nome = :nome, cedula = :cedula, email = :email, perfil_id = :perfil, password_hash = :hash WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':cedula' => $cedula, ':email' => $email, ':perfil' => $perfil_id, ':hash' => $hash, ':id' => $id]);
        } else {
            // A password ficou em branco, atualizamos apenas os outros dados.
            $sql = "UPDATE utilizadores SET nome = :nome, cedula = :cedula, email = :email, perfil_id = :perfil WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':cedula' => $cedula, ':email' => $email, ':perfil' => $perfil_id, ':id' => $id]);
        }

        header("Location: /gira/private/utilizadores/utilizadores.php?sucesso=utilizador_editado");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            die("<h3>Erro de Atualização</h3><p>O E-mail ou a Cédula já estão a ser utilizados por outra pessoa.</p><a href='javascript:history.back()'>Voltar atrás</a>");
        }
        die("Erro ao editar utilizador: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/utilizadores/utilizadores.php");
    exit;
}
