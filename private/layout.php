<?php
/**
 * FUNÇÃO 1: render_header
 * Esta função vai desenhar o início do site, importar os estilos,
 * e montar a Sidebar e a Topbar automaticamente.
 * * O ($title) permite que cada página escolha o seu próprio título na aba do browser.
 */
function render_header($title = "Gira - Sistema de Gestão Hospitalar") {
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
    </nav>

    <div class="main-wrapper">

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
 * Esta função serve para fechar as tags HTML que abrimos lá em cima
 * e rodar os teus scripts de JavaScript (Sidebar e Modo Escuro).
 */
function render_footer() {
?>
    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        // Se o utilizador já tinha o menu encolhido, ativa-o ao carregar
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

        // Se o utilizador já usava o modo escuro, ativa-o ao carregar
        if (localStorage.getItem('giraTheme') === 'dark') {
            htmlElement.setAttribute('data-bs-theme', 'dark');
            themeIcon.className = 'fa-solid fa-sun text-warning';
        }
    </script>
</body>
</html>
<?php
}
?>