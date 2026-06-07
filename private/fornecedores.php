<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

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
                <button class="btn btn-light btn-sm rounded-3 me-1 border" onclick="alert('Edição em desenvolvimento!');">
                    <i class="fa-solid fa-pen text-primary"></i>
                </button>
            </span>
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
                <button class="btn btn-light btn-sm rounded-3 text-danger border" onclick="alert('Eliminar em desenvolvimento!');">
                    <i class="fa-solid fa-trash"></i>
                </button>
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

render_table_end();
render_footer();
?>