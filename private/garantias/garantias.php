<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. LÓGICA DINÂMICA: Buscar equipamentos que tenham garantia
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
        <h2 class="fw-bold m-0">Garantias e Contratos</h2>
        <p class="text-muted m-0 small">Controlo de coberturas de fábrica, contratos de assistência técnica externa e SLAs de fornecedores.</p>
    </div>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Cód. Ativo', 'sort' => 'id_contrato'],
    ['label' => 'Equipamento / Sistema', 'sort' => 'equipamento'],
    ['label' => 'Fornecedor Oficial', 'sort' => 'fornecedor'],
    ['label' => 'Tipo de Cobertura', 'sort' => 'tipo'],
    ['label' => 'Fim da Garantia', 'sort' => 'data_fim'],
    ['label' => 'Estado', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior
render_table_start($colunas);

// 3. O LOOP MÁGICO
$hoje = new DateTime();
$hoje->setTime(0, 0, 0);

foreach ($equipamentos as $eq):
    // Calcular diferença de dias
    $data_fim = new DateTime($eq['fim_garantia']);
    $data_fim->setTime(0, 0, 0);
    $intervalo = $hoje->diff($data_fim);
    $dias_restantes = (int)$intervalo->format('%R%a');

    // Lógica das Cores
    if ($dias_restantes < 0) {
        $cor = 'danger';
        $estado = 'Expirado';
    } elseif ($dias_restantes <= 60) {
        $cor = 'warning';
        $estado = 'A Expirar';
    } else {
        $cor = 'success';
        $estado = 'Ativo';
    }
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($eq['codigo_ativo']); ?></td>
        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($eq['nome']); ?></div>
            <small class="text-muted"><?php echo htmlspecialchars($eq['modelo']); ?></small>
        </td>
        <td><?php echo htmlspecialchars($eq['nome_empresa'] ?? 'Desconhecido'); ?></td>
        <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Garantia de Fábrica</span></td>
        <td><?php echo date('d/m/Y', strtotime($eq['fim_garantia'])); ?></td>
        <td><span class="badge bg-<?php echo $cor; ?> bg-opacity-10 text-<?php echo $cor; ?> rounded-pill px-2"><?php echo $estado; ?></span></td>
        <td class="text-end">
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Atualizar Data">
                <button class="btn btn-light btn-sm rounded-3 me-1 border"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAdicionarGarantia"
                    data-id="<?php echo $eq['id']; ?>"
                    data-data="<?php echo $eq['fim_garantia']; ?>">
                    <i class="fa-solid fa-pen text-primary"></i>
                </button>
            </span>
        </td>
    </tr>
<?php
endforeach;

if (count($equipamentos) === 0):
?>
    <tr>
        <td colspan="7" class="text-center text-muted py-5">Não há equipamentos registados.</td>
    </tr>
<?php
endif;

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

<?php
// Incluir os modais e fechar
require_once __DIR__ . '/../modals.php';
render_footer();
?>