<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. QUERY LIMPA: O DataTables encarrega-se da paginação e pesquisa
try {
    $sql = "SELECT e.id, e.codigo_ativo, e.nome, e.modelo, e.fim_garantia, f.nome_empresa 
            FROM equipamentos e
            LEFT JOIN fornecedores f ON e.fornecedor_id = f.id
            WHERE e.fim_garantia IS NOT NULL
            ORDER BY e.fim_garantia ASC";
    $stmt = $pdo->query($sql);
    $equipamentos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar garantias: " . $e->getMessage());
}

// 3. Montamos o topo da página
render_header("Gira - Garantias e Contratos de Manutenção");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0 text-dark">Garantias e Contratos</h2>
        <p class="text-muted m-0 small">Controlo de coberturas de fábrica, contratos de assistência técnica externa e SLAs de fornecedores.</p>
    </div>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação Concluída!</strong>
        <?php
        if ($_GET['sucesso'] == 'garantia_atualizada') {
            echo "A data de garantia foi atualizada com sucesso.";
        } elseif ($_GET['sucesso'] == 'garantia_eliminada') {
            echo "A garantia foi removida do sistema.";
        } else {
            echo "Operação realizada com sucesso.";
        }
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Tabela definida com exatamente 6 colunas, utilizando a chave 'label'
render_table_start([
    ['label' => 'ID Ativo', 'width' => '15%'],
    ['label' => 'Equipamento / Modelo', 'width' => '30%'],
    ['label' => 'Fornecedor', 'width' => '20%'],
    ['label' => 'Fim de Garantia', 'width' => '15%'],
    ['label' => 'Estado', 'width' => '10%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '10%']
]);

foreach ($equipamentos as $eq):
    // Lógica para calcular se a garantia está válida, a expirar ou expirada
    $data_fim = new DateTime($eq['fim_garantia']);
    $hoje = new DateTime();
    $hoje->setTime(0, 0, 0); // Limpar horas para comparar dias exatos
    $expirada = $data_fim < $hoje;

    // Calcular a diferença de dias para o aviso amarelo
    $intervalo = $hoje->diff($data_fim);
    $dias_restantes = (int)$intervalo->format('%r%a');

    $cor_badge = 'success';
    $texto_badge = 'Válida';

    if ($expirada) {
        $cor_badge = 'danger';
        $texto_badge = 'Expirada';
    } elseif ($dias_restantes <= 30) {
        $cor_badge = 'warning';
        $texto_badge = 'A expirar';
    }
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($eq['codigo_ativo']); ?></td>

        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($eq['nome']); ?></div>
            <small class="text-muted"><?php echo htmlspecialchars($eq['modelo']); ?></small>
        </td>

        <td>
            <span class="text-secondary small fw-medium">
                <i class="fa-solid fa-industry me-1"></i> <?php echo htmlspecialchars($eq['nome_empresa'] ?? 'Sem Fornecedor'); ?>
            </span>
        </td>

        <td class="fw-medium text-dark">
            <?php echo date('d/m/Y', strtotime($eq['fim_garantia'])); ?>
        </td>

        <td>
            <span class="badge bg-<?php echo $cor_badge; ?> bg-opacity-10 text-<?php echo $cor_badge; ?> border border-<?php echo $cor_badge; ?>-subtle px-2 py-1 rounded-pill">
                <?php echo $texto_badge; ?>
            </span>
        </td>

        <td class="text-end text-nowrap">
            <button class="btn btn-light btn-sm rounded-3 border shadow-none"
                data-bs-toggle="modal"
                data-bs-target="#modalAdicionarGarantia"
                data-id="<?php echo $eq['id']; ?>"
                data-data="<?php echo $eq['fim_garantia']; ?>"
                data-bs-toggle="tooltip" title="Atualizar Data">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>

            <button type="button" class="btn btn-light btn-sm rounded-3 border shadow-none hover-danger ms-1"
                onclick="confirmarEliminacao('/sibdas/1241251/gira/private/garantias/eliminar_garantia.php?id=<?php echo $eq['id']; ?>', 'Tem a certeza que deseja remover a garantia do equipamento \'<?php echo htmlspecialchars($eq['nome']); ?>\'? A data será limpa do sistema.', 'Remover Garantia')"
                data-bs-toggle="tooltip" title="Remover Garantia">
                <i class="fa-solid fa-trash-can text-danger"></i>
            </button>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalGarantia = document.getElementById('modalAdicionarGarantia');
        if (modalGarantia) {
            modalGarantia.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const eqId = button.getAttribute('data-id');
                const dataGarantia = button.getAttribute('data-data');

                document.getElementById('garantia_id_equipamento').value = eqId;
                document.querySelector('#formGarantia input[name="fim_garantia"]').value = dataGarantia;
            });
        }
    });
</script>

<?php render_footer(); ?>