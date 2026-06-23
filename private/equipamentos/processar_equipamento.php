<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $erros = [];
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/equipamentos/equipamentos.php';

    // 1. RECOLHER DADOS DO FORMULÁRIO
    $nome = trim($_POST['nome'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $sn = trim($_POST['sn'] ?? '');
    $mac_address = trim($_POST['mac_address'] ?? '');
    // Substitui vírgulas por pontos para a BD não rejeitar os cêntimos
    $custo_aquisicao = !empty($_POST['custo_aquisicao']) ? str_replace(',', '.', $_POST['custo_aquisicao']) : null;

    $categoria = trim($_POST['categoria'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');

    $fabricante_id = !empty($_POST['fabricante_id']) ? (int) $_POST['fabricante_id'] : null;

    // OS NOVOS CAMPOS OBRIGATÓRIOS
    $ano_fabrico = !empty($_POST['ano_fabrico']) ? (int) $_POST['ano_fabrico'] : null;
    $tipo_entrada = trim($_POST['tipo_entrada'] ?? 'Compra');

    // 2. VALIDAÇÕES
    if ($e = validar_texto_obrigatorio($nome, 100, "Nome do Equipamento")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($modelo, 100, "Modelo / Versão")) $erros[] = $e;
    if ($e = validar_texto_obrigatorio($sn, 100, "Número de Série")) $erros[] = $e;
    if ($e = validar_mac_opcional($mac_address)) $erros[] = $e;

    // Validar Dropdowns Obrigatórias
    if (empty($_POST['fornecedor_id'])) $erros[] = "Deve selecionar a Assistência / Fornecedor.";
    if (empty($_POST['localizacao_id'])) $erros[] = "Deve selecionar uma localização válida.";
    if (empty($_POST['classe_risco'])) $erros[] = "A Classe de Risco é obrigatória.";
    if (empty($_POST['estado_operacional'])) $erros[] = "O Estado Operacional é obrigatório.";
    if (empty($_POST['data_aquisicao'])) $erros[] = "A Data de Aquisição é obrigatória.";

    // Se houver erros de preenchimento, devolve ao formulário com as mensagens
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalRegistarEquipamento';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }

    try {
        // 3. GERAR CÓDIGO ÚNICO DE INVENTÁRIO (Ex: EQ-2026-A1B2)
        $ano = date('Y');
        $random_hex = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
        $codigo_gerado = "EQ-{$ano}-{$random_hex}";

        // 4. REGISTAR NA BASE DE DADOS (Tabela Principal)
        $sql = "INSERT INTO equipamentos (codigo_ativo, nome, categoria, marca, modelo, num_serie, mac_address, classe_risco, estado, localizacao_id, fabricante_id, fornecedor_id, data_aquisicao, ano_fabrico, tipo_entrada, custo_aquisicao, fim_garantia, proxima_revisao, observacoes) 
                VALUES (:codigo, :nome, :categoria, :marca, :modelo, :serie, :mac, :risco, :estado, :localizacao, :fabricante, :fornecedor, :data_aq, :ano_fabrico, :tipo_entrada, :custo, :garantia, :revisao, :observacoes)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':codigo'      => $codigo_gerado,
            ':nome'        => $nome,
            ':categoria'   => !empty($categoria) ? $categoria : null,
            ':marca'       => !empty($marca) ? $marca : null,
            ':modelo'      => $modelo,
            ':serie'       => $sn,
            ':mac'         => !empty($mac_address) ? $mac_address : null,
            ':risco'       => $_POST['classe_risco'],
            ':estado'      => $_POST['estado_operacional'],
            ':localizacao' => $_POST['localizacao_id'],
            ':fabricante'  => $fabricante_id,
            ':fornecedor'  => $_POST['fornecedor_id'],
            ':data_aq'     => $_POST['data_aquisicao'],
            ':ano_fabrico' => $ano_fabrico,
            ':tipo_entrada' => $tipo_entrada,
            ':custo'       => $custo_aquisicao,
            ':garantia'    => !empty($_POST['fim_garantia']) ? $_POST['fim_garantia'] : null,
            ':revisao'     => !empty($_POST['proxima_revisao']) ? $_POST['proxima_revisao'] : null,
            ':observacoes' => !empty($observacoes) ? $observacoes : null
        ]);

        if (function_exists('registar_log')) {
            registar_log($pdo, $_SESSION['user_id'], "Registou um novo equipamento: $codigo_gerado - $nome", "Equipamentos");
        }

        // =======================================================
        // 5. RELAÇÃO N:M - Inserir Consumíveis Múltiplos
        // =======================================================
        if (!empty($_POST['consumiveis']) && is_array($_POST['consumiveis'])) {
            $sql_pecas = "INSERT INTO equipamento_artigo_armazem (equipamento_id, artigo_id) VALUES (:eq_id, :art_id)";
            $stmt_pecas = $pdo->prepare($sql_pecas);

            // Descobrir o ID do equipamento que acabámos de criar
            $novo_eq_id = $pdo->lastInsertId();

            foreach ($_POST['consumiveis'] as $id_artigo) {
                $stmt_pecas->execute([
                    ':eq_id' => $novo_eq_id,
                    ':art_id' => (int) $id_artigo
                ]);
            }
        }

        // 6. REDIRECIONAMENTO DE SUCESSO
        $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
        $url_origem = rtrim($url_origem, '?&');
        $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
        header("Location: " . $url_origem . $separador . "sucesso=atualizado");
        exit;
    } catch (PDOException $e) {
        // Se a BD falhar (ex: constrangimento de chave), apanhamos o erro aqui
        $_SESSION['erros'] = ["Erro crítico ao registar o equipamento: " . $e->getMessage()];
        $_SESSION['modal_aberto'] = 'modalRegistarEquipamento';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
} else {
    // Se tentarem aceder ao ficheiro diretamente sem ser pelo formulário
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}
