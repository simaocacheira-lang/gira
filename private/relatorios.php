<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Relatórios Analíticos e Indicadores");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Relatórios Analíticos</h2>
        <p class="text-muted m-0 small">Indicadores de desempenho, estatísticas de operacionalidade e custos de manutenção do hospital.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm">
        <i class="fa-solid fa-file-export me-2"></i> Exportar Dados Global
    </button>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Disponibilidade Geral</small>
            <h3 class="fw-bold my-1 text-success">94.8%</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Metas mínimas de 92% cumpridas</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Custo de Manutenção</small>
            <h3 class="fw-bold my-1 text-danger">12.4K €</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Valor acumulado neste mês</small>
        </div>
    </div>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Ref. Relatório', 'sort' => 'id_relatorio'],
    ['label' => 'Designação / Conteúdo', 'sort' => 'nome'],
    ['label' => 'Frequência / Período', 'sort' => 'frequencia'],
    ['label' => 'Departamento Alvo', 'sort' => 'departamento'],
    ['label' => 'Formato', 'sort' => 'formato'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

<tr>
    <td class="fw-bold text-primary fw-mono">#REP-2026-M05</td>
    <td>
        <div class="fw-bold">Relatório Mensal de Operacionalidade</div>
        <small class="text-muted">Taxas de falha, MTBF e tempos médios de reparação em maio.</small>
    </td>
    <td>Maio (2026)</td>
    <td>Direção Clínica</td>
    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2"><i class="fa-solid fa-file-pdf me-1"></i> PDF</span></td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar Relatório">
            <i class="fa-solid fa-download text-primary"></i>
        </button>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Histórico">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<tr>
    <td class="fw-bold text-primary fw-mono">#REP-2026-A01</td>
    <td>
        <div class="fw-bold">Auditoria de Custos de Inventário e Peças Dräger</div>
        <small class="text-muted">Resumo de faturas de consumíveis alocados a contratos de garantia.</small>
    </td>
    <td>Anual (2025)</td>
    <td>Direção Financeira</td>
    <td><span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2"><i class="fa-solid fa-file-excel me-1"></i> XLSX</span></td>
    <td class="text-end">
        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar Relatório">
            <i class="fa-solid fa-download text-primary"></i>
        </button>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Histórico">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamente!
render_table_end();

// 4. Fechamos a página e injetamos os scripts
render_footer();
?>