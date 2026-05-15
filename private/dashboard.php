<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gira - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/1241251.css">
</head>

<body>

    <!-- Sidebar -->

    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-notes-medical me-2 text-primary"></i> Gira
        </div>

        <div class="small text-uppercase mb-2 text-secondary fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Dashboard</div>
        <a href="#" class="sidebar-link active">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>

        <div class="small text-uppercase mt-4 mb-2 text-secondary fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Gestão</div>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-stethoscope"></i> Equipamentos</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-location-dot"></i> Localizações</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-truck-field"></i> Fornecedores</a>
    </nav>

    <!-- Mensagem de boas-vindas e data -->

    <main class="main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Bom dia, Administrador! 👋</h2>
                <p class="text-muted small mb-0">Aqui está o panorama do inventário de equipamentos médicos.</p>
            </div>
            <div class="bg-white p-2 rounded-3 shadow-sm px-3 d-flex align-items-center">
                <i class="fa-regular fa-calendar me-2 text-primary"></i>
                <span class="small fw-bold text-dark">20 de maio, 2024</span>
            </div>
        </div>

        <!-- KPIs Principais -->

        <div class="row g-3">

            <div class="col">
                <div class="kpi-card">
                    <div class="icon-circle bg-blue-light"><i class="fa-solid fa-file-invoice"></i></div>
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Total Equipamentos</p>
                        <h3 class="fw-bold mb-1">1,532</h3>
                        <p class="text-primary small mb-0 fw-bold">↑ 8% <span class="text-muted fw-normal">desde o passado</span></p>
                    </div>
                    <div class="kpi-chart">
                        <svg viewBox="0 0 100 40" preserveAspectRatio="none" style="width:100%; height:100%;">
                            <path d="M0 35 Q 20 35, 40 20 T 80 25 T 100 5" fill="none" stroke="#1a73e8" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="kpi-card">
                    <div class="icon-circle bg-green-light"><i class="fa-solid fa-calendar-check"></i></div>
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Equipamentos Ativos</p>
                        <h3 class="fw-bold mb-1">1,328</h3>
                        <p class="text-success small mb-0 fw-bold">↑ 5% <span class="text-muted fw-normal">desde o mês</span></p>
                    </div>
                    <div class="kpi-chart">
                        <svg viewBox="0 0 100 40" preserveAspectRatio="none" style="width:100%; height:100%;">
                            <path d="M0 30 Q 25 10, 50 25 T 100 15" fill="none" stroke="#34a853" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="kpi-card">
                    <div class="icon-circle bg-orange-light"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Em Manutenção</p>
                        <h3 class="fw-bold mb-1">124</h3>
                        <p class="text-danger small mb-0 fw-bold">↓ 3% <span class="text-muted fw-normal">desde o mês</span></p>
                    </div>
                    <div class="kpi-chart">
                        <svg viewBox="0 0 100 40" preserveAspectRatio="none" style="width:100%; height:100%;">
                            <path d="M0 20 Q 20 40, 50 20 T 100 30" fill="none" stroke="#fb8c00" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="kpi-card">
                    <div class="icon-circle bg-blue-light" style="opacity:0.7;"><i class="fa-solid fa-power-off"></i></div>
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Inativos</p>
                        <h3 class="fw-bold mb-1">80</h3>
                        <p class="text-muted small mb-0 fw-bold">↘ 2% <span class="text-muted fw-normal">desde o mês</span></p>
                    </div>
                    <div class="kpi-chart">
                        <svg viewBox="0 0 100 40" preserveAspectRatio="none" style="width:100%; height:100%;">
                            <path d="M0 35 Q 50 35, 100 35" fill="none" stroke="#6c757d" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="kpi-card border-start border-danger border-4">
                    <div class="icon-circle bg-red-light"><i class="fa-solid fa-shield-heart"></i></div>
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Garantias a Expirar</p>
                        <h3 class="fw-bold mb-1 text-danger">23</h3>
                        <p class="text-warning small mb-0 fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> 30 dias</p>
                    </div>
                    <div class="text-center mt-3" style="opacity:0.15;">
                        <i class="fa-solid fa-clock-rotate-left fa-2x"></i>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="kpi-card border-start border-primary border-4">
                    <div class="icon-circle bg-blue-light"><i class="fa-solid fa-file-circle-exclamation"></i></div>
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Documentos em Falta</p>
                        <h3 class="fw-bold mb-1 text-primary">17</h3>
                        <p class="text-danger small mb-0 fw-bold"><i class="fa-solid fa-circle-info me-1"></i> Ação necessária</p>
                    </div>
                    <div class="text-center mt-3" style="opacity:0.15;">
                        <i class="fa-solid fa-file-signature fa-2x"></i>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>

</html>