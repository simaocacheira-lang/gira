<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar se a informação veio do formulário (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['id_equipamento'])) {
        die("Erro Crítico: O ID do equipamento desapareceu.");
    }

    $id_equipamento = (int) $_POST['id_equipamento'];
    $erros = [];

    // 3. RECOLHER E VALIDAR DADOS
    $nome = trim($_POST['nome'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $sn = trim($_POST['sn'] ?? '');
    $mac_address = trim($_POST['mac_address'] ?? '');
    $custo_aquisicao = $_POST['custo_aquisicao'] ?? '';
    $categoria = trim($_POST['categoria'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');

    // Utilizar as funções do db.php
    if ($e = validar_texto_obrigatorio($nome, 100, "Nome do Equipamento")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($modelo, 100, "Modelo / Versão")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($sn, 100, "Número de Série")) $erros[] = $e;
    if ($e = validar_mac_opcional($mac_address)) $erros[] = $e;

    // Validar Dropdowns e Datas
    if (empty($_POST['fornecedor_id'])) $erros[] = "Deve selecionar o Fabricante Oficial.";
    if (empty($_POST['classe_risco'])) $erros[] = "A Classe de Risco é obrigatória.";
    if (empty($_POST['localizacao_id'])) $erros[] = "Deve indicar a Localização / Serviço Alocado.";
    if (empty($_POST['data_aquisicao'])) $erros[] = "A Data de Aquisição é obrigatória.";
    if (empty($_POST['proxima_revisao'])) $erros[] = "A data da Próxima Revisão é obrigatória.";

    // Validar Custo (Não pode ser negativo)
    if (!empty($custo_aquisicao) && (!is_numeric($custo_aquisicao) || $custo_aquisicao < 0)) {
        $erros[] = "O Custo de Aquisição não pode ser negativo.";
    }

    // 4. DECISÃO: Encontrou Erros?
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['dados_form'] = $_POST; // Guardar o que o utilizador tentou editar!
        header("Location: /sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento);
        exit;
    }

    // 5. O comando UPDATE SEGURO
    $sql = "UPDATE equipamentos 
            SET nome = :nome, categoria = :categoria, marca = :marca, modelo = :modelo, num_serie = :serie, mac_address = :mac, 
                classe_risco = :risco, estado = :estado, localizacao_id = :localizacao, fornecedor_id = :fornecedor, 
                data_aquisicao = :data_aq, custo_aquisicao = :custo, proxima_revisao = :revisao, consumiveis = :consumiveis, observacoes = :observacoes
            WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':id'           => $id_equipamento,
            ':nome'         => $nome,
            ':modelo'       => !empty($modelo) ? $modelo : null,
            ':fornecedor'   => $_POST['fornecedor_id'],
            ':serie'        => $sn,
            ':mac'          => !empty($mac_address) ? $mac_address : null,
            ':risco'        => $_POST['classe_risco'],
            ':estado'       => $_POST['estado_operacional'],
            ':localizacao'  => $_POST['localizacao_id'],
            ':data_aq'      => $_POST['data_aquisicao'],
            ':custo'        => !empty($custo_aquisicao) ? $custo_aquisicao : null,
            ':revisao'      => $_POST['proxima_revisao'],
            ':consumiveis'  => !empty($_POST['consumiveis']) ? $_POST['consumiveis'] : null,
            ':categoria'   => !empty($categoria) ? $categoria : null,
            ':marca'       => !empty($marca) ? $marca : null,
            ':observacoes' => !empty($observacoes) ? $observacoes : null,
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Atualizou a ficha técnica do equipamento: " . $nome, "Equipamentos", "equipamentos", $id_equipamento);
        }

        header("Location: /sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento . "&sucesso=atualizado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro crítico ao atualizar o equipamento: " . $e->getMessage()];
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento);
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}
