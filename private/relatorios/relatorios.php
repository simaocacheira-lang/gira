<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. LÓGICA DINÂMICA: Calcular KPIs Reais do Hospital
try {
    // A) Disponibilidade Geral do Parque
    $stmt_total = $pdo->query("SELECT COUNT(*) FROM equipamentos");
    $total_equipamentos = $stmt_total->fetchColumn();

    $stmt_op = $pdo->query("SELECT COUNT(*) FROM equipamentos WHERE estado = 'Operacional'");
    $equipamentos_op = $stmt_op->fetchColumn();

    $taxa_disponibilidade = ($total_equipamentos > 0) ? round(($equipamentos_op / $total_equipamentos) * 100, 1) : 0;

    // B) Ordens de Trabalho Pendentes vs Concluídas
    $stmt_ots = $pdo->query("SELECT COUNT(*) FROM ordens_trabalho WHERE estado != 'Concluída'");
    $ots_abertas = $stmt_ots->fetchColumn();
} catch (PDOException $e) {
    die("Erro ao carregar indicadores: " . $e->getMessage());
}

render_header("Gira - Relatórios Analíticos e Indicadores");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Centro de Relatórios</h2>
        <p class="text-muted m-0 small">Indicadores de desempenho em tempo real e exportação de dados para Excel/CSV.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Disponibilidade Geral</small>
            <h3 class="fw-bold my-1 text-success"><?php echo $taxa_disponibilidade; ?>%</h3>
            <small class="text-muted" style="font-size: 0.75rem;"><?php echo $equipamentos_op; ?> de <?php echo $total_equipamentos; ?> operacionais</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Manutenções em Curso</small>
            <h3 class="fw-bold my-1 text-warning"><?php echo $ots_abertas; ?> O.T.s</h3>
            <small class="text-muted" style="font-size: 0.75rem;">A aguardar resolução técnica</small>
        </div>
    </div>
</div>

<?php
// Tabela de Relatórios Disponíveis com larguras (width) fixadas
$colunas = [
    ['label' => 'Ref. Relatório', 'width' => '15%'],
    ['label' => 'Designação / Conteúdo', 'width' => '35%'],
    ['label' => 'Módulo', 'width' => '15%'],
    ['label' => 'Formato', 'width' => '15%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '20%']
];

render_table_start($colunas);

// Array estruturado com os relatórios que vamos poder exportar
$relatorios_disponiveis = [
    [
        'ref' => '#REP-INV-01',
        'nome' => 'Inventário Global de Equipamentos',
        'desc' => 'Lista completa do parque tecnológico, marcas, modelos e estados atuais.',
        'modulo' => 'Equipamentos',
        'tipo' => 'inventario'
    ],
    [
        'ref' => '#REP-MAN-01',
        'nome' => 'Histórico Geral de Manutenções',
        'desc' => 'Todas as Ordens de Trabalho (OTs) abertas e concluídas.',
        'modulo' => 'Manutenção',
        'tipo' => 'manutencoes'
    ],
    [
        'ref' => '#REP-ARM-01',
        'nome' => 'Status do Armazém e Ruturas',
        'desc' => 'Exportação do stock atual e alertas de material abaixo do limite mínimo.',
        'modulo' => 'Armazém',
        'tipo' => 'armazem'
    ]
];

foreach ($relatorios_disponiveis as $rep):
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo $rep['ref']; ?></td>
        <td>
            <div class="fw-bold"><?php echo htmlspecialchars($rep['nome']); ?></div>
            <small class="text-muted"><?php echo htmlspecialchars($rep['desc']); ?></small>
        </td>
        <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2"><?php echo $rep['modulo']; ?></span></td>
        <td><span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2"><i class="fa-solid fa-file-csv me-1"></i> CSV / Excel</span></td>
        <td class="text-end text-nowrap">
            <a href="/sibdas/1241251/gira/private/relatorios/exportar_relatorio.php?tipo=<?php echo $rep['tipo']; ?>" class="btn btn-primary btn-sm rounded-3 fw-bold shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Gerar e Descarregar">
                <i class="fa-solid fa-download me-1"></i> Exportar
            </a>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
render_footer();
?>