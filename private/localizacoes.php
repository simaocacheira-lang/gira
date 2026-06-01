<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Localizações");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gestão de Localizações Hospitalares</h2>
        <p class="text-muted m-0 small">Mapeamento de blocos, pisos e salas para rastreabilidade dos dispositivos médicos.</p>
    </div>
    
    <!-- ATUALIZADO: Adicionados os gatilhos para abrir o Modal do Bootstrap -->
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaLocalizacao">
        <i class="fa-solid fa-location-dot me-2"></i> Nova Localização
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('cod_sala')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Cód. Sala <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('nome')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nome da Localização <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('piso')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Piso / Bloco <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('equipamentos')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Dispositivos Alocados <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('estado')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Estado do Alerta <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>
            
            <tbody>
                
                <tr>
                    <td class="fw-bold text-primary fw-mono">#LOC-UCI02</td>
                    <td>
                        <div class="fw-bold">Unidade de Cuidados Intensivos (UCI)</div>
                        <small class="text-muted">Sala 2 · Camas 5 a 8</small>
                    </td>
                    <td>Piso 2 · Bloco Central</td>
                    <td><span class="fw-bold text-primary">14 equipamentos</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Normal</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Espaço/Sala">
                            <i class="fa-solid fa-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Localização">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <tr>
                    <td class="fw-bold text-primary fw-mono">#LOC-BO03</td>
                    <td>
                        <div class="fw-bold">Bloco Operatório (BO3)</div>
                        <small class="text-muted">Sala de Cirurgia Geral 3</small>
                    </td>
                    <td>Piso 1 · Bloco Cirúrgico</td>
                    <td><span class="fw-bold text-primary">22 equipamentos</span></td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">1 Crítico</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Espaço/Sala">
                            <i class="fa-solid fa-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Localização">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#LOC-URG01</td>
                    <td>
                        <div class="fw-bold">Serviço de Urgência Hospitalar</div>
                        <small class="text-muted">Sala de Reanimação (Trauma 1)</small>
                    </td>
                    <td>Piso 0 · Entrada Norte</td>
                    <td><span class="fw-bold text-primary">9 equipamentos</span></td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2">1 Manutenção</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Espaço/Sala">
                            <i class="fa-solid fa-pen text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Localização">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================================== -->
<!-- INJEÇÃO: MODAL PARA ADICIONAR NOVA LOCALIZAÇÃO HOSPITALAR -->
<!-- ============================================================================== -->
<div class="modal fade" id="modalNovaLocalizacao" tabindex="-1" aria-labelledby="modalNovaLocalizacaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold" id="modalNovaLocalizacaoLabel">
                    <i class="fa-solid fa-map-location-dot text-primary me-2"></i>Mapear Nova Localização
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formNovaLocalizacao" action="processar_localizacao.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="locCod" class="form-label small fw-bold text-secondary">Código Identificador da Sala</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono text-uppercase" id="locCod" name="cod_sala" placeholder="Ex: #LOC-UCI03" required>
                    </div>

                    <div class="mb-3">
                        <label for="locNome" class="form-label small fw-bold text-secondary">Nome do Serviço / Sala</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" id="locNome" name="nome" placeholder="Ex: Unidade de Cuidados Intensivos (UCI)" required>
                    </div>

                    <div class="mb-3">
                        <label for="locDetalhe" class="form-label small fw-bold text-secondary">Sublocalização / Detalhe Técnico</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" id="locDetalhe" name="detalhe" placeholder="Ex: Sala 3 · Camas 9 a 12">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="locPiso" class="form-label small fw-bold text-secondary">Piso</label>
                            <select class="form-select rounded-3 bg-light border-0" id="locPiso" name="piso" required>
                                <option value="Piso 0">Piso 0 (R/C)</option>
                                <option value="Piso 1">Piso 1</option>
                                <option value="Piso 2" selected>Piso 2</option>
                                <option value="Piso 3">Piso 3</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="locBloco" class="form-label small fw-bold text-secondary">Bloco / Ala</label>
                            <select class="form-select rounded-3 bg-light border-0" id="locBloco" name="bloco" required>
                                <option value="Bloco Central">Bloco Central</option>
                                <option value="Bloco Cirúrgico">Bloco Cirúrgico</option>
                                <option value="Entrada Norte">Entrada Norte</option>
                                <option value="Ala Sul">Ala Sul</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="locEstado" class="form-label small fw-bold text-secondary">Estado Inicial do Alerta</label>
                        <select class="form-select rounded-3 bg-light border-0" id="locEstado" name="estado_alerta" required>
                            <option value="Normal" selected>Normal (Espaço Operacional)</option>
                            <option value="1 Manutenção">1 Manutenção Ativa no Espaço</option>
                            <option value="1 Crítico">Aviso Crítico (Equipamento de Suporte de Vida com Falha)</option>
                        </select>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaLocalizacao" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-location-dot me-2"></i>Mapear Espaço
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    document.querySelector('a[href="localizacoes.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar localizações por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde para renderizar os scripts finais
render_footer();
?>