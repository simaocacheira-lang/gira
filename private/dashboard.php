<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gira - Visão Geral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/1241251.css">
</head>

<body>

    <nav class="sidebar">
        <div class="text-center mb-5 mt-3">
            <h3 class="fw-bold text-purple">
                <i class="fa-solid fa-notes-medical me-2"></i>Gira
            </h3>
            <p class="small text-muted">Gestão Hospitalar</p>
        </div>

        <div>
            <a href="#" class="sidebar-link active">
                <i class="fa-solid fa-chart-pie me-2"></i> Painel Geral
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-stethoscope me-2"></i> Equipamentos
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-regular fa-building me-2"></i> Localizações
            </a>
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-users-gear me-2"></i> Fornecedores
            </a>
        </div>
    </nav>

    <main class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold text-dark">Visão Geral</h2>
            <p class="text-muted">Estado atual do parque tecnológico hospitalar.</p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-bold mb-1 text-uppercase">Equipamentos</p>
                            <h2 class="fw-bold mb-0">1.452</h2>
                        </div>
                        <div class="bg-purple bg-opacity-10 p-3 rounded-3">
                            <i class="fa-solid fa-box text-purple fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-bold mb-1 text-uppercase">Ativos</p>
                            <h2 class="fw-bold mb-0 text-success">1.234</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                            <i class="fa-solid fa-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-bold mb-1 text-uppercase">Em Manutenção</p>
                            <h2 class="fw-bold mb-0 text-danger">42</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3 text-danger">
                            <i class="fa-solid fa-wrench fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>

</html>