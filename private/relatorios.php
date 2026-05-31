<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

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
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Tempo Médio de Reparação</small>
            <h3 class="fw-bold my-1 text-dark">4.2 horas</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Dispositivos de suporte de vida</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Avarias Ativas</small>
            <h3 class="fw-bold my-1 text-danger">3 Equipamentos</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Ordens corretivas em diagnóstico</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Custos Mensais (Peças)</small>
            <h3 class="fw-bold my-1 text-primary">1,840 €</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Maio 2026 · Filtros e juntas</small>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('id_rep')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Ref. Relatório <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('nome')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Título do Relatório <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('periodo')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Período de Análise <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('emitido_por')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Emitido Por <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('formato')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Formato <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td class="fw-bold text-primary fw-mono">#REP-2026-M05</td>
                    <td>
                        <div class="fw-bold">Indicadores de Manutenção Semestral - UCI</div>
                        <small class="text-muted">Desempenho técnico de ventiladores e monitores de sinais vitais.</small>
                    </td>
                    <td>Jan 2026 - Mai 2026</td>
                    <td>Eng. Biomédica Central</td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2"><i class="fa-solid fa-file-pdf me-1"></i> PDF</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar Relatório">
                            <i class="fa-solid fa-download text-muted"></i>
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
                            <i class="fa-solid fa-download text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Histórico">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    document.querySelector('a[href="relatorios.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar relatórios por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde
render_footer();
?>