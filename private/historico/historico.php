<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. LÓGICA DINÂMICA: Buscar os Logs
try {
    $sql = "SELECT l.*, u.nome AS nome_utilizador, p.nome_perfil 
            FROM logs_auditoria l
            LEFT JOIN utilizadores u ON l.utilizador_id = u.id
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id
            ORDER BY l.data_hora DESC";
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

    <form action="/sibdas/1241251/gira/private/historico/processar_limpeza.php" method="POST" onsubmit="return confirm('ATENÇÃO: Tem a certeza de que deseja apagar todo o histórico de auditoria? Esta ação é irreversível!');">
        <button type="submit" class="btn btn-light border rounded-3 fw-bold small px-3 py-2 text-danger shadow-sm hover-danger">
            <i class="fa-solid fa-trash-can me-2"></i> Limpar Histórico de Logs
        </button>
    </form>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação Concluída!</strong>
        <?php
        if ($_GET['sucesso'] == 'restaurado') echo "O registo foi restaurado com sucesso e já se encontra novamente ativo no sistema.";
        elseif ($_GET['sucesso'] == 'limpeza') echo "O histórico foi purgado.";
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Definição das colunas agora com o botão de ações!
$colunas = [
    ['label' => 'Cód. Registo', 'width' => '10%'],
    ['label' => 'Data / Hora', 'width' => '15%'],
    ['label' => 'Utilizador', 'width' => '20%'],
    ['label' => 'Ação / Evento', 'width' => '25%'],
    ['label' => 'Módulo', 'width' => '10%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '10%']
];

render_table_start($colunas);

foreach ($lista_logs as $log):

    $acao_texto = strtolower($log['acao']);

    if (strpos($acao_texto, 'elimin') !== false || strpos($acao_texto, 'apag') !== false || strpos($acao_texto, 'remov') !== false || strpos($acao_texto, 'abateu') !== false) {
        $cor = 'danger';
        $icone = 'fa-trash';
    } elseif (strpos($acao_texto, 'criou') !== false || strpos($acao_texto, 'inser') !== false || strpos($acao_texto, 'adicion') !== false || strpos($acao_texto, 'registou') !== false) {
        $cor = 'success';
        $icone = 'fa-plus';
    } elseif (strpos($acao_texto, 'atualiz') !== false || strpos($acao_texto, 'edit') !== false || strpos($acao_texto, 'alter') !== false || strpos($acao_texto, 'restaurou') !== false) {
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

    // =========================================================================
    // NOVA LÓGICA INTELIGENTE DO BOTÃO DE RESTAURO
    // =========================================================================
    $mostrar_restauro = false;
    if ($cor === 'danger' && !empty($log['tabela_afetada']) && !empty($log['registo_id'])) {
        $tabela_alvo = $log['tabela_afetada'];
        $id_alvo = (int) $log['registo_id'];
        $tabelas_permitidas = ['equipamentos', 'utilizadores', 'perfis_acesso', 'ordens_trabalho', 'documentos_equipamento', 'fornecedores', 'localizacoes', 'artigos_armazem'];

        // Vai à base de dados confirmar se a linha AINDA está com Soft Delete ativo
        if (in_array($tabela_alvo, $tabelas_permitidas)) {
            $stmt_check = $pdo->query("SELECT apagado_em FROM $tabela_alvo WHERE id = $id_alvo");
            $resultado = $stmt_check->fetch(PDO::FETCH_ASSOC);

            // Se o registo existir e a data de eliminação NÃO estiver nula, então pode ser restaurado
            if ($resultado && !empty($resultado['apagado_em'])) {
                $mostrar_restauro = true;
            }
        }
    }
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

        <td class="text-end text-nowrap">
            <?php if ($mostrar_restauro): ?>
                <a href="/sibdas/1241251/gira/private/historico/restaurar_registo.php?tabela=<?php echo urlencode($log['tabela_afetada']); ?>&id=<?php echo $log['registo_id']; ?>"
                    class="btn btn-success btn-sm rounded-3 shadow-sm px-3 fw-bold text-decoration-none"
                    style="color: #ffffff !important;"
                    onclick="return confirm('Tem a certeza que deseja restaurar este registo para o sistema?');">
                    <i class="fa-solid fa-clock-rotate-left me-1" style="color: #ffffff !important;"></i> Restaurar
                </a>
            <?php elseif ($cor === 'danger' && !empty($log['tabela_afetada'])): ?>
                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1"><i class="fa-solid fa-check me-1"></i> Restaurado</span>
            <?php else: ?>
                <span class="text-muted small fst-italic">-</span>
            <?php endif; ?>
        </td>
    </tr>
<?php
endforeach;

render_table_end();
render_footer();
?>