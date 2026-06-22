<?php
// 1. Chamamos o molde e a ligação à base de dados
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. EXTRAÇÃO LIMPA (MVC)
try {
    $lista_perfis = obterTodosPerfis($pdo);
} catch (PDOException $e) {
    die("Erro ao carregar perfis de acesso: " . $e->getMessage());
}

// 3. Montamos o topo da página
render_header("Gira - Perfis e Grupos de Permissões");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Perfis de Acesso</h2>
        <p class="text-muted m-0 small">Configuração de grupos de utilizadores, níveis de autorização e políticas de segurança.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarPerfil">
        <i class="fa-solid fa-users-gear me-2"></i> Adicionar Perfil
    </button>
</div>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-shield-halved me-2"></i>
        <strong>Ação Bloqueada!</strong>
        <?php
        if ($_GET['erro'] == 'perfil_bloqueado') echo "Não podes apagar ou despromover o perfil principal de Administração.";
        if ($_GET['erro'] == 'perfil_ocupado') echo "Este perfil não pode ser apagado porque ainda existem utilizadores associados a ele. Altera o perfil desses utilizadores primeiro.";
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i>
        <strong>Ação concluída!</strong>
        <?php
        if ($_GET['sucesso'] == 'perfil_criado') echo "O novo perfil de acesso foi registado.";
        elseif ($_GET['sucesso'] == 'perfil_editado') echo "O nível de acesso e os dados do perfil foram atualizados.";
        // BUG CORRIGIDO: Agora reconhece tanto 'perfil_eliminado' como o 'eliminado' que vem do eliminar_perfil.php
        elseif ($_GET['sucesso'] == 'perfil_eliminado' || $_GET['sucesso'] == 'eliminado') echo "O perfil foi removido do sistema de forma segura.";
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php
// Definimos as colunas da tabela com as larguras (width) adequadas
$colunas = [
    ['label' => 'Nome do Perfil', 'width' => '30%'],
    ['label' => 'Nível (Interno)', 'width' => '15%'],
    ['label' => 'Nº Utilizadores', 'width' => '15%'],
    ['label' => 'Permissões Globais', 'width' => '25%'],
    ['label' => 'Ações', 'align' => 'end', 'width' => '15%']
];

render_table_start($colunas);

// ============================================================================
// O LOOP: Desenhar uma linha por cada perfil encontrado na Base de Dados
// ============================================================================
foreach ($lista_perfis as $perfil):

    // Lógica inteligente para as cores e ícones baseada no nível de acesso
    $nivel = (int) $perfil['nivel_acesso'];

    if ($nivel >= 3) {
        $badge_class = 'danger';
        $icon = '<i class="fa-solid fa-shield me-1"></i> Escrita Total (Admin)';
        $descricao = 'Acesso total e irrestrito ao sistema.';
    } elseif ($nivel == 2) {
        $badge_class = 'primary';
        $icon = '<i class="fa-solid fa-pen-to-square me-1"></i> Modificação';
        $descricao = 'Gestão de equipamentos, manutenção e armazém.';
    } else {
        $badge_class = 'info';
        $icon = '<i class="fa-solid fa-eye me-1"></i> Apenas Leitura';
        $descricao = 'Visualização de dados e relatórios. Não pode alterar.';
    }
?>
    <tr>
        <td>
            <div class="fw-bold text-dark"><?php echo htmlspecialchars($perfil['nome_perfil']); ?></div>
            <small class="text-secondary"><?php echo $descricao; ?></small>
        </td>
        <td class="fw-mono text-muted">Nível <?php echo $nivel; ?></td>
        <td>
            <?php if ($perfil['total_users'] > 0): ?>
                <span class="fw-bold text-primary"><?php echo $perfil['total_users']; ?> utilizador(es)</span>
            <?php else: ?>
                <span class="text-muted small">Sem utilizadores</span>
            <?php endif; ?>
        </td>
        <td>
            <span class="badge bg-<?php echo $badge_class; ?> bg-opacity-10 text-<?php echo $badge_class; ?> border border-<?php echo $badge_class; ?>-subtle px-2">
                <?php echo $icon; ?>
            </span>
        </td>
        <td class="text-end text-nowrap">
            <button class="btn btn-light btn-sm rounded-3 me-1 border"
                data-bs-toggle="modal"
                data-bs-target="#modalEditarPerfil"
                data-id="<?php echo $perfil['id']; ?>"
                data-nome="<?php echo htmlspecialchars($perfil['nome_perfil']); ?>"
                data-nivel="<?php echo $perfil['nivel_acesso']; ?>"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Configurar Direitos">
                <i class="fa-solid fa-key text-primary"></i>
            </button>

            <?php if ($nivel >= 3): ?>
                <button class="btn btn-light btn-sm rounded-3 text-danger border disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Perfil de Sistema (Bloqueado)">
                    <i class="fa-solid fa-lock"></i>
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-light btn-sm rounded-3 border hover-danger"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Perfil"
                    onclick="confirmarEliminacao('/sibdas/1241251/gira/private/perfis/eliminar_perfil.php', <?php echo $perfil['id']; ?>, 'Tem a certeza que deseja eliminar o perfil \'<?php echo htmlspecialchars($perfil['nome_perfil']); ?>\'?', 'Eliminar Perfil')">
                    <i class="fa-solid fa-trash-can text-danger"></i>
                </button>
            <?php endif; ?>
        </td>
    </tr>
<?php
endforeach;

render_table_end(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEditar = document.getElementById('modalEditarPerfil');
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', function(event) {
                // Qual foi o botão que ativou o modal?
                const button = event.relatedTarget;

                // Transportar os dados do botão para dentro do formulário de edição
                document.getElementById('edit_id_perfil').value = button.getAttribute('data-id');
                document.getElementById('edit_nome_perfil').value = button.getAttribute('data-nome');
                document.getElementById('edit_nivel_perfil').value = button.getAttribute('data-nivel');
            });
        }
    });
</script>

<?php
render_footer();
?>