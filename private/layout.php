<?php

/**
 * layout.php - Estrutura central do sistema
 */

// ============================================================================
// FUNÇÃO 1: RENDER_HEADER (Desenha o Head, Sidebar e Topbar)
// ============================================================================
function render_header($title = "Gira - Sistema de Gestão Hospitalar")
{

    // 1. ARRAY DINÂMICO DA SIDEBAR
    // Para adicionar um menu, basta acrescentar uma linha aqui!
    $menu_items = [
        ['link' => 'dashboard.php', 'icon' => 'fa-house', 'label' => 'Dashboard'],
        ['is_header' => true, 'label' => 'Gestão'],
        ['link' => 'equipamentos.php', 'icon' => 'fa-stethoscope', 'label' => 'Equipamentos'],
        ['link' => 'localizacoes.php', 'icon' => 'fa-location-dot', 'label' => 'Localizações'],
        ['link' => 'fornecedores.php', 'icon' => 'fa-truck-field', 'label' => 'Fornecedores'],
        ['link' => 'documentos.php', 'icon' => 'fa-regular fa-file-lines', 'label' => 'Documentos'],
        ['link' => 'garantias.php', 'icon' => 'fa-solid fa-shield-halved', 'label' => 'Garantias e Contratos'],
        ['link' => 'manutencao.php', 'icon' => 'fa-solid fa-screwdriver-wrench', 'label' => 'Manutenção'],
        ['link' => 'armazem.php', 'icon' => 'fa-solid fa-warehouse', 'label' => 'Armazém'],
        ['link' => 'relatorios.php', 'icon' => 'fa-solid fa-chart-simple', 'label' => 'Relatórios'],
        ['link' => 'historico.php', 'icon' => 'fa-solid fa-clock-rotate-left', 'label' => 'Histórico']
    ];

    // Descobre em que página o utilizador está agora (ex: 'equipamentos.php')
    $current_page = basename($_SERVER['PHP_SELF']);
?>
    <!DOCTYPE html>
    <html lang="pt-pt">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/all.min.css">
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

            <?php foreach ($menu_items as $item): ?>
                <?php if (isset($item['is_header'])): ?>
                    <div class="small-caps text-secondary mt-3 mb-2 opacity-50 sidebar-text"><?php echo $item['label']; ?></div>
                <?php else: ?>
                    <a href="<?php echo $item['link']; ?>" class="sidebar-link <?php echo ($current_page == $item['link']) ? 'active' : ''; ?>">
                        <i class="fa-solid <?php echo $item['icon']; ?>"></i>
                        <span class="sidebar-text ms-2"><?php echo $item['label']; ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
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
                    <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 0.7rem; letter-spacing: 0.5px;">Gestão de Acessos</h6>
                    <div class="list-group list-group-flush mb-4">
                        <a href="utilizadores.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-solid fa-users text-muted w-20px me-3 text-center"></i> Contas de Utilizadores</a>
                        <a href="perfis.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-solid fa-user-shield text-muted w-20px me-3 text-center"></i> Perfis e Permissões</a>
                    </div>
                    <div class="mt-auto pt-3 border-top">
                        <a href="logout.php" class="btn btn-danger bg-opacity-10 text-danger border-0 w-100 rounded-3 fw-bold py-2 shadow-none d-flex align-items-center justify-content-center hover-danger">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Terminar Sessão
                        </a>
                    </div>
                </div>
            </div>

        <?php
    } // <--- FIM OBRIGATÓRIO DA FUNÇÃO RENDER_HEADER


    // ============================================================================
    // FUNÇÃO 2: RENDER_FOOTER (Fecha as tags e centraliza os scripts comuns)
    // ============================================================================
    function render_footer()
    {
        require_once 'modals.php';
        ?>
        </div>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>

        <script>
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
            // Ativa Tooltips globalmente
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // Gestão do Dark Mode
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
        </script>

        <script src="../assets/js/1241251.js"></script>
    </body>

    </html>
<?php
    } // <--- FIM OBRIGATÓRIO DA FUNÇÃO RENDER_FOOTER
?>