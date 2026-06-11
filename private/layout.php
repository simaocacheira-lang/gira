<?php
// ============================================================================
// BLOQUEIO DE SEGURANÇA (VERIFICAÇÃO DE SESSÃO)
// ============================================================================
session_start(); // Inicia a memória da sessão para ler quem está logado

// Se a variável 'user_id' NÃO existir na sessão, significa que não passou pelo login
if (!isset($_SESSION['user_id'])) {
    // Expulsa o intruso de volta para a página de entrada (Caminho Absoluto)
    header("Location: /sibdas/1241251/gira/public/login.php");
    exit; // Obrigatório: impede que o resto do código da página seja executado
}

// ============================================================================
// FUNÇÕES DE TABELA (DRY - Don't Repeat Yourself)
// ============================================================================

function render_table_start($headers)
{
    echo '<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">';
    echo '    <div class="table-responsive">';
    echo '        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">';
    echo '            <thead class="table-light">';
    echo '                <tr class="text-muted fw-bold unselectable">';

    foreach ($headers as $th) {
        $align = isset($th['align']) ? ' text-' . $th['align'] : '';

        if (isset($th['sort'])) {
            echo '<th class="th-sortable' . $align . '" onclick="simularOrdenacao(\'' . $th['sort'] . '\')">';
            echo '<div class="d-inline-flex align-items-center gap-1">' . $th['label'] . '<i class="fa-solid fa-sort text-muted opacity-50 ms-1" style="font-size: 0.7rem;"></i></div>';
            echo '</th>';
        } else {
            echo '<th class="' . $align . '">' . $th['label'] . '</th>';
        }
    }

    echo '                </tr>';
    echo '            </thead>';
    echo '            <tbody>';
}

function render_table_end()
{
    echo '            </tbody>';
    echo '        </table>';
    echo '    </div>';
    echo '</div>';
}

// ============================================================================
// FUNÇÃO 1: RENDER_HEADER (Desenha o Head, Sidebar e Topbar)
// ============================================================================
function render_header($title = "Gira - Sistema de Gestão Hospitalar")
{ // ============================================================================
    // MOTOR DE NOTIFICAÇÕES INTELIGENTE
    // ============================================================================
    global $pdo;
    if (empty($pdo)) {
        require_once __DIR__ . '/db.php';
    }

    $total_notificacoes = 0;
    $alertas = [];

    try {
        // 1. Verificar Stock em Rutura
        $stmt_stock = $pdo->query("SELECT COUNT(*) FROM artigos_armazem WHERE quantidade_atual < quantidade_minima");
        $ruturas = $stmt_stock->fetchColumn();
        if ($ruturas > 0) {
            $alertas[] = [
                'icone' => 'fa-box-open text-warning',
                'texto' => "<strong>$ruturas artigos</strong> em rutura no armazém.",
                'link' => '/sibdas/1241251/gira/private/armazem/armazem.php'
            ];
            $total_notificacoes += $ruturas;
        }

        // 2. Verificar Garantias a Expirar (próximos 30 dias)
        $stmt_gar = $pdo->query("SELECT COUNT(*) FROM equipamentos WHERE fim_garantia IS NOT NULL AND fim_garantia BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
        $garantias_exp = $stmt_gar->fetchColumn();
        if ($garantias_exp > 0) {
            $alertas[] = [
                'icone' => 'fa-shield-halved text-danger',
                'texto' => "<strong>$garantias_exp garantias</strong> a expirar em breve.",
                'link' => '/sibdas/1241251/gira/private/garantias/garantias.php'
            ];
            $total_notificacoes += $garantias_exp;
        }

        // 3. Verificar OTs Pendentes
        $stmt_ots = $pdo->query("SELECT COUNT(*) FROM ordens_trabalho WHERE estado != 'Concluída'");
        $ots_pendentes = $stmt_ots->fetchColumn();
        if ($ots_pendentes > 0) {
            $alertas[] = [
                'icone' => 'fa-screwdriver-wrench text-primary',
                'texto' => "Existem <strong>$ots_pendentes OTs</strong> pendentes.",
                'link' => '/sibdas/1241251/gira/private/manutencao/manutencao.php'
            ];
            $total_notificacoes += $ots_pendentes;
        }
    } catch (PDOException $e) {
        // Silencia erro para não quebrar a barra superior
    }
    // ============================================================================
    // LÓGICA DE NÍVEIS DE ACESSO (RBAC) PARA CONSTRUÇÃO DA SIDEBAR
    // ============================================================================
    $nivel = $_SESSION['nivel_acesso'] ?? 1; // Se não tiver nível, assume o Nível 1 (Básico)

    // Identificar visualmente o cargo
    $nome_cargo = 'Corpo Clínico (Leitura)';
    if ($nivel == 2) $nome_cargo = 'Engenheiro / Técnico';
    if ($nivel >= 3) $nome_cargo = 'Administrador de Sistema';

    // Construção Dinâmica do Menu (Toda a gente vê estes)
    $menu_items = [
        ['link' => 'dashboard.php', 'icon' => 'fa-house', 'label' => 'Dashboard'],
        ['is_header' => true, 'label' => 'Gestão'],
        ['link' => 'equipamentos/equipamentos.php', 'icon' => 'fa-stethoscope', 'label' => 'Equipamentos']
    ];

    // Só Nível 2 e 3 veem isto
    if ($nivel >= 2) {
        $menu_items[] = ['link' => 'localizacoes/localizacoes.php', 'icon' => 'fa-location-dot', 'label' => 'Localizações'];
        $menu_items[] = ['link' => 'fornecedores/fornecedores.php', 'icon' => 'fa-truck-field', 'label' => 'Fornecedores'];
    }

    // Toda a gente vê manuais e relatórios técnicos
    $menu_items[] = ['link' => 'documentos/documentos.php', 'icon' => 'fa-regular fa-file-lines', 'label' => 'Documentos'];

    // Só Nível 2 e 3 veem garantias
    if ($nivel >= 2) {
        $menu_items[] = ['link' => 'garantias/garantias.php', 'icon' => 'fa-solid fa-shield-halved', 'label' => 'Garantias e Contratos'];
    }

    // Toda a gente vê manutenção (os médicos precisam abrir avarias)
    $menu_items[] = ['link' => 'manutencao/manutencao.php', 'icon' => 'fa-solid fa-screwdriver-wrench', 'label' => 'Manutenção'];

    // Só Nível 2 e 3 veem peças e relatórios financeiros/globais
    if ($nivel >= 2) {
        $menu_items[] = ['link' => 'armazem/armazem.php', 'icon' => 'fa-solid fa-warehouse', 'label' => 'Armazém'];
        $menu_items[] = ['link' => 'relatorios/relatorios.php', 'icon' => 'fa-solid fa-chart-simple', 'label' => 'Relatórios'];
    }

    // SÓ O NÍVEL 3 (ADMIN) vê a Auditoria Completa
    if ($nivel >= 3) {
        $menu_items[] = ['link' => 'historico/historico.php', 'icon' => 'fa-solid fa-clock-rotate-left', 'label' => 'Histórico'];
    }

    $current_page = basename($_SERVER['PHP_SELF']);
?>
    <!DOCTYPE html>
    <html lang="pt-pt">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>

        <link rel="stylesheet" href="/sibdas/1241251/gira/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/sibdas/1241251/gira/assets/css/all.min.css">
        <link rel="stylesheet" href="/sibdas/1241251/gira/assets/css/1241251.css">
        <link rel="icon" type="image/png" href="/sibdas/1241251/gira/assets/img/favicon.png">
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
                    <?php
                    // Divide o link para perceber se está dentro de uma pasta ou solto
                    $partes_link = explode('/', $item['link']);

                    if (count($partes_link) > 1) {
                        // É um módulo com pasta (ex: equipamentos/equipamentos.php)
                        $modulo = $partes_link[0];
                        $ativo = (strpos($_SERVER['PHP_SELF'], '/' . $modulo . '/') !== false) ? 'active' : '';
                    } else {
                        // É um ficheiro na raiz (ex: dashboard.php)
                        $ficheiro = $partes_link[0];
                        $ativo = (basename($_SERVER['PHP_SELF']) == $ficheiro) ? 'active' : '';
                    }
                    ?>
                    <a href="/sibdas/1241251/gira/private/<?php echo $item['link']; ?>" class="sidebar-link <?php echo $ativo; ?>">
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
                            <?php if ($total_notificacoes > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.6rem;">
                                    <?php echo $total_notificacoes > 99 ? '99+' : $total_notificacoes; ?>
                                </span>
                            <?php endif; ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 p-0 overflow-hidden" style="width: 340px;">
                            <li class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark m-0">Notificações</span>
                                <?php if ($total_notificacoes > 0): ?>
                                    <span class="badge bg-primary rounded-pill small"><?php echo $total_notificacoes; ?> Novas</span>
                                <?php endif; ?>
                            </li>

                            <?php if (empty($alertas)): ?>
                                <li class="p-4 text-center">
                                    <i class="fa-regular fa-bell-slash fs-3 mb-2 text-muted opacity-50"></i>
                                    <p class="small text-muted m-0">Tudo tranquilo! Não há novos alertas.</p>
                                </li>
                            <?php else: ?>
                                <?php foreach ($alertas as $alerta): ?>
                                    <li>
                                        <a href="<?php echo htmlspecialchars($alerta['link']); ?>" class="dropdown-item d-flex align-items-center py-3 border-bottom text-wrap">
                                            <div class="bg-white border rounded-circle p-2 me-3 d-flex justify-content-center align-items-center shadow-sm" style="width: 40px; height: 40px; flex-shrink: 0;">
                                                <i class="fa-solid <?php echo htmlspecialchars($alerta['icone']); ?> fs-6"></i>
                                            </div>
                                            <span class="small text-dark lh-sm"><?php echo $alerta['texto']; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <button class="btn btn-light rounded-circle p-2 shadow-none" style="width: 40px; height: 40px;" id="themeToggle" title="Modo Noturno">
                        <i class="fa-regular fa-moon" id="themeIcon"></i>
                    </button>

                    <div class="vr mx-1 text-muted opacity-25" style="height: 30px;"></div>

                    <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPerfil" aria-controls="offcanvasPerfil" title="Abrir Perfil e Administração">
                        <div class="text-end me-3 d-none d-lg-block">
                            <p class="fw-bold mb-0 small lh-1 text-dark"><?php echo htmlspecialchars($_SESSION['nome'] ?? 'Utilizador'); ?></p>
                            <small class="text-muted" style="font-size: 0.65rem;"><?php echo $nome_cargo; ?></small>
                        </div>
                        <img src="https://i.pravatar.cc/150?u=<?php echo urlencode($_SESSION['nome'] ?? 'miguel'); ?>" alt="Perfil" class="rounded-circle border border-2 border-white shadow-sm hover-primary" width="40" height="40" style="transition: transform 0.2s;">
                    </div>

                </div>
            </div>

            <div class="offcanvas offcanvas-end border-0 shadow" tabindex="-1" id="offcanvasPerfil" aria-labelledby="offcanvasPerfilLabel">
                <div class="offcanvas-header bg-light border-bottom p-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://i.pravatar.cc/150?u=<?php echo urlencode($_SESSION['nome'] ?? 'miguel'); ?>" alt="Perfil" class="rounded-circle border border-3 border-white shadow-sm" width="60" height="60">
                        <div>
                            <h5 class="fw-bold m-0 text-dark" id="offcanvasPerfilLabel"><?php echo htmlspecialchars($_SESSION['nome'] ?? 'Utilizador'); ?></h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 mt-1"><?php echo $nome_cargo; ?></span>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none mb-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body p-4 d-flex flex-column">

                    <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 0.7rem; letter-spacing: 0.5px;">A Minha Conta</h6>
                    <div class="list-group list-group-flush mb-4">
                        <a href="/sibdas/1241251/gira/private/meu_perfil/meu_perfil.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-regular fa-id-badge text-muted w-20px me-3 text-center"></i> O Meu Perfil</a>

                        <?php if ($nivel >= 3): // Apenas Administradores podem aceder às definições globais 
                        ?>
                            <a href="/sibdas/1241251/gira/private/configuracoes.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-solid fa-sliders text-muted w-20px me-3 text-center"></i> Configurações do Sistema</a>
                            <a href="/sibdas/1241251/gira/private/backoffice_publico/backoffice_publico.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-solid fa-globe text-muted w-20px me-3 text-center"></i> Gerir Site Público</a>
                        <?php endif; ?>
                    </div>

                    <?php if ($nivel >= 3): // Apenas Administradores têm acesso a criar Perfis e Utilizadores 
                    ?>
                        <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 0.7rem; letter-spacing: 0.5px;">Gestão de Acessos</h6>
                        <div class="list-group list-group-flush mb-4">
                            <a href="/sibdas/1241251/gira/private/utilizadores/utilizadores.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-solid fa-users text-muted w-20px me-3 text-center"></i> Contas de Utilizadores</a>
                            <a href="/sibdas/1241251/gira/private/perfis/perfis.php" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center fw-medium rounded-3 mb-1 text-secondary"><i class="fa-solid fa-user-shield text-muted w-20px me-3 text-center"></i> Perfis e Permissões</a>
                        </div>
                    <?php endif; ?>

                    <div class="mt-auto pt-3 border-top">
                        <a href="/sibdas/1241251/gira/private/logout.php" class="btn btn-danger bg-opacity-10 text-danger border-0 w-100 rounded-3 fw-bold py-2 shadow-none d-flex align-items-center justify-content-center hover-danger">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Terminar Sessão
                        </a>
                    </div>
                </div>
            </div>

        <?php
    } // <--- FIM OBRIGATÓRIO DA FUNÇÃO RENDER_HEADER


    // ============================================================================
    // FUNÇÃO 2: RENDER_FOOTER
    // ============================================================================
    function render_footer()
    {
        // CAMINHO ABSOLUTO DO PHP: Puxa o modals.php da mesma pasta física deste ficheiro
        require_once __DIR__ . '/modals.php';
        ?>
        </div>

        <script src="/sibdas/1241251/gira/assets/js/bootstrap.bundle.min.js"></script>
        <script src="/sibdas/1241251/gira/assets/js/1241251.js"></script>

        <script>
            // Alternar Sidebar
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }

            // Modo Escuro
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

            // INICIALIZAÇÃO BLINDADA DOS TOOLTIPS
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(elemento) {
                new bootstrap.Tooltip(elemento);
            });
        </script>

    </body>

    </html>
<?php
    } // <--- FIM DA FUNÇÃO RENDER_FOOTER
?>