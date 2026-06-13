<?php
global $pdo;
if (empty($pdo)) {
    require_once __DIR__ . '/db.php';
}

try {
    // 1. Ir buscar os Equipamentos para a O.T.
    $stmt_lista_eq = $pdo->query("SELECT id, codigo_ativo, nome FROM equipamentos ORDER BY codigo_ativo ASC");
    $equipamentos_dropdown = $stmt_lista_eq->fetchAll();

    // 2. Ir buscar as Localizações para o Registo de Equipamento
    $stmt_lista_loc = $pdo->query("SELECT id, cod_sala, nome FROM localizacoes ORDER BY nome ASC");
    $localizacoes_dropdown = $stmt_lista_loc->fetchAll();

    // 3. Ir buscar os Perfis para o modal de Utilizadores
    $stmt_perfis = $pdo->query("SELECT id, nome_perfil FROM perfis_acesso ORDER BY nivel_acesso DESC");
    $perfis_dropdown = $stmt_perfis->fetchAll();

    // 4. Ir buscar os Fornecedores para o Registo de Equipamento (Fabricante)
    $stmt_forn = $pdo->query("SELECT id, nome_empresa FROM fornecedores ORDER BY nome_empresa ASC");
    $fornecedores_dropdown = $stmt_forn->fetchAll();

    // 5. Ir buscar os Artigos do Armazém para os Consumíveis
    $stmt_artigos = $pdo->query("SELECT id, referencia, nome FROM artigos_armazem ORDER BY nome ASC");
    $artigos_dropdown = $stmt_artigos->fetchAll();
} catch (Exception $e) {
    $equipamentos_dropdown = [];
    $localizacoes_dropdown = [];
    $perfis_dropdown = [];
    $fornecedores_dropdown = [];
    $artigos_dropdown = [];
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
                <form id="formNovoEquipamento" action="/sibdas/1241251/gira/private/equipamentos/processar_equipamento.php" method="POST" enctype="multipart/form-data">
                    <div class="form-step" id="step-1">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-fingerprint text-muted me-2"></i>Passo 1: Identificação e Rede</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label small fw-bold text-secondary">Nome do Equipamento</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome" placeholder="Ex: Ventilador Pulmonar" required></div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Fabricante Oficial</label>
                                <select class="form-select rounded-3 bg-light border-0" name="fornecedor_id" required>
                                    <option value="" selected disabled>Escolha o fabricante...</option>
                                    <?php foreach ($fornecedores_dropdown as $forn): ?>
                                        <option value="<?php echo $forn['id']; ?>">
                                            <?php echo htmlspecialchars($forn['nome_empresa']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Modelo / Versão</label>
                                <input type="text" class="form-control rounded-3 bg-light border-0" name="modelo" placeholder="Ex: Evita V500" required>
                            </div>

                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Número de Série (SN)</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="sn" placeholder="Ex: DG-EV-99214" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Endereço MAC (Integração IT)</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="mac_address" placeholder="Ex: 00:1A:2B:3C:4D:5E"></div>
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
                            <div class="col-md-4"><label class="form-label small fw-bold text-secondary">Data de Aquisição</label><input type="date" class="form-control rounded-3 bg-light border-0" name="data_aquisicao" required></div>
                            <div class="col-md-4"><label class="form-label small fw-bold text-secondary">Custo de Aquisição (€)</label><input type="number" step="0.01" class="form-control rounded-3 bg-light border-0" name="custo_aquisicao" placeholder="Ex: 24500.00" required></div>
                            <div class="col-md-4"><label class="form-label small fw-bold text-secondary">Fim da Garantia</label><input type="date" class="form-control rounded-3 bg-light border-0" name="fim_garantia" required></div>
                        </div>
                    </div>
                    <div class="form-step d-none" id="step-4">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2"><i class="fa-solid fa-paperclip text-muted me-2"></i>Passo 4: Consumíveis e Anexos</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Periféricos / Consumíveis</label>
                                <select class="form-select rounded-3 bg-light border-0" name="consumiveis">
                                    <option value="" selected>Nenhum (Sem peça oficial associada)</option>
                                    <?php foreach ($artigos_dropdown as $artigo): ?>
                                        <option value="<?php echo $artigo['id']; ?>">
                                            <?php echo htmlspecialchars($artigo['referencia'] . ' - ' . $artigo['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
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
                <form id="formNovaOT" action="/sibdas/1241251/gira/private/manutencao/processar_manutencao.php" method="POST">
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
                        <span class="text-muted fw-mono small" id="fecho_numero_ot">#OT-XXXX</span>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0"><i class="fa-solid fa-flag-checkered text-success me-2"></i>Encerrar Ordem de Trabalho</h5>
                </div>
                <button type="button" class="btn-close shadow-none mb-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formFecharOT" action="/sibdas/1241251/gira/private/manutencao/processar_fecho_ot.php" method="POST">
                    <input type="hidden" name="id_ot" id="fecho_id_ot">
                    <input type="hidden" name="id_equipamento" id="fecho_id_equipamento">

                    <h6 class="fw-bold mb-3 pb-2 border-bottom"><i class="fa-solid fa-clipboard-check text-primary me-2"></i>Relatório Técnico</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Trabalho Realizado</label>
                            <textarea class="form-control rounded-3 bg-light border-0" name="relatorio_tecnico" rows="3" required placeholder="Descreva a intervenção..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Tempo Gasto (Horas)</label>
                            <input type="number" step="0.5" class="form-control rounded-3 bg-light border-0" name="tempo_gasto" placeholder="Ex: 1.5" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Novo Estado do Equipamento</label>
                            <select class="form-select rounded-3 bg-light border-0 text-success fw-bold" name="novo_estado_equipamento" required>
                                <option value="Operacional" selected>Operacional</option>
                                <option value="Manutenção" class="text-warning">Aguardar Calibração Extra</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3 bg-white rounded-bottom-4">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formFecharOT" class="btn btn-success rounded-3 fw-bold small px-4"><i class="fa-solid fa-check-double me-2"></i>Encerrar O.T.</button>
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
                <form id="formNovoDocumento" action="/sibdas/1241251/gira/private/documentos/processar_documento.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Equipamento Associado</label>
                        <select class="form-select bg-light border-0 fw-bold text-primary" name="id_equipamento" id="doc_id_equipamento" required>
                            <option value="" selected disabled>Selecione o equipamento...</option>
                            <?php foreach ($equipamentos_dropdown as $opt): ?>
                                <option value="<?php echo $opt['id']; ?>">
                                    <?php echo htmlspecialchars($opt['codigo_ativo'] . ' - ' . $opt['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome / Título do Documento</label>
                        <input type="text" class="form-control bg-light border-0" name="nome_documento" placeholder="Ex: Manual de Serviço" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Tipo de Documento</label>
                        <select class="form-select bg-light border-0" name="tipo_documento" required>
                            <option value="Manual Técnico">Manual Técnico / Instruções</option>
                            <option value="Certificado Conformidade (CE)">Certificado de Conformidade (CE)</option>
                            <option value="Guia de Calibração">Guia de Calibração</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Ficheiro (PDF, JPG, PNG)</label>
                        <input type="file" class="form-control bg-white border shadow-sm rounded-3" name="ficheiro" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoDocumento" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-cloud-arrow-up me-2"></i>Submeter Documento
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarGarantia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-shield text-primary me-2"></i>Atualizar Garantia</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formGarantia" action="/sibdas/1241251/gira/private/garantias/processar_garantia.php" method="POST">
                    <input type="hidden" name="id_equipamento" id="garantia_id_equipamento">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Data de Fim da Garantia</label>
                        <input type="date" class="form-control rounded-3 bg-light border-0" name="fim_garantia" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formGarantia" class="btn btn-primary rounded-3 fw-bold small px-4">Guardar Alteração</button>
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

                <?php if (function_exists('exibir_erros_modal')) exibir_erros_modal('modalRegistarFornecedor'); ?>

                <form id="formNovoFornecedor" action="/sibdas/1241251/gira/private/fornecedores/processar_fornecedor.php" method="POST" novalidate>
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary">Nome da Empresa</label>
                            <input type="text" class="form-control bg-light border-0" name="nome_empresa" maxlength="100" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">NIF</label>
                            <input type="text" class="form-control bg-light border-0 fw-mono" name="nif" pattern="\d{9}" maxlength="9" title="O NIF deve conter exatamente 9 números." required>
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
                                <option value="Bloco Operatório e Cirurgia">Bloco Operatório e Cirurgia</option>
                                <option value="Laboratório e Diagnóstico">Laboratório e Diagnóstico</option>
                                <option value="Mobiliário Hospitalar">Mobiliário Hospitalar</option>
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

<div class="modal fade" id="modalEditarFornecedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Editar Fornecedor</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarFornecedor" action="/sibdas/1241251/gira/private/fornecedores/processar_edicao_fornecedor.php" method="POST">
                    <input type="hidden" name="id_fornecedor" id="edit_id_fornecedor">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary">Nome da Empresa</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" name="nome_empresa" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">NIF</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="nif" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">E-mail de Suporte</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                <input type="email" class="form-control rounded-end-3 bg-light border-0" name="email_suporte" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Contacto Telefónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 bg-light border-0" name="telefone_suporte" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label small fw-bold text-secondary">Especialidade Principal</label>
                            <select class="form-select rounded-3 bg-light border-0" name="especialidade" required>
                                <option value="Monitores e Imagiologia">Monitores e Imagiologia</option>
                                <option value="Ventilação e Suporte de Vida">Ventilação e Suporte de Vida</option>
                                <option value="Bombas de Infusão">Bombas de Infusão</option>
                                <option value="Consumíveis Gerais">Consumíveis Gerais</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label small fw-bold text-secondary">Estado da Parceria</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-bold" name="estado" required>
                                <option value="Ativo" class="text-success">Ativo (Contrato Válido)</option>
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

<div class="modal fade" id="modalNovaLocalizacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-location-dot text-primary me-2"></i>Nova Localização</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                <?php if (function_exists('exibir_erros_modal')) exibir_erros_modal('modalNovaLocalizacao'); ?>

                <form id="formNovaLocalizacao" action="/sibdas/1241251/gira/private/localizacoes/processar_localizacao.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Código Sala</label>
                        <input type="text" class="form-control bg-light border-0 fw-mono text-uppercase" name="cod_sala" placeholder="Ex: #LOC-BLO01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome Serviço / Sala</label>
                        <input type="text" class="form-control bg-light border-0" name="nome" maxlength="100" placeholder="Ex: Bloco Operatório" required>
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
                                <option value="Piso -2">Piso -2</option>
                                <option value="Piso -1">Piso -1</option>
                                <option value="Piso 0">Piso 0</option>
                                <option value="Piso 1">Piso 1</option>
                                <option value="Piso 2">Piso 2</option>
                                <option value="Piso 3">Piso 3</option>
                                <option value="Piso 4">Piso 4</option>
                                <option value="Piso 5">Piso 5</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Bloco / Ala</label>
                            <select class="form-select bg-light border-0" name="bloco">
                                <option value="" selected disabled>Escolha...</option>
                                <option value="Bloco Central">Bloco Central</option>
                                <option value="Bloco Cirúrgico">Bloco Cirúrgico</option>
                                <option value="Ala Norte">Ala Norte</option>
                                <option value="Ala Sul">Ala Sul</option>
                                <option value="Ala Pediátrica">Ala Pediátrica</option>
                                <option value="Edifício Exterior">Edifício Exterior</option>
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

<div class="modal fade" id="modalEditarLocalizacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Editar Localização</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarLocalizacao" action="/sibdas/1241251/gira/private/localizacoes/processar_edicao_localizacao.php" method="POST">
                    <input type="hidden" name="id_localizacao" id="edit_id_localizacao">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Código Sala</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono text-uppercase" name="cod_sala" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome Serviço / Sala</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Sublocalização / Camas</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" name="detalhe">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Piso</label>
                            <select class="form-select rounded-3 bg-light border-0" name="piso" required>
                                <option value="Piso 0">Piso 0</option>
                                <option value="Piso 1">Piso 1</option>
                                <option value="Piso 2">Piso 2</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Bloco / Ala</label>
                            <select class="form-select rounded-3 bg-light border-0" name="bloco" required>
                                <option value="Bloco Central">Bloco Central</option>
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

<div class="modal fade" id="modalNovaEncomenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-cart-plus text-primary me-2"></i>Nova Encomenda</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                <?php if (function_exists('exibir_erros_modal')) exibir_erros_modal('modalNovaEncomenda'); ?>

                <form id="formNovaEncomenda" action="/sibdas/1241251/gira/private/armazem/processar_encomenda.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Artigo a Encomendar</label>
                        <select class="form-select bg-light border-0" name="artigo_id" required>
                            <option value="" selected disabled>Selecione o artigo...</option>
                            <?php foreach ($artigos_dropdown as $artigo): ?>
                                <option value="<?php echo $artigo['id']; ?>">
                                    <?php echo htmlspecialchars($artigo['referencia'] . ' - ' . $artigo['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Quantidade</label>
                            <input type="number" class="form-control bg-light border-0" name="quantidade" min="1" value="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary">Data Prevista</label>
                            <input type="date" class="form-control bg-light border-0" name="data_prevista" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Notas / Observações</label>
                        <textarea class="form-control bg-light border-0" name="notas" rows="2"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaEncomenda" class="btn btn-primary rounded-3 fw-bold small px-4">Confirmar Pedido</button>
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
                <form id="formNovoUtilizador" action="/sibdas/1241251/gira/private/utilizadores/processar_utilizador.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary">Nome Completo</label>
                            <input type="text" class="form-control bg-light border-0" name="nome" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Cédula Profissional</label>
                            <input type="text" class="form-control bg-light border-0 fw-mono" name="cedula" placeholder="Opcional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">E-mail de Acesso</label>
                            <input type="email" class="form-control bg-light border-0" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Palavra-passe Inicial</label>
                            <input type="password" class="form-control bg-light border-0" name="password" required>
                        </div>
                        <div class="col-md-12 border-top pt-3 mt-3">
                            <label class="form-label small fw-bold text-secondary">Perfil de Acesso / Permissões</label>
                            <select class="form-select bg-light border-0 fw-bold text-primary" name="perfil_id" required>
                                <option value="" selected disabled>Selecione o perfil...</option>
                                <?php foreach ($perfis_dropdown as $perfil): ?>
                                    <option value="<?php echo $perfil['id']; ?>">
                                        <?php echo htmlspecialchars($perfil['nome_perfil']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-3 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoUtilizador" class="btn btn-primary rounded-3 fw-bold small px-4">Criar Conta</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarUtilizador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-pen text-primary me-2"></i>Editar Utilizador</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarUtilizador" action="/sibdas/1241251/gira/private/utilizadores/processar_edicao_utilizador.php" method="POST">
                    <input type="hidden" name="id_utilizador" id="edit_id_utilizador">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary">Nome Completo</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" name="nome" id="edit_nome_utilizador" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Cédula Profissional</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="cedula" id="edit_cedula_utilizador">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">E-mail de Acesso</label>
                            <input type="email" class="form-control rounded-3 bg-light border-0" name="email" id="edit_email_utilizador" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Nova Palavra-passe</label>
                            <input type="password" class="form-control rounded-3 bg-light border-0" name="password" placeholder="Deixar em branco para não alterar">
                        </div>
                        <div class="col-md-12 border-top pt-3 mt-3">
                            <label class="form-label small fw-bold text-secondary">Perfil de Acesso / Permissões</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-bold text-primary" name="perfil_id" id="edit_perfil_utilizador" required>
                                <?php foreach ($perfis_dropdown as $perfil): ?>
                                    <option value="<?php echo $perfil['id']; ?>">
                                        <?php echo htmlspecialchars($perfil['nome_perfil']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarUtilizador" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-users-gear text-primary me-2"></i>Novo Perfil</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formAdicionarPerfil" action="/sibdas/1241251/gira/private/perfis/processar_perfil.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome do Perfil / Grupo</label>
                        <input type="text" class="form-control bg-light border-0" name="nome_perfil" placeholder="Ex: Técnico Auxiliar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nível de Acesso do Profissional</label>
                        <select class="form-select bg-light border-0 fw-bold text-primary" name="nivel_acesso" required>
                            <option value="" selected disabled>Selecione as permissões...</option>
                            <option value="1">Nível 1 - Apenas Leitura (Médicos/Enfermeiros)</option>
                            <option value="2">Nível 2 - Modificação (Técnicos/Engenheiros)</option>
                            <option value="3" class="text-danger">Nível 3 - Administração Total</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formAdicionarPerfil" class="btn btn-primary rounded-3 fw-bold small px-4">Criar Perfil</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-key text-primary me-2"></i>Configurar Direitos</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditarPerfil" action="/sibdas/1241251/gira/private/perfis/processar_edicao_perfil.php" method="POST">
                    <input type="hidden" name="id_perfil" id="edit_id_perfil">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nome do Perfil / Grupo</label>
                        <input type="text" class="form-control bg-light border-0" name="nome_perfil" id="edit_nome_perfil" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nível de Acesso do Profissional</label>
                        <select class="form-select bg-light border-0 fw-bold text-primary" name="nivel_acesso" id="edit_nivel_perfil" required>
                            <option value="1">Nível 1 - Apenas Leitura (Médicos/Enfermeiros)</option>
                            <option value="2">Nível 2 - Modificação (Técnicos/Engenheiros)</option>
                            <option value="3" class="text-danger">Nível 3 - Administração Total</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarPerfil" class="btn btn-primary rounded-3 fw-bold small px-4">Guardar Alterações</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalConfirmarEliminacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0 p-4 pb-2">
                <h5 class="modal-title fw-bold text-danger" id="tituloModalEliminacao">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Confirmar Eliminação
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <p class="text-secondary mb-0 fw-medium" id="textoModalEliminacao">
                    Tem a certeza que deseja eliminar este registo?
                </p>
            </div>
            <div class="modal-footer border-top-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-4 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmarEliminacao" class="btn btn-danger rounded-3 fw-bold small px-4 shadow-sm hover-danger">
                    <i class="fa-solid fa-trash-can me-2"></i>Sim, Eliminar
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalConfirmarEstado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0 p-4 pb-2">
                <h5 class="modal-title fw-bold" id="tituloModalEstado">
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <p class="text-secondary mb-0 fw-medium" id="textoModalEstado">
                </p>
            </div>
            <div class="modal-footer border-top-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-3 fw-bold small px-4 text-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmarEstado" class="btn rounded-3 fw-bold small px-4 shadow-sm">
                </a>
            </div>
        </div>
    </div>
</div>