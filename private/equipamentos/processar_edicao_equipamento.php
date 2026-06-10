<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar se a informação veio do formulário (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Garantir que recebemos o ID do equipamento
    if (empty($_POST['id_equipamento'])) {
        die("Erro Crítico: O ID do equipamento desapareceu.");
    }

    $id_equipamento = (int) $_POST['id_equipamento'];

    // 4. O comando UPDATE
    $sql = "UPDATE equipamentos SET 
                nome = :nome,
                modelo = :modelo,
                num_serie = :serie,
                mac_address = :mac,
                classe_risco = :risco,
                estado = :estado,
                localizacao_id = :localizacao,
                data_aquisicao = :data_aq,
                custo_aquisicao = :custo,
                proxima_revisao = :revisao,
                consumiveis = :consumiveis
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':id'           => $id_equipamento,
            ':nome'         => $_POST['nome'],
            ':modelo'       => $_POST['marca'],
            ':serie'        => $_POST['sn'],
            ':mac'          => !empty($_POST['mac_address']) ? $_POST['mac_address'] : null,
            ':risco'        => $_POST['classe_risco'],
            ':estado'       => $_POST['estado_operacional'],
            ':localizacao'  => $_POST['localizacao_id'],
            ':data_aq'      => $_POST['data_aquisicao'],
            ':custo'        => !empty($_POST['custo_aquisicao']) ? $_POST['custo_aquisicao'] : null,
            ':revisao'      => !empty($_POST['proxima_revisao']) ? $_POST['proxima_revisao'] : null,
            ':consumiveis'  => !empty($_POST['consumiveis']) ? $_POST['consumiveis'] : null
        ]);

        // --> TRANSMISSOR DE LOG <--
        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Atualizou a ficha técnica do equipamento " . $_POST['nome'] . " (ID: $id_equipamento)", "Equipamentos");
        }

        // 6. Sucesso! Volta para a ficha do próprio equipamento
        header("Location: /gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento . "&sucesso=1");
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar na base de dados: " . $e->getMessage());
    }
} else {
    header("Location: /gira/private/equipamentos/equipamentos.php");
    exit;
}
