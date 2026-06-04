<?php
// 1. Chamamos o molde
require_once 'layout.php';

// 2. Montamos o topo
render_header("Gira - Armazém e Gestão de Stock Técnico");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Armazém Técnico</h2>
        <p class="text-muted m-0 small">Gestão de peças sobresselentes, consumíveis e alertas de stock crítico.</p>
    </div>

   <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaEncomenda">
    <i class="fa-solid fa-cart-plus me-2"></i> Nova Encomenda
</button>
</div>

<!-- ============================================================================== -->
<!-- ESTATÍSTICAS RÁPIDAS DE STOCK -->
<!-- ============================================================================== -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-danger border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Stock em Rutura</small>
            <h3 class="fw-bold my-1 text-danger">4 Artigos</h3>
            <small class="text-muted" style="font-size: 0.75rem;">A necessitar de compra urgente</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Valor Total em Stock</small>
            <h3 class="fw-bold my-1 text-dark">42.500 €</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Valor contabilístico das peças</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Movimentações (Mês)</small>
            <h3 class="fw-bold my-1 text-success">128</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Saídas registadas em OTs</small>
        </div>
    </div>
</div>

<!-- ============================================================================== -->
<!-- TABELA DE INVENTÁRIO -->
<!-- ============================================================================== -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th>Ref. Peça</th>
                    <th>Designação do Artigo</th>
                    <th>Fornecedor</th>
                    <th>Stock Atual</th>
                    <th>Stock Mínimo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold text-primary fw-mono">P01</td>
                    <td>
                        <div class="fw-bold text-dark">Módulo SpO2 - Philips</div>
                        <small class="text-muted">Compatível com série IntelliVue</small>
                    </td>
                    <td>Philips Healthcare</td>
                    <td class="fw-bold text-danger">0</td>
                    <td>5</td>
                    <td><span class="badge bg-danger rounded-pill px-2">Rutura</span></td>
                </tr>
                <tr>
                    <td class="fw-bold text-primary fw-mono">P02</td>
                    <td>
                        <div class="fw-bold text-dark">Bateria 12V - Dräger</div>
                        <small class="text-muted">Célula de chumbo selada</small>
                    </td>
                    <td>Dräger Portugal</td>
                    <td class="fw-bold text-dark">12</td>
                    <td>10</td>
                    <td><span class="badge bg-success rounded-pill px-2">Saudável</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- ============================================================================== -->
<!-- MODAL: NOVA ENCOMENDA DE STOCK                                                 -->
<!-- ============================================================================== -->
<div class="modal fade" id="modalNovaEncomenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-cart-plus text-primary me-2"></i>Nova Encomenda ao Fornecedor
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <form id="formNovaEncomenda" action="processar_encomenda.php" method="POST">
                    <div class="row g-3">
                        <!-- Seleção do Artigo -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Artigo a Encomendar</label>
                            <select class="form-select rounded-3 bg-light border-0" name="artigo_id" required>
                                <option value="" selected disabled>Escolha o artigo...</option>
                                <option value="P01">P01 - Módulo SpO2 - Philips</option>
                                <option value="P02">P02 - Bateria 12V - Dräger</option>
                            </select>
                        </div>

                        <!-- Quantidade -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Quantidade</label>
                            <input type="number" class="form-control rounded-3 bg-light border-0" name="quantidade" min="1" value="1" required>
                        </div>

                        <!-- Data Prevista -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Data Prevista Chegada</label>
                            <input type="date" class="form-control rounded-3 bg-light border-0" name="data_prevista" required>
                        </div>

                        <!-- Observações -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Notas ao Fornecedor</label>
                            <textarea class="form-control rounded-3 bg-light border-0" name="notas" rows="2" placeholder="Ex: Urgente, stock em rutura."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovaEncomenda" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-paper-plane me-2"></i>Confirmar Pedido
                </button>
            </div>

        </div>
    </div>
</div>

<?php
render_footer();
?>