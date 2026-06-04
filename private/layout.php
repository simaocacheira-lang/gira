<?php

/**
 * FUNÇÃO 1: render_header
 * Esta função vai desenhar o início do site, importar os estilos,
 * e montar a Sidebar e a Topbar automaticamente.
 * * O ($title) permite que cada página escolha o seu próprio título na aba do browser.
 */
function render_header($title = "Gira - Sistema de Gestão Hospitalar")
{
?>
    <!DOCTYPE html>
    <html lang="pt-pt">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <link rel="stylesheet" href="../assets/css/1241251.css">
    </head>

    <body>

        <nav class="sidebar" id="sidebar">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-square-plus text-primary fs-2 m-0 padding-0 lh-1 align-middle"></i>
                    <div class="sidebar-text d-flex flex-column justify-content-center">
                        <div class="fw-bold text-white lh-1" style="font-size: 1.4rem; letter-spacing: 0.3px;">Gira</div>
                    </div>
                </div>
                <button id="toggleSidebar" class="btn btn-link text-white p-0 shadow-none border-0">
                    <i class="fa-solid fa-angles-left" id="toggleIcon"></i>
                </button>
            </div>

            <a href="dashboard.php" class="sidebar-link">
                <i class="fa-solid fa-house"></i>
                <span class="sidebar-text ms-2">Dashboard</span>
            </a>

            <div class="small-caps text-secondary mt-3 mb-2 opacity-50 sidebar-text">Gestão</div>
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
            <a href="documentos.php" class="sidebar-link">
                <i class="fa-regular fa-file-lines"></i>
                <span class="sidebar-text ms-2">Documentos</span>
            </a>
            <a href="garantias.php" class="sidebar-link">
                <i class="fa-solid fa-shield-halved"></i>
                <span class="sidebar-text ms-2" style="font-size: 0.85rem;">Garantias e Contratos</span>
            </a>
            <a href="manutencao.php" class="sidebar-link">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <span class="sidebar-text ms-2">Manutenção</span>
            </a>
            <a href="armazem.php" class="sidebar-link">
                <i class="fa-solid fa-warehouse"></i>
                <span class="sidebar-text ms-2">Armazém</span>
            </a>
            <a href="relatorios.php" class="sidebar-link">
                <i class="fa-solid fa-chart-simple"></i>
                <span class="sidebar-text ms-2">Relatórios</span>
            </a>
            <a href="historico.php" class="sidebar-link">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="sidebar-text ms-2">Histórico</span>
            </a>
            </nav>

        <div class="main-wrapper">

            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm mb-4 sticky-top" style="top: 20px; z-index: 990;">
                
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold m-0 text-secondary opacity-75 sidebar-text"><i class="fa-solid fa-laptop-medical me-2 text-primary"></i>Painel Técnico</h5>
                </div>

                <div class="d-flex align-items-center gap-3">
                    
                    <div class="dropdown">
                        <button class="btn btn-light rounded-circle position-relative p-2 shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;" title="Notificações do Sistema">
                            <i class="fa-regular fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.6rem;">3</span>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 p-0 overflow-hidden" style="width: 340px;">
                            <li class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark m-0">Notificações</span>
                                <span class="badge bg-primary rounded-pill small">3 Novas</span>
                            </li>
                            
                            <li>
                                <a class="dropdown-item py-3 border-bottom d-flex align-items-start gap-3 text-wrap" href="manutencao.php">
                                    <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-circle flex-shrink-0 mt-1">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold small text-dark lh-sm">Nova O.T. Crítica</p>
                                        <p class="mb-1 text-muted" style="font-size: 0.75rem;">Ventilador Evita V500 reportou falha de pressão.</p>
                                        <small class="text-secondary fw-bold" style="font-size: 0.65rem;"><i class="fa-regular fa-clock me-1"></i>Há 10 min</small>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a class="dropdown-item py-3 border-bottom d-flex align-items-start gap-3 text-wrap" href="garantias.php">
                                    <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle flex-shrink-0 mt-1">
                                        <i class="fa-solid fa-file-shield"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold small text-dark lh-sm">Garantia a Expirar</p>
                                        <p class="mb-1 text-muted" style="font-size: 0.75rem;">O contrato SLA com a B. Braun termina em 5 dias.</p>
                                        <small class="text-secondary fw-bold" style="font-size: 0.65rem;"><i class="fa-regular fa-clock me-1"></i>Hoje, 09:00</small>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item py-3 border-bottom d-flex align-items-start gap-3 text-wrap" href="armazem.php">
                                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle flex-shrink-0 mt-1">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 fw-bold small text-dark lh-sm">Material Rececionado</p>
                                        <p class="mb-1 text-muted" style="font-size: 0.75rem;">Encomenda (#ENC-04) deu entrada no armazém.</p>
                                        <small class="text-secondary fw-bold" style="font-size: 0.65rem;"><i class="fa-regular fa-clock me-1"></i>Ontem</small>
                                    </div>
                                </a>
                            </li>
                            
                            <li class="p-2 text-center bg-light">
                                <a href="#" class="text-decoration-none small fw-bold text-primary d-block py-1">Ver todo o histórico</a>
                            </li>
                        </ul>
                    </div>
                    
                    <button class="btn btn-light rounded-circle p-2 shadow-none" style="width: 40px; height: 40px;" id="themeToggle" title="Modo Noturno">
                        <i class="fa-regular fa-moon" id="themeIcon"></i>
                    </button>

                    <div class="vr mx-1 text-muted opacity-25" style="height: 30px;"></div>

                    <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPerfil" aria-controls="offcanvasPerfil" title="Abrir Perfil e Administração">
                        <div class="text-end me-3 d-none d-lg-block">
                            <p class="fw-bold mb-0 small lh-1 text-dark">Dr. Miguel Santos</p>
                            <small class="text-muted" style="font-size: 0.65rem;">Administrador</small>
                        </div>
                        <img src="https://i.pravatar.cc/150?u=miguel" alt="Perfil" class="rounded-circle border border-2 border-white shadow-sm hover-primary" width="40" height="40" style="transition: transform 0.2s;">
                    </div>

                </div>
            </div>

            <div class="offcanvas offcanvas-end border-0 shadow" tabindex="-1" id="offcanvasPerfil" aria-labelledby="offcanvasPerfilLabel">
                <div class="offcanvas-header bg-light border-bottom p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://i.pravatar.cc/150?u=miguel" alt="Perfil" class="rounded-circle border border-3 border-white shadow-sm" width="60" height="60">
                        <div>
                            <h5 class="fw-bold m-0 text-dark" id="offcanvasPerfilLabel">Dr. Miguel Santos</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 mt-1">Administrador</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none mb-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                
                <div class="offcanvas-body p-4 d-flex flex-column">
                    
                    <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 0.7rem; letter-spacing: 0.5px;">A Minha Conta</h6>
                    <div class="list-group list-group-flush mb-4">
                        <a href="configuracoes.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary">
                            <i class="fa-solid fa-gear text-muted w-20px me-3 text-center"></i> Definições do Sistema
                        </a>
                    </div>

                    <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 0.7rem; letter-spacing: 0.5px;">Gestão de Acessos</h6>
                    <div class="list-group list-group-flush mb-4">
                        <a href="utilizadores.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary">
                            <i class="fa-solid fa-users text-muted w-20px me-3 text-center"></i> Contas de Utilizadores
                        </a>
                        <a href="perfis.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary">
                            <i class="fa-solid fa-user-shield text-muted w-20px me-3 text-center"></i> Perfis e Permissões
                        </a>
                    </div>

                    <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 0.7rem; letter-spacing: 0.5px;">Plataforma Pública</h6>
                    <div class="list-group list-group-flush mb-4">
                        <a href="backoffice_publico.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary">
                            <i class="fa-solid fa-laptop text-muted w-20px me-3 text-center"></i> Editar Site Público
                        </a>
                        <a href="../public/index.html" target="_blank" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary">
                            <i class="fa-solid fa-arrow-up-right-from-square text-muted w-20px me-3 text-center"></i> Ver Site (Nova Aba)
                        </a>
                    </div>

                    <div class="mt-auto pt-3 border-top">
                        <a href="logout.php" class="btn btn-danger bg-opacity-10 text-danger border-0 w-100 rounded-3 fw-bold py-2 shadow-none d-flex align-items-center justify-content-center hover-danger">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Terminar Sessão
                        </a>
                    </div>

                </div>
            </div>

<?php
}

/**
 * FUNÇÃO 2: render_footer
 * Fecha as tags e corre os scripts unificados do ecossistema.
 */
function render_footer()
{
    // 1. INJETAR TODOS OS MODAIS DO SISTEMA AQUI:
    require_once 'modals.php';
    ?>
        </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Script da Sidebar
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });

            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        </script>

        <script>
            // Script do Modo Escuro
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

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

            if (localStorage.getItem('giraTheme') === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                themeIcon.className = 'fa-solid fa-sun text-warning';
            }

            // Inicializar Tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        </script>

        <script src="../assets/js/1241251.js"></script>
    </body>

    </html>
<?php
}
?>