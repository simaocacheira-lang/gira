<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Utilizadores e Acessos");

// ============================================================================
// LÓGICA DINÂMICA: Buscar Utilizadores à Base de Dados
// ============================================================================
try {
    $sql = "SELECT u.*, p.nome_perfil 
            FROM utilizadores u
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id
            ORDER BY u.id DESC";
    $stmt = $pdo->query($sql);
    $lista_utilizadores = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar os utilizadores: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Utilizadores do Sistema</h2>
        <p class="text-muted m-0 small">Controlo de contas de operadores, credenciais de acesso técnico e estado das sessões.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCriarUtilizador">
        <i class="fa-solid fa-user-plus me-2"></i> Criar Utilizador
    </button>
</div>
<?php if (isset($_GET['erro']) && $_GET['erro'] == 'auto_eliminacao'): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-shield-halved me-2"></i><strong>Ação Bloqueada!</strong> Não podes eliminar a conta com que tens a sessão iniciada.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Ação concluída!</strong>
        <?php
        if ($_GET['sucesso'] == 'utilizador_criado') echo "O novo utilizador foi registado.";
        if ($_GET['sucesso'] == 'utilizador_editado') echo "Os dados do utilizador foram atualizados.";
        if ($_GET['sucesso'] == 'utilizador_eliminado') echo "O utilizador foi removido do sistema.";
        if ($_GET['sucesso'] == 'estado_alterado') echo "O estado de acesso do utilizador foi modificado.";
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php
// Definimos as colunas da tabela
$colunas = [
    ['label' => 'Utilizador / Identificação', 'sort' => 'nome'],
    ['label' => 'E-mail', 'sort' => 'email'],
    ['label' => 'Cédula', 'sort' => 'cedula'],
    ['label' => 'Perfil de Acesso', 'sort' => 'perfil'],
    ['label' => 'Registo', 'sort' => 'data_criacao'],
    ['label' => 'Estado', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

// Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);

// ============================================================================
// O LOOP: Desenhar uma linha por cada utilizador encontrado na BD
// ============================================================================
foreach ($lista_utilizadores as $user):

    // Lógica das cores dos Perfis
    $badge_perfil = 'secondary';
    if (strpos(strtolower($user['nome_perfil']), 'admin') !== false) $badge_perfil = 'danger';
    elseif (strpos(strtolower($user['nome_perfil']), 'engenheiro') !== false) $badge_perfil = 'primary';
    elseif (strpos(strtolower($user['nome_perfil']), 'técnico') !== false) $badge_perfil = 'info';

    // Lógica das cores do Estado
    $badge_estado = ($user['estado'] == 'Ativo') ? 'success' : 'danger';
?>
    <tr>
        <td>
            <div class="d-flex align-items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['nome']); ?>&background=random&color=fff&rounded=true" alt="Avatar" width="38" height="38" class="shadow-sm">
                <div>
                    <div class="fw-bold"><?php echo htmlspecialchars($user['nome']); ?></div>
                </div>
            </div>
        </td>
        <td class="fw-mono text-secondary"><?php echo htmlspecialchars($user['email']); ?></td>
        <td class="fw-mono"><?php echo !empty($user['cedula']) ? htmlspecialchars($user['cedula']) : '<em class="text-muted small">Sem cédula</em>'; ?></td>
        <td>
            <span class="badge bg-<?php echo $badge_perfil; ?> bg-opacity-10 text-<?php echo $badge_perfil; ?> border border-<?php echo $badge_perfil; ?>-subtle px-2">
                <?php echo htmlspecialchars($user['nome_perfil'] ?? 'Sem Perfil'); ?>
            </span>
        </td>
        <td class="fw-mono text-secondary small"><?php echo date('d/m/Y', strtotime($user['data_criacao'])); ?></td>
        <td>
            <span class="badge bg-<?php echo $badge_estado; ?> bg-opacity-10 text-<?php echo $badge_estado; ?> rounded-pill px-2">
                <?php echo htmlspecialchars($user['estado']); ?>
            </span>
        </td>
        <td class="text-end">
            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Utilizador">
                <button class="btn btn-light btn-sm rounded-3 me-1 border"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditarUtilizador"
                    data-id="<?php echo $user['id']; ?>"
                    data-nome="<?php echo htmlspecialchars($user['nome']); ?>"
                    data-email="<?php echo htmlspecialchars($user['email']); ?>"
                    data-cedula="<?php echo htmlspecialchars($user['cedula'] ?? ''); ?>"
                    data-perfil="<?php echo $user['perfil_id']; ?>">
                    <i class="fa-solid fa-user-pen text-primary"></i>
                </button>
            </span>

            <?php if ($user['estado'] == 'Ativo'): ?>
                <a href="/gira/private/utilizadores/alternar_estado.php?id=<?php echo $user['id']; ?>" class="btn btn-light btn-sm rounded-3 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspender Acesso" onclick="return confirm('Tem a certeza que deseja suspender o acesso deste utilizador?');">
                    <i class="fa-solid fa-user-slash text-warning"></i>
                </a>
            <?php else: ?>
                <a href="/gira/private/utilizadores/alternar_estado.php?id=<?php echo $user['id']; ?>" class="btn btn-light btn-sm rounded-3 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Reativar Acesso" onclick="return confirm('Deseja reativar o acesso a este utilizador?');">
                    <i class="fa-solid fa-user-check text-success"></i>
                </a>
            <?php endif; ?>
        </td>
    </tr>
<?php
endforeach;

// Mensagem caso a tabela esteja vazia
if (count($lista_utilizadores) === 0):
?>
    <tr>
        <td colspan="7" class="text-center text-muted py-5">
            <i class="fa-solid fa-users-slash fs-1 text-light mb-3"></i><br>
            Ainda não existem utilizadores registados no sistema.
        </td>
    </tr>
<?php
endif;

// Fechamos as tags da tabela automaticamente!
render_table_end();
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEditar = document.getElementById('modalEditarUtilizador');
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', function(event) {
                // Qual foi o botão de lápis que o utilizador clicou?
                const button = event.relatedTarget;

                // Transferir os dados do botão (data-*) para dentro dos inputs invisíveis e visíveis do formulário
                document.getElementById('edit_id_utilizador').value = button.getAttribute('data-id');
                document.getElementById('edit_nome_utilizador').value = button.getAttribute('data-nome');
                document.getElementById('edit_email_utilizador').value = button.getAttribute('data-email');
                document.getElementById('edit_cedula_utilizador').value = button.getAttribute('data-cedula');
                document.getElementById('edit_perfil_utilizador').value = button.getAttribute('data-perfil');
            });
        }
    });
</script>

<?php
// Fechamos a página e injetamos os scripts base (incluindo o próprio modal)
render_footer();
?>