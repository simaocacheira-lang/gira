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
                <tr onclick="window.location.href='detalhes_equipamento.php'" style="cursor: pointer;">
                    <td class="fw-bold text-primary fw-mono">#EQ-2026-001</td>
                    <td>
                        <div class="fw-bold">Ventilador Pulmonar de Alta Performance</div>
                        <small class="text-muted">Dräger · Evita Infinity V500</small>
                    </td>
                    <td class="fw-mono text-secondary">DG-EV-99214</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento" onclick="event.stopPropagation();">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr onclick="window.location.href='detalhes_equipamento.php'" style="cursor: pointer;">
                    <td class="fw-bold text-primary fw-mono">#EQ-2026-002</td>
                    <td>
                        <div class="fw-bold">Sistema de Ultrassom / Ecógrafo</div>
                        <small class="text-muted">Philips · Affiniti 70</small>
                    </td>
                    <td class="fw-mono text-secondary">PH-UL-44122</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento" onclick="event.stopPropagation();">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr onclick="window.location.href='detalhes_equipamento.php'" style="cursor: pointer;">
                    <td class="fw-bold text-primary fw-mono">#EQ-2026-003</td>
                    <td>
                        <div class="fw-bold">Monitor Multiparamétrico de Sinais Vitais</div>
                        <small class="text-muted">Mindray · BeneVision N17</small>
                    </td>
                    <td class="fw-mono text-secondary">MR-MN-77119</td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Aguardar Calibração</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Consultar Equipamento">
                            <i class="fa-solid fa-eye text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Equipamento" onclick="event.stopPropagation();">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalRegistarEquipamento" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-header border-bottom border-light p-3 pb-4 position-relative bg-light rounded-top-4">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="modal-title fw-bold text-dark">
                            <i class="fa-solid fa-laptop-medical text-primary me-2"></i>Registar Novo Equipamento
                        </h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="position-relative mt-2">
                        <div class="progress bg-white border shadow-sm" style="height: 6px;">
                            <div class="progress-bar bg-primary" id="stepperProgressBar" role="progressbar" style="width: 0%; transition: width 0.4s ease;"></div>
                        </div>
                        <div class="d-flex justify-content-between position-absolute top-50 start-0 w-100 translate-middle-y mt-n1 px-2">
                            <span class="step-indicator bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold small shadow-sm" style="width: 30px; height: 30px;" id="ind-step-1">1</span>
                            <span class="step-indicator bg-white text-secondary border rounded-circle d-flex align-items-center justify-content-center fw-bold small shadow-sm" style="width: 30px; height: 30px;" id="ind-step-2">2</span>
                            <span class="step-indicator bg-white text-secondary border rounded-circle d-flex align-items-center justify-content-center fw-bold small shadow-sm" style="width: 30px; height: 30px;" id="ind-step-3">3</span>
                            <span class="step-indicator bg-white text-secondary border rounded-circle d-flex align-items-center justify-content-center fw-bold small shadow-sm" style="width: 30px; height: 30px;" id="ind-step-4">4</span>
                            <span class="step-indicator bg-white text-secondary border rounded-circle d-flex align-items-center justify-content-center fw-bold small shadow-sm" style="width: 30px; height: 30px;" id="ind-step-5">5</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-body p-4">
                <form id="formNovoEquipamento" action="processar_equipamento.php" method="POST" enctype="multipart/form-data">

                    <div class="form-step" id="step-1">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-fingerprint text-muted me-2"></i>Passo 1: Identificação e Rede</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Nome do Equipamento</label>
                                <input type="text" class="form-control rounded-3 bg-light border-0" name="nome" placeholder="Ex: Ventilador Pulmonar" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Fabricante / Modelo</label>
                                <input type="text" class="form-control rounded-3 bg-light border-0" name="marca" placeholder="Ex: Dräger · Evita V500" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Número de Série (SN)</label>
                                <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="sn" placeholder="Ex: DG-EV-99214" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Endereço MAC (Opcional - Integração IT)</label>
                                <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="mac_address" placeholder="Ex: 00:1A:2B:3C:4D:5E">
                            </div>
                        </div>
                    </div>

                    <div class="form-step d-none" id="step-2">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-location-crosshairs text-muted me-2"></i>Passo 2: Risco e Localização</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Classe de Risco (Infraestrutura Clínica)</label>
                                <select class="form-select rounded-3 bg-light border-0" name="classe_risco" required>
                                    <option value="" selected disabled>Escolha a classe...</option>
                                    <option value="Suporte de Vida">Classe III - Suporte de Vida</option>
                                    <option value="Médio/Alto Risco">Classe IIb - Médio/Alto Risco</option>
                                    <option value="Monitorização">Classe IIa - Monitorização / Medição</option>
                                    <option value="Baixo Risco">Classe I - Baixo Risco</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Localização / Serviço Alocado</label>
                                <select class="form-select rounded-3 bg-light border-0" name="localizacao" required>
                                    <option value="" selected disabled>Escolha o serviço...</option>
                                    <option value="Urgências · Sala de Reanimação">Urgências · Sala de Reanimação</option>
                                    <option value="Obstetrícia · Consulta 3">Obstetrícia · Consulta 3</option>
                                    <option value="UCI · Quarto 04 (Isolamento)">UCI · Quarto 04 (Isolamento)</option>
                                    <option value="Bloco Operatório · Sala 3">Bloco Operatório · Sala de Cirurgia 3</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-step d-none" id="step-3">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-file-invoice-dollar text-muted me-2"></i>Passo 3: Aquisição e Contratos</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Data de Aquisição</label>
                                <input type="date" class="form-control rounded-3 bg-light border-0" name="data_aquisicao" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Custo de Aquisição (€)</label>
                                <input type="number" step="0.01" class="form-control rounded-3 bg-light border-0" name="custo_aquisicao" placeholder="Ex: 24500.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Fornecedor Oficial</label>
                                <select class="form-select rounded-3 bg-light border-0" name="fornecedor_id" required>
                                    <option value="" selected disabled>Selecione o fornecedor...</option>
                                    <option value="Philips Healthcare">Philips Healthcare</option>
                                    <option value="Dräger Portugal">Dräger Portugal</option>
                                    <option value="B. Braun">B. Braun</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Fim da Garantia de Fábrica</label>
                                <input type="date" class="form-control rounded-3 bg-light border-0" name="fim_garantia" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-step d-none" id="step-4">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-paperclip text-muted me-2"></i>Passo 4: Consumíveis e Anexos</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Periféricos / Consumíveis Associados</label>
                                <input type="text" class="form-control rounded-3 bg-light border-0" name="consumiveis" placeholder="Ex: Cabos ECG, Módulo SpO2, Filtros HEPA (separados por vírgula)">
                                <small class="text-muted" style="font-size: 0.65rem;">Ajudará na gestão de stock e no armazém técnico futuro.</small>
                            </div>
                            <div class="col-12 border-top pt-3 mt-3">
                                <label class="form-label small fw-bold text-secondary">Documento a Anexar (Manual, Certificado CE, Fatura)</label>
                                <input type="file" class="form-control rounded-3 bg-white shadow-sm border-light" name="documento_anexo" accept=".pdf,.doc,.docx,.jpg,.png">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Tipo do Documento Anexado</label>
                                <select class="form-select rounded-3 bg-light border-0" name="tipo_documento">
                                    <option value="" selected disabled>Selecione o tipo do ficheiro carregado...</option>
                                    <option value="Manual Técnico">Manual Técnico / Instruções</option>
                                    <option value="Certificado Conformidade">Certificado de Conformidade (CE)</option>
                                    <option value="Guia de Transporte">Guia de Transporte / Faturação</option>
                                    <option value="Relatório Ensaios">Relatório de Ensaios / Segurança Elétrica</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-step d-none" id="step-5">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-stethoscope text-muted me-2"></i>Passo 5: Estado Clínico</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Estado Operacional Inicial</label>
                                <select class="form-select rounded-3 bg-light border-0 text-success fw-bold" name="estado_operacional" required>
                                    <option value="Operacional" selected>Operacional (Pronto para Uso Clínico)</option>
                                    <option value="Aguardar Calibração">Aguardar Calibração / Testes de Aceitação</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Próxima Revisão / Calibração Planeada</label>
                                <input type="date" class="form-control rounded-3 bg-light border-0 text-secondary" name="proxima_revisao" required>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer border-top border-light p-3 bg-white rounded-bottom-4 d-flex justify-content-between">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-4 d-none" id="btnStepperPrev">
                    <i class="fa-solid fa-arrow-left me-2"></i>Anterior
                </button>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary rounded-3 fw-bold small px-4" id="btnStepperNext">
                        Seguinte <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" form="formNovoEquipamento" class="btn btn-success rounded-3 fw-bold small px-4 d-none" id="btnStepperSubmit">
                        <i class="fa-solid fa-check-double me-2"></i>Concluir Registo
                    </button>
                </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const totalSteps = 5;

        const btnNext = document.getElementById('btnStepperNext');
        const btnPrev = document.getElementById('btnStepperPrev');
        const btnSubmit = document.getElementById('btnStepperSubmit');
        const progressBar = document.getElementById('stepperProgressBar');

        function updateStepper() {
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step-${i}`).classList.add('d-none');

                let indicator = document.getElementById(`ind-step-${i}`);
                if (i <= currentStep) {
                    indicator.classList.remove('bg-white', 'text-secondary', 'border');
                    indicator.classList.add('bg-primary', 'text-white', 'shadow-sm');
                } else {
                    indicator.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                    indicator.classList.add('bg-white', 'text-secondary', 'border');
                }
            }

            document.getElementById(`step-${currentStep}`).classList.remove('d-none');

            let progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressBar.style.width = progressPercentage + '%';

            if (currentStep === 1) {
                btnPrev.classList.add('d-none');
            } else {
                btnPrev.classList.remove('d-none');
            }

            if (currentStep === totalSteps) {
                btnNext.classList.add('d-none');
                btnSubmit.classList.remove('d-none');
            } else {
                btnNext.classList.remove('d-none');
                btnSubmit.classList.add('d-none');
            }
        }

        btnNext.addEventListener('click', function() {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepper();
            }
        });

        btnPrev.addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateStepper();
            }
        });

        document.getElementById('modalRegistarEquipamento').addEventListener('hidden.bs.modal', function() {
            currentStep = 1;
            document.getElementById('formNovoEquipamento').reset();
            updateStepper();
        });
    });
</script>

<?php
// 3. Chamamos o fim do molde
render_footer();
?>