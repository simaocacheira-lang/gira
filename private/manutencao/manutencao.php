<?php
// 1. Ligar à Base de Dados e chamar o molde
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. EXTRAÇÃO LIMPA (MVC): OTs e Preventivas
try {
    $lista_ots = obterOrdensTrabalho($pdo);
    $lista_preventiva = obterRevisoesPreventivas($pdo);
} catch (PDOException $e) {
    die("Erro ao carregar o dashboard de manutenção: " . $e->getMessage());
}

try {
    // Buscar equipamentos que tenham uma data de revisão definida
    $sql_prev = "SELECT e.id, e.codigo_ativo, e.nome, e.proxima_revisao, l.cod_sala 
                 FROM equipamentos e 
                 LEFT JOIN localizacoes l ON e.localizacao_id = l.id 
                 WHERE e.proxima_revisao IS NOT NULL AND e.apagado_em IS NULL 
                 ORDER BY e.proxima_revisao ASC";
    $stmt_prev = $pdo->query($sql_prev);
    $lista_preventiva = $stmt_prev->fetchAll();

    // =======================================================
    // CONVERTER DADOS PARA O FULLCALENDAR (JSON)
    // =======================================================
    $eventos_calendario = [];
    foreach ($lista_preventiva as $prev) {
        $hoje = strtotime(date('Y-m-d'));
        $data_revisao = strtotime($prev['proxima_revisao']);
        $dias_em_falta = round(($data_revisao - $hoje) / (60 * 60 * 24));

        // Cores do Bootstrap em Hexadecimal
        $cor_evento = '#198754'; // Verde (No prazo)
        if ($dias_em_falta < 0) {
            $cor_evento = '#dc3545'; // Vermelho (Atrasado)
        } elseif ($dias_em_falta <= 15) {
            $cor_evento = '#ffc107'; // Amarelo/Laranja (Urgente)
        }

        $eventos_calendario[] = [
            'title' => $prev['codigo_ativo'] . ' - ' . $prev['nome'],
            'start' => $prev['proxima_revisao'],
            'url'   => '/sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=' . $prev['id'] . '&tab=manutencao',
            'color' => $cor_evento
        ];
    }
    $json_eventos = json_encode($eventos_calendario);
} catch (PDOException $e) {
    die("Erro ao carregar o plano preventivo: " . $e->getMessage());
}

// 3. Montamos o topo da página
render_header("Gira - Ordens de Trabalho e Manutenção");
?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação Concluída!</strong>
        <?php
        if ($_GET['sucesso'] == 'ot_criada') echo "A nova Ordem de Trabalho foi emitida com sucesso.";
        elseif ($_GET['sucesso'] == 'ot_fechada') echo "A Ordem de Trabalho foi encerrada e o relatório técnico guardado.";
        elseif ($_GET['sucesso'] == 'ot_eliminada') echo "A Ordem de Trabalho foi cancelada e removida do sistema.";
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

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
            ['label' => 'Nº O.T.', 'width' => '10%'],
            ['label' => 'Equipamento / Modelo', 'width' => '25%'],
            ['label' => 'Tipo de Intervenção', 'width' => '15%'],
            ['label' => 'Prioridade', 'width' => '10%'],
            ['label' => 'Abertura', 'width' => '10%'],
            ['label' => 'Estado', 'width' => '10%'],
            ['label' => 'Ações Técnicas', 'align' => 'end', 'width' => '20%']
        ];

        render_table_start($colunas);

        // =======================================================
        // O LOOP DINÂMICO DA TABELA
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

            // 3. Lógica para as cores do Estado
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

                <td class="text-end text-nowrap">
                    <?php if ($estado_atual != 'Concluída'): ?>
                        <button class="btn btn-light btn-sm rounded-3 me-1 border btn-fechar-ot hover-success"
                            data-bs-toggle="modal"
                            data-bs-target="#modalFecharOT"
                            data-id="<?php echo $ot['id']; ?>"
                            data-numero="<?php echo htmlspecialchars($ot['numero_ot']); ?>"
                            data-equipamento="<?php echo $ot['equipamento_id']; ?>"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Gerir / Fechar Ordem">
                            <i class="fa-solid fa-check text-success"></i>
                        </button>
                    <?php endif; ?>

                    <button type="button" class="btn btn-light btn-sm rounded-3 border hover-danger"
                        onclick="confirmarEliminacao('/sibdas/1241251/gira/private/manutencao/eliminar_ot.php?id=<?php echo $ot['id']; ?>', 'Tem a certeza que deseja cancelar e eliminar a O.T. <?php echo htmlspecialchars($ot['numero_ot']); ?>? Esta ação não pode ser desfeita.', 'Cancelar Ordem de Trabalho')"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar O.T.">
                        <i class="fa-solid fa-trash-can text-danger"></i>
                    </button>
                </td>
            </tr>
        <?php
        endforeach;

        render_table_end();
        ?>
    </div>

    <div class="tab-pane fade" id="calendario" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-dark mb-4"><i class="fa-solid fa-calendar-days text-primary me-2"></i>Calendário de Intervenções Preventivas</h5>

            <div id="calendario-preventivo"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inicializar o FullCalendar
        var calendarEl = document.getElementById('calendario-preventivo');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                list: 'Lista'
            },
            events: <?php echo $json_eventos; ?>,
            eventClick: function(info) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            }
        });

        // 2. Truque para renderizar o calendário corretamente ao mudar de aba
        var tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabs.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function(event) {
                if (event.target.getAttribute('data-bs-target') === '#calendario') {
                    calendar.render();
                }
            });
        });

        // 3. Lógica original do Modal de Fechar O.T.
        const modalFecharOT = document.getElementById('modalFecharOT');
        if (modalFecharOT) {
            modalFecharOT.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const idOt = button.getAttribute('data-id');
                const numOt = button.getAttribute('data-numero');
                const idEquip = button.getAttribute('data-equipamento');

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