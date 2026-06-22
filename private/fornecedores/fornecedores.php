<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Gestão de Fornecedores");

try {
    // 2. EXTRAÇÃO LIMPA
    $fornecedores = obterTodosFornecedores($pdo);
} catch (PDOException $e) {
    die("Erro ao carregar a lista de fornecedores: " . $e->getMessage());
}

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0 text-dark">Fornecedores</h4>
        <p class="text-muted m-0 small">Gestão de entidades parceiras e contratos.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarFornecedor">
        <i class="fa-solid fa-plus me-2"></i> Registar
    </button>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação Concluída!</strong> A base de dados de fornecedores foi atualizada.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Correção do 'text' para 'label' efetuada!
render_table_start([
    ['label' => 'ID', 'width' => '5%'],
    ['label' => 'Empresa / NIF', 'width' => '30%'],
    ['label' => 'Especialidade', 'width' => '20%'],
    ['label' => 'Contactos', 'width' => '25%'],
    ['label' => 'Estado', 'width' => '10%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '10%']
]);

foreach ($fornecedores as $f):
    // Lógica para as cores da badge de estado
    $cor_estado = ($f['estado'] === 'Ativo') ? 'success' : 'danger';
?>
    <tr>
        <td class="fw-bold text-muted">#<?php echo htmlspecialchars($f['id']); ?></td>
        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($f['nome_empresa']); ?></div>
            <small class="text-muted">NIF: <?php echo htmlspecialchars($f['nif']); ?></small>
        </td>
        <td>
            <div class="fw-medium text-secondary small">
                <?php echo htmlspecialchars($f['especialidade']); ?>
            </div>
        </td>
        <td>
            <div class="small">
                <?php if (!empty($f['email_suporte'])) echo '<i class="fa-solid fa-envelope text-muted me-1"></i>' . htmlspecialchars($f['email_suporte']) . '<br>'; ?>
                <?php if (!empty($f['telefone_suporte'])) echo '<i class="fa-solid fa-phone text-muted me-1"></i>' . htmlspecialchars($f['telefone_suporte']); ?>
            </div>
        </td>
        <td>
            <span class="badge bg-<?php echo $cor_estado; ?> bg-opacity-10 text-<?php echo $cor_estado; ?> border border-<?php echo $cor_estado; ?>-subtle px-2 py-1 rounded-pill">
                <?php echo htmlspecialchars($f['estado']); ?>
            </span>
        </td>
        <td class="text-end text-nowrap">
            <button type="button" class="btn btn-light btn-sm rounded-3 border shadow-none me-1"
                data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor"
                data-id="<?php echo $f['id']; ?>"
                data-nome="<?php echo htmlspecialchars($f['nome_empresa']); ?>"
                data-nif="<?php echo htmlspecialchars($f['nif']); ?>"
                data-email="<?php echo htmlspecialchars($f['email_suporte']); ?>"
                data-telefone="<?php echo htmlspecialchars($f['telefone_suporte']); ?>"
                data-especialidade="<?php echo htmlspecialchars($f['especialidade']); ?>"
                data-estado="<?php echo htmlspecialchars($f['estado']); ?>"
                title="Editar Fornecedor">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>
            <button type="button" class="btn btn-light btn-sm rounded-3 border shadow-none hover-danger" onclick="confirmarEliminacao('/sibdas/1241251/gira/private/fornecedores/eliminar_fornecedor.php?id=<?php echo $f['id']; ?>', 'Tem a certeza de que deseja abater este fornecedor?', 'Abater Fornecedor')" data-bs-toggle="tooltip" title="Abater Fornecedor">
                <i class="fa-solid fa-trash-can text-danger"></i>
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
        const modalEditar = document.getElementById('modalEditarFornecedor');
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                modalEditar.querySelector('[name="id_fornecedor"]').value = btn.getAttribute('data-id');
                modalEditar.querySelector('[name="nome_empresa"]').value = btn.getAttribute('data-nome');
                modalEditar.querySelector('[name="nif"]').value = btn.getAttribute('data-nif');
                modalEditar.querySelector('[name="email_suporte"]').value = btn.getAttribute('data-email');
                modalEditar.querySelector('[name="telefone_suporte"]').value = btn.getAttribute('data-telefone');
                modalEditar.querySelector('[name="especialidade"]').value = btn.getAttribute('data-especialidade');
                modalEditar.querySelector('[name="estado"]').value = btn.getAttribute('data-estado');
            });
        }
    });
</script>