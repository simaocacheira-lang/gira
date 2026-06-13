<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Gerar código automaticamente
    $codigo_gerado = 'EQ-2026-' . strtoupper(substr(uniqid(), -4));

    // SQL corrigido para guardar TODOS os campos que tens no Modal!
    $sql = "INSERT INTO equipamentos (
                codigo_ativo, nome, modelo, num_serie, mac_address, classe_risco, 
                estado, localizacao_id, fornecedor_id, data_aquisicao, custo_aquisicao, 
                fim_garantia, proxima_revisao, consumiveis
            ) VALUES (
                :codigo, :nome, :modelo, :serie, :mac, :risco, 
                :estado, :localizacao, :fornecedor, :data_aq, :custo, 
                :garantia, :revisao, :consumiveis
            )";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':codigo'      => $codigo_gerado,
            ':nome'        => $_POST['nome'],
            ':modelo'      => $_POST['modelo'] ?? null, // O novo campo isolado para o Modelo
            ':serie'       => $_POST['sn'],
            ':mac'         => !empty($_POST['mac_address']) ? $_POST['mac_address'] : null,
            ':risco'       => $_POST['classe_risco'],
            ':estado'      => $_POST['estado_operacional'],
            ':localizacao' => $_POST['localizacao_id'],
            ':fornecedor'  => $_POST['fornecedor_id'], // O teu novo Dropdown de Fornecedores
            ':data_aq'     => $_POST['data_aquisicao'],
            ':custo'       => !empty($_POST['custo_aquisicao']) ? $_POST['custo_aquisicao'] : null,
            ':garantia'    => !empty($_POST['fim_garantia']) ? $_POST['fim_garantia'] : null,
            ':revisao'     => !empty($_POST['proxima_revisao']) ? $_POST['proxima_revisao'] : null,
            ':consumiveis' => !empty($_POST['consumiveis']) ? $_POST['consumiveis'] : null // O teu novo Dropdown de Artigos
        ]);

        header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        die("Erro ao guardar na base de dados: " . $e->getMessage());
    }
} else {
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}
