<?php
global $pdo;
if (empty($pdo)) {
    require_once __DIR__ . '/db.php';
}

try {
    // 1. Ir buscar os Equipamentos para a O.T.
    $stmt_lista_eq = $pdo->query("SELECT id, codigo_ativo, nome FROM equipamentos ORDER BY codigo_ativo ASC");
    $equipamentos_dropdown = $stmt_lista_eq->fetchAll();

    // 2. Ir buscar as Localizações para o Registo de Equipamento (NOVO)
    $stmt_lista_loc = $pdo->query("SELECT id, cod_sala, nome FROM localizacoes ORDER BY nome ASC");
    $localizacoes_dropdown = $stmt_lista_loc->fetchAll();
} catch (Exception $e) {
    $equipamentos_dropdown = [];
    $localizacoes_dropdown = [];
}
?>

<div class="modal fade" id="modalRegistarEquipamento" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom border-light p-3 pb-4 position-relative bg-light rounded-top-4">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-laptop-medical text-primary me-2"></i>Registar Novo Equipamento</h5>
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
                <form id="formNovoEquipamento" action="/gira/private/processar_equipamento.php" method="POST" enctype="multipart/form-data">
                    <div class="form-step" id="step-1">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-fingerprint text-muted me-2"></i>Passo 1: Identificação e Rede</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label small fw-bold text-secondary">Nome do Equipamento</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome" placeholder="Ex: Ventilador Pulmonar" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Fabricante / Modelo</label><input type="text" class="form-control rounded-3 bg-light border-0" name="marca" placeholder="Ex: Dräger · Evita V500" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Número de Série (SN)</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="sn" placeholder="Ex: DG-EV-99214" required></div>
                            <div class="col-12"><label class="form-label small fw-bold text-secondary">Endereço MAC (Opcional - Integração IT)</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="mac_address" placeholder="Ex: 00:1A:2B:3C:4D:5E"></div>
                        </div>
                    </div>
                    <div class="form-step d-none" id="step-2">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-location-crosshairs text-muted me-2"></i>Passo 2: Risco e Localização</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Classe de Risco</label>
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
                                <select class="form-select rounded-3 bg-light border-0" name="localizacao_id" required>
                                    <option value="" selected disabled>Escolha o serviço...</option>

                                    <?php foreach ($localizacoes_dropdown as $loc): ?>
                                        <option value="<?php echo $loc['id']; ?>">
                                            <?php echo htmlspecialchars($loc['cod_sala'] . ' · ' . $loc['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-step d-none" id="step-3">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-file-invoice-dollar text-muted me-2"></i>Passo 3: Aquisição e Contratos</h6>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Data de Aquisição</label><input type="date" class="form-control rounded-3 bg-light border-0" name="data_aquisicao" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Custo de Aquisição (€)</label><input type="number" step="0.01" class="form-control rounded-3 bg-light border-0" name="custo_aquisicao" placeholder="Ex: 24500.00" required></div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Fornecedor Oficial</label>
                                <select class="form-select rounded-3 bg-light border-0" name="fornecedor_id" required>
                                    <option value="" selected disabled>Selecione o fornecedor...</option>
                                    <option value="1">B. Braun Medical S.A.</option>
                                    <option value="2">Dräger Portugal</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Fim da Garantia de Fábrica</label><input type="date" class="form-control rounded-3 bg-light border-0" name="fim_garantia" required></div>
                        </div>
                    </div>
                    <div class="form-step d-none" id="step-4">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-paperclip text-muted me-2"></i>Passo 4: Consumíveis e Anexos</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label small fw-bold text-secondary">Periféricos / Consumíveis</label><input type="text" class="form-control rounded-3 bg-light border-0" name="consumiveis" placeholder="Ex: Cabos ECG, Módulo SpO2"></div>
                            <div class="col-12 border-top pt-3 mt-3"><label class="form-label small fw-bold text-secondary">Documento a Anexar</label><input type="file" class="form-control rounded-3 bg-white shadow-sm border-light" name="documento_anexo" accept=".pdf,.doc,.docx,.jpg,.png"></div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Tipo do Documento</label>
                                <select class="form-select rounded-3 bg-light border-0" name="tipo_documento">
                                    <option value="" selected disabled>Selecione o tipo do ficheiro...</option>
                                    <option value="Manual Técnico">Manual Técnico / Instruções</option>
                                    <option value="Certificado Conformidade">Certificado de Conformidade (CE)</option>
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
                                    <option value="Operacional" selected>Operacional (Pronto para Uso)</option>
                                    <option value="Aguardar Calibração">Aguardar Calibração</option>
                                </select>
                            </div>
                            <div class="col-12"><label class="form-label small fw-bold text-secondary">Próxima Revisão / Calibração</label><input type="date" class="form-control rounded-3 bg-light border-0 text-secondary" name="proxima_revisao" required></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3 bg-white rounded-bottom-4 d-flex justify-content-between">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-4 d-none" id="btnStepperPrev"><i class="fa-solid fa-arrow-left me-2"></i>Anterior</button>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary rounded-3 fw-bold small px-4" id="btnStepperNext">Seguinte <i class="fa-solid fa-arrow-right ms-2"></i></button>
                    <button type="submit" form="formNovoEquipamento" class="btn btn-success rounded-3 fw-bold small px-4 d-none" id="btnStepperSubmit"><i class="fa-solid fa-check-double me-2"></i>Concluir Registo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAbrirOT" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-screwdriver-wrench text-primary me-2"></i>Abrir Ordem de Trabalho</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovaOT" action="/gira/private/processar_manutencao.php" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Dispositivo Médico com Ocorrência</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-mono" name="equipamento_id" required>
                                <option value="" selected disabled>Selecione o equipamento...</option>
                                <?php foreach ($equipamentos_dropdown as $opt): ?>
                                    <option value="<?php echo $opt['id']; ?>">
                                        <?php echo htmlspecialchars($opt['codigo_ativo'] . ' - ' . $opt['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Tipo de Intervenção</label>
                            <select class="form-select rounded-3 bg-light border-0" name="tipo_manutencao" required>
                                <option value="Corretiva (Avaria)">Corretiva (Reparação de Avarias)</option>
                                <option value="Preventiva Planeada">Preventiva (Revisão Planeada)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Prioridade Clínica</label>
                            <select class="form-select rounded-3 bg-light border-0" name="prioridade" required>
                                <option value="Crítica">Crítica (Suporte de Vida)</option>
                                <option value="Alta">Alta (Fora de Serviço)</option>
                                <option value="Média" selected>Média</option>
                            </select>
                        </div>
                        <div class="col-12"><label class="form-label small fw-bold text-secondary">Sintomas / Descrição</label><textarea class="form-control rounded-3 bg-light border-0" name="descricao_avaria" rows="4" placeholder="Descreva os sintomas..." required></textarea></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaOT" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-circle-exclamation me-2"></i>Emitir O.T.</button>
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
                </div>
                <button type="button" class="btn-close shadow-none mb-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formFecharOT" action="/gira/private/processar_fecho_ot.php" method="POST">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom"><i class="fa-solid fa-clipboard-check text-primary me-2"></i>Relatório Técnico</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Trabalho Realizado</label>
                            <textarea class="form-control rounded-3 bg-light border-0" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Tempo Gasto (Horas)</label>
                            <input type="number" step="0.5" class="form-control rounded-3 bg-light border-0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Novo Estado</label>
                            <select class="form-select rounded-3 bg-light border-0 text-success fw-bold" required>
                                <option value="Operacional" selected>Operacional</option>
                                <option value="Aguardar Teste">Aguardar Calibração</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold m-0"><i class="fa-solid fa-boxes-stacked text-warning me-2"></i>Materiais e Peças Consumidas</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fw-bold" style="font-size: 0.7rem;"><i class="fa-solid fa-plus me-1"></i> Adicionar</button>
                    </div>
                    <div class="row g-2 align-items-center mb-2 bg-light p-2 rounded-3 border">
                        <div class="col-7">
                            <select class="form-select form-select-sm rounded-2 border-0 bg-white">
                                <option value="P01">Módulo SpO2 - Philips</option>
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
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3 bg-white rounded-bottom-4">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success rounded-3 fw-bold small px-4"><i class="fa-solid fa-check-double me-2"></i>Encerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovoDocumento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-import text-primary me-2"></i>Upload de Documento</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/gira/private/processar_documento.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3"><label class="form-label small fw-bold">Nome do Documento</label><input type="text" class="form-control bg-light border-0" required></div>
                    <div class="mb-3"><label class="form-label small fw-bold">Tipo</label><select class="form-select bg-light border-0">
                            <option>Manual Técnico</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label small fw-bold">Equipamento</label><select class="form-select bg-light border-0">
                            <option>#EQ-2026-001</option>
                        </select></div>
                    <div class="mb-2"><label class="form-label small fw-bold">Ficheiro</label><input type="file" class="form-control" required></div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4">Submeter</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistarFornecedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-truck-field text-primary me-2"></i>Registar Fornecedor</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovoFornecedor" action="/gira/private/processar_fornecedor.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary">Nome da Empresa</label>
                            <input type="text" class="form-control bg-light border-0" name="nome_empresa" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">NIF</label>
                            <input type="text" class="form-control bg-light border-0 fw-mono" name="nif" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">E-mail de Suporte</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control rounded-end-3 bg-light border-0" name="email_suporte">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Telefone / Linha de Apoio</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 bg-light border-0" name="telefone_suporte">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Especialidade / Equipamentos</label>
                            <select class="form-select bg-light border-0" name="especialidade" required>
                                <option value="Monitores e Imagiologia">Monitores e Imagiologia</option>
                                <option value="Ventilação e Suporte de Vida">Ventilação e Suporte de Vida</option>
                                <option value="Bombas de Infusão">Bombas de Infusão</option>
                                <option value="Consumíveis Gerais">Consumíveis Gerais</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Estado da Parceria</label>
                            <select class="form-select bg-light border-0 fw-bold text-success" name="estado">
                                <option value="Ativo" selected>Ativo (Contrato Válido)</option>
                                <option value="Inativo" class="text-danger">Suspenso / Inativo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoFornecedor" class="btn btn-primary rounded-3 fw-bold small px-4">Guardar Fornecedor</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarGarantia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-shield text-primary me-2"></i>Adicionar Contrato</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/gira/private/processar_garantia.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label small fw-bold">Referência Contrato</label><input type="text" class="form-control bg-light border-0" required></div>
                        <div class="col-md-6"><label class="form-label small fw-bold">Tipo Cobertura</label><select class="form-select bg-light border-0">
                                <option>Garantia de Fábrica</option>
                            </select></div>
                        <div class="col-12"><label class="form-label small fw-bold">Dispositivo</label><select class="form-select bg-light border-0">
                                <option>#EQ-2026-001</option>
                            </select></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4">Ativar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovaLocalizacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-location-dot text-primary me-2"></i>Nova Localização</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovaLocalizacao" action="/gira/private/processar_localizacao.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Código Sala</label>
                        <input type="text" class="form-control bg-light border-0 fw-mono text-uppercase" name="cod_sala" placeholder="Ex: #LOC-BLO01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome Serviço / Sala</label>
                        <input type="text" class="form-control bg-light border-0" name="nome" placeholder="Ex: Bloco Operatório" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Sublocalização / Camas</label>
                        <input type="text" class="form-control bg-light border-0" name="detalhe" placeholder="Ex: Sala 2 · Camas 5 a 8">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Piso</label>
                            <select class="form-select bg-light border-0" name="piso">
                                <option value="" selected disabled>Escolha...</option>
                                <option value="Piso 0">Piso 0</option>
                                <option value="Piso 1">Piso 1</option>
                                <option value="Piso 2">Piso 2</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Bloco / Ala</label>
                            <select class="form-select bg-light border-0" name="bloco">
                                <option value="" selected disabled>Escolha...</option>
                                <option value="Bloco Central">Bloco Central</option>
                                <option value="Bloco Cirúrgico">Bloco Cirúrgico</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaLocalizacao" class="btn btn-primary rounded-3 fw-bold small px-4">Mapear</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCriarUtilizador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus text-primary me-2"></i>Registar Utilizador</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/gira/private/processar_utilizador.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-7"><label class="form-label small fw-bold">Nome Completo</label><input type="text" class="form-control bg-light border-0" required></div>
                        <div class="col-md-5"><label class="form-label small fw-bold">Cédula</label><input type="text" class="form-control bg-light border-0" required></div>
                        <div class="col-md-6"><label class="form-label small fw-bold">Perfil</label><select class="form-select bg-light border-0">
                                <option>Eng. Biomédico</option>
                            </select></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4">Criar Conta</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-users-gear text-primary me-2"></i>Criar Perfil</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/gira/private/processar_perfil.php" method="POST">
                    <div class="mb-3"><label class="form-label small fw-bold">Nome do Perfil</label><input type="text" class="form-control bg-light border-0" required></div>
                    <div class="bg-light rounded-3 p-3">
                        <div class="form-check"><input class="form-check-input" type="checkbox" checked><label class="form-check-label small">Acesso Completo</label></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovaEncomenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-cart-plus text-primary me-2"></i>Nova Encomenda</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/gira/private/processar_encomenda.php" method="POST">
                    <div class="mb-3"><label class="form-label small fw-bold">Artigo</label><select class="form-select bg-light border-0">
                            <option>Módulo SpO2</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label small fw-bold">Qtd</label><input type="number" class="form-control bg-light border-0" value="1"></div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4">Confirmar Pedido</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarLocalizacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Editar Localização</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarLocalizacao" action="/gira/private/processar_edicao_localizacao.php" method="POST">

                    <input type="hidden" name="id_localizacao" value="LOC-001">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Código Sala</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono text-uppercase" name="cod_sala" value="#LOC-UCI02" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome Serviço / Sala</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" name="nome" value="Unidade de Cuidados Intensivos (UCI)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Sublocalização / Camas</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" name="detalhe" value="Sala 2 · Camas 5 a 8">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Piso</label>
                            <select class="form-select rounded-3 bg-light border-0" name="piso" required>
                                <option value="Piso 0">Piso 0</option>
                                <option value="Piso 1">Piso 1</option>
                                <option value="Piso 2" selected>Piso 2</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Bloco / Ala</label>
                            <select class="form-select rounded-3 bg-light border-0" name="bloco" required>
                                <option value="Bloco Central" selected>Bloco Central</option>
                                <option value="Bloco Cirúrgico">Bloco Cirúrgico</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarLocalizacao" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarFornecedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Editar Fornecedor</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarFornecedor" action="/gira/private/processar_edicao_fornecedor.php" method="POST">

                    <input type="hidden" name="id_fornecedor" value="FORN-001">

                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary">Nome da Empresa</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" name="nome_empresa" value="Philips Healthcare Portugal" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">NIF</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="nif" value="501234567" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">E-mail de Suporte</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control rounded-end-3 bg-light border-0" name="email_suporte" value="suporte.pt@philips.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Contacto Telefónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 bg-light border-0" name="telefone_suporte" value="210 000 000" required>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label class="form-label small fw-bold text-secondary">Especialidade Principal</label>
                            <select class="form-select rounded-3 bg-light border-0" name="especialidade" required>
                                <option value="Monitores e Imagiologia" selected>Monitores e Imagiologia</option>
                                <option value="Ventilação e Suporte de Vida">Ventilação e Suporte de Vida</option>
                                <option value="Bombas de Infusão">Bombas de Infusão</option>
                                <option value="Consumíveis Gerais">Consumíveis Gerais</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label small fw-bold text-secondary">Estado da Parceria</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-bold" name="estado" required>
                                <option value="Ativo" class="text-success" selected>Ativo (Contrato Válido)</option>
                                <option value="Inativo" class="text-danger">Suspenso / Expirado</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarFornecedor" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
                </button>
            </div>
        </div>
    </div>
</div>