<?php
// 1. Definir as "Coordenadas" da Base de Dados, ou seja, as informações necessárias para o PHP se conectar à base de dados
$host = '127.0.0.1';           // O endereço do teu servidor local (Laragon)
$dbname = 'sibdas_inventario'; // Nome da bd
$username = 'root';            // O utilizador padrão do Laragon
$password = '';                // O Laragon, por defeito, não tem palavra-passe definida

// 2. Tentar fazer a ligação (Try / Catch) - enta (try) fazer a ligação. Se houver algum problema (por exemplo, o Laragon estar desligado), em vez de o site explodir com erros feios, apanha (catch) o erro e mostra uma mensagem limpa."
try {
    // Criar a nova ligação PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // 3. Configurações adicionais para a ligação PDO
    // Obrigar o PHP a mostrar-nos os erros da base de dados caso algo corra mal
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Definir que queremos receber os dados da base de dados num formato fácil de ler (Array Associativo)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se a ligação falhar, o código entra aqui e "morre" (die), mostrando o erro exato
    die("Erro crítico de ligação à base de dados: " . $e->getMessage());
}
?>