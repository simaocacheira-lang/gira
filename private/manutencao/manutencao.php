<?php
// 1. Ligar à Base de Dados e chamar o molde
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. O Motor de Busca: Fazer JOIN para juntar as OTs com os dados dos Equipamentos
try {
    $sql = "SELECT ot.*, e.nome AS equip_nome, e.modelo AS equip_modelo 
            FROM ordens_trabalho ot
            LEFT JOIN equipamentos e ON ot.equipamento_id = e.id
            ORDER BY ot.id DESC";
    $stmt = $pdo->query($sql);
    $lista_ots = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar o dashboard de manutenção: " . $e->getMessage());
}

// 3. Montamos o topo da página
render_header("Gira - Ordens de Trabalho e Manutenção");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Ordens de Trabalho e Manutenção</h2>
        <p class="text-muted m-0 small">Acompanhamento de avarias, intervenções corretivas e planos de manutenção preventiva do parque médico.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAbrirOT">
        <i class="fa-solid fa-circle-exclamation me-2"></i> Abrir Ordem de Trabalho
    </button>
</div>

<ul class="nav nav-tabs border-bottom mb-4" id="manutencaoTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista" type="button" role="tab">
            <i class="fa-solid fa-list-check me-2"></i>Intervenções Ativas (Corretivas)
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="calendario-tab" data-bs-toggle="tab" data-bs-target="#calendario" type="button" role="tab">
            <i class="fa-regular fa-calendar-days me-2"></i>Plano Preventivo (Calendário)
        </button>
    </li>
</ul>

<div class="tab-content" id="manutencaoTabsContent">

    <div class="tab-pane fade show active" id="lista" role="tabpanel" tabindex="0">
        <?php
        $colunas = [
            ['label' => 'Nº O.T.', 'sort' => 'id_ot'],
            ['label' => 'Equipamento / Modelo', 'sort' => 'equipamento'],
            ['label' => 'Tipo de Intervenção', 'sort' => 'tipo_manutencao'],
            ['label' => 'Prioridade', 'sort' => 'prioridade'],
            ['label' => 'Abertura', 'sort' => 'data_abertura'],
            ['label' => 'Estado', 'sort' => 'status'],
            ['label' => 'Ações Técnicas', 'align' => 'end']
        ];

        render_table_start($colunas);

        // =======================================================
        // O LOOP DINÂMICO QUE SUBSTITUI OS EXEMPLOS ESTÁTICOS
        // =======================================================
        foreach ($lista_ots as $ot):
            // 1. Lógica para as cores do Tipo de Intervenção
            $tipo_badge = 'secondary';
            if (strpos($ot['tipo_manutencao'], 'Corretiva') !== false) $tipo_badge = 'danger';
            elseif (strpos($ot['tipo_manutencao'], 'Preventiva') !== false) $tipo_badge = 'success';

            // 2. Lógica para as cores da Prioridade
            $prioridade_icon = '';
            $prioridade_class = 'text-muted fw-medium';
            if ($ot['prioridade'] == 'Crítica') {
                $prioridade_class = 'text-danger fw-bold';
                $prioridade_icon = '<i class="fa-solid fa-triangle-exclamation me-1"></i>';
            } elseif ($ot['prioridade'] == 'Alta') {
                $prioridade_class = 'text-warning fw-bold';
            }

            // 3. Lógica para as cores do Estado (Assumindo 'Pendente' se não existir ainda)
            $estado_atual = isset($ot['estado']) ? $ot['estado'] : 'Pendente';
            $estado_badge = 'danger text-white';
            if ($estado_atual == 'Em Curso') $estado_badge = 'warning text-dark';
            elseif ($estado_atual == 'Concluída') $estado_badge = 'light text-muted border';

            // 4. Formatação de Data
            $data_abertura = isset($ot['data_abertura']) ? date('d/m/Y', strtotime($ot['data_abertura'])) : date('d/m/Y');
        ?>
            <tr>
                <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($ot['numero_ot']); ?></td>
                <td>
                    <div class="fw-bold"><?php echo htmlspecialchars($ot['equip_nome']); ?></div>
                    <small class="text-muted"><i class="fa-solid fa-industry me-1"></i><?php echo htmlspecialchars($ot['equip_modelo']); ?></small>
                </td>
                <td><span class="badge bg-<?php echo $tipo_badge; ?> bg-opacity-10 text-<?php echo $tipo_badge; ?> border border-<?php echo $tipo_badge; ?>-subtle px-2"><?php echo htmlspecialchars($ot['tipo_manutencao']); ?></span></td>
                <td><span class="<?php echo $prioridade_class; ?>"><?php echo $prioridade_icon . htmlspecialchars($ot['prioridade']); ?></span></td>
                <td><?php echo $data_abertura; ?></td>
                <td><span class="badge bg-<?php echo $estado_badge; ?> rounded-pill px-2"><?php echo htmlspecialchars($estado_atual); ?></span></td>
                <td class="text-end">
                    <?php if ($estado_atual != 'Concluída'): ?>
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Gerir / Fechar Ordem">
                            <button class="btn btn-light btn-sm rounded-3 me-1 border btn-fechar-ot hover-success"
                                data-bs-toggle="modal"
                                data-bs-target="#modalFecharOT"
                                data-id="<?php echo $ot['id']; ?>"
                                data-numero="<?php echo htmlspecialchars($ot['numero_ot']); ?>"
                                data-equipamento="<?php echo $ot['equipamento_id']; ?>">
                                <i class="fa-solid fa-check text-success"></i>
                            </button>
                        </span>
                    <?php endif; ?>

                    <form action="/sibdas/1241251/gira/private/manutencao/eliminar_ot.php?id=<?php echo $ot['id']; ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem a certeza que deseja cancelar e eliminar a O.T. <?php echo htmlspecialchars($ot['numero_ot']); ?>? Esta ação não pode ser desfeita.');">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar O.T.">
                            <button type="submit" class="btn btn-light btn-sm rounded-3 text-danger border hover-danger">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </span>
                    </form>
                </td>
            </tr>
        <?php
        endforeach;

        if (count($lista_ots) === 0):
        ?>
            <tr>
                <td colspan="7" class="text-center text-muted py-5">
                    <i class="fa-solid fa-clipboard-check fs-1 text-light mb-3"></i><br>
                    Tudo operacional! Não existem Ordens de Trabalho pendentes.
                </td>
            </tr>
        <?php
        endif;

        render_table_end();
        ?>
    </div>

    <div class="tab-pane fade" id="calendario" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark m-0">Maio 2026</h5>
                <p class="text-muted small mt-4"><em>(Visualização do Calendário Estática para Efeitos de Design)</em></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalFecharOT = document.getElementById('modalFecharOT');
        if (modalFecharOT) {
            modalFecharOT.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                // Apanhar os dados
                const idOt = button.getAttribute('data-id');
                const numOt = button.getAttribute('data-numero');
                const idEquip = button.getAttribute('data-equipamento');

                // Preencher o modal
                document.getElementById('fecho_id_ot').value = idOt;
                document.getElementById('fecho_id_equipamento').value = idEquip;
                document.getElementById('fecho_numero_ot').textContent = numOt;
            });
        }
    });
</script>
<?php
// IMPORTAR TODOS OS MODAIS ANTES DO RODAPÉ
require_once __DIR__ . '/../modals.php';

render_footer(); ?>