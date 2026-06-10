<?php
require_once __DIR__ . '/../db.php';
session_start();

if (!isset($_GET['tipo'])) {
    header("Location: /sibdas/1241251/gira/private/relatorios/relatorios.php");
    exit;
}

$tipo = $_GET['tipo'];
$data_hoje = date('Y-m-d_H-i');

// Forçar o navegador a entender que isto é um download de ficheiro CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Relatorio_Gira_' . ucfirst($tipo) . '_' . $data_hoje . '.csv');

// Abrir a saída de dados do PHP
$output = fopen('php://output', 'w');

// Adicionar o BOM para o Excel no Windows ler os acentos (ç, ã, á) corretamente
fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

try {
    if ($tipo == 'inventario') {
        // 1. Relatório de Inventário
        fputcsv($output, ['CÓDIGO ATIVO', 'NOME / TIPO', 'MARCA / MODELO', 'Nº SÉRIE', 'CLASSE RISCO', 'ESTADO', 'DATA AQUISIÇÃO'], ';');

        $stmt = $pdo->query("SELECT codigo_ativo, nome, modelo, num_serie, classe_risco, estado, data_aquisicao FROM equipamentos ORDER BY codigo_ativo ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row, ';');
        }

        $log_msg = "Exportou o Relatório de Inventário Global de Equipamentos";
    } elseif ($tipo == 'manutencoes') {
        // 2. Relatório de Manutenções
        fputcsv($output, ['Nº O.T.', 'TIPO INTERVENÇÃO', 'PRIORIDADE', 'ESTADO', 'DATA ABERTURA', 'RELATÓRIO TÉCNICO', 'TEMPO GASTO (H)'], ';');

        $stmt = $pdo->query("SELECT numero_ot, tipo_manutencao, prioridade, estado, data_abertura, relatorio_tecnico, tempo_gasto FROM ordens_trabalho ORDER BY id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, $row, ';');
        }

        $log_msg = "Exportou o Relatório de Histórico de Manutenções (O.T.s)";
    } elseif ($tipo == 'armazem') {
        // 3. Relatório de Armazém
        fputcsv($output, ['REFERÊNCIA', 'NOME ARTIGO', 'CATEGORIA', 'STOCK ATUAL', 'STOCK MÍNIMO', 'ESTADO ALERTA'], ';');

        $stmt = $pdo->query("SELECT referencia, nome, categoria, quantidade_atual, quantidade_minima FROM artigos_armazem ORDER BY nome ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Adicionar uma coluna calculada na hora para o Excel
            $alerta = ($row['quantidade_atual'] < $row['quantidade_minima']) ? 'EM RUTURA' : 'SAUDÁVEL';
            $row['alerta'] = $alerta;
            fputcsv($output, $row, ';');
        }

        $log_msg = "Exportou o Relatório de Stock e Ruturas de Armazém";
    }

    // Registar a ação na nossa Auditoria!
    if (isset($log_msg) && function_exists('registar_log')) {
        registar_log($pdo, $_SESSION['user_id'], $log_msg, "Relatórios");
    }
} catch (PDOException $e) {
    // Se der erro, escreve no CSV
    fputcsv($output, ['ERRO AO GERAR RELATÓRIO', $e->getMessage()], ';');
}

fclose($output);
exit;
