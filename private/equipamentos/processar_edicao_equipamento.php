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

    // Tratar vírgulas e cêntimos no custo
    $custo_aquisicao = !empty($_POST['custo_aquisicao']) ? str_replace(',', '.', $_POST['custo_aquisicao']) : null;

    $categoria = trim($_POST['categoria'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');
    $fabricante_id = !empty($_POST['fabricante_id']) ? (int) $_POST['fabricante_id'] : null;

    // OS NOVOS CAMPOS
    $ano_fabrico = !empty($_POST['ano_fabrico']) ? (int) $_POST['ano_fabrico'] : null;
    $tipo_entrada = trim($_POST['tipo_entrada'] ?? 'Compra');

    // Utilizar as funções do db.php
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
    if (empty($_POST['proxima_revisao'])) $erros[] = "A data da Próxima Revisão é obrigatória.";

    // Se houver erros, devolve ao formulário
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['dados_form'] = $_POST;
        header("Location: /sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento);
        exit;
    }

    try {
        // 4. ATUALIZAR O EQUIPAMENTO NA BASE DE DADOS
        $sql = "UPDATE equipamentos 
                SET nome = :nome, categoria = :categoria, marca = :marca, modelo = :modelo, num_serie = :serie, mac_address = :mac, 
                    classe_risco = :risco, estado = :estado, localizacao_id = :localizacao, fabricante_id = :fabricante, fornecedor_id = :fornecedor, 
                    data_aquisicao = :data_aq, ano_fabrico = :ano_fabrico, tipo_entrada = :tipo_entrada, custo_aquisicao = :custo, proxima_revisao = :revisao, observacoes = :observacoes
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':id'           => $id_equipamento,
            ':nome'         => $nome,
            ':categoria'    => !empty($categoria) ? $categoria : null,
            ':marca'        => !empty($marca) ? $marca : null,
            ':modelo'       => $modelo,
            ':serie'        => $sn,
            ':mac'          => !empty($mac_address) ? $mac_address : null,
            ':risco'        => $_POST['classe_risco'],
            ':estado'       => $_POST['estado_operacional'],
            ':localizacao'  => $_POST['localizacao_id'],
            ':fabricante'   => $fabricante_id,
            ':fornecedor'   => $_POST['fornecedor_id'],
            ':data_aq'      => $_POST['data_aquisicao'],
            ':ano_fabrico'  => $ano_fabrico,
            ':tipo_entrada' => $tipo_entrada,
            ':custo'        => $custo_aquisicao,
            ':revisao'      => $_POST['proxima_revisao'],
            ':observacoes'  => !empty($observacoes) ? $observacoes : null
        ]);

        // =======================================================
        // RELAÇÃO N:M - Atualizar Consumíveis Múltiplos
        // =======================================================
        // A) Apagar todas as ligações antigas deste equipamento
        $sql_limpar = "DELETE FROM equipamento_artigo_armazem WHERE equipamento_id = :id";
        $stmt_limpar = $pdo->prepare($sql_limpar);
        $stmt_limpar->execute([':id' => $id_equipamento]);

        // B) Inserir as novas ligações (se o utilizador selecionou alguma)
        if (!empty($_POST['consumiveis']) && is_array($_POST['consumiveis'])) {
            $sql_inserir = "INSERT INTO equipamento_artigo_armazem (equipamento_id, artigo_id) VALUES (:eq_id, :art_id)";
            $stmt_inserir = $pdo->prepare($sql_inserir);

            foreach ($_POST['consumiveis'] as $id_artigo) {
                $stmt_inserir->execute([
                    ':eq_id' => $id_equipamento,
                    ':art_id' => (int) $id_artigo
                ]);
            }
        }

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
