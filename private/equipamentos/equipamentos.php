<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Inventário de Equipamentos Médicos");

try {
    // 2. QUERY LIMPA: Sem paginação nem filtros de pesquisa manual!
    // O DataTables vai agarrar nestes dados todos e criar a magia no ecrã.
    $sql = "SELECT e.*, 
                   l.cod_sala, 
                   l.nome AS nome_localizacao, 
                   f.nome_empresa 
            FROM equipamentos e 
            LEFT JOIN localizacoes l ON e.localizacao_id = l.id 
            LEFT JOIN fornecedores f ON e.fornecedor_id = f.id 
            ORDER BY e.id DESC";

    $stmt = $pdo->query($sql);
    $lista_equipamentos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar o inventário: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0 text-dark">Equipamentos Médicos</h4>
        <p class="text-muted m-0 small">Gestão centralizada do parque tecnológico e estado operacional.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarEquipamento">
        <i class="fa-solid fa-plus me-2"></i> Registar
    </button>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação Concluída!</strong> O inventário foi atualizado com sucesso.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// A classe mágica que adicionámos no layout.php vai detetar esta tabela
render_table_start([
    ['label' => 'ID Ativo', 'width' => '15%'],
    ['label' => 'Equipamento', 'width' => '30%'],
    ['label' => 'Localização', 'width' => '20%'],
    ['label' => 'Estado', 'width' => '20%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '15%']
]);

foreach ($lista_equipamentos as $eq):
    // Lógica das tuas cores para o ENUM do estado
    $cor_estado = 'success';
    if ($eq['estado'] == 'Inoperacional') $cor_estado = 'danger';
    elseif ($eq['estado'] == 'Manutenção') $cor_estado = 'warning';
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($eq['codigo_ativo']); ?></td>
        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($eq['nome']); ?></div>
            <small class="text-muted"><?php echo htmlspecialchars($eq['modelo']); ?> <span class="mx-1">•</span> SN: <?php echo htmlspecialchars($eq['num_serie']); ?></small>
        </td>
        <td>
            <div class="fw-medium small text-secondary">
                <i class="fa-solid fa-location-dot me-1"></i> <?php echo htmlspecialchars($eq['cod_sala'] ?? 'Sem Sala'); ?>
            </div>
            <small class="text-muted"><?php echo htmlspecialchars($eq['nome_localizacao'] ?? '-'); ?></small>
        </td>
        <td>
            <span class="badge bg-<?php echo $cor_estado; ?> bg-opacity-10 text-<?php echo $cor_estado; ?> border border-<?php echo $cor_estado; ?>-subtle px-2 py-1 rounded-pill">
                <?php echo htmlspecialchars($eq['estado']); ?>
            </span>
        </td>
        <td class="text-end text-nowrap">
            <a href="/sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=<?php echo $eq['id']; ?>" class="btn btn-light btn-sm rounded-3 border shadow-none me-1" data-bs-toggle="tooltip" title="Ver Ficha / Editar">
                <i class="fa-solid fa-folder-open text-primary"></i>
            </a>
            <a href="/sibdas/1241251/gira/private/equipamentos/eliminar_equipamento.php?id=<?php echo $eq['id']; ?>" class="btn btn-light btn-sm rounded-3 border shadow-none" onclick="return confirm('Tem a certeza absoluta que deseja abater este equipamento?');" data-bs-toggle="tooltip" title="Abater Inventário">
                <i class="fa-solid fa-trash-can text-danger"></i>
            </a>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
render_footer();
?>