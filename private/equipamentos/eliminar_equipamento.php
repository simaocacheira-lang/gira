<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar se o sistema recebeu realmente um ID pela barra de endereço (GET)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    $id_para_apagar = (int) $_GET['id'];
    
    try {
        // 3. Preparar o comando SQL de destruição (usamos :id por segurança contra hackers)
        $sql = "DELETE FROM equipamentos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        // 4. Executar a ação final
        $stmt->execute([':id' => $id_para_apagar]);
        
        // 5. Missão cumprida! Voltar à base sem deixar rasto.
        header("Location: /gira/private/equipamentos/equipamentos.php?sucesso=eliminado");
        exit;
        
    } catch (PDOException $e) {
        // Se houver erro (ex: o equipamento já está associado a ordens de trabalho)
        die("Erro ao eliminar o equipamento na base de dados: " . $e->getMessage());
    }
} else {
    // Se alguém tentar aceder a este ficheiro diretamente, é expulso de volta para a lista
    header("Location: /gira/private/equipamentos/equipamentos.php");
    exit;
}
?>