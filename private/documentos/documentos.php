<?php
// 1. Chamamos o molde e a ligação à base de dados
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. QUERY LIMPA: Apenas o SELECT com o JOIN, sem LIMITs nem offsets
try {
    $sql = "SELECT d.*, e.codigo_ativo, e.nome AS equipamento_nome 
            FROM documentos_equipamento d
            LEFT JOIN equipamentos e ON d.equipamento_id = e.id
            ORDER BY d.data_upload DESC";
    $stmt = $pdo->query($sql);
    $lista_documentos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar documentos: " . $e->getMessage());
}

render_header("Gira - Gestão de Documentos Técnicos");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0 text-dark">Repositório de Documentos</h2>
        <p class="text-muted m-0 small">Arquivo centralizado de manuais de utilizador, certificados de calibração e relatórios de conformidade.</p>
    </div>

    <button type="button" class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoDocumento">
        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Upload Ficheiro
    </button>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação concluída!</strong> O documento foi carregado com sucesso.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Aqui está a correção do ERRO do DataTables! 
// Garantimos exatamente 5 'labels' e ajustamos as larguras.
render_table_start([
    ['label' => 'Nome do Documento', 'width' => '30%'],
    ['label' => 'Tipo', 'width' => '15%'],
    ['label' => 'Equipamento Associado', 'width' => '25%'],
    ['label' => 'Data Upload', 'width' => '15%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '15%']
]);

foreach ($lista_documentos as $doc):
?>
    <tr>
        <td>
            <div class="fw-bold text-dark text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($doc['nome_documento']); ?>">
                <i class="fa-regular fa-file-pdf text-danger me-2"></i><?php echo htmlspecialchars($doc['nome_documento']); ?>
            </div>
        </td>
        <td>
            <span class="badge bg-light text-secondary border border-secondary-subtle px-2">
                <?php echo htmlspecialchars($doc['tipo_documento']); ?>
            </span>
        </td>
        <td>
            <?php if (!empty($doc['equipamento_id'])): ?>
                <span class="fw-mono fw-bold text-primary"><?php echo htmlspecialchars($doc['codigo_ativo']); ?></span><br>
                <small class="text-muted"><?php echo htmlspecialchars($doc['equipamento_nome']); ?></small>
            <?php else: ?>
                <em class="text-muted small">Documento Geral</em>
            <?php endif; ?>
        </td>
        <td class="text-secondary small fw-medium">
            <?php echo date('d/m/Y', strtotime($doc['data_upload'])); ?>
        </td>
        <td class="text-end text-nowrap">
            <a href="/sibdas/1241251/gira/private/<?php echo htmlspecialchars($doc['caminho_ficheiro']); ?>" target="_blank" class="btn btn-light btn-sm rounded-3 border shadow-none me-1" data-bs-toggle="tooltip" title="Abrir / Descarregar">
                <i class="fa-solid fa-download text-primary"></i>
            </a>
            <button class="btn btn-light btn-sm rounded-3 border shadow-none" onclick="alert('Função de apagar documento em desenvolvimento!');" data-bs-toggle="tooltip" title="Remover Documento">
                <i class="fa-solid fa-trash-can text-danger"></i>
            </button>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
render_footer();
?>