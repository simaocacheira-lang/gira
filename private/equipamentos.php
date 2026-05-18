<?php
// Chamar molde da Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. topo da página com o título correto na aba do browser
render_header("Gira - Inventário de Equipamentos");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Inventário de Equipamentos</h2>
        <p class="text-muted m-0 small">Listagem geral e controlo dos dispositivos médicos do hospital.</p>
    </div>
    
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm">
        <i class="fa-solid fa-plus me-2"></i> Adicionar Equipamento
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-light btn-sm rounded-pill px-3 active fw-bold">Todos</button>
        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Ativos</button>
        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Em Manutenção</button>
        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted">Críticos</button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold">
                    <th>ID / Nº Série</th>
                    <th>Equipamento</th>
                    <th>Categoria</th>
                    <th>Localização</th>
                    <th>Próxima Revisão</th>
                    <th>Estado</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            
            <tbody>
                
                <tr>
                    <td class="text-muted fw-mono">
                        #EQ-00124<br>
                        <small style="font-size:0.65rem;">SN: PH-9921</small>
                    </td>
                    <td>
                        <div class="fw-bold">Monitor Multiparamétrico</div>
                        <small class="text-muted">Philips IntelliVue</small>
                    </td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Monitorização</span></td>
                    <td>UCI - Sala 2</td>
                    <td>25/06/2026</td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" title="Editar"><i class="fa-solid fa-pen text-muted"></i></button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                
                <tr>
                    <td class="text-muted fw-mono">
                        #EQ-00125<br>
                        <small style="font-size:0.65rem;">SN: BB-4412</small>
                    </td>
                    <td>
                        <div class="fw-bold">Bomba de Infusão Contínua</div>
                        <small class="text-muted">B. Braun Space</small>
                    </td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Suporte de Vida</span></td>
                    <td>Medicina - Bloco B</td>
                    <td>12/06/2026</td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">Manutenção</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" title="Editar"><i class="fa-solid fa-pen text-muted"></i></button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>

                <tr>
                    <td class="text-muted fw-mono">
                        #EQ-00126<br>
                        <small style="font-size:0.65rem;">SN: DG-7711</small>
                    </td>
                    <td>
                        <div class="fw-bold">Ventilador Pulmonar Oxilog</div>
                        <small class="text-muted">Dräger Evita</small>
                    </td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Suporte de Vida</span></td>
                    <td>Urgências - Reanimação</td>
                    <td>30/05/2026</td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Crítico</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" title="Editar"><i class="fa-solid fa-pen text-muted"></i></button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

<?php
// Chamar fim do molde para fechar o wrapper e carregar os scripts
render_footer();
?>