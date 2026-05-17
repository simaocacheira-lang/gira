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

    <!--Botão de toggle do sidebar -->

    <nav class="sidebar" id="sidebar">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="sidebar-brand mb-0">
                <i class="fa-solid fa-square-plus me-2 text-primary"></i>
                <span class="sidebar-text">Gira</span>
            </div>
            <button id="toggleSidebar" class="btn btn-link text-white p-0 shadow-none border-0">
                <i class="fa-solid fa-angles-left" id="toggleIcon"></i>
            </button>
        </div>

        <div class="small-caps text-secondary mb-2 opacity-50 sidebar-text">Dashboard</div>
        <a href="dashboard.php" class="sidebar-link active">
            <i class="fa-solid fa-house"></i>
            <span class="sidebar-text ms-2">Dashboard</span>
        </a>

        <div class="small-caps text-secondary mt-4 mb-2 opacity-50 sidebar-text">Gestão</div>
        <a href="equipamentos.php" class="sidebar-link">
            <i class="fa-solid fa-stethoscope"></i>
            <span class="sidebar-text ms-2">Equipamentos</span>
        </a>
        <a href="localizacoes.php" class="sidebar-link">
            <i class="fa-solid fa-location-dot"></i>
            <span class="sidebar-text ms-2">Localizações</span>
        </a>
        <a href="fornecedores.php" class="sidebar-link">
            <i class="fa-solid fa-truck-field"></i>
            <span class="sidebar-text ms-2">Fornecedores</span>
        </a>

        <div class="small-caps text-secondary mt-4 mb-2 opacity-50 sidebar-text">Configurações</div>
        <a href="backoffice_publico.php" class="sidebar-link">
            <i class="fa-solid fa-globe"></i>
            <span class="sidebar-text ms-2">Gerir Área Pública</span>
        </a>
    </nav>

    <!-- TUDO tem de estar dentro da main-wrapper!! -->
    <div class="main-wrapper">

        <!-- Search bar, notificações, perfil -->


        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm mb-4">

            <div class="flex-grow-1 me-4" style="max-width: 600px;">
                <div class="input-group bg-light rounded-3">
                    <span class="input-group-text border-0 bg-transparent text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" class="form-control border-0 bg-transparent small" placeholder="Pesquisar equipamento, número de série, modelo..." style="font-size: 0.85rem;">
                    <span class="input-group-text border-0 bg-transparent">
                        <kbd class="bg-white text-muted border shadow-sm px-2" style="font-size: 0.7rem;">⌘ K</kbd>
                    </span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light rounded-circle position-relative p-2" style="width: 40px; height: 40px;">
                    <i class="fa-regular fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        6
                    </span>
                </button>

                <button class="btn btn-light rounded-circle p-2" style="width: 40px; height: 40px;" id="themeToggle">
                    <i class="fa-regular fa-moon" id="themeIcon"></i>
                </button>

                <div class="vr mx-2 text-muted opacity-25" style="height: 30px;"></div>

                <div class="d-flex align-items-center cursor-pointer">
                    <div class="text-end me-3 d-none d-lg-block">
                        <p class="fw-bold mb-0 small lh-1">Dr. Miguel Santos</p>
                        <small class="text-muted" style="font-size: 0.65rem;">Administrador</small>
                    </div>
                    <img src="https://i.pravatar.cc/150?u=miguel" alt="Perfil" class="rounded-circle border" width="40" height="40">
                    <i class="fa-solid fa-chevron-down text-muted small ms-2"></i>
                </div>
            </div>
        </div>




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


        <!-- Tabelas e ações rápidas (3ª linha de cenas) -->

        <div class="row g-4 mt-3 mb-5">

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">Equipamentos Recentes</h6>
                        <a href="#" class="text-primary small text-decoration-none">Ver todos</a>
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
                        <a href="#" class="text-primary small text-decoration-none">Calendário</a>
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
                    <a href="#" class="btn btn-light btn-sm mt-auto rounded-pill text-primary fw-bold" style="font-size: 0.7rem;">Ver todas as manutenções</a>
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
    </div>

    <!-- JAVA SCRIPTS  -->

    <!-- Scrips do Toggle da Sidebar -->

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');

            // Guarda a preferência
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        // Ao carregar, verifica se estava colapsado
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            document.getElementById('sidebar').classList.add('collapsed');
        }
    </script>
    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement; // Alvo: tag <html>

        themeToggle.addEventListener('click', function() {
            if (htmlElement.getAttribute('data-bs-theme') === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'light');
                themeIcon.className = 'fa-regular fa-moon';
                localStorage.setItem('giraTheme', 'light');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                themeIcon.className = 'fa-solid fa-sun text-warning';
                localStorage.setItem('giraTheme', 'dark');
            }
        });

        // Mantém o estado quando mudas de página ou dás refresh
        if (localStorage.getItem('giraTheme') === 'dark') {
            htmlElement.setAttribute('data-bs-theme', 'dark');
            themeIcon.className = 'fa-solid fa-sun text-warning';
        }
    </script>

</body>

</html>