<?php
// PHP vai buscar as funções do ficheiro de molde.
// 'require_once'-> garante que o ficheiro é carregado apenas uma vez.
require_once __DIR__ . '/layout.php';

// Função molde que desenha o topo (HTML base, Sidebar e Topbar).
// Passamos o texto "Gira - Dashboard Geral" para ser o título na aba do navegador.
render_header("Gira - Dashboard Geral");
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold m-0">Bom dia, Dr. Miguel! 👋</h2>
        <p class="text-muted m-0 small">Aqui está o panorama do inventário de equipamentos médicos.</p>
    </div>
    <div class="bg-white p-2 px-3 rounded-4 shadow-sm fw-bold small">
        <i class="fa-regular fa-calendar text-primary me-2"></i> 20 de maio, 2026
    </div>
</div>

<div class="row g-3">

    <div class="col-md-2">
        <a href="/gira/private/relatorios.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-danger border-4">
                <div class="icon-circle bg-danger-light"><i class="fa-solid fa-euro-sign text-danger"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Custos (Mês)</p>
                    <h3 class="text-dark">4.250 €</h3>
                    <small class="text-danger fw-bold">↑ 12% vs abr</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="/gira/private/equipamentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-success border-4">
                <div class="icon-circle bg-success-light"><i class="fa-solid fa-calendar-check text-success"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Ativos</p>
                    <h3>1.328</h3>
                    <small class="text-success fw-bold">Operacionais</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="/gira/private/manutencao.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-warning border-4">
                <div class="icon-circle bg-warning-light"><i class="fa-solid fa-wrench text-warning"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Reparação</p>
                    <h3>124</h3>
                    <small class="text-warning fw-bold text-dark">Em intervenção</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="/gira/private/equipamentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-secondary border-4">
                <div class="icon-circle bg-gray-light"><i class="fa-solid fa-power-off text-secondary"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Inativos</p>
                    <h3>80</h3>
                    <small class="text-secondary fw-bold">Abate / Parados</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="/gira/private/garantias.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-danger border-4">
                <div class="icon-circle bg-danger-light"><i class="fa-solid fa-shield-heart text-danger"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Garantias</p>
                    <h3 class="text-danger">23</h3>
                    <small class="text-danger fw-bold">A expirar (< 30d)</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="/gira/private/documentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-primary border-4">
                <div class="icon-circle bg-primary-light"><i class="fa-solid fa-file-circle-exclamation text-primary"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Docs</p>
                    <h3 class="text-primary">17</h3>
                    <small class="text-primary fw-bold">Ação necessária</small>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4 mt-2">

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Rácio de Intervenções</h6>
                <a href="/gira/private/manutencao.php" class="text-primary small text-decoration-none">Análise Mês</a>
            </div>

            <div class="mb-4 mt-2">
                <div class="d-flex justify-content-between align-items-end mb-1">
                    <div>
                        <i class="fa-solid fa-shield-halved text-success me-1"></i>
                        <span class="fw-bold small text-dark">Preventivas (Planeadas)</span>
                    </div>
                    <span class="h5 fw-black text-success mb-0">68%</span>
                </div>
                <div class="progress rounded-pill bg-light border" style="height: 10px;">
                    <div class="progress-bar bg-success rounded-pill" style="width: 68%;"></div>
                </div>
                <small class="text-muted fw-bold" style="font-size: 0.65rem;">Meta ideal: > 80%</small>
            </div>

            <div class="mb-auto">
                <div class="d-flex justify-content-between align-items-end mb-1">
                    <div>
                        <i class="fa-solid fa-wrench text-danger me-1"></i>
                        <span class="fw-bold small text-dark">Corretivas (Avarias)</span>
                    </div>
                    <span class="h5 fw-black text-danger mb-0">32%</span>
                </div>
                <div class="progress rounded-pill bg-light border" style="height: 10px;">
                    <div class="progress-bar bg-danger rounded-pill" style="width: 32%;"></div>
                </div>
                <small class="text-muted fw-bold" style="font-size: 0.65rem;">Impacto financeiro: Elevado</small>
            </div>

            <div class="bg-light p-2.5 rounded-3 mt-4 mb-0 border border-light-subtle">
                <p class="mb-0 text-secondary" style="font-size: 0.65rem; line-height: 1.3;">
                    <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                    <strong>Alerta:</strong> As reparações corretivas aumentaram 5% face ao mês homólogo.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Distribuição por Criticidade</h6>
                <a href="/gira/private/relatorios.php" class="text-primary small text-decoration-none">Ver relatório</a>
            </div>
            <div class="d-flex align-items-center mb-3">
                <div class="donut-container me-4">
                    <div class="donut-critic">
                        <div class="donut-center">
                            <i class="fa-solid fa-shield-plus text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <ul class="list-unstyled mb-0 small">
                        <li class="d-flex justify-content-between mb-2">
                            <span><i class="fa-solid fa-circle text-danger me-2" style="font-size: 0.5rem;"></i> Suporte Vida</span>
                            <span class="fw-bold">15%</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span><i class="fa-solid fa-circle text-warning me-2" style="font-size: 0.5rem;"></i> Alta</span>
                            <span class="fw-bold">31%</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span><i class="fa-solid fa-circle text-success me-2" style="font-size: 0.5rem;"></i> Normal</span>
                            <span class="fw-bold">54%</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 mt-auto border border-primary-subtle">
                <p class="mb-0 text-primary fw-bold" style="font-size: 0.65rem;">
                    <i class="fa-solid fa-circle-info me-1"></i> 230 equipamentos críticos requerem prioridade máxima nas manutenções.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0">Disponibilidade (Uptime)</h6>
                    <small class="text-muted" style="font-size: 0.65rem;">Rácio operacional ativo.</small>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill fw-bold" style="font-size: 0.6rem;">
                    <i class="fa-solid fa-arrow-trend-up me-1"></i> +0.4% em maio
                </span>
            </div>

            <div class="my-auto text-center py-2">
                <h1 class="fw-black text-dark m-0 display-5" style="letter-spacing: -1px;">96.8%</h1>
                <p class="text-muted mb-3" style="font-size: 0.7rem;">Meta Institucional: <strong>95.0%</strong></p>

                <div class="progress rounded-pill bg-light border shadow-sm mx-auto" style="height: 10px; max-width: 85%;">
                    <div class="progress-bar bg-success rounded-pill progress-bar-striped progress-bar-animated" role="progressbar" style="width: 96.8%;" aria-valuenow="96.8" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="pt-3 border-top border-light mt-auto">
                <div class="row g-2 text-center">
                    <div class="col-6 border-end border-light">
                        <small class="text-muted d-block mb-1" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.3px;">MTBF GLOBAL</small>
                        <span class="fw-bold text-dark h6 m-0">184 Dias</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.3px;">MTTR MÉDIO</small>
                        <span class="fw-bold text-primary h6 m-0">12.4 Horas</span>
                    </div>
                </div>
            </div>

            <div class="bg-danger bg-opacity-10 p-2 rounded-3 mt-3 mb-0 border border-danger-subtle text-center">
                <p class="mb-0 text-danger fw-bold" style="font-size: 0.62rem;">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Critério Crítico: 15 garantias expiram nos próximos 30 dias.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-3 mb-5">

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h6 class="fw-bold mb-0">Distribuição por Localização</h6>
                    <small class="text-muted" style="font-size: 0.65rem;">Carga física e criticidade de manutenção por serviço.</small>
                </div>
                <a href="/gira/private/localizacoes.php" class="text-primary small text-decoration-none fw-bold">Ver todas</a>
            </div>

            <div class="vstack gap-4">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="fw-bold text-dark small">Unidade de Cuidados Intensivos (UCI)</span>
                            <span class="text-muted fw-mono ms-1" style="font-size: 0.65rem;">#LOC-UCI02</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-secondary fw-bold" style="font-size: 0.75rem;">14 eq.</span>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill" style="font-size: 0.55rem;">Normal</span>
                        </div>
                    </div>
                    <div class="progress rounded-pill bg-light border-0 shadow-none" style="height: 6px;">
                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="fw-bold text-dark small">Bloco Operatório (BO3)</span>
                            <span class="text-muted fw-mono ms-1" style="font-size: 0.65rem;">#LOC-BO03</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-secondary fw-bold" style="font-size: 0.75rem;">22 eq.</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-pill" style="font-size: 0.55rem;"><i class="fa-solid fa-triangle-exclamation me-1"></i>1 Crítico</span>
                        </div>
                    </div>
                    <div class="progress rounded-pill bg-light border-0 shadow-none" style="height: 6px;">
                        <div class="progress-bar bg-danger rounded-pill" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <span class="fw-bold text-dark small">Serviço de Urgência Hospitalar</span>
                            <span class="text-muted fw-mono ms-1" style="font-size: 0.65rem;">#LOC-URG01</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-secondary fw-bold" style="font-size: 0.75rem;">9 eq.</span>
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle text-dark rounded-pill" style="font-size: 0.55rem;">1 Manutenção</span>
                        </div>
                    </div>
                    <div class="progress rounded-pill bg-light border-0 shadow-none" style="height: 6px;">
                        <div class="progress-bar bg-warning rounded-pill" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <div class="bg-light p-2.5 rounded-3 mt-4 mb-0 border border-light-subtle">
                <p class="mb-0 text-secondary" style="font-size: 0.65rem; line-height: 1.3;">
                    <i class="fa-solid fa-circle-nodes text-primary me-1"></i>
                    <strong>Logística Clínica:</strong> O Bloco Operatório concentra atualmente <strong>75%</strong> da capacidade máxima alocada de dispositivos de suporte de vida.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Cumprimento SLA</h6>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill" style="font-size: 0.6rem;">Semestre 1</span>
            </div>

            <div class="text-center my-auto pt-2">
                <div class="position-relative d-inline-block mb-3">
                    <svg width="130" height="130" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#f8f9fa" stroke-width="12"></circle>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#0d6efd" stroke-width="12" stroke-dasharray="339.29" stroke-dashoffset="54.28" stroke-linecap="round" transform="rotate(-90 60 60)"></circle>
                    </svg>
                    <div class="position-absolute top-50 start-50 translate-middle text-center mt-1">
                        <h2 class="fw-black text-dark m-0">84%</h2>
                    </div>
                </div>

                <p class="fw-bold small text-dark mb-1">Preventivas Concluídas</p>
                <p class="text-muted m-0 mx-2" style="font-size: 0.7rem; line-height: 1.2;">342 de 410 equipamentos aferidos até ao momento.</p>
            </div>

            <a href="/gira/private/manutencao.php" class="btn btn-light border border-light-subtle w-100 mt-4 rounded-pill fw-bold text-primary shadow-sm text-decoration-none" style="font-size: 0.75rem;">
                Plano Mensal (68 OTs em falta)
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 position-relative">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Ações Rápidas</h6>

                <div class="dropdown">
                    <button class="btn btn-link text-muted p-0 border-0 shadow-none" type="button" id="dropdownPersonalizarAcoes" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical fs-5 cursor-pointer text-secondary"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 p-3" aria-labelledby="dropdownPersonalizarAcoes" style="min-width: 280px; font-size: 0.8rem;">
                        <li class="dropdown-header px-1 pb-2 fw-bold text-dark border-bottom mb-2"><i class="fa-solid fa-sliders me-1 text-primary"></i> Personalizar Atalhos (Máx. 6)</li>

                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favEq"><label class="form-check-label fw-medium" for="favEq">Equipamentos</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favMan"><label class="form-check-label fw-medium" for="favMan">Manutenção</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favDoc"><label class="form-check-label fw-medium" for="favDoc">Documentos</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favForn"><label class="form-check-label fw-medium" for="favForn">Fornecedores</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favGar"><label class="form-check-label fw-medium" for="favGar">Garantias e Contratos</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favLoc"><label class="form-check-label fw-medium" for="favLoc">Localizações</label></div>
                        </li>

                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="favRel"><label class="form-check-label fw-medium" for="favRel">Relatórios</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="favUtil"><label class="form-check-label fw-medium" for="favUtil">Utilizadores</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="favPerf"><label class="form-check-label fw-medium" for="favPerf">Perfis de Acesso</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="favArm"><label class="form-check-label fw-medium" for="favArm">Armazém</label></div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row g-2 text-center">

                <div class="col-4 acao-item" id="btnAcaoEquipamentos" data-bs-toggle="modal" data-bs-target="#modalRegistarEquipamento">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-circle-plus text-primary fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Registar Equipamento</p>
                    </div>
                </div>
                <div class="col-4 acao-item" id="btnAcaoManutencao" data-bs-toggle="modal" data-bs-target="#modalAbrirOT">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-wrench text-success fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Abrir Ordem Trabalho</p>
                    </div>
                </div>
                <div class="col-4 acao-item" id="btnAcaoDocumentos" data-bs-toggle="modal" data-bs-target="#modalNovoDocumento">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-file-arrow-up text-info fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Enviar Documento</p>
                    </div>
                </div>
                <div class="col-4 acao-item" id="btnAcaoFornecedores" data-bs-toggle="modal" data-bs-target="#modalRegistarFornecedor">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-truck text-warning fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Registar Fornecedor</p>
                    </div>
                </div>
                <div class="col-4 acao-item" id="btnAcaoGarantias" data-bs-toggle="modal" data-bs-target="#modalAdicionarGarantia">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-file-shield text-danger fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Adicionar Contrato</p>
                    </div>
                </div>
                <div class="col-4 acao-item" id="btnAcaoLocalizacoes" data-bs-toggle="modal" data-bs-target="#modalNovaLocalizacao">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-location-dot text-secondary fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Nova Localização</p>
                    </div>
                </div>

                <div class="col-4 acao-item d-none" id="btnAcaoRelatorios">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-chart-pie text-purple fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Exportar Dados Global</p>
                    </div>
                </div>
                <div class="col-4 acao-item d-none" id="btnAcaoUtilizadores" data-bs-toggle="modal" data-bs-target="#modalCriarUtilizador">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-user-plus text-dark fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Criar Utilizador</p>
                    </div>
                </div>
                <div class="col-4 acao-item d-none" id="btnAcaoPerfis" data-bs-toggle="modal" data-bs-target="#modalAdicionarPerfil">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-users-gear text-muted fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Adicionar Perfil</p>
                    </div>
                </div>
                <div class="col-4 acao-item d-none" id="btnAcaoArmazem" data-bs-toggle="modal" data-bs-target="#modalNovaEncomenda">
                    <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                        <i class="fa-solid fa-cart-plus text-primary fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Nova Encomenda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Função molde que fecha as tags HTML abertas e injeta os scripts do Modo Escuro e da Sidebar
render_footer();
?>