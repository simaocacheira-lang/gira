<?php
// 1. Chamamos o molde
require_once __DIR__ . '/layout.php';

// 2. Montamos o topo da página
render_header("Gira - Detalhes do Equipamento");
?>

<!-- Transformamos a página num formulário vivo -->
<form action="/gira/private/processar_edicao_equipamento.php" method="POST">

    <!-- ============================================================================== -->
    <!-- 1. HEADER (Botões de Ação e Submissão)                                         -->
    <!-- ============================================================================== -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small fw-bold">
                <li class="breadcrumb-item"><a href="/gira/private/equipamentos.php" class="text-decoration-none text-muted">Equipamentos</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Ficha Técnica e Edição</li>
            </ol>
        </nav>
        <div class="d-flex gap-2">
            <a href="/gira/private/equipamentos.php" class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Voltar
            </a>
            <div class="dropdown">
                <button class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 small">
                    <li><a class="dropdown-item fw-medium py-2" href="#"><i class="fa-solid fa-qrcode text-muted me-2"></i> Imprimir Etiqueta QR</a></li>
                    <li><a class="dropdown-item fw-medium py-2" href="#"><i class="fa-solid fa-ban text-warning me-2"></i> Suspender Equipamento</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item fw-bold text-danger py-2" href="#"><i class="fa-solid fa-trash-can me-2"></i> Abater Inventário</a></li>
                </ul>
            </div>
            <!-- Novo botão de Guardar -->
            <button type="submit" class="btn btn-success rounded-3 fw-bold small px-3 py-2 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
            </button>
        </div>
    </div>

    <!-- ============================================================================== -->
    <!-- 2. HERO HEADER (Identificação Editável do Ativo)                               -->
    <!-- ============================================================================== -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 border-top border-primary border-4">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            <!-- Nome do equipamento agora é um input -->
            <input type="text" class="form-control form-control-lg fw-bold bg-light border-0 w-auto" name="nome_equipamento" value="Monitor Multiparamétrico IntelliVue" style="min-width: 350px;">

            <!-- Estados agora são selects rápidos -->
            <select class="form-select form-select-sm bg-success bg-opacity-10 text-success fw-bold border-success-subtle w-auto rounded-3" name="estado_operacional">
                <option value="Operacional" selected>Operacional</option>
                <option value="Avariado">Avariado / Em Reparação</option>
                <option value="Calibracao">Aguardar Calibração</option>
            </select>

            <select class="form-select form-select-sm bg-danger bg-opacity-10 text-danger fw-bold border-danger-subtle w-auto rounded-3" name="classe_risco">
                <option value="Classe III" selected>Suporte de Vida (Classe III)</option>
                <option value="Classe IIb">Médio/Alto Risco (Classe IIb)</option>
                <option value="Classe IIa">Monitorização (Classe IIa)</option>
            </select>
        </div>

        <!-- Grelha Rápida Editável -->
        <div class="row g-4 border-top pt-3">
            <div class="col-6 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-fingerprint me-1"></i>ID Ativo (Fixo)</label>
                <input type="text" class="form-control form-control-sm bg-light border-0 fw-mono fw-bold text-muted" name="id_ativo" value="#EQ-2026-001" readonly>
            </div>
            <div class="col-6 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-industry me-1"></i>Marca</label>
                <input type="text" class="form-control form-control-sm bg-light border-0 fw-medium" name="marca" value="Philips">
            </div>
            <div class="col-6 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-microchip me-1"></i>Modelo</label>
                <input type="text" class="form-control form-control-sm bg-light border-0 fw-medium" name="modelo" value="MX400">
            </div>
            <div class="col-6 col-md-4">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-location-dot me-1"></i>Localização Exata</label>
                <select class="form-select form-select-sm bg-light border-0 fw-bold text-primary" name="localizacao">
                    <option value="UCI02" selected>#LOC-UCI02 · UCI Piso 2 (Sala 2)</option>
                    <option value="BO03">#LOC-BO03 · Bloco Operatório 3</option>
                    <option value="URG01">#LOC-URG01 · Urgência (Trauma)</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-regular fa-calendar me-1"></i>Data Aquisição</label>
                <input type="date" class="form-control form-control-sm bg-light border-0 fw-medium" name="data_aquisicao" value="2022-03-15">
            </div>
        </div>
    </div>

    <!-- ============================================================================== -->
    <!-- 3. NAVEGAÇÃO CENTRALIZADORA DE TABS                                            -->
    <!-- ============================================================================== -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white px-3 pt-3">
        <ul class="nav nav-underline flex-nowrap overflow-x-auto border-bottom-0 gap-3 fw-bold" id="equipamentoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-nowrap text-secondary pb-3" id="visao-tab" data-bs-toggle="tab" data-bs-target="#visao" type="button" role="tab"><i class="fa-solid fa-cube me-2"></i>Visão Geral</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="manutencao-tab" data-bs-toggle="tab" data-bs-target="#manutencao" type="button" role="tab"><i class="fa-solid fa-screwdriver-wrench me-2"></i>Ordens Trabalho</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab"><i class="fa-regular fa-file-pdf me-2"></i>Documentos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="comercial-tab" data-bs-toggle="tab" data-bs-target="#comercial" type="button" role="tab"><i class="fa-solid fa-handshake me-2"></i>Comercial & Garantias</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="armazem-tab" data-bs-toggle="tab" data-bs-target="#armazem" type="button" role="tab"><i class="fa-solid fa-boxes-stacked me-2"></i>Peças Compativeis</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="auditoria-tab" data-bs-toggle="tab" data-bs-target="#auditoria" type="button" role="tab"><i class="fa-solid fa-clock-rotate-left me-2"></i>Logs</button>
            </li>
        </ul>
    </div>

    <!-- ============================================================================== -->
    <!-- 4. CONTEÚDO DAS TABS                                                           -->
    <!-- ============================================================================== -->
    <div class="tab-content" id="equipamentoTabsContent">

        <!-- TAB 1: VISÃO GERAL (Editável) -->
        <div class="tab-pane fade show active" id="visao" role="tabpanel" tabindex="0">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                        <h6 class="fw-bold mb-4 text-dark fs-5">Detalhes Técnicos e IT</h6>

                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Número de Série (SN)</label>
                                <input type="text" class="form-control bg-light border-0 fw-mono fw-bold" name="sn" value="MPS-2022-45873">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Endereço MAC (Integração IT)</label>
                                <input type="text" class="form-control bg-light border-0 fw-mono fw-bold" name="mac_address" value="00:1A:2B:3C:4D:5E">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Custo de Aquisição Original (€)</label>
                                <input type="number" step="0.01" class="form-control bg-light border-0 fw-bold" name="custo_aquisicao" value="24500.00">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Próxima Revisão Obrigatória</label>
                                <input type="date" class="form-control bg-light border-0 fw-bold text-primary" name="proxima_revisao" value="2026-05-20">
                            </div>

                            <div class="col-12 mt-4 pt-3 border-top">
                                <label class="text-muted d-block mb-2 small fw-bold">Notas do Engenheiro Clínico</label>
                                <textarea class="form-control bg-light border-0 text-secondary small" name="notas" rows="3">Equipamento principal de suporte da UCI 2. Requer calibração metrológica semestral obrigatória devido à certificação de risco. O módulo de capnografia apresenta sensibilidade a quedas.</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna Direita: KPIs de Fiabilidade do Equipamento -->
                <div class="col-lg-4">
                    <div class="vstack gap-4 h-100">
                        <!-- Indicador MTBF -->
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-success border-4">
                            <small class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.7rem;">Fiabilidade (MTBF)</small>
                            <h2 class="fw-black text-dark mb-0">184 <span class="fs-6 fw-medium text-muted">Dias</span></h2>
                            <small class="text-success fw-bold mt-1" style="font-size: 0.7rem;"><i class="fa-solid fa-arrow-trend-up me-1"></i> Acima da média da UCI</small>
                        </div>

                        <!-- Custo Total Acumulado (TCO) -->
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-danger border-4">
                            <small class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.7rem;">Custos de Reparação (TCO)</small>
                            <h2 class="fw-black text-dark mb-0">1.250 <span class="fs-6 fw-medium text-muted">€</span></h2>
                            <small class="text-muted mt-1" style="font-size: 0.7rem;">Gasto em OTs e Peças Substituídas</small>
                        </div>

                        <!-- Alerta de Próxima Manutenção -->
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-warning bg-opacity-10 border border-warning-subtle flex-grow-1 d-flex flex-column justify-content-center text-center">
                            <i class="fa-solid fa-calendar-check fs-2 text-warning mb-2"></i>
                            <small class="text-dark fw-bold d-block mb-1">Próxima Calibração</small>
                            <span class="fw-black text-dark fs-5">20 de Maio, 2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: OTs (MANUTENÇÃO) -->
        <div class="tab-pane fade" id="manutencao" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0 text-dark">Histórico de Ordens de Trabalho</h6>
                    <button type="button" class="btn btn-sm btn-primary rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAbrirOT">
                        <i class="fa-solid fa-plus me-1"></i> Nova O.T. para este Equipamento
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Nº O.T.</th>
                                <th>Data</th>
                                <th>Sintoma / Relatório Técnico</th>
                                <th>Tipo</th>
                                <th>Técnico</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-primary fw-mono">#OT-2025-412</td>
                                <td>20/11/2025</td>
                                <td>
                                    <div class="fw-bold">Falha no display LCD</div>
                                    <small class="text-muted">Substituição de ecrã tátil fraturado.</small>
                                </td>
                                <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2">Corretiva</span></td>
                                <td>Eng. Helena Barbosa</td>
                                <td><span class="badge bg-light text-muted border rounded-pill px-2">Fechada</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 3: DOCUMENTOS -->
        <div class="tab-pane fade" id="documentos" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0 text-dark">Anexos Técnicos e Conformidade</h6>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovoDocumento"><i class="fa-solid fa-upload me-1"></i> Anexar Doc</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Documento</th>
                                <th>Tipo</th>
                                <th>Data Upload</th>
                                <th class="text-end">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark"><i class="fa-regular fa-file-pdf text-danger me-2 fs-5 align-middle"></i>Manual_Servico_MX400.pdf</div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary border px-2">Manual Técnico</span></td>
                                <td>15/03/2022</td>
                                <td class="text-end"><button type="button" class="btn btn-light btn-sm border rounded-3"><i class="fa-solid fa-download text-muted"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 4: COMERCIAL (Fornecedor + Garantia cruzados) -->
        <div class="tab-pane fade" id="comercial" role="tabpanel" tabindex="0">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h6 class="fw-bold mb-4 text-dark">Entidade Fornecedora Oficial</h6>
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-light p-3 rounded-circle border me-3 flex-shrink-0">
                                <i class="fa-solid fa-building fs-3 text-primary opacity-50"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Philips Healthcare Portugal</h5>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Monitores e Imagiologia</span>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2 text-secondary"><i class="fa-solid fa-fingerprint w-20px me-2 text-muted"></i> <strong class="text-dark">NIF:</strong> 501234567</li>
                            <li class="mb-2 text-secondary"><i class="fa-solid fa-phone w-20px me-2 text-muted"></i> <strong class="text-dark">Suporte Técnico:</strong> 210 000 000</li>
                            <li class="text-secondary"><i class="fa-solid fa-envelope w-20px me-2 text-muted"></i> <strong class="text-dark">E-mail:</strong> <a href="mailto:suporte.pt@philips.com" class="text-decoration-none">suporte.pt@philips.com</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100 text-center d-flex flex-column justify-content-center">
                        <div class="mb-3">
                            <i class="fa-solid fa-shield-cat fs-1 text-danger mb-3"></i>
                            <h6 class="fw-bold text-dark mb-1">Garantia Expirada</h6>
                            <small class="text-muted d-block">Sem cobertura ativa neste momento.</small>
                        </div>
                        <div class="bg-light p-2 rounded-3 border mb-3">
                            <small class="text-secondary fw-bold">Término de Fábrica: 15/03/2024</small>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalAdicionarGarantia">Associar Novo Contrato SLA</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: ARMAZÉM E PEÇAS -->
        <div class="tab-pane fade" id="armazem" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Peças e Consumíveis Compatíveis</h6>
                        <small class="text-muted">Artigos do armazém validados para uso neste modelo.</small>
                    </div>
                    <a href="/gira/private/armazem.php" class="btn btn-sm btn-light border rounded-3 fw-bold text-secondary">
                        Ir para Armazém <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Ref. Artigo</th>
                                <th>Descrição da Peça</th>
                                <th>Stock Atual</th>
                                <th class="text-end">Ação Rápida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-mono text-secondary">#ART-P01</td>
                                <td class="fw-bold text-dark">Módulo SpO2 Descartável (Philips)</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">45 Unidades</span></td>
                                <td class="text-end"><button type="button" class="btn btn-light btn-sm border rounded-3 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#modalNovaEncomenda" style="font-size: 0.7rem;">Encomendar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 6: AUDITORIA (Logs Isolados da Máquina) -->
        <div class="tab-pane fade" id="auditoria" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold mb-4 text-dark">Registo de Auditoria do Ativo</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Data / Hora</th>
                                <th>Utilizador</th>
                                <th>Ação Registada no Sistema</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-mono text-secondary">20/11/2025 15:30</td>
                                <td><span class="fw-bold text-dark"><img src="https://i.pravatar.cc/150?u=helena" class="rounded-circle me-2 border" width="24" height="24">Eng. Maria Helena</span></td>
                                <td>Fechou a Ordem de Trabalho Corretiva <a href="#" class="text-decoration-none fw-bold">#OT-2025-412</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</form> <!-- /Fim do Formulário -->

<?php
// Fecha a página e puxa o modals.php automaticamente
render_footer();
?>