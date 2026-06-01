<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Histórico de Atividades e Logs");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Histórico do Sistema</h2>
        <p class="text-muted m-0 small">Registo cronológico de operações, alterações de inventário e acessos de utilizadores para fins de auditoria.</p>
    </div>
    
    <button class="btn btn-light border rounded-3 fw-bold small px-3 py-2 text-danger shadow-sm">
        <i class="fa-solid fa-trash-can me-2"></i> Limpar Logs Antigos
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('id_log')">
                        <div class="d-inline-flex align-items-center gap-1">
                            ID Log <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('data_hora')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Data / Hora <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('utilizador')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Utilizador <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('acao')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Ação Efetuada <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('modulo')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Módulo <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('ip')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Endereço IP <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td class="fw-bold text-secondary fw-mono">#LOG-88412</td>
                    <td class="fw-mono text-dark">01/06/2026 09:14:22</td>
                    <td>
                        <div class="fw-bold">Dr. Miguel Santos</div>
                        <small class="text-muted">Administrador</small>
                    </td>
                    <td><span class="text-success fw-medium"><i class="fa-solid fa-circle-check me-1"></i> Login Efetuado com Sucesso</span></td>
                    <td><span class="badge bg-light text-dark border px-2">Autenticação</span></td>
                    <td class="fw-mono text-secondary">192.168.1.45</td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalhes do Log">
                            <i class="fa-solid fa-circle-info text-muted"></i>
                        </button>
                    </td>
                </tr>
                
                <tr>
                    <td class="fw-bold text-secondary fw-mono">#LOG-88411</td>
                    <td class="fw-mono text-dark">31/05/2026 17:45:01</td>
                    <td>
                        <div class="fw-bold">Eng. Helena Barbosa</div>
                        <small class="text-muted">Técnico Biomédico</small>
                    </td>
                    <td><span class="text-warning fw-medium"><i class="fa-solid fa-pen-to-square me-1"></i> Alterou Estado da O.T. #OT-2026-098</span></td>
                    <td><span class="badge bg-light text-dark border px-2">Manutenção</span></td>
                    <td class="fw-mono text-secondary">192.168.1.112</td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalhes do Log">
                            <i class="fa-solid fa-circle-info text-muted"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-secondary fw-mono">#LOG-88410</td>
                    <td class="fw-mono text-dark">31/05/2026 14:22:19</td>
                    <td>
                        <div class="fw-bold">Eng. Dinis Martins</div>
                        <small class="text-muted">Técnico Biomédico</small>
                    </td>
                    <td><span class="text-danger fw-medium"><i class="fa-solid fa-trash me-1"></i> Eliminou Documento #DOC-9914</span></td>
                    <td><span class="badge bg-light text-dark border px-2">Documentos</span></td>
                    <td class="fw-mono text-secondary">192.168.1.115</td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalhes do Log">
                            <i class="fa-solid fa-circle-info text-muted"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    document.querySelector('a[href="historico.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar logs por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde
render_footer();
?>