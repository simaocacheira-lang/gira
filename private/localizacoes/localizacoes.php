<?php
// 1. Chamamos a base de dados e o molde
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

render_header("Gira - Gestão de Localizações");

// 2. Consulta Nível Pro: Vai buscar as salas e CONTA os equipamentos que lá estão
try {
    $sql = "SELECT l.*, COUNT(e.id) as total_equipamentos 
            FROM localizacoes l 
            LEFT JOIN equipamentos e ON l.id = e.localizacao_id 
            GROUP BY l.id 
            ORDER BY l.nome ASC";
    $stmt = $pdo->query($sql);
    $lista_locais = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar localizações: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gestão de Localizações Hospitalares</h2>
        <p class="text-muted m-0 small">Mapeamento de blocos, pisos e salas para rastreabilidade dos dispositivos médicos.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaLocalizacao">
        <i class="fa-solid fa-location-dot me-2"></i> Nova Localização
    </button>
</div>
<?php if (isset($_GET['erro']) && $_GET['erro'] == 'sala_ocupada'): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-shield-halved me-2"></i>
        <strong>Ação Bloqueada pelo Sistema!</strong> Não podes apagar esta localização porque ainda tem equipamentos médicos alocados a ela. Transfere-os primeiro para outra sala.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php
$colunas = [
    ['label' => 'Cód. Espaço', 'sort' => 'id_localizacao'],
    ['label' => 'Designação / Serviço', 'sort' => 'nome'],
    ['label' => 'Edifício / Bloco'],
    ['label' => 'Equip. Alocados'],
    ['label' => 'Estado da Sala'],
    ['label' => 'Ações', 'align' => 'end']
];

render_table_start($colunas);

// 3. O Loop que desenha o teu HTML as vezes necessárias
foreach ($lista_locais as $loc):
?>
    <tr>
        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($loc['cod_sala']); ?></td>
        <td>
            <div class="fw-bold"><?php echo htmlspecialchars($loc['nome']); ?></div>
            <small class="text-muted"><?php echo !empty($loc['detalhe']) ? htmlspecialchars($loc['detalhe']) : 'Sem sub-sala definida'; ?></small>
        </td>
        <td class="text-secondary">
            <?php
            // Mostra o Piso e o Bloco, ou um traço se estiver vazio
            if (!empty($loc['piso']) || !empty($loc['bloco'])) {
                echo htmlspecialchars($loc['piso'] . ' · ' . $loc['bloco']);
            } else {
                echo '<em class="text-muted">-</em>';
            }
            ?>
        </td>
        <td><span class="fw-bold text-primary"><?php echo $loc['total_equipamentos']; ?> equipamentos</span></td>
        <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Operacional</span></td>
        <td class="text-end">
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Espaço/Sala">
                <button class="btn btn-light btn-sm rounded-3 me-1 border"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditarLocalizacao"
                    data-id="<?php echo $loc['id']; ?>"
                    data-cod="<?php echo htmlspecialchars($loc['cod_sala']); ?>"
                    data-nome="<?php echo htmlspecialchars($loc['nome']); ?>"
                    data-detalhe="<?php echo htmlspecialchars($loc['detalhe'] ?? ''); ?>"
                    data-piso="<?php echo htmlspecialchars($loc['piso'] ?? ''); ?>"
                    data-bloco="<?php echo htmlspecialchars($loc['bloco'] ?? ''); ?>">
                    <i class="fa-solid fa-pen text-primary"></i>
                </button>
            </span>
            <a href="/gira/private/localizacoes/eliminar_localizacao.php?id=<?php echo $loc['id']; ?>"
                class="btn btn-light btn-sm rounded-3 border"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Remover Localização"
                onclick="return confirm('⚠️ ATENÇÃO: Tens a certeza que queres eliminar o espaço <?php echo htmlspecialchars($loc['cod_sala']); ?>?');">
                <i class="fa-solid fa-trash text-danger"></i>
            </a>
        </td>
    </tr>

    <script>
        // Este código fica à escuta. Quando o modal de edição estiver prestes a abrir...
        document.addEventListener('DOMContentLoaded', function() {
            const modalEditar = document.getElementById('modalEditarLocalizacao');
            if (modalEditar) {
                modalEditar.addEventListener('show.bs.modal', function(event) {
                    // 1. Descobrir qual foi o botão exato em que o utilizador clicou
                    const button = event.relatedTarget;

                    // 2. Abrir as "mochilas" e tirar os dados
                    const id = button.getAttribute('data-id');
                    const cod = button.getAttribute('data-cod');
                    const nome = button.getAttribute('data-nome');
                    const detalhe = button.getAttribute('data-detalhe');
                    const piso = button.getAttribute('data-piso');
                    const bloco = button.getAttribute('data-bloco');

                    // 3. Injetar esses dados nas caixas de texto do formulário do modal
                    const form = document.getElementById('formEditarLocalizacao');
                    form.querySelector('input[name="id_localizacao"]').value = id;
                    form.querySelector('input[name="cod_sala"]').value = cod;
                    form.querySelector('input[name="nome"]').value = nome;
                    form.querySelector('input[name="detalhe"]').value = detalhe;
                    form.querySelector('select[name="piso"]').value = piso;
                    form.querySelector('select[name="bloco"]').value = bloco;
                });
            }
        });
    </script>
<?php
endforeach;

// 4. Mensagem caso a base de dados esteja vazia
if (count($lista_locais) === 0):
?>
    <tr>
        <td colspan="6" class="text-center text-muted py-5">
            <i class="fa-solid fa-map-location-dot fs-1 text-light mb-3"></i><br>
            Ainda não tens localizações mapeadas no hospital.
        </td>
    </tr>
<?php
endif;

render_table_end();
render_footer();
?>