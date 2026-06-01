<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Perfis e Grupos de Permissões");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Perfis de Acesso</h2>
        <p class="text-muted m-0 small">Configuração de grupos de utilizadores, níveis de autorização e politicas de segurança.</p>
    </div>
    
    <!-- ATUALIZADO: Adicionados os gatilhos para abrir o Modal do Bootstrap -->
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarPerfil">
        <i class="fa-solid fa-users-gear me-2"></i> Adicionar Perfil
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('nome_perfil')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nome do Perfil <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('descricao')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Descrição do Escopo <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('total_users')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nº Utilizadores <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('nivel_acesso')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nível de Permissão <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td class="fw-bold text-dark">Administrador</td>
                    <td class="text-secondary">Acesso total e irrestrito a todos os módulos, configurações de sistema e logs de auditoria.</td>
                    <td><span class="fw-bold text-primary">1 utilizador</span></td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2"><i class="fa-solid fa-shield me-1"></i> Escrita Total</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos do Grupo">
                            <i class="fa-solid fa-key text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfil de Sistema (Bloqueado)">
                            <i class="fa-solid fa-lock"></i>
                        </button>
                    </td>
                </tr>
                
                <tr>
                    <td class="fw-bold text-dark">Eng. Biomédico</td>
                    <td class="text-secondary">Gestão completa de inventário, localizações, fornecedores, documentos e abertura de O.T.</td>
                    <td><span class="fw-bold text-primary">1 utilizador</span></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2"><i class="fa-solid fa-pen-to-square me-1"></i> Modificação</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos do Grupo">
                            <i class="fa-solid fa-key text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Perfil">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-dark">Técnico Interno</td>
                    <td class="text-secondary">Visualização do parque tecnológico e alteração/conclusão de ordens de trabalho atribuídas.</td>
                    <td><span class="fw-bold text-primary">1 utilizador</span></td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2"><i class="fa-solid fa-wrench me-1"></i> Operação</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos do Grupo">
                            <i class="fa-solid fa-key text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Perfil">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================================== -->
<!-- INJEÇÃO: MODAL PARA ADICIONAR NOVO PERFIL / GRUPO DE PERMISSÕES -->
<!-- ============================================================================== -->
<div class="modal fade" id="modalAdicionarPerfil" tabindex="-1" aria-labelledby="modalAdicionarPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold" id="modalAdicionarPerfilLabel">
                    <i class="fa-solid fa-users-gear text-primary me-2"></i>Criar Perfil de Acesso
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formNovoPerfil" action="processar_perfil.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="perfNome" class="form-label small fw-bold text-secondary">Nome do Perfil / Grupo</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" id="perfNome" name="nome_perfil" placeholder="Ex: Técnico Externo (Fornecedor)" required>
                    </div>

                    <div class="mb-4">
                        <label for="perfDesc" class="form-label small fw-bold text-secondary">Descrição das Responsabilidades</label>
                        <textarea class="form-control rounded-3 bg-light border-0" id="perfDesc" name="descricao" rows="2" placeholder="Ex: Acesso limitado para consulta de ordens de trabalho atribuídas por fornecedor." required></textarea>
                    </div>

                    <!-- Matriz de Permissões Rápidas em Checkboxes -->
                    <div>
                        <label class="form-label small fw-bold text-dark d-block mb-2"><i class="fa-solid fa-shield-halved text-primary me-1"></i>Módulos Autorizados</label>
                        
                        <div class="bg-light rounded-3 p-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="checkInv" name="perm_inventario" checked>
                                <label class="form-check-label small fw-medium text-secondary" for="checkInv">Gestão de Inventário e Localizações</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="checkMan" name="perm_manutencao" checked>
                                <label class="form-check-label small fw-medium text-secondary" for="checkMan">Abertura e Fecho de Ordens de Trabalho</label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="checkConf" name="perm_configuracoes">
                                <label class="form-check-label small fw-medium text-secondary" for="checkConf">Definições Globais e Logs de Auditoria</label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoPerfil" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Perfil
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    document.querySelector('a[href="perfis.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar perfis por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde
render_footer();
?>