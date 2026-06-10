<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. LÓGICA DINÂMICA: Buscar os Logs mais recentes
try {
    $sql = "SELECT l.*, u.nome AS nome_utilizador, p.nome_perfil 
            FROM logs_auditoria l
            LEFT JOIN utilizadores u ON l.utilizador_id = u.id
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id
            ORDER BY l.data_hora DESC 
            LIMIT 200";
    $stmt = $pdo->query($sql);
    $lista_logs = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar o histórico de auditoria: " . $e->getMessage());
}

render_header("Gira - Histórico de Atividades e Logs");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Histórico do Sistema</h2>
        <p class="text-muted m-0 small">Registo cronológico de operações, alterações de inventário e acessos de utilizadores para fins de auditoria.</p>
    </div>

    <form action="/sibdas/1241251/gira/private/historico/processar_limpeza.php" method="POST" onsubmit="return confirm('ATENÇÃO: Tem a certeza absoluta que deseja apagar todo o histórico de auditoria? Esta ação é irreversível!');">
        <button type="submit" class="btn btn-light border rounded-3 fw-bold small px-3 py-2 text-danger shadow-sm hover-danger">
            <i class="fa-solid fa-trash-can me-2"></i> Limpar Histórico de Logs
        </button>
    </form>
</div>

<?php
// Definição das colunas SEM a coluna de Ações
$colunas = [
    ['label' => 'Cód. Registo'],
    ['label' => 'Data / Hora'],
    ['label' => 'Utilizador'],
    ['label' => 'Ação / Evento'],
    ['label' => 'Módulo'],
    ['label' => 'IP Origem']
];

render_table_start($colunas);

foreach ($lista_logs as $log):

    $acao_texto = strtolower($log['acao']);

    if (strpos($acao_texto, 'elimin') !== false || strpos($acao_texto, 'apag') !== false || strpos($acao_texto, 'remov') !== false || strpos($acao_texto, 'purga') !== false) {
        $cor = 'danger';
        $icone = 'fa-trash';
    } elseif (strpos($acao_texto, 'criou') !== false || strpos($acao_texto, 'inser') !== false || strpos($acao_texto, 'adicion') !== false) {
        $cor = 'success';
        $icone = 'fa-plus';
    } elseif (strpos($acao_texto, 'atualiz') !== false || strpos($acao_texto, 'edit') !== false || strpos($acao_texto, 'alter') !== false) {
        $cor = 'warning';
        $icone = 'fa-pen';
    } elseif (strpos($acao_texto, 'sessão') !== false || strpos($acao_texto, 'login') !== false) {
        $cor = 'primary';
        $icone = 'fa-right-to-bracket';
    } else {
        $cor = 'secondary';
        $icone = 'fa-circle-info';
    }

    $data_log = date('d/m/Y', strtotime($log['data_hora']));
    $hora_log = date('H:i', strtotime($log['data_hora']));
    $cod_log = '#LOG-' . str_pad($log['id'], 5, '0', STR_PAD_LEFT);
?>
    <tr>
        <td class="fw-bold text-secondary fw-mono"><?php echo $cod_log; ?></td>
        <td>
            <div class="fw-bold text-dark"><?php echo $data_log; ?></div>
            <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> <?php echo $hora_log; ?>h</small>
        </td>
        <td>
            <?php if ($log['nome_utilizador']): ?>
                <div class="fw-bold"><?php echo htmlspecialchars($log['nome_utilizador']); ?></div>
                <small class="text-muted"><?php echo htmlspecialchars($log['nome_perfil'] ?? 'Sem Perfil'); ?></small>
            <?php else: ?>
                <div class="text-muted fst-italic">Sistema / Removido</div>
            <?php endif; ?>
        </td>
        <td>
            <span class="text-<?php echo $cor; ?> fw-medium">
                <i class="fa-solid <?php echo $icone; ?> me-1"></i> <?php echo htmlspecialchars($log['acao']); ?>
            </span>
        </td>
        <td><span class="badge bg-light text-dark border px-2"><?php echo htmlspecialchars($log['modulo']); ?></span></td>
        <td class="fw-mono text-secondary"><?php echo htmlspecialchars($log['ip_origem'] ?? 'Desconhecido'); ?></td>
    </tr>
<?php
endforeach;

// Mensagem ajustada para 6 colunas
if (count($lista_logs) === 0):
?>
    <tr>
        <td colspan="6" class="text-center text-muted py-5">
            <i class="fa-solid fa-clipboard-list fs-1 text-light mb-3"></i><br>
            O histórico de auditoria está limpo.
        </td>
    </tr>
<?php
endif;

render_table_end();
render_footer();
?>