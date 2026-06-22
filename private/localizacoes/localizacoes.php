<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Gestão de Localizações");

// 2. EXTRAÇÃO LIMPA
try {
    $localizacoes = obterLocalizacoes($pdo);
} catch (PDOException $e) {
    die("Erro ao carregar as localizações: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0 text-dark">Localizações Hospitalares</h4>
        <p class="text-muted m-0 small">Mapeamento de salas, blocos e pisos do parque tecnológico.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaLocalizacao">
        <i class="fa-solid fa-plus me-2"></i> Registar
    </button>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação Concluída!</strong> O mapa de localizações foi atualizado com sucesso.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (isset($_GET['erro']) && $_GET['erro'] == 'sala_ocupada'): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>
        <strong>Ação Recusada!</strong> Não é possível apagar esta localização porque ainda existem equipamentos ativos associados a ela. Mova os equipamentos primeiro.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Utilização de 'label' em vez de 'text' para evitar o erro da linha 34
render_table_start([
    ['label' => 'Cód. Sala', 'width' => '15%'],
    ['label' => 'Localização', 'width' => '30%'],
    ['label' => 'Detalhe', 'width' => '25%'],
    ['label' => 'Piso / Bloco', 'width' => '20%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '10%']
]);

foreach ($localizacoes as $loc):
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($loc['cod_sala']); ?></td>
        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($loc['nome']); ?></div>
        </td>
        <td>
            <span class="text-muted small"><?php echo htmlspecialchars($loc['detalhe'] ?? '-'); ?></span>
        </td>
        <td>
            <div class="small">
                <span class="fw-medium text-secondary"><i class="fa-regular fa-building me-1"></i><?php echo htmlspecialchars($loc['bloco'] ?? '-'); ?></span><br>
                <span class="text-muted"><i class="fa-solid fa-stairs me-1"></i><?php echo htmlspecialchars($loc['piso'] ?? '-'); ?></span>
            </div>
        </td>
        <td class="text-end text-nowrap">
            <button type="button" class="btn btn-light btn-sm rounded-3 border shadow-none me-1"
                data-bs-toggle="modal" data-bs-target="#modalEditarLocalizacao"
                data-id="<?php echo $loc['id']; ?>"
                data-cod="<?php echo htmlspecialchars($loc['cod_sala']); ?>"
                data-nome="<?php echo htmlspecialchars($loc['nome']); ?>"
                data-detalhe="<?php echo htmlspecialchars($loc['detalhe'] ?? ''); ?>"
                data-piso="<?php echo htmlspecialchars($loc['piso'] ?? ''); ?>"
                data-bloco="<?php echo htmlspecialchars($loc['bloco'] ?? ''); ?>"
                title="Editar Localização">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>
            <button type="button" class="btn btn-light btn-sm rounded-3 border shadow-none hover-danger" onclick="confirmarEliminacao('/sibdas/1241251/gira/private/localizacoes/eliminar_localizacao.php', <?php echo $loc['id']; ?>, 'Tem a certeza de que deseja abater esta localização?', 'Abater Localização')"> <i class="fa-solid fa-trash-can text-danger"></i>
            </button>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
render_footer();
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEditarLoc = document.getElementById('modalEditarLocalizacao');
        if (modalEditarLoc) {
            modalEditarLoc.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;

                // Preenchimento à prova de bala usando IDs!
                document.getElementById('edit_id_localizacao').value = btn.getAttribute('data-id');
                document.getElementById('edit_cod_sala').value = btn.getAttribute('data-cod');
                document.getElementById('edit_nome_sala').value = btn.getAttribute('data-nome');
                document.getElementById('edit_detalhe_sala').value = btn.getAttribute('data-detalhe');
                document.getElementById('edit_piso_sala').value = btn.getAttribute('data-piso');
                document.getElementById('edit_bloco_sala').value = btn.getAttribute('data-bloco');
            });
        }
    });
</script>