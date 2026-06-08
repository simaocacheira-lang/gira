<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Configurações Gerais do Sistema");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Definições do Sistema</h2>
        <p class="text-muted m-0 small">Ajustes operacionais do painel, parâmetros de rede, segurança e políticas de manutenção.</p>
    </div>

    <button type="submit" form="form-configuracoes" class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm">
        <i class="fa-solid fa-floppy-disk me-2"></i> Guardar Alterações
    </button>
</div>

<form id="form-configuracoes" action="/gira/private/guardar_config.php" method="POST">
    <div class="row g-4">

        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-hospital text-primary me-2"></i>Parâmetros Clínicos</h5>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Nome da Unidade Hospitalar</label>
                    <input type="text" class="form-control rounded-3" value="Hospital Central do Porto" placeholder="Ex: Hospital de São João">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">E-mail Geral de Alertas Técnicos</label>
                    <input type="email" class="form-control rounded-3" value="engenharia.clinica@gira.hosp">
                </div>

                <div>
                    <label class="form-label text-muted small fw-bold">Fuso Horário de Auditoria</label>
                    <select class="form-select rounded-3">
                        <option selected>(UTC+00:00) Lisboa, Porto, Londres</option>
                        <option>(UTC+01:00) Copenhaga, Madrid, Paris</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-shield-halved text-primary me-2"></i>Segurança e Acessos</h5>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">Tempo Limite da Sessão (Inatividade)</label>
                    <div class="input-group">
                        <input type="number" class="form-control rounded-start-3" value="30">
                        <span class="input-group-text rounded-end-3 text-muted small">minutos</span>
                    </div>
                </div>

                <div class="form-check form-switch mb-3 mt-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="switchForcaSenha" checked>
                    <label class="form-check-label fw-medium text-dark small" for="switchForcaSenha">Exigir complexidade forte em novas senhas</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switchMFA">
                    <label class="form-check-label fw-medium text-dark small" for="switchMFA">Forçar verificação em duas etapas para Administradores</label>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-sliders text-primary me-2"></i>Regras de Engenharia Clínica</h5>
                <div class="row g-3">

                    <div class="col-12 col-sm-6">
                        <label class="form-label text-muted small fw-bold">Aviso Prévio de Próxima Calibração / Revisão</label>
                        <div class="input-group">
                            <input type="number" class="form-control rounded-start-3" value="15">
                            <span class="input-group-text rounded-end-3 text-muted small">dias de antecedência</span>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label class="form-label text-muted small fw-bold">Tamanho Máximo de Upload (Manuais / Certificados)</label>
                        <div class="input-group">
                            <input type="number" class="form-control rounded-start-3" value="20">
                            <span class="input-group-text rounded-end-3 text-muted small">MegaBytes (MB)</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</form>
<?php
// 3. Chamamos o fim do molde
render_footer();
?>