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
            <a href="relatorios.php" class="sidebar-link">
                <i class="fa-solid fa-chart-simple"></i>
                <span class="sidebar-text ms-2">Relatórios</span>
            </a>
            <a href="historico.php" class="sidebar-link">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="sidebar-text ms-2">Histórico</span>
            </a>

            <div class="small-caps text-secondary mt-3 mb-2 opacity-50 sidebar-text">Configurações</div>
            <a href="utilizadores.php" class="sidebar-link">
                <i class="fa-solid fa-user-gear"></i>
                <span class="sidebar-text ms-2">Perfis</span>
            </a>
            <a href="utilizadores.php" class="sidebar-link">
                <i class="fa-solid fa-user-gear"></i>
                <span class="sidebar-text ms-2">Utilizadores</span>
            </a>
            <a href="backoffice_publico.php" class="sidebar-link">
                <i class="fa-solid fa-sliders"></i>
                <span class="sidebar-text ms-2">Área Pública</span>
            </a>
            <a href="configuracoes.php" class="sidebar-link">
                <i class="fa-solid fa-gear"></i>
                <span class="sidebar-text ms-2">Configurações</span>
            </a>

            <div class="small-caps text-secondary mt-3 mb-2 opacity-50 sidebar-text">Sessão</div>
            <a href="../public/index.html" target="_blank" class="sidebar-link">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span class="sidebar-text ms-2">Ver Site Público</span>
            </a>
            <a href="logout.php" class="sidebar-link text-danger-hover mb-4">
                <i class="fa-solid fa-right-from-bracket text-danger"></i>
                <span class="sidebar-text ms-2 text-danger">Logout</span>
            </a>
        </nav>

        <div class="main-wrapper">

            <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm mb-4 sticky-top" style="top: 20px; z-index: 990;">
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold m-0 text-secondary opacity-75 sidebar-text"><i class="fa-solid fa-laptop-medical me-2 text-primary"></i>Painel Técnico</h5>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light rounded-circle position-relative p-2" style="width: 40px; height: 40px;">
                        <i class="fa-regular fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">6</span>
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
        ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>
    </body>

    </html>
<?php
    }
?>