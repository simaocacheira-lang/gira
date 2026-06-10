<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Gestão de Fornecedores");

// 2. Ir à base de dados buscar todos os fornecedores
try {
    $stmt = $pdo->query("SELECT * FROM fornecedores ORDER BY nome_empresa ASC");
    $lista_fornecedores = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar fornecedores: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gestão de Fornecedores</h2>
        <p class="text-muted m-0 small">Controlo de contratos, contactos e assistência técnica oficial das marcas parceiras.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarFornecedor">
        <i class="fa-solid fa-truck-field text-white me-2"></i> Registar Fornecedor
    </button>
</div>
<?php if (isset($_GET['erro']) && $_GET['erro'] == 'fornecedor_ocupado'): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-shield-halved me-2"></i>
        <strong>Ação Bloqueada pelo Sistema!</strong> Não podes eliminar este fornecedor porque existem equipamentos no inventário associados a ele. Tens de alterar o fornecedor dessas máquinas primeiro.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação concluída!</strong>
        <?php
        if ($_GET['sucesso'] == 'registado') {
            echo "O novo fornecedor foi registado com sucesso.";
        } elseif ($_GET['sucesso'] == 'editado') {
            echo "Os dados do fornecedor foram atualizados.";
        } elseif ($_GET['sucesso'] == 'eliminado') {
            echo "O fornecedor foi removido do sistema.";
        }
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Tabela
$colunas = [
    ['label' => 'Fornecedor / NIF', 'sort' => 'nif_empresa'],
    ['label' => 'Contacto Técnico'],
    ['label' => 'Categoria Principal'],
    ['label' => 'Estado da Parceria', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

render_table_start($colunas);

// 3. Desenhar os fornecedores reais
foreach ($lista_fornecedores as $forn):
    // Lógica para a cor da etiqueta
    $cor_badge = ($forn['estado'] == 'Ativo') ? 'success' : 'danger';
?>
    <tr>
        <td>
            <div class="fw-bold text-primary"><?php echo htmlspecialchars($forn['nome_empresa']); ?></div>
            <small class="text-muted fw-mono">NIF: <?php echo htmlspecialchars($forn['nif']); ?></small>
        </td>
        <td>
            <?php if (!empty($forn['email_suporte'])): ?>
                <a href="mailto:<?php echo htmlspecialchars($forn['email_suporte']); ?>" class="text-decoration-none">
                    <i class="fa-solid fa-envelope text-muted me-1"></i><?php echo htmlspecialchars($forn['email_suporte']); ?>
                </a>
                <br>
            <?php endif; ?>
            <?php if (!empty($forn['telefone_suporte'])): ?>
                <small class="text-muted"><i class="fa-solid fa-phone me-1"></i><?php echo htmlspecialchars($forn['telefone_suporte']); ?></small>
            <?php endif; ?>
        </td>
        <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2"><?php echo htmlspecialchars($forn['especialidade']); ?></span></td>
        <td><span class="badge bg-<?php echo $cor_badge; ?> bg-opacity-10 text-<?php echo $cor_badge; ?> rounded-pill px-2"><?php echo htmlspecialchars($forn['estado']); ?></span></td>
        <td class="text-end">
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Dados do Fornecedor">
                <button class="btn btn-light btn-sm rounded-3 me-1 border"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditarFornecedor"
                    data-id="<?php echo $forn['id']; ?>"
                    data-nome="<?php echo htmlspecialchars($forn['nome_empresa']); ?>"
                    data-nif="<?php echo htmlspecialchars($forn['nif']); ?>"
                    data-email="<?php echo htmlspecialchars($forn['email_suporte'] ?? ''); ?>"
                    data-telefone="<?php echo htmlspecialchars($forn['telefone_suporte'] ?? ''); ?>"
                    data-especialidade="<?php echo htmlspecialchars($forn['especialidade']); ?>"
                    data-estado="<?php echo htmlspecialchars($forn['estado']); ?>">
                    <i class="fa-solid fa-pen text-primary"></i>
                </button>
            </span>
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
                <a href="/sibdas/1241251/gira/private/fornecedores/eliminar_fornecedor.php?id=<?php echo $forn['id']; ?>"
                    class="btn btn-light btn-sm rounded-3 border"
                    onclick="return confirm('⚠️ ATENÇÃO: Tens a certeza que queres revogar o contrato e eliminar o fornecedor <?php echo htmlspecialchars($forn['nome_empresa']); ?>?');">
                    <i class="fa-solid fa-trash text-danger"></i>
                </a>
            </span>
        </td>
    </tr>
<?php
endforeach;

if (count($lista_fornecedores) === 0):
?>
    <tr>
        <td colspan="5" class="text-center text-muted py-5">
            <i class="fa-solid fa-building fs-1 text-light mb-3"></i><br>
            Ainda não tens fornecedores registados no sistema.
        </td>
    </tr>
<?php
endif;

render_table_end(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEditarForn = document.getElementById('modalEditarFornecedor');
        if (modalEditarForn) {
            modalEditarForn.addEventListener('show.bs.modal', function(event) {
                // 1. Descobrir qual foi o botão clicado
                const button = event.relatedTarget;

                // 2. Extrair os dados
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');
                const nif = button.getAttribute('data-nif');
                const email = button.getAttribute('data-email');
                const telefone = button.getAttribute('data-telefone');
                const especialidade = button.getAttribute('data-especialidade');
                const estado = button.getAttribute('data-estado');

                // 3. Injetar nos campos do formulário (que já tens no teu modals.php)
                const form = document.getElementById('formEditarFornecedor');
                form.querySelector('input[name="id_fornecedor"]').value = id;
                form.querySelector('input[name="nome_empresa"]').value = nome;
                form.querySelector('input[name="nif"]').value = nif;
                form.querySelector('input[name="email_suporte"]').value = email;
                form.querySelector('input[name="telefone_suporte"]').value = telefone;
                form.querySelector('select[name="especialidade"]').value = especialidade;
                form.querySelector('select[name="estado"]').value = estado;
            });
        }
    });
</script>
<?php
render_footer();
?>