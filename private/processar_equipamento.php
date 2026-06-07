<?php
// 1. Ligar à Base de Dados e iniciar a Sessão
require_once __DIR__ . '/db.php';
session_start();

// 2. Verificar se o pedido veio realmente de um formulário (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Preparar o comando SQL para inserir dados na tabela 'equipamentos'
    // Usamos os :pontos (parâmetros) por segurança, para evitar ataques de SQL Injection
    $sql = "INSERT INTO equipamentos (codigo_ativo, nome, modelo, num_serie, estado, localizacao_id, fornecedor_id, data_aquisicao) 
            VALUES (:codigo, :nome, :modelo, :serie, :estado, :localizacao, :fornecedor, :data)";
    
    try {
        $stmt = $pdo->prepare($sql);
        
        // 4. Injetar os dados que vieram do formulário ($_POST) para dentro da Base de Dados
        $stmt->execute([
            ':codigo'      => $_POST['codigo_ativo'],
            ':nome'        => $_POST['nome'],
            ':modelo'      => $_POST['modelo'],
            ':serie'       => $_POST['num_serie'],
            ':estado'      => $_POST['estado'],
            ':localizacao' => $_POST['localizacao_id'],
            ':fornecedor'  => $_POST['fornecedor_id'],
            ':data'        => $_POST['data_aquisicao']
        ]);
        
        // 5. Sucesso! Redirecionar o utilizador de volta para a lista de equipamentos
        header("Location: /gira/private/equipamentos.php?sucesso=1");
        exit;
        
    } catch (PDOException $e) {
        // Se houver erro (ex: código_ativo duplicado), mostra o problema
        die("Erro ao guardar o equipamento na base de dados: " . $e->getMessage());
    }
} else {
    // Se alguém tentar aceder a este ficheiro diretamente pela barra de endereço, é expulso
    header("Location: /gira/private/equipamentos.php");
    exit;
}
?>