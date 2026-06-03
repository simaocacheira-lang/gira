<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Ordens de Trabalho e Manutenção");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Ordens de Trabalho e Manutenção</h2>
        <p class="text-muted m-0 small">Acompanhamento de avarias, intervenções corretivas e planos de manutenção preventiva do parque médico.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAbrirOT">
        <i class="fa-solid fa-circle-exclamation me-2"></i> Abrir Ordem de Trabalho
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">

            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('id_ot')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nº O.T. <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('equipamento')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Equipamento / Modelo <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('tipo_manutencao')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Tipo de Intervenção <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('prioridade')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Prioridade <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('data_abertura')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Abertura <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('status')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Estado <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="fw-bold text-primary fw-mono">#OT-2026-102</td>
                    <td>
                        <div class="fw-bold">Ventilador Pulmonar de Alta Performance</div>
                        <small class="text-muted">Urgências · Erro de fluxo de oxigénio</small>
                    </td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2">Corretiva (Avaria)</span></td>
                    <td><span class="text-danger fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Crítica</span></td>
                    <td>31/05/2026</td>
                    <td><span class="badge bg-danger text-white rounded-pill px-2">Pendente</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Assumir Reparação / Diagnóstico">
                            <i class="fa-solid fa-wrench text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Ordem">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#OT-2026-098</td>
                    <td>
                        <div class="fw-bold">Sistema de Ultrassom / Ecógrafo</div>
                        <small class="text-muted">Obstetrícia · Calibração e revisão semestral</small>
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2">Preventiva Planeada</span></td>
                    <td><span class="text-muted fw-medium">Média</span></td>
                    <td>25/05/2026</td>
                    <td><span class="badge bg-warning text-dark rounded-pill px-2">Em Curso</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalFecharOT" title="Fechar Relatório Técnico">
                            <i class="fa-solid fa-check text-success"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Ordem">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#OT-2026-085</td>
                    <td>
                        <div class="fw-bold">Monitor Multiparamétrico de Sinais Vitais</div>
                        <small class="text-muted">UCI · Substituição de bateria interna afetada</small>
                    </td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Verificação Técnica</span></td>
                    <td><span class="text-warning fw-bold">Alta</span></td>
                    <td>18/05/2026</td>
                    <td><span class="badge bg-light text-muted border rounded-pill px-2">Concluída</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Histórico da OT">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Registo">
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
    document.querySelector('a[href="manutencao.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar ordens de trabalho por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde
render_footer();
?>