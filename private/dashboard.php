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
                        <tr>
                            <td>
                                <div class="fw-bold">Monitor Multiparamétrico</div>
                                <div class="text-muted" style="font-size: 0.65rem;">SN: MPS-2022-45873</div>
                            </td>
                            <td>Philips IntelliVue</td>
                            <td>UCI - Sala 2</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-bold">Bomba de Infusão</div>
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
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="fw-bold mb-4">Ações Rápidas</h6>
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="action-btn border rounded-3 p-3 h-100">
                        <i class="fa-solid fa-circle-plus text-primary fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Novo Equipamento</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="action-btn border rounded-3 p-3 h-100">
                        <i class="fa-solid fa-wrench text-success fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Nova Manutenção</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="action-btn border rounded-3 p-3 h-100">
                        <i class="fa-solid fa-file-arrow-up text-info fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Novo Documento</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="action-btn border rounded-3 p-3 h-100">
                        <i class="fa-solid fa-users text-warning fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Novo Fornecedor</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="action-btn border rounded-3 p-3 h-100">
                        <i class="fa-solid fa-chart-line text-purple fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Relatório Rápido</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="action-btn border rounded-3 p-3 h-100">
                        <i class="fa-solid fa-magnifying-glass text-secondary fs-4 mb-2"></i>
                        <p class="mb-0 fw-bold" style="font-size: 0.6rem;">Pesquisa Avançada</p>
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
                                <small class="text-muted style=" font-size: 0.7rem;">Sem mais tarefas agendadas</small>
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
<?php
// Função molde que fecha as tags HTML abertas e injeta os scripts do Modo Escuro e da Sidebar
render_footer();
?>