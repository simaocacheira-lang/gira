<?php
// 1. Chamamos o molde do layout e a ligação à base de dados
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. LÓGICA DINÂMICA: Buscar artigos e contar ruturas
try {
    $sql = "SELECT a.*, f.nome_empresa 
            FROM artigos_armazem a 
            LEFT JOIN fornecedores f ON a.fornecedor_id = f.id 
            ORDER BY a.nome ASC";
    $stmt = $pdo->query($sql);
    $artigos = $stmt->fetchAll();

    // Contar quantas peças estão abaixo do mínimo
    $total_ruturas = 0;
    foreach ($artigos as $artigo) {
        if ($artigo['quantidade_atual'] < $artigo['quantidade_minima']) {
            $total_ruturas++;
        }
    }
} catch (PDOException $e) {
    die("Erro ao carregar o armazém: " . $e->getMessage());
}

// 3. Montamos o topo
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

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-danger border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Stock em Rutura</small>
            <h3 class="fw-bold my-1 text-danger"><?php echo $total_ruturas; ?> Artigos</h3>
            <small class="text-muted" style="font-size: 0.75rem;">A necessitar de compra urgente</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Valor Total em Stock</small>
            <h3 class="fw-bold my-1 text-dark">-- €</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Módulo financeiro em desenvolvimento</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Movimentações (Mês)</small>
            <h3 class="fw-bold my-1 text-success">--</h3>
            <small class="text-muted" style="font-size: 0.75rem;">Módulo estatístico em desenvolvimento</small>
        </div>
    </div>
</div>

<?php
// 1. Definimos as colunas da tabela com as larguras (width) adequadas
$colunas = [
    ['label' => 'Ref. Peça', 'width' => '15%'],
    ['label' => 'Designação do Artigo', 'width' => '30%'],
    ['label' => 'Fornecedor', 'width' => '20%'],
    ['label' => 'Stock Atual', 'width' => '10%'],
    ['label' => 'Em Trânsito', 'align' => 'center', 'width' => '15%'],
    ['label' => 'Estado', 'width' => '10%']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos
render_table_start($colunas);

// ============================================================================
// O LOOP: Preencher o armazém com dados reais da base de dados
// ============================================================================
foreach ($artigos as $artigo):

    $em_rutura = ($artigo['quantidade_atual'] < $artigo['quantidade_minima']);
    $cor_texto = $em_rutura ? 'text-danger' : 'text-dark';
    $classe_badge = $em_rutura ? 'bg-danger badge-rutura' : 'bg-success';
    $texto_badge = $em_rutura ? 'Rutura' : 'Saudável';
    $nome_fornecedor = $artigo['nome_empresa'] ? $artigo['nome_empresa'] : '<span class="text-muted fst-italic">Sem Fornecedor</span>';

    // LÓGICA DO "EM TRÂNSITO": Se for maior que 0, mostra o camião azul
    $html_transito = '<span class="text-muted">-</span>';
    if ($artigo['quantidade_em_transito'] > 0) {
        $html_transito = '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 py-1"><i class="fa-solid fa-truck-fast me-1"></i> +' . $artigo['quantidade_em_transito'] . '</span>';
    }
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($artigo['referencia']); ?></td>
        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($artigo['nome']); ?></div>
            <small class="text-muted"><?php echo htmlspecialchars($artigo['categoria']); ?></small>
        </td>
        <td><?php echo $nome_fornecedor; ?></td>
        <td>
            <span class="fw-bold <?php echo $cor_texto; ?> fs-6"><?php echo $artigo['quantidade_atual']; ?></span>
            <small class="text-muted ms-1">(Mín: <?php echo $artigo['quantidade_minima']; ?>)</small>
        </td>
        <td class="text-center"><?php echo $html_transito; ?></td>
        <td><span class="badge <?php echo $classe_badge; ?> rounded-pill px-3 py-2 shadow-sm"><?php echo $texto_badge; ?></span></td>
    </tr>
<?php
endforeach;

// 3. Fechamos as tags da tabela
render_table_end();
?>

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
                <form id="formNovaEncomenda" action="/sibdas/1241251/gira/private/armazem/processar_encomenda.php" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Artigo a Encomendar</label>
                            <select class="form-select rounded-3 bg-light border-0" name="artigo_id" required>
                                <option value="" selected disabled>Escolha o artigo...</option>
                                <?php foreach ($artigos as $artigo_modal): ?>
                                    <option value="<?php echo $artigo_modal['id']; ?>">
                                        <?php echo htmlspecialchars($artigo_modal['referencia'] . ' - ' . $artigo_modal['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Quantidade</label>
                            <input type="number" class="form-control rounded-3 bg-light border-0" name="quantidade" min="1" value="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Data Prevista Chegada</label>
                            <input type="date" class="form-control rounded-3 bg-light border-0" name="data_prevista" required>
                        </div>

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