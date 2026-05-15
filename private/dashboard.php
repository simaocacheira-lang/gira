<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <title>Gira - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/1241251.css">
</head>

<body>

    <nav class="sidebar">
        <div class="sidebar-brand"><i class="fa-solid fa-square-plus me-2 text-primary"></i> Gira</div>
        <a href="#" class="sidebar-link active"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-stethoscope"></i> Equipamentos</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-location-dot"></i> Localizações</a>
    </nav>

    <!-- TUDO tem de estar dentro da main-wrapper!! -->
    <div class="main-wrapper">

<!-- Cabeçalho do Dashboard -->

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold m-0">Bom dia, Dr. Miguel! 👋</h2>
                <p class="text-muted m-0 small">Aqui está o panorama do inventário de equipamentos médicos.</p>
            </div>
            <div class="bg-white p-2 px-3 rounded-4 shadow-sm fw-bold small">
                <i class="fa-regular fa-calendar text-primary me-2"></i> 20 de maio, 2026
            </div>
        </div>

        <!-- KPIs Principais (1ª linha de cenas) -->

        <div class="row g-3">

            <div class="col-md-2">
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
            </div>

            <div class="col-md-2">
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
            </div>

            <div class="col-md-2">
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
            </div>

            <div class="col-md-2">
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
            </div>

            <div class="col-md-2">
                <div class="kpi-card border-start border-danger border-4">
                    <div class="icon-circle bg-danger-light"><i class="fa-solid fa-shield-heart"></i></div>
                    <div>
                        <p class="text-muted small-caps mb-0">Garantias</p>
                        <h3 class="text-danger">23</h3>
                        <small class="text-danger fw-bold">30 dias</small>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="kpi-card border-start border-primary border-4">
                    <div class="icon-circle bg-primary-light"><i class="fa-solid fa-file-circle-exclamation"></i></div>
                    <div>
                        <p class="text-muted small-caps mb-0">Docs</p>
                        <h3 class="text-primary">17</h3>
                        <small class="text-primary fw-bold">Ação necessária</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos e alertas (2º linha de cenas) -->

        <div class="row g-4 mt-2">

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">Equipamentos por Categoria</h6>
                        <a href="#" class="text-primary small text-decoration-none">Ver todas</a>
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
                        <a href="#" class="text-primary small text-decoration-none">Ver relatório</a>
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
    </div>
</body>

</html>