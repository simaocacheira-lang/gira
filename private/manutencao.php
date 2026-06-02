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

<div class="modal fade" id="modalAbrirOT" tabindex="-1" aria-labelledby="modalAbrirOTLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold" id="modalAbrirOTLabel">
                    <i class="fa-solid fa-screwdriver-wrench text-primary me-2"></i>Abrir Nova Ordem de Trabalho
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formNovaOT" action="processar_manutencao.php" method="POST">
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="otEquipamento" class="form-label small fw-bold text-secondary">Dispositivo Médico com Ocorrência</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-mono" id="otEquipamento" name="equipamento_id" required>
                                <option value="" selected disabled>Selecione o equipamento afetado...</option>
                                <option value="#EQ-2026-001">#EQ-2026-001 - Dräger Evita V500 (Urgências)</option>
                                <option value="#EQ-2026-002">#EQ-2026-002 - Philips Affiniti 70 (Obstetrícia)</option>
                                <option value="#EQ-2026-003">#EQ-2026-003 - Mindray BeneVision N17 (UCI)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="otTipo" class="form-label small fw-bold text-secondary">Tipo de Intervenção</label>
                            <select class="form-select rounded-3 bg-light border-0" id="otTipo" name="tipo_manutencao" required>
                                <option value="" selected disabled>Escolha o tipo...</option>
                                <option value="Corretiva (Avaria)">Corretiva (Reparação de Avarias / Falhas)</option>
                                <option value="Preventiva Planeada">Preventiva (Revisões Planeadas / Calibração)</option>
                                <option value="Verificação Técnica">Verificação Técnica / Auditoria Interna</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="otPrioridade" class="form-label small fw-bold text-secondary">Nível de Prioridade Clínica</label>
                            <select class="form-select rounded-3 bg-light border-0" id="otPrioridade" name="prioridade" required>
                                <option value="" selected disabled>Escolha o nível...</option>
                                <option value="Crítica">Crítica (Risco para o Doente / Suporte de Vida)</option>
                                <option value="Alta">Alta (Dispositivo Fora de Serviço no Setor)</option>
                                <option value="Média" selected>Média (Falha Parcial / Dispositivo com Backup)</option>
                                <option value="Baixa">Baixa (Ajustes Estéticos / Calibração não Urgente)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="otDescricao" class="form-label small fw-bold text-secondary">Descrição Detalhada do Sintoma / Intervenção</label>
                            <textarea class="form-control rounded-3 bg-light border-0" id="otDescricao" name="descricao_avaria" rows="4" placeholder="Ex: Equipamento apresenta erro de fluxo no circuito de oxigénio durante os testes de inicialização. Serviço solicita verificação urgente..." required></textarea>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaOT" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>Emitir O.T.
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalFecharOT" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            
            <div class="modal-header border-bottom border-light p-4 bg-light rounded-top-4">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-warning text-dark rounded-pill px-2">Em Curso</span>
                        <span class="text-muted fw-mono small">#OT-2026-098</span>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0"><i class="fa-solid fa-flag-checkered text-success me-2"></i>Encerrar Ordem de Trabalho</h5>
                    <small class="text-muted fw-bold">Sistema de Ultrassom / Ecógrafo (SN: PH-UL-44122)</small>
                </div>
                <button type="button" class="btn-close shadow-none mb-auto" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formFecharOT" action="processar_fecho_ot.php" method="POST">
                    
                    <h6 class="fw-bold mb-3 pb-2 border-bottom"><i class="fa-solid fa-clipboard-check text-primary me-2"></i>Relatório Técnico</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Trabalho Realizado</label>
                            <textarea class="form-control rounded-3 bg-light border-0" rows="3" placeholder="Descreva a intervenção feita, testes de segurança elétrica, etc..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Tempo Gasto (Horas)</label>
                            <input type="number" step="0.5" class="form-control rounded-3 bg-light border-0" placeholder="Ex: 2.5" required>
                            <small class="text-muted" style="font-size: 0.65rem;">Isto alimenta o indicador MTTR.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Novo Estado do Equipamento</label>
                            <select class="form-select rounded-3 bg-light border-0 text-success fw-bold" required>
                                <option value="Operacional" selected>Operacional (Pronto a Usar)</option>
                                <option value="Aguardar Teste">Aguardar Calibração Externa</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold m-0"><i class="fa-solid fa-boxes-stacked text-warning me-2"></i>Materiais e Peças Consumidas</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fw-bold" style="font-size: 0.7rem;">
                            <i class="fa-solid fa-plus me-1"></i> Adicionar Peça
                        </button>
                    </div>
                    
                    <div class="row g-2 align-items-center mb-2 bg-light p-2 rounded-3 border">
                        <div class="col-7">
                            <select class="form-select form-select-sm rounded-2 border-0 bg-white">
                                <option value="" disabled selected>Selecionar artigo do armazém...</option>
                                <option value="P01">Módulo SpO2 - Philips</option>
                                <option value="P02">Bateria 12V - Dräger</option>
                                <option value="P03">Kit Filtros - B. Braun</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-0 text-muted">Qtd</span>
                                <input type="number" class="form-control border-0 rounded-end-2" value="1" min="1">
                            </div>
                        </div>
                        <div class="col-2 text-end">
                            <button type="button" class="btn btn-sm text-danger shadow-none"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <small class="text-muted" style="font-size: 0.65rem;"><i class="fa-solid fa-circle-info me-1"></i>O valor destas peças será descontado ao stock e somado ao TCO deste equipamento.</small>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3 bg-white rounded-bottom-4">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-check-double me-2"></i>Encerrar e Atualizar Stock
                </button>
            </div>
            
        </div>
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