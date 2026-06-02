<?php
// PHP vai buscar as funções do ficheiro de molde.
// 'require_once'-> garante que o ficheiro é carregado apenas uma vez.
require_once 'layout.php';

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
        <a href="equipamentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card">
                <div class="icon-circle bg-primary-light"><i class="fa-solid fa-file-invoice"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Total</p>
                    <h3>1.532</h3>
                    <small class="text-primary fw-bold">↑ 8%</small>
                </div>
                <div class="sparkline-box">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%; height:100%;">
                        <path d="M0 25 Q 20 25, 40 10 T 80 15 T 100 5" fill="none" stroke="#0d6efd" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="equipamentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card">
                <div class="icon-circle bg-success-light"><i class="fa-solid fa-calendar-check"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Ativos</p>
                    <h3>1.328</h3>
                    <small class="text-success fw-bold">↑ 5%</small>
                </div>
                <div class="sparkline-box">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%; height:100%;">
                        <path d="M0 20 Q 30 5, 60 20 T 100 10" fill="none" stroke="#198754" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="manutencao.php" class="text-decoration-none text-dark">
            <div class="kpi-card">
                <div class="icon-circle bg-warning-light"><i class="fa-solid fa-wrench"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Reparação</p>
                    <h3>124</h3>
                    <small class="text-danger fw-bold">↓ 3%</small>
                </div>
                <div class="sparkline-box">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%; height:100%;">
                        <path d="M0 10 Q 50 30, 100 20" fill="none" stroke="#fd7e14" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="equipamentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card">
                <div class="icon-circle bg-gray-light"><i class="fa-solid fa-power-off"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Inativos</p>
                    <h3>80</h3>
                    <small class="text-secondary fw-bold">↘ 2%</small>
                </div>
                <div class="sparkline-box">
                    <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%; height:100%;">
                        <path d="M0 25 H 100" fill="none" stroke="#6c757d" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="garantias.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-danger border-4">
                <div class="icon-circle bg-danger-light"><i class="fa-solid fa-shield-heart"></i></div>
                <div>
                    <p class="text-muted small-caps mb-0">Garantias</p>
                    <h3 class="text-danger">23</h3>
                    <small class="text-danger fw-bold">30 dias</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-2">
        <a href="documentos.php" class="text-decoration-none text-dark">
            <div class="kpi-card border-start border-primary border-4">
                <div class="icon-circle bg-primary-light"><i class="fa-solid fa-file-circle-exclamation"></i></div>
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
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Equipamentos por Categoria</h6>
                <a href="equipamentos.php" class="text-primary small text-decoration-none">Ver todas</a>
            </div>
            <div class="d-flex align-items-center">
                <div class="donut-container me-4">
                    <div class="donut-main">
                        <div class="donut-center">
                            <span class="fw-bold d-block lh-1">1,532</span>
                            <small class="text-muted" style="font-size: 0.6rem;">Total</small>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <ul class="list-unstyled mb-0 small">
                        <li class="d-flex justify-content-between mb-2">
                            <span><i class="fa-solid fa-circle text-primary me-2" style="font-size: 0.5rem;"></i> Monitorização</span>
                            <span class="text-muted">28% <small>(429)</small></span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span><i class="fa-solid fa-circle text-info me-2" style="font-size: 0.5rem;"></i> Suporte Vida</span>
                            <span class="text-muted">24% <small>(368)</small></span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Outros</span>
                            <span class="text-muted">7% <small>(106)</small></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Distribuição por Criticidade</h6>
                <a href="relatorios.php" class="text-primary small text-decoration-none">Ver relatório</a>
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
                    </ul>
                </div>
            </div>
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 mt-auto">
                <p class="mb-0 text-primary fw-bold" style="font-size: 0.65rem;">
                    <i class="fa-solid fa-circle-info me-1"></i> 230 equipamentos requerem atenção prioritária.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Alertas Importantes</h6>
                <a href="#" class="text-primary small text-decoration-none">Ver todos</a>
            </div>
            <div class="vstack gap-2">
                <div class="d-flex align-items-center p-2 rounded-3 border border-light-subtle">
                    <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-3 me-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="small fw-bold mb-0">15 garantias expiram</p>
                        <p class="text-muted mb-0" style="font-size: 0.6rem;">Equipamentos críticos afetados</p>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill me-2" style="font-size: 0.55rem;">Crítico</span>
                    <i class="fa-solid fa-chevron-right text-muted small"></i>
                </div>
                <div class="d-flex align-items-center p-2 rounded-3 border border-light-subtle">
                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-3 me-3">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="small fw-bold mb-0">7 em manutenção</p>
                        <p class="text-muted mb-0" style="font-size: 0.6rem;">Aguardam intervenção</p>
                    </div>
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill me-2" style="font-size: 0.55rem;">Atenção</span>
                    <i class="fa-solid fa-chevron-right text-muted small"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-3 mb-5">

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Equipamentos Recentes</h6>
                <a href="equipamentos.php" class="text-primary small text-decoration-none">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                    <thead class="table-light">
                        <tr class="text-muted">
                            <th>Equipamento</th>
                            <th>Modelo</th>
                            <th>Localização</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-bs-toggle="modal" data-bs-target="#modalFichaEquipamento" style="cursor: pointer;">
                            <td>
                                <div class="fw-bold text-dark">Monitor Multiparamétrico</div>
                                <div class="text-muted" style="font-size: 0.65rem;">SN: MPS-2022-45873</div>
                            </td>
                            <td>Philips IntelliVue</td>
                            <td>UCI - Sala 2</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                        </tr>

                        <tr data-bs-toggle="modal" data-bs-target="#modalFichaEquipamento" style="cursor: pointer;">
                            <td>
                                <div class="fw-bold text-dark">Bomba de Infusão</div>
                                <div class="text-muted" style="font-size: 0.65rem;">SN: INF-2020-88321</div>
                            </td>
                            <td>B. Braun Space</td>
                            <td>Medicina - 3º Piso</td>
                            <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Manutenção</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Manutenções Agendadas</h6>
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalAgendaTurno" class="text-primary small text-decoration-none">Calendário</a>
            </div>
            <div class="vstack gap-3">
                <div class="d-flex align-items-center">
                    <div class="date-box bg-light rounded-3 text-center p-2 me-3" style="min-width: 50px;">
                        <div class="text-danger small fw-bold text-uppercase" style="font-size: 0.5rem;">Mai</div>
                        <div class="fw-bold fs-5 lh-1">21</div>
                    </div>
                    <div>
                        <p class="small fw-bold mb-0">Ventilador Pulmonar</p>
                        <p class="text-muted mb-0" style="font-size: 0.65rem;">Preventiva · 09:00</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="date-box bg-light rounded-3 text-center p-2 me-3" style="min-width: 50px;">
                        <div class="text-danger small fw-bold text-uppercase" style="font-size: 0.5rem;">Mai</div>
                        <div class="fw-bold fs-5 lh-1">22</div>
                    </div>
                    <div>
                        <p class="small fw-bold mb-0">Autoclave</p>
                        <p class="text-muted mb-0" style="font-size: 0.65rem;">Calibração · 10:30</p>
                    </div>
                </div>
            </div>
            <a href="manutencao.php" class="btn btn-light btn-sm mt-auto rounded-pill text-primary fw-bold" style="font-size: 0.7rem;">Ver todas as manutenções</a>
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
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="favPerf"><label class="form-check-label fw-medium" for="favPerf">Peris de Acesso</label></div>
                        </li>
                        <li class="my-1">
                            <div class="form-check"><input class="form-check-input" type="checkbox" checked id="favArm"><label class="form-check-label fw-medium" for="favArm">Armazém</label></div>
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
                    <div class="col-4 acao-item" id="btnAcaoArmazem" data-bs-toggle="modal" data-bs-target="#modalNovaEncomenda">
                        <div class="action-btn border rounded-3 p-3 h-100 cursor-pointer">
                            <i class="fa-solid fa-cart-plus text-primary fs-4 mb-2"></i>
                            <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Nova Encomenda</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgendaTurno" tabindex="-1" aria-labelledby="modalAgendaTurnoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <div>
                    <h5 class="modal-title fw-bold" id="modalAgendaTurnoLabel">
                        <i class="fa-solid fa-calendar-day text-primary me-2"></i>Agenda de Manutenções por Turno
                    </h5>
                    <small class="text-muted">Planeamento cirúrgico para o dia de hoje · 20 de maio, 2026</small>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light bg-opacity-50">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-primary rounded-pill px-2.5 py-1.5" style="font-size: 0.7rem;">Manhã</span>
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">08:00 - 13:00</small>
                        </div>
                        <div class="vstack gap-2">
                            <div class="bg-white p-3 rounded-3 border-start border-success border-3 shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="small fw-bold mb-0 text-dark">Ventilador Pulmonar</h6>
                                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.6rem;">09:00</span>
                                </div>
                                <p class="text-muted m-0" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-check text-success me-1"></i>Manutenção Preventiva Semestral</p>
                                <small class="text-secondary fw-mono" style="font-size: 0.65rem;">Urgências · Bloco Norte</small>
                            </div>
                            <div class="text-center p-3 rounded-3 border border-dashed opacity-50 bg-white" style="border-style: dashed !important;">
                                <small class="text-muted" style="font-size: 0.7rem;">Sem mais tarefas agendadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1.5" style="font-size: 0.7rem;">Tarde</span>
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">13:00 - 18:00</small>
                        </div>
                        <div class="vstack gap-2">
                            <div class="bg-white p-3 rounded-3 border-start border-warning border-3 shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="small fw-bold mb-0 text-dark">Autoclave Industrial</h6>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill" style="font-size: 0.6rem;">10:30</span>
                                </div>
                                <p class="text-muted m-0" style="font-size: 0.7rem;"><i class="fa-solid fa-clock text-warning me-1"></i>Calibração de Pressão / Sensores</p>
                                <small class="text-secondary fw-mono" style="font-size: 0.65rem;">Esterilização · Piso -1</small>
                            </div>
                            <div class="bg-white p-3 rounded-3 border-start border-danger border-3 shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="small fw-bold mb-0 text-dark">Ecógrafo Philips</h6>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill" style="font-size: 0.6rem;">16:00</span>
                                </div>
                                <p class="text-muted m-0" style="font-size: 0.7rem;"><i class="fa-solid fa-wrench text-danger me-1"></i>Intervenção Corretiva (Ecrã)</p>
                                <small class="text-secondary fw-mono" style="font-size: 0.65rem;">Obstetrícia · Consulta 3</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-secondary rounded-pill px-2.5 py-1.5" style="font-size: 0.7rem;">Noite / Banco</span>
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">18:00 - 08:00</small>
                        </div>
                        <div class="vstack gap-2">
                            <div class="bg-white p-3 rounded-3 border border-light shadow-sm text-center py-4 bg-light bg-opacity-25">
                                <div class="text-muted mb-2"><i class="fa-solid fa-moon text-secondary fs-4"></i></div>
                                <h6 class="small fw-bold mb-1 text-secondary">Prevenção e Piquete Técnico</h6>
                                <p class="text-muted m-0 px-2" style="font-size: 0.65rem;">Nenhuma preventiva planeada para o período noturno. Apenas intervenções de urgência via Banco Clínico.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Fechar Vista</button>
                <a href="manutencao.php" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-sliders me-2"></i>Gerir Ordens de Trabalho
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistarEquipamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-laptop-medical text-primary me-2"></i>Registar Novo Equipamento</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovoEquipamento" action="processar_equipamento.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Nome do Equipamento</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome" placeholder="Ex: Ventilador Pulmonar" required></div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Fabricante / Modelo</label><input type="text" class="form-control rounded-3 bg-light border-0" name="marca" placeholder="Ex: Dräger · Evita V500" required></div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Número de Série (SN)</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="sn" placeholder="Ex: DG-EV-99214" required></div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Classe de Risco</label>
                            <select class="form-select rounded-3 bg-light border-0" name="classe_risco" required>
                                <option value="Suporte de Vida">Classe III - Suporte de Vida</option>
                                <option value="Médio/Alto Risco">Classe IIb - Médio/Alto Risco</option>
                                <option value="Monitorização">Classe IIa - Monitorização</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Localização / Serviço</label>
                            <select class="form-select rounded-3 bg-light border-0" name="localizacao" required>
                                <option value="Urgências · Sala de Reanimação">Urgências · Sala de Reanimação</option>
                                <option value="UCI · Quarto 04 (Isolamento)">UCI · Quarto 04 (Isolamento)</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Próxima Revisão</label><input type="date" class="form-control rounded-3 bg-light border-0 text-secondary" name="proxima_revisao" required></div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Estado Operacional Inicial</label>
                            <select class="form-select rounded-3 bg-light border-0" name="estado_operacional" required>
                                <option value="Operacional" selected>Operacional (Pronto para Uso Clínico)</option>
                                <option value="Aguardar Calibração">Aguardar Calibração</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoEquipamento" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-plus me-2"></i>Registar Ativo</button>
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
                <form id="formNovaOT" action="processar_manutencao.php" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Dispositivo Médico com Ocorrência</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-mono" name="equipamento_id" required>
                                <option value="#EQ-2026-001">#EQ-2026-001 - Dräger Evita V500 (Urgências)</option>
                                <option value="#EQ-2026-002">#EQ-2026-002 - Philips Affiniti 70 (Obstetrícia)</option>
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
                        <div class="col-12"><label class="form-label small fw-bold text-secondary">Sintomas / Descrição Ocorrência</label><textarea class="form-control rounded-3 bg-light border-0" name="descricao_avaria" rows="4" placeholder="Descreva os sintomas apresentados pelo dispositivo..." required></textarea></div>
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

<div class="modal fade" id="modalNovoDocumento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-import text-primary me-2"></i>Upload de Documento Técnico</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovoDocumento" action="processar_documento.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3"><label class="form-label small fw-bold text-secondary">Nome do Documento</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome_doc" placeholder="Ex: Certificado de Calibração Anual 2026" required></div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Tipo</label>
                        <select class="form-select rounded-3 bg-light border-0" name="tipo_doc" required>
                            <option value="Manual Técnico">Manual Técnico / Serviço</option>
                            <option value="Metrologia / Calibração">Metrologia / Calibração</option>
                            <option value="Financeiro / Fatura">Financeiro / Fatura</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Dispositivo Associado</label>
                        <select class="form-select rounded-3 bg-light border-0 fw-mono" name="equipamento_doc">
                            <option value="Nenhum">Nenhum (Documento Geral)</option>
                            <option value="#EQ-2026-001">#EQ-2026-001 - Dräger Evita V500</option>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label small fw-bold text-secondary">Ficheiro (PDF, PNG, JPG)</label><input class="form-control rounded-3" type="file" name="ficheiro_doc" required></div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoDocumento" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-upload me-2"></i>Submeter</button>
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
                <form id="formNovoFornecedor" action="processar_fornecedor.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-7"><label class="form-label small fw-bold text-secondary">Nome da Empresa</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome_empresa" placeholder="Siemens Healthcare Lda." required></div>
                        <div class="col-md-5"><label class="form-label small fw-bold text-secondary">NIF</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="nif" placeholder="501234567" maxlength="9" required></div>
                        <div class="col-md-5"><label class="form-label small fw-bold text-secondary">Contacto Telefónico</label><input type="text" class="form-control rounded-3 bg-light border-0" name="contacto" placeholder="210 000 000" required></div>
                        <div class="col-md-7"><label class="form-label small fw-bold text-secondary">E-mail Oficial Suporte</label><input type="email" class="form-control rounded-3 bg-light border-0" name="email" placeholder="suporte.pt@siemens.com" required></div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Especialidade Biomédica</label>
                            <select class="form-select rounded-3 bg-light border-0" name="representacao" required>
                                <option value="Monitores e Imagiologia">Monitores e Imagiologia Médica</option>
                                <option value="Ventilação e Anestesia">Ventilação e Anestesia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Estado Contrato</label>
                            <select class="form-select rounded-3 bg-light border-0" name="estado_contrato" required>
                                <option value="Ativo" selected>Ativo</option>
                                <option value="Expirado">Expirado</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoFornecedor" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarGarantia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-shield text-primary me-2"></i>Adicionar Contrato / Cobertura</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovaGarantia" action="processar_garantia.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Referência Contrato</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono text-uppercase" name="id_contrato" placeholder="Ex: #CTR-2026-088" required></div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Tipo Cobertura</label>
                            <select class="form-select rounded-3 bg-light border-0" name="tipo_cobertura" required>
                                <option value="Garantia de Fábrica">Garantia de Fábrica</option>
                                <option value="Manutenção Total (SLA)">Manutenção Total (SLA)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Dispositivo Médico Coberto</label>
                            <select class="form-select rounded-3 bg-light border-0 fw-mono" name="equipamento_id" required>
                                <option value="#EQ-2026-001">#EQ-2026-001 - Dräger Evita V500</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Fornecedor Responsável</label>
                            <select class="form-select rounded-3 bg-light border-0" name="fornecedor" required>
                                <option value="Dräger Portugal Lda.">Dräger Portugal Lda.</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Fim Validade</label><input type="date" class="form-control rounded-3 bg-light border-0 text-secondary" name="fim_validade" required></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaGarantia" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Ativar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovaLocalizacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-location-dot text-primary me-2"></i>Mapear Nova Localização</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovaLocalizacao" action="processar_localizacao.php" method="POST">
                    <div class="mb-3"><label class="form-label small fw-bold text-secondary">Código Sala</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono text-uppercase" name="cod_sala" placeholder="Ex: #LOC-UCI03" required></div>
                    <div class="mb-3"><label class="form-label small fw-bold text-secondary">Nome Serviço / Sala</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome" placeholder="Ex: Unidade Cuidados Intensivos" required></div>
                    <div class="mb-3"><label class="form-label small fw-bold text-secondary">Sublocalização / Camas</label><input type="text" class="form-control rounded-3 bg-light border-0" name="detalhe" placeholder="Ex: Sala 3 · Camas 9 a 12"></div>
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
                                <option value="Bloco Central">Bloco Central</option>
                                <option value="Bloco Cirúrgico">Bloco Cirúrgico</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaLocalizacao" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-location-dot me-2"></i>Mapear</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCriarUtilizador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus text-primary me-2"></i>Registar Novo Utilizador</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovoUtilizador" action="processar_utilizador.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-7"><label class="form-label small fw-bold text-secondary">Nome Completo</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome" placeholder="Ex: Eng. Maria Helena Barbosa" required></div>
                        <div class="col-md-5"><label class="form-label small fw-bold text-secondary">Serviço / Departamento</label><input type="text" class="form-control rounded-3 bg-light border-0" name="servico" placeholder="Ex: Engenharia Clínica" required></div>
                        <div class="col-md-7"><label class="form-label small fw-bold text-secondary">E-mail Institucional</label><input type="email" class="form-control rounded-3 bg-light border-0 fw-mono" name="email" placeholder="mhelena.barbosa@gira.hosp" required></div>
                        <div class="col-md-5"><label class="form-label small fw-bold text-secondary">Cédula / Nº Mecanográfico</label><input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" name="cedula" placeholder="Ex: EB-44122" required></div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Perfil de Acesso</label>
                            <select class="form-select rounded-3 bg-light border-0" name="perfil_id" required>
                                <option value="Administrador">Administrador</option>
                                <option value="Eng. Biomédico" selected>Eng. Biomédico</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label small fw-bold text-secondary">Senha Provisória</label><input type="password" class="form-control rounded-3 bg-light border-0" name="password" placeholder="••••••••" required></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoUtilizador" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-user-plus me-2"></i>Criar Conta</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-users-gear text-primary me-2"></i>Criar Perfil de Acesso</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formNovoPerfil" action="processar_perfil.php" method="POST">
                    <div class="mb-3"><label class="form-label small fw-bold text-secondary">Nome do Perfil</label><input type="text" class="form-control rounded-3 bg-light border-0" name="nome_perfil" placeholder="Ex: Técnico Externo" required></div>
                    <div class="mb-3"><label class="form-label small fw-bold text-secondary">Descrição das Responsabilidades</label><textarea class="form-control rounded-3 bg-light border-0" name="descricao" rows="2" placeholder="Responsabilidades do grupo..." required></textarea></div>
                    <div class="bg-light rounded-3 p-3">
                        <div class="form-check mb-2"><input class="form-check-input" type="checkbox" checked id="chkInv"><label class="form-check-label small fw-medium text-secondary" for="chkInv">Inventário e Localizações</label></div>
                        <div class="form-check mb-0"><input class="form-check-input" type="checkbox" checked id="chkMan"><label class="form-check-label small fw-medium text-secondary" for="chkMan">Ordens de Trabalho</label></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoPerfil" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar Perfil</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFichaEquipamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-light">

            <div class="modal-header border-bottom border-light p-4 bg-white rounded-top-4">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill border border-primary-subtle px-2">#EQ-2026-001</span>
                        <span class="badge bg-success rounded-pill px-2"><i class="fa-solid fa-check me-1"></i> Operacional</span>
                    </div>
                    <h4 class="modal-title fw-bold text-dark mb-0">Monitor Multiparamétrico - Philips IntelliVue</h4>
                    <small class="text-muted fw-mono">SN: MPS-2022-45873 · Adquirido em: 15/01/2022</small>
                </div>
                <button type="button" class="btn-close shadow-none mb-auto" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="bg-white p-4 rounded-4 shadow-sm h-100 border border-light-subtle">
                            <h6 class="fw-bold mb-4 border-bottom pb-2"><i class="fa-solid fa-info-circle text-primary me-2"></i>Informação Geral</h6>

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block fw-bold" style="font-size: 0.65rem;">CATEGORIA / CLASSE</small>
                                    <span class="fw-medium text-dark">Suporte de Vida (Classe III)</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block fw-bold" style="font-size: 0.65rem;">LOCALIZAÇÃO ATUAL</small>
                                    <span class="fw-medium text-dark">UCI - Sala 2</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block fw-bold" style="font-size: 0.65rem;">FORNECEDOR OFICIAL</small>
                                    <span class="fw-medium text-dark">Philips Healthcare Portugal</span>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block fw-bold" style="font-size: 0.65rem;">COBERTURA TÉCNICA</small>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle text-dark">Garantia Expira em 30 Dias</span>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3 border-bottom pb-2 pt-2"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Últimas Intervenções</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="fa-solid fa-wrench text-secondary me-2"></i> <strong class="text-dark">12/03/2026:</strong> Substituição do módulo de SpO2 (Corretiva)</li>
                                <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i> <strong class="text-dark">10/01/2026:</strong> Calibração anual dos sensores (Preventiva)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="bg-white p-4 rounded-4 shadow-sm h-100 border border-light-subtle">
                            <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                                <div>
                                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-chart-line text-danger me-2"></i>Análise TCO</h6>
                                    <p class="text-muted small m-0" style="font-size: 0.65rem;">Custo de Aquisição vs Manutenção</p>
                                </div>
                                <span class="badge bg-danger text-white rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Risco
                                </span>
                            </div>

                            <div class="row g-2 mb-4 text-center">
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded-3 border">
                                        <small class="text-secondary fw-bold text-uppercase d-block mb-1" style="font-size: 0.6rem;">Aquisição</small>
                                        <h5 class="fw-bold text-dark m-0">24.500 €</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-danger bg-opacity-10 rounded-3 border border-danger-subtle">
                                        <small class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.6rem;">Gastos</small>
                                        <h5 class="fw-bold text-danger m-0">26.150 €</h5>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between text-muted fw-bold mb-1" style="font-size: 0.7rem;">
                                    <span>Rentabilidade</span>
                                    <span class="text-danger">106% do valor original</span>
                                </div>
                                <div class="progress rounded-pill mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: 100%;"></div>
                                </div>
                                <p class="text-muted lh-sm m-0" style="font-size: 0.7rem;">
                                    O custo acumulado de reparações já superou o valor de compra. Recomenda-se avançar com o plano de abate para este dispositivo.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-top border-light p-3 bg-white rounded-bottom-4">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Fechar Ficha</button>
                <a href="equipamentos.php" class="btn btn-primary rounded-3 fw-bold small px-4">Ir para Edição Completa <i class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>

        </div>
    </div>
</div>
<!-- MODAL: NOVA ENCOMENDA (Reutilizado do armazem.php) -->
<div class="modal fade" id="modalNovaEncomenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-cart-plus text-primary me-2"></i>Nova Encomenda</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="processar_encomenda.php" method="POST">
                    <div class="mb-3"><label class="form-label small fw-bold">Artigo</label><select class="form-select bg-light border-0" name="artigo_id">
                            <option>Módulo SpO2 - Philips</option>
                            <option>Bateria 12V - Dräger</option>
                        </select></div>
                    <div class="mb-3"><label class="form-label small fw-bold">Quantidade</label><input type="number" class="form-control bg-light border-0" name="quantidade" value="1"></div>
                </form>
            </div>
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4">Confirmar Pedido</button>
            </div>
        </div>
    </div>
</div>
<?php
// Função molde que fecha as tags HTML abertas e injeta os scripts do Modo Escuro e da Sidebar
render_footer();
?>