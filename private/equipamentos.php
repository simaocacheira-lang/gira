<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Inventário de Equipamentos Médicos");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Inventário de Dispositivos Médicos</h2>
        <p class="text-muted m-0 small">Registo, controlo técnico e classificação de risco do parque tecnológico do hospital.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarEquipamento">
        <i class="fa-solid fa-plus me-2"></i> Registar Equipamento
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">

            <thead class="table-light">
                <tr>
                    <th class="th-sortable" onclick="simularOrdenacao('id')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Cód. Ativo <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('nome')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Equipamento / Fabricante <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('sn')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nº Série (SN) <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('estado')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Estado Operacional <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="fw-bold text-primary fw-mono">#EQ-2026-001</td>
                    <td>
                        <div class="fw-bold">Ventilador Pulmonar de Alta Performance</div>
                        <small class="text-muted">Dräger · Evita Infinity V500</small>
                    </td>
                    <td class="fw-mono text-secondary">DG-EV-99214</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
                    <td class="text-end">
                        <a href="detalhes_equipamento.php" class="btn btn-light btn-sm rounded-3 me-1 border" title="Consultar Equipamento">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </a>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar Equipamento">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#EQ-2026-002</td>
                    <td>
                        <div class="fw-bold">Sistema de Ultrassom / Ecógrafo</div>
                        <small class="text-muted">Philips · Affiniti 70</small>
                    </td>
                    <td class="fw-mono text-secondary">PH-UL-44122</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
                    <td class="text-end">
                        <a href="detalhes_equipamento.php" class="btn btn-light btn-sm rounded-3 me-1 border" title="Consultar Equipamento">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </a>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar Equipamento">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#EQ-2026-003</td>
                    <td>
                        <div class="fw-bold">Monitor Multiparamétrico de Sinais Vitais</div>
                        <small class="text-muted">Mindray · BeneVision N17</small>
                    </td>
                    <td class="fw-mono text-secondary">MR-MN-77119</td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Aguardar Calibração</span></td>
                    <td class="text-end">
                        <a href="detalhes_equipamento.php" class="btn btn-light btn-sm rounded-3 me-1 border" title="Consultar Equipamento">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </a>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar Equipamento">
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
    document.querySelector('a[href="equipamentos.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar por: " + coluna);
    }
</script>
<?php
// 3. Chamamos o fim do molde
render_footer();
?>