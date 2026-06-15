<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Relatórios Analíticos e Indicadores");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Centro de Relatórios</h2>
        <p class="text-muted m-0 small">Indicadores de desempenho em tempo real e exportação de dados para Excel/CSV.</p>
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
            <a href="/sibdas/1241251/gira/private/relatorios/exportar_relatorio.php?tipo=<?php echo $rep['tipo']; ?>" class="btn btn-primary btn-sm rounded-3 fw-bold shadow-sm text-white" style="color: #ffffff !important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Gerar e Descarregar">
                <i class="fa-solid fa-download me-1" style="color: #ffffff !important;"></i> <span style="color: #ffffff !important;">Exportar</span>
            </a>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
render_footer();
?>