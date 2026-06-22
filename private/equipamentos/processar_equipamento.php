<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $erros = [];
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/equipamentos/equipamentos.php';

    // 1. RECOLHER DADOS
    $nome = trim($_POST['nome'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $sn = trim($_POST['sn'] ?? '');
    $mac_address = trim($_POST['mac_address'] ?? '');
    $custo_aquisicao = $_POST['custo_aquisicao'] ?? '';
    $categoria = trim($_POST['categoria'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');
    $fabricante_id = !empty($_POST['fabricante_id']) ? (int) $_POST['fabricante_id'] : null;

    // 2. VALIDAÇÕES
    if ($e = validar_texto_obrigatorio($nome, 100, "Nome do Equipamento")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($modelo, 100, "Modelo / Versão")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($sn, 100, "Número de Série")) $erros[] = $e;
    if ($e = validar_mac_opcional($mac_address)) $erros[] = $e;

    // Validar Dropdowns Obrigatórias
    if (empty($_POST['fornecedor_id'])) $erros[] = "Deve selecionar o Fabricante Oficial.";
    if (empty($_POST['classe_risco'])) $erros[] = "A Classe de Risco é obrigatória.";
    if (empty($_POST['localizacao_id'])) $erros[] = "Deve indicar a Localização / Serviço Alocado.";

    // Validar Datas
    if (empty($_POST['data_aquisicao'])) $erros[] = "A Data de Aquisição é obrigatória.";
    if (empty($_POST['proxima_revisao'])) $erros[] = "A data da Próxima Revisão é obrigatória.";

    // Validar Custo (Não pode ser negativo)
    if (!empty($custo_aquisicao) && (!is_numeric($custo_aquisicao) || $custo_aquisicao < 0)) {
        $erros[] = "O Custo de Aquisição não pode ser negativo.";
    }

    // 3. DECISÃO: Gravar ou Devolver Erros?
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalRegistarEquipamento';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }

    // 4. GRAVAÇÃO NA BASE DE DADOS
    $codigo_gerado = 'EQ-2026-' . strtoupper(substr(uniqid(), -4));

    $sql = "INSERT INTO equipamentos (codigo_ativo, nome, categoria, marca, modelo, num_serie, mac_address, classe_risco, estado, localizacao_id, fabricante_id, fornecedor_id, data_aquisicao, custo_aquisicao, fim_garantia, proxima_revisao, consumiveis, observacoes) 
            VALUES (:codigo, :nome, :categoria, :marca, :modelo, :serie, :mac, :risco, :estado, :localizacao, :fabricante, :fornecedor, :data_aq, :custo, :garantia, :revisao, :consumiveis, :observacoes)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':codigo'      => $codigo_gerado,
            ':nome'        => $nome,
            ':modelo'      => $modelo,
            ':serie'       => $sn,
            ':mac'         => !empty($mac_address) ? $mac_address : null,
            ':risco'       => $_POST['classe_risco'],
            ':estado'      => $_POST['estado_operacional'],
            ':localizacao' => $_POST['localizacao_id'],
            ':fabricante'  => $fabricante_id,
            ':fornecedor'  => $_POST['fornecedor_id'],
            ':data_aq'     => $_POST['data_aquisicao'],
            ':custo'       => !empty($custo_aquisicao) ? $custo_aquisicao : null,
            ':garantia'    => !empty($_POST['fim_garantia']) ? $_POST['fim_garantia'] : null,
            ':revisao'     => $_POST['proxima_revisao'],
            ':consumiveis' => !empty($_POST['consumiveis']) ? $_POST['consumiveis'] : null,
            ':categoria'   => !empty($categoria) ? $categoria : null,
            ':marca'       => !empty($marca) ? $marca : null,
            ':observacoes' => !empty($observacoes) ? $observacoes : null,

        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Registou um novo equipamento: $codigo_gerado - $nome", "Equipamentos");
        }

        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
        header("Location: " . $url_origem . $separador . "sucesso=atualizado");
        exit;
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro crítico ao registar o equipamento: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalRegistarEquipamento';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}
