<?php
// 1. Chamamos o molde
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. Consulta à Base de Dados: Juntar os documentos com o nome do equipamento correspondente
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
        <h2 class="fw-bold m-0">Repositório de Documentos</h2>
        <p class="text-muted m-0 small">Arquivo centralizado de manuais de utilizador, certificados de calibração e relatórios de conformidade.</p>
    </div>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação concluída!</strong> O documento foi carregado e guardado com sucesso.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
$colunas = [
    ['label' => 'Nome do Documento / Ficheiro'],
    ['label' => 'Tipo'],
    ['label' => 'Dispositivo Associado'],
    ['label' => 'Data de Registo'],
    ['label' => 'Ações', 'align' => 'end']
];

render_table_start($colunas);

foreach ($lista_documentos as $doc):
    // Lógica para ícones consoante o tipo de extensão do ficheiro
    $extensao = pathinfo($doc['caminho_ficheiro'], PATHINFO_EXTENSION);
    $icone_file = ($extensao == 'pdf') ? 'fa-file-pdf text-danger' : 'fa-file-image text-primary';
?>
    <tr>
        <td>
            <div class="fw-bold"><i class="fa-regular <?php echo $icone_file; ?> me-2 fs-5 align-middle"></i><?php echo htmlspecialchars($doc['nome_documento']); ?></div>
            <small class="text-muted"><?php echo basename($doc['caminho_ficheiro']); ?></small>
        </td>
        <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2"><?php echo htmlspecialchars($doc['tipo_documento']); ?></span></td>
        <td>
            <?php if (!empty($doc['codigo_ativo'])): ?>
                <span class="fw-mono fw-bold text-primary"><?php echo htmlspecialchars($doc['codigo_ativo']); ?></span><br>
                <small class="text-muted"><?php echo htmlspecialchars($doc['equipamento_nome']); ?></small>
            <?php else: ?>
                <em class="text-muted">Documento Geral</em>
            <?php endif; ?>
        </td>
        <td class="text-secondary"><?php echo date('d/m/Y', strtotime($doc['data_upload'])); ?></td>
        <td class="text-end">
            <!-- LINK DE DOWNLOAD REAL -->
            <a href="/gira/private/<?php echo htmlspecialchars($doc['caminho_ficheiro']); ?>" target="_blank" class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Abrir / Descarregar">
                <i class="fa-solid fa-download text-primary"></i>
            </a>
            <button class="btn btn-light btn-sm rounded-3 text-danger border" onclick="alert('Função de apagar documento em desenvolvimento!');">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    </tr>
<?php
endforeach;

if (count($lista_documentos) === 0):
?>
    <tr>
        <td colspan="5" class="text-center text-muted py-5">
            <i class="fa-solid fa-folder-open fs-1 text-light mb-3"></i><br>
            Ainda não fizeste upload de nenhum documento técnico.
        </td>
    </tr>
<?php
endif;

render_table_end();
render_footer();
?>