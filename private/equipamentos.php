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
    
    <!-- ATUALIZADO: Adicionados os gatilhos para abrir o Modal do Bootstrap -->
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarEquipamento">
        <i class="fa-solid fa-plus me-2"></i> Registar Equipamento
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
           <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
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
                    <th class="th-sortable" onclick="simularOrdenacao('classe')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Classe de Risco <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('local')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Localização / Serviço <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('revisao')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Próxima Revisão <i class="fa-solid fa-sort th-sort-icon"></i>
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
                    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2">Suporte de Vida</span></td>
                    <td>Urgências · Sala de Reanimação</td>
                    <td>15/07/2026</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Equipamento">
                            <i class="fa-solid fa-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento">
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
                    <td><span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle px-2">Médio/Alto Risco</span></td>
                    <td>Obstetrícia · Consulta 3</td>
                    <td>02/09/2026</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Equipamento">
                            <i class="fa-solid fa-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento">
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
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Monitorização</span></td>
                    <td>UCI · Quarto 04 (Isolamento)</td>
                    <td>12/06/2026</td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Aguardar Calibração</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Equipamento">
                            <i class="fa-solid fa-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================================== -->
<!-- INJEÇÃO: MODAL PARA REGISTAR NOVO EQUIPAMENTO MÉDICO -->
<!-- ============================================================================== -->
<div class="modal fade" id="modalRegistarEquipamento" tabindex="-1" aria-labelledby="modalRegistarEquipamentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg para dar mais espaço aos inputs duplos -->
        <div class="modal-content border-0 rounded-4 shadow">
            
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold" id="modalRegistarEquipamentoLabel">
                    <i class="fa-solid fa-laptop-medical text-primary me-2"></i>Registar Novo Equipamento no Parque
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formNovoEquipamento" action="processar_equipamento.php" method="POST">
                    
                    <div class="row g-3">
                        <!-- Nome e Fabricante/Modelo -->
                        <div class="col-md-6">
                            <label for="eqNome" class="form-label small fw-bold text-secondary">Nome do Equipamento</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" id="eqNome" name="nome" placeholder="Ex: Ventilador Pulmonar" required>
                        </div>
                        <div class="col-md-6">
                            <label for="eqMarca" class="form-label small fw-bold text-secondary">Fabricante / Modelo</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" id="eqMarca" name="marca" placeholder="Ex: Dräger · Evita V500" required>
                        </div>

                        <!-- Número de Série e Classe de Risco -->
                        <div class="col-md-6">
                            <label for="eqSN" class="form-label small fw-bold text-secondary">Número de Série (SN)</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" id="eqSN" name="sn" placeholder="Ex: DG-EV-99214" required>
                        </div>
                        <div class="col-md-6">
                            <label for="eqClasse" class="form-label small fw-bold text-secondary">Classe de Risco (Infraestrutura Clínica)</label>
                            <select class="form-select rounded-3 bg-light border-0" id="eqClasse" name="classe_risco" required>
                                <option value="" selected disabled>Escolha a classe...</option>
                                <option value="Suporte de Vida">Classe III - Suporte de Vida</option>
                                <option value="Médio/Alto Risco">Classe IIb - Médio/Alto Risco</option>
                                <option value="Monitorização">Classe IIa - Monitorização / Medição</option>
                                <option value="Baixo Risco">Classe I - Baixo Risco</option>
                            </select>
                        </div>

                        <!-- Localização e Data de Revisão -->
                        <div class="col-md-6">
                            <label for="eqLocal" class="form-label small fw-bold text-secondary">Localização / Serviço Alocado</label>
                            <select class="form-select rounded-3 bg-light border-0" id="eqLocal" name="localizacao" required>
                                <option value="" selected disabled>Escolha o serviço...</option>
                                <!-- Vinculado aos dados fictícios do teu localizacoes.php -->
                                <option value="Urgências · Sala de Reanimação">Urgências · Sala de Reanimação</option>
                                <option value="Obstetrícia · Consulta 3">Obstetrícia · Consulta 3</option>
                                <option value="UCI · Quarto 04 (Isolamento)">UCI · Quarto 04 (Isolamento)</option>
                                <option value="Bloco Operatório · Sala 3">Bloco Operatório · Sala de Cirurgia 3</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="eqRevisao" class="form-label small fw-bold text-secondary">Próxima Revisão / Calibração Planeada</label>
                            <input type="date" class="form-control rounded-3 bg-light border-0 text-secondary" id="eqRevisao" name="proxima_revisao" required>
                        </div>

                        <!-- Estado Inicial do Equipamento -->
                        <div class="col-12">
                            <label for="eqEstado" class="form-label small fw-bold text-secondary">Estado Operacional Inicial</label>
                            <select class="form-select rounded-3 bg-light border-0" id="eqEstado" name="estado_operacional" required>
                                <option value="Operacional" selected>Operacional (Pronto para Uso Clínico)</option>
                                <option value="Aguardar Calibração">Aguardar Calibração / Testes de Aceitação</option>
                                <option value="Em Manutenção">Inativo - Em Manutenção</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoEquipamento" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-plus me-2"></i>Registar Ativo
                </button>
            </div>

        </div>
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