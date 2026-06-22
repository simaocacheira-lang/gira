<?php
// 1. Ligar à BD e carregar o layout
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. EXTRAÇÃO LIMPA: Ir buscar todos os conteúdos à Base de Dados
try {
    $conteudos = obterConteudosSite($pdo);
} catch (PDOException $e) {
    die("Erro ao carregar os conteúdos: " . $e->getMessage());
}

render_header("Gira - Backoffice da Área Pública");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gerir Área Pública</h2>
        <p class="text-muted m-0 small">Altere os conteúdos visíveis na página inicial em tempo real.</p>
    </div>

    <button type="submit" form="formConteudos" class="btn btn-primary rounded-3 fw-bold small px-4 shadow-sm">
        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
    </button>
</div>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i><strong>Sucesso!</strong> Os conteúdos do site público foram atualizados.
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">

    <ul class="nav nav-tabs mb-4 border-bottom-0" id="backofficeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold small rounded-3 me-2" data-bs-toggle="tab" data-bs-target="#Hero" type="button" role="tab">Secção Inicial</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold small rounded-3 me-2 text-muted" data-bs-toggle="tab" data-bs-target="#sobre" type="button" role="tab">Sobre Nós</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold small rounded-3 text-muted" data-bs-toggle="tab" data-bs-target="#contacto" type="button" role="tab">Contactos</button>
        </li>
    </ul>

    <form id="formConteudos" action="/sibdas/1241251/gira/private/backoffice_publico/processar_conteudos.php" method="POST">
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="Hero" role="tabpanel">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Título Principal (Hero)</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" name="hero_titulo" value="<?php echo htmlspecialchars($conteudos['hero_titulo'] ?? ''); ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Subtítulo Descritivo</label>
                        <textarea class="form-control bg-light border-0 p-2.5" name="hero_subtitulo" rows="2" required><?php echo htmlspecialchars($conteudos['hero_subtitulo'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="sobre" role="tabpanel">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Texto Descritivo do Projeto</label>
                        <textarea class="form-control bg-light border-0 p-2.5" name="sobre_texto" rows="4" required><?php echo htmlspecialchars($conteudos['sobre_texto'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="contacto" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary">E-mail Institucional</label>
                        <input type="email" class="form-control bg-light border-0 p-2.5" name="contacto_email" value="<?php echo htmlspecialchars($conteudos['contacto_email'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary">Telefone / Contacto</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" name="contacto_telefone" value="<?php echo htmlspecialchars($conteudos['contacto_telefone'] ?? ''); ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary">Morada Física</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" name="contacto_morada" value="<?php echo htmlspecialchars($conteudos['contacto_morada'] ?? ''); ?>" required>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<?php render_footer(); ?>