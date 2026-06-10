<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// Ir buscar os dados completos do utilizador que tem sessão iniciada
try {
    $sql = "SELECT u.*, p.nome_perfil, p.nivel_acesso 
            FROM utilizadores u 
            LEFT JOIN perfis_acesso p ON u.perfil_id = p.id 
            WHERE u.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $meu_perfil = $stmt->fetch();

    if (!$meu_perfil) {
        die("Erro Crítico: Perfil não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao carregar dados do perfil: " . $e->getMessage());
}

render_header("Gira - O Meu Perfil");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">A Minha Conta</h2>
        <p class="text-muted m-0 small">Gere as tuas informações pessoais e credenciais de segurança.</p>
    </div>
</div>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-shield-halved me-2"></i><strong>Ação Bloqueada!</strong>
        <?php
        if ($_GET['erro'] == 'nome_invalido') echo "O teu nome não pode conter algarismos numéricos.";
        if ($_GET['erro'] == 'pass_mismatch') echo "As novas palavras-passe não coincidem.";
        if ($_GET['erro'] == 'email_duplicado') echo "Este e-mail ou cédula já está a ser utilizado por outro colega.";
        ?>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check text-success me-2"></i><strong>Dados Guardados!</strong> O teu perfil foi atualizado com sucesso.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-dark mb-4"><i class="fa-solid fa-id-card text-primary me-2"></i>Dados Pessoais</h5>

            <form action="/sibdas/1241251/gira/private/meu_perfil/processar_meu_perfil.php" method="POST">
                <input type="hidden" name="acao" value="dados">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Nome Completo</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" name="nome" value="<?php echo htmlspecialchars($meu_perfil['nome']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary">E-mail de Acesso</label>
                        <input type="email" class="form-control bg-light border-0 p-2.5" name="email" value="<?php echo htmlspecialchars($meu_perfil['email']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary">Cédula Profissional</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" name="cedula" value="<?php echo htmlspecialchars($meu_perfil['cedula'] ?? ''); ?>" placeholder="Opcional">
                    </div>

                    <div class="col-12 mt-4">
                        <label class="form-label small fw-bold text-secondary">O Teu Perfil no Sistema</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5 text-muted fw-bold" value="<?php echo htmlspecialchars($meu_perfil['nome_perfil']); ?>" readonly disabled>
                        <small class="text-muted" style="font-size: 0.65rem;">O nível de acesso só pode ser alterado por Administradores.</small>
                    </div>
                </div>

                <hr class="my-4 border-light">
                <button type="submit" class="btn btn-primary rounded-3 fw-bold small px-4 shadow-sm w-100">Guardar Dados Pessoais</button>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-dark mb-4"><i class="fa-solid fa-lock text-danger me-2"></i>Segurança da Conta</h5>

            <form action="/sibdas/1241251/gira/private/meu_perfil/processar_meu_perfil.php" method="POST">
                <input type="hidden" name="acao" value="password">

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Nova Palavra-passe</label>
                    <input type="password" class="form-control bg-light border-0 p-2.5" name="nova_pass" placeholder="Escreve a nova senha" required minlength="6">
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Confirmar Nova Palavra-passe</label>
                    <input type="password" class="form-control bg-light border-0 p-2.5" name="confirma_pass" placeholder="Repete a senha" required minlength="6">
                </div>

                <div class="bg-danger bg-opacity-10 p-3 rounded-3 mb-4 border border-danger-subtle text-center">
                    <p class="mb-0 text-danger" style="font-size: 0.7rem; line-height: 1.4;">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                        Ao alterares a tua palavra-passe, a tua sessão será terminada e terás de fazer login novamente.
                    </p>
                </div>

                <button type="submit" class="btn btn-danger text-white rounded-3 fw-bold small px-4 shadow-sm w-100 mt-auto">Atualizar Palavra-passe</button>
            </form>
        </div>
    </div>
</div>

<?php render_footer(); ?>