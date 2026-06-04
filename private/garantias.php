<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Garantias e Contratos de Manutenção");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Garantias e Contratos</h2>
        <p class="text-muted m-0 small">Controlo de coberturas de fábrica, contratos de assistência técnica externa e SLAs de fornecedores.</p>
    </div>

    <!-- ATUALIZADO: Adicionados os gatilhos para abrir o Modal do Bootstrap -->
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarGarantia">
        <i class="fa-solid fa-file-shield me-2"></i> Adicionar Contrato / Cobertura
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">

            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('id_contrato')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Cód. Contrato <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('equipamento')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Dispositivo Associado <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('fornecedor')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Entidade / Fornecedor <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('tipo')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Tipo de Cobertura <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('fim_validade')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Fim da Validade <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('estado')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Estado <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="fw-bold text-primary fw-mono">#CTR-2026-044</td>
                    <td>
                        <div class="fw-bold">Ventilador Pulmonar</div>
                        <small class="text-muted">SN: DG-EV-99214</small>
                    </td>
                    <td>Dräger Portugal Lda.</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Garantia de Fábrica</span></td>
                    <td>31/12/2027</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Vigente</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Termos do Contrato">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminar Cobertura">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#CTR-2026-012</td>
                    <td>
                        <div class="fw-bold">Sistema de Ultrassom / Ecógrafo</div>
                        <small class="text-muted">SN: PH-UL-44122</small>
                    </td>
                    <td>Philips Healthcare Portugal</td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Manutenção Total (SLA)</span></td>
                    <td>15/09/2026</td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Expira Brevemente</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Termos do Contrato">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminar Cobertura">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#CTR-2025-009</td>
                    <td>
                        <div class="fw-bold">Bombas de Infusão Contínua</div>
                        <small class="text-muted">Lote Geral Volumétricas</small>
                    </td>
                    <td>B. Braun Medical S.A.</td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Suporte Técnico Básico</span></td>
                    <td>01/01/2026</td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Expirado</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Termos do Contrato">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Terminar Cobertura">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php
// 3. Chamamos o fim do molde
render_footer();
?>