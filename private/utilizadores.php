<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Utilizadores e Acessos");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Utilizadores do Sistema</h2>
        <p class="text-muted m-0 small">Controlo de contas de operadores, credenciais de acesso técnico e estado das sessões.</p>
    </div>
    
    <!-- ATUALIZADO: Adicionados os gatilhos para abrir o Modal do Bootstrap -->
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCriarUtilizador">
        <i class="fa-solid fa-user-plus me-2"></i> Criar Utilizador
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('utilizador')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Utilizador / Identificação <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('username')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Username / E-mail <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('cedula')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Cédula / Registo <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('perfil')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Perfil de Acesso <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('ultimo_acesso')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Último Acesso <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('estado')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Estado <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/150?u=miguel" alt="Miguel" class="rounded-circle border" width="38" height="38">
                            <div>
                                <div class="fw-bold">Dr. Miguel Santos</div>
                                <small class="text-muted">Direção do Serviço</small>
                            </div>
                        </div>
                    </td>
                    <td class="fw-mono text-secondary">msantos.admin@gira.hosp</td>
                    <td class="fw-mono">M-99214</td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2">Administrador</span></td>
                    <td class="fw-mono text-dark">Hoje, 01:25</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Utilizador">
                            <i class="fa-solid fa-user-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-warning border" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspender Acesso">
                            <i class="fa-solid fa-user-slash"></i>
                        </button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/150?u=helena" alt="Helena" class="rounded-circle border" width="38" height="38">
                            <div>
                                <div class="fw-bold">Eng. Maria Helena Barbosa</div>
                                <small class="text-muted">Engenharia Clínica</small>
                            </div>
                        </div>
                    </td>
                    <td class="fw-mono text-secondary">mhelena.barbosa@gira.hosp</td>
                    <td class="fw-mono">EB-44122</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Eng. Biomédico</span></td>
                    <td class="fw-mono text-secondary">31/05/2026 17:45</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Utilizador">
                            <i class="fa-solid fa-user-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-warning border" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspender Acesso">
                            <i class="fa-solid fa-user-slash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/150?u=dinis" alt="Dinis" class="rounded-circle border" width="38" height="38">
                            <div>
                                <div class="fw-bold">Eng. Dinis Martins</div>
                                <small class="text-muted">Técnico de Laboratório</small>
                            </div>
                        </div>
                    </td>
                    <td class="fw-mono text-secondary">dmartins.tecnico@gira.hosp</td>
                    <td class="fw-mono">TL-77119</td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Técnico Interno</span></td>
                    <td class="fw-mono text-secondary">31/05/2026 14:22</td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Suspenso</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Utilizador">
                            <i class="fa-solid fa-user-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-success border" data-bs-toggle="tooltip" data-bs-placement="top" title="Reativar Acesso">
                            <i class="fa-solid fa-user-check"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php
// 3. Chamamos o fim do molde
render_footer();
?>