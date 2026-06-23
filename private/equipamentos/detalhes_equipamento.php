<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../layout.php';

// 2. Verificar se recebemos um ID válido pelo URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /sibdas/1241251/gira/private/equipamentos/equipamentos.php");
    exit;
}

$id_equipamento = (int) $_GET['id'];

try {
    // 3. Ir buscar os dados do equipamento E do Fornecedor associado
    $sql = "SELECT e.*, 
                   f_ass.nome_empresa AS nome_assistencia, f_ass.email_suporte AS assistencia_email, f_ass.telefone_suporte AS assistencia_telefone,
                   f_fab.nome_empresa AS nome_fabricante
            FROM equipamentos e 
            LEFT JOIN fornecedores f_ass ON e.fornecedor_id = f_ass.id 
            LEFT JOIN fornecedores f_fab ON e.fabricante_id = f_fab.id
            WHERE e.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_equipamento]);
    $eq = $stmt->fetch();

    if (!$eq) {
        die("<h3>Erro 404: Equipamento não encontrado no parque tecnológico.</h3><a href='/sibdas/1241251/gira/private/equipamentos/equipamentos.php'>Voltar à lista</a>");
    }

    // 4. Ir buscar o histórico clínico (OTs) DESTE equipamento específico (Corrigido: apenas 1 vez!)
    $sql_historico = "SELECT * FROM ordens_trabalho WHERE equipamento_id = :id ORDER BY id DESC";
    $stmt_historico = $pdo->prepare($sql_historico);
    $stmt_historico->execute([':id' => $id_equipamento]);
    $historico_ots = $stmt_historico->fetchAll();

    // 5. Ir buscar os documentos técnicos anexados
    $sql_docs = "SELECT * FROM documentos_equipamento WHERE equipamento_id = :id ORDER BY data_upload DESC";
    $stmt_docs = $pdo->prepare($sql_docs);
    $stmt_docs->execute([':id' => $id_equipamento]);
    $lista_documentos = $stmt_docs->fetchAll();

    // 6. NOVA PESQUISA: Ir buscar todas as localizações para o dropdown dinâmico
    $sql_loc = "SELECT id, cod_sala, nome FROM localizacoes ORDER BY nome ASC";
    $stmt_loc = $pdo->query($sql_loc);
    $todas_localizacoes = $stmt_loc->fetchAll();

    // 7. NOVA LÓGICA N:M - Buscar todas as peças associadas a este equipamento
    $sql_cons = "SELECT a.* FROM artigos_armazem a 
                 INNER JOIN equipamento_artigo_armazem ea ON a.id = ea.artigo_id 
                 WHERE ea.equipamento_id = :id_eq";
    $stmt_cons = $pdo->prepare($sql_cons);
    $stmt_cons->execute([':id_eq' => $id_equipamento]);
    $consumiveis_associados = $stmt_cons->fetchAll();

    // Extrair apenas os IDs num array simples para pré-selecionar na lista
    $ids_consumiveis_selecionados = array_column($consumiveis_associados, 'id');

    // 8. NOVA PESQUISA: Buscar o catálogo do armazém para podermos associar peças
    $sql_art = "SELECT id, referencia, nome FROM artigos_armazem ORDER BY nome ASC";
    $stmt_art = $pdo->query($sql_art);
    $lista_artigos = $stmt_art->fetchAll();

    // Buscar todos os fornecedores para as dropdowns do ecrã Comercial
    $sql_forn = "SELECT id, nome_empresa FROM fornecedores ORDER BY nome_empresa ASC";
    $stmt_forn = $pdo->query($sql_forn);
    $lista_fornecedores = $stmt_forn->fetchAll();

    // 9. HISTÓRICO DE AUDITORIA (LOGS)
    // Procuramos os logs deste equipamento específico e fazemos JOIN para saber o nome de quem fez a ação
    $sql_logs = "SELECT l.*, u.nome AS nome_utilizador 
                 FROM logs_auditoria l 
                 LEFT JOIN utilizadores u ON l.utilizador_id = u.id 
                 WHERE (l.tabela_afetada = 'equipamentos' AND l.registo_id = :id) 
                    OR (l.modulo = 'Equipamentos' AND l.acao LIKE :texto)
                 ORDER BY l.data_hora DESC";
    $stmt_logs = $pdo->prepare($sql_logs);
    // Usamos um truque no :texto para apanhar logs antigos que só tinham o ID no meio da frase
    $stmt_logs->execute([
        ':id' => $id_equipamento,
        ':texto' => '%ID: ' . $id_equipamento . '%'
    ]);
    $lista_logs = $stmt_logs->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}

render_header("Detalhes - " . htmlspecialchars($eq['codigo_ativo']));
?>

<form action="/sibdas/1241251/gira/private/equipamentos/processar_edicao_equipamento.php" method="POST" novalidate>
    <?php
    // INJEÇÃO DA NOSSA CAIXA DE ERROS DE VALIDAÇÃO
    if (isset($_SESSION['erros']) && !empty($_SESSION['erros'])):
    ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
            <strong class="fs-6">Verifique os seguintes erros antes de guardar:</strong>
            <ul class="mb-0 mt-2 fw-medium">
                <?php foreach ($_SESSION['erros'] as $erro): ?>
                    <li><?php echo htmlspecialchars($erro); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
        </div>
    <?php
        unset($_SESSION['erros']);
    endif;
    ?>
    <input type="hidden" name="id_equipamento" value="<?php echo $eq['id']; ?>">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small fw-bold">
                <li class="breadcrumb-item"><a href="/sibdas/1241251/gira/private/equipamentos/equipamentos.php" class="text-decoration-none text-muted">Equipamentos</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Ficha Técnica e Edição</li>
            </ol>
        </nav>
        <div class="d-flex gap-2">
            <a href="/sibdas/1241251/gira/private/equipamentos/equipamentos.php" class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Voltar
            </a>
            <div class="dropdown">
                <button class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 small">
                    <?php if ($eq['estado'] == 'Operacional'): ?>
                        <li>
                            <button type="button" class="dropdown-item fw-medium py-2" onclick="confirmarEstado('/sibdas/1241251/gira/private/equipamentos/suspender_equipamento.php?id=<?php echo $eq['id']; ?>&acao=suspender', 'Tem a certeza que deseja suspender a atividade deste equipamento? Ele passará automaticamente ao estado de Inoperacional.', 'Suspender Equipamento', 'suspender')">
                                <i class="fa-solid fa-ban text-warning me-2"></i> Suspender Equipamento
                            </button>
                        </li>
                    <?php else: ?>
                        <li>
                            <button type="button" class="dropdown-item fw-medium py-2" onclick="confirmarEstado('/sibdas/1241251/gira/private/equipamentos/suspender_equipamento.php?id=<?php echo $eq['id']; ?>&acao=reativar', 'Deseja reativar este equipamento? O seu estado passará novamente a Operacional e poderá ser utilizado.', 'Reativar Equipamento', 'reativar')">
                                <i class="fa-solid fa-check text-success me-2"></i> Reativar Equipamento
                            </button>
                        </li>
                    <?php endif; ?> <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <button type="button" class="dropdown-item fw-bold text-danger py-2" onclick="confirmarEliminacao('/sibdas/1241251/gira/private/equipamentos/eliminar_equipamento.php?id=<?php echo $eq['id']; ?>', 'Tem a certeza que deseja de que quer abater este equipamento do sistema?', 'Abater Inventário')">
                            <i class="fa-solid fa-trash-can me-2"></i> Abater Inventário
                        </button>
                    </li>
                </ul>
            </div>
            <button type="submit" class="btn btn-success rounded-3 fw-bold small px-3 py-2 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
            </button>
        </div>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check text-success me-2"></i>
            <strong>Ação concluída!</strong>
            <?php
            if ($_GET['sucesso'] == 'doc_eliminado') echo "O documento técnico foi eliminado permanentemente.";
            elseif ($_GET['sucesso'] == 'estado_alterado') echo "O estado operacional do equipamento foi atualizado.";
            elseif ($_GET['sucesso'] == '1') echo "A ficha técnica do equipamento foi guardada com sucesso.";
            else echo "Operação realizada com sucesso.";
            ?>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 border-top border-primary border-4">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            <input type="text" class="form-control form-control-lg fw-bold bg-light border-0 w-auto" name="nome" value="<?php echo htmlspecialchars($eq['nome']); ?>" style="min-width: 350px;">

            <select class="form-select form-select-sm bg-success bg-opacity-10 text-success fw-bold border-success-subtle w-auto rounded-3" name="estado_operacional">
                <option value="Operacional" <?php echo ($eq['estado'] == 'Operacional') ? 'selected' : ''; ?>>Operacional</option>
                <option value="Inoperacional" <?php echo ($eq['estado'] == 'Inoperacional') ? 'selected' : ''; ?>>Avariado / Em Reparação</option>
                <option value="Manutenção" <?php echo ($eq['estado'] == 'Manutenção' || $eq['estado'] == 'Aguardar Calibração') ? 'selected' : ''; ?>>Aguardar Calibração</option>
            </select>

            <select class="form-select form-select-sm bg-danger bg-opacity-10 text-danger fw-bold border-danger-subtle w-auto rounded-3" name="classe_risco">
                <option value="Suporte de Vida" <?php echo ($eq['classe_risco'] == 'Suporte de Vida') ? 'selected' : ''; ?>>Suporte de Vida (Classe III)</option>
                <option value="Médio/Alto Risco" <?php echo ($eq['classe_risco'] == 'Médio/Alto Risco') ? 'selected' : ''; ?>>Médio/Alto Risco (Classe IIb)</option>
                <option value="Monitorização" <?php echo ($eq['classe_risco'] == 'Monitorização') ? 'selected' : ''; ?>>Monitorização (Classe IIa)</option>
                <option value="Baixo Risco" <?php echo ($eq['classe_risco'] == 'Baixo Risco') ? 'selected' : ''; ?>>Baixo Risco (Classe I)</option>
            </select>
        </div>

        <div class="row g-4 border-top pt-3">
            <div class="col-6 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-fingerprint me-1"></i>ID Ativo (Fixo)</label>
                <input type="text" class="form-control form-control-sm bg-light border-0 fw-mono fw-bold text-muted" value="<?php echo htmlspecialchars($eq['codigo_ativo']); ?>" readonly>
            </div>
            <div class="col-6 col-md-4">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-industry me-1"></i>Fabricante / Modelo</label>
                <input type="text" class="form-control form-control-sm bg-light border-0 fw-medium" name="modelo" value="<?php echo htmlspecialchars($eq['modelo']); ?>">
            </div>
            <div class="col-6 col-md-4">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-location-dot me-1"></i>Localização ID</label>
                <select class="form-select form-select-sm bg-light border-0 fw-bold text-primary" name="localizacao_id">
                    <?php foreach ($todas_localizacoes as $loc): ?>
                        <option value="<?php echo $loc['id']; ?>" <?php echo ($eq['localizacao_id'] == $loc['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($loc['cod_sala'] . ' · ' . $loc['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-regular fa-calendar me-1"></i>Data Aquisição</label>
                <input type="date" class="form-control form-control-sm bg-light border-0 fw-medium" name="data_aquisicao" value="<?php echo $eq['data_aquisicao']; ?>">
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light p-2">
        <ul class="nav nav-pills flex-nowrap overflow-x-auto gap-2 fw-bold" id="equipamentoTabs" role="tablist" style="scrollbar-width: none;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 py-2 text-nowrap" id="visao-tab" data-bs-toggle="tab" data-bs-target="#visao" type="button" role="tab">
                    <i class="fa-solid fa-cube me-2"></i>Visão Geral
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 text-nowrap" id="manutencao-tab" data-bs-toggle="tab" data-bs-target="#manutencao" type="button" role="tab">
                    <i class="fa-solid fa-screwdriver-wrench me-2"></i>Ordens de Trabalho
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 text-nowrap" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab">
                    <i class="fa-regular fa-file-pdf me-2"></i>Documentos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 text-nowrap" id="comercial-tab" data-bs-toggle="tab" data-bs-target="#comercial" type="button" role="tab">
                    <i class="fa-solid fa-handshake me-2"></i>Comercial e Garantias
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 text-nowrap" id="armazem-tab" data-bs-toggle="tab" data-bs-target="#armazem" type="button" role="tab">
                    <i class="fa-solid fa-boxes-stacked me-2"></i>Peças Compatíveis
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 py-2 text-nowrap" id="auditoria-tab" data-bs-toggle="tab" data-bs-target="#auditoria" type="button" role="tab">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i>Logs
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="equipamentoTabsContent">

        <div class="tab-pane fade show active" id="visao" role="tabpanel" tabindex="0">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                        <h6 class="fw-bold mb-4 text-dark fs-5">Detalhes Técnicos e IT</h6>

                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Categoria / Grupo</label>
                                <select class="form-select bg-light border-0 fw-bold" name="categoria">
                                    <option value="" <?php echo empty($eq['categoria']) ? 'selected' : ''; ?>>Selecione...</option>
                                    <option value="Monitorização" <?php echo ($eq['categoria'] == 'Monitorização') ? 'selected' : ''; ?>>Monitorização</option>
                                    <option value="Suporte de Vida" <?php echo ($eq['categoria'] == 'Suporte de Vida') ? 'selected' : ''; ?>>Suporte de Vida</option>
                                    <option value="Terapia" <?php echo ($eq['categoria'] == 'Terapia') ? 'selected' : ''; ?>>Terapia</option>
                                    <option value="Diagnóstico" <?php echo ($eq['categoria'] == 'Diagnóstico') ? 'selected' : ''; ?>>Diagnóstico</option>
                                    <option value="Laboratório" <?php echo ($eq['categoria'] == 'Laboratório') ? 'selected' : ''; ?>>Laboratório</option>
                                    <option value="Esterilização" <?php echo ($eq['categoria'] == 'Esterilização') ? 'selected' : ''; ?>>Esterilização</option>
                                    <option value="Reabilitação" <?php echo ($eq['categoria'] == 'Reabilitação') ? 'selected' : ''; ?>>Reabilitação</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Marca</label>
                                <input type="text" class="form-control bg-light border-0 fw-bold" name="marca" value="<?php echo htmlspecialchars($eq['marca'] ?? ''); ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Número de Série (SN)</label>
                                <input type="text" class="form-control bg-light border-0 fw-mono fw-bold" name="sn" value="<?php echo htmlspecialchars($eq['num_serie']); ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Endereço MAC (Integração IT)</label>
                                <input type="text" class="form-control bg-light border-0 fw-mono fw-bold" name="mac_address" value="<?php echo htmlspecialchars($eq['mac_address'] ?? ''); ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Custo de Aquisição Original (€)</label>
                                <input type="number" step="0.01" class="form-control bg-light border-0 fw-bold" name="custo_aquisicao" value="<?php echo $eq['custo_aquisicao']; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Próxima Revisão Obrigatória</label>
                                <input type="date" class="form-control bg-light border-0 fw-bold text-primary" name="proxima_revisao" value="<?php echo $eq['proxima_revisao']; ?>">
                            </div>

                            <div class="col-12">
                                <label class="text-muted d-block mb-1 small fw-bold">Observações / Notas</label>
                                <textarea class="form-control bg-light border-0" name="observacoes" rows="3" placeholder="Informações adicionais..."><?php echo htmlspecialchars($eq['observacoes'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="vstack gap-4 h-100">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-success border-4">
                            <small class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.7rem;">Fiabilidade (MTBF)</small>
                            <h2 class="fw-black text-dark mb-0">184 <span class="fs-6 fw-medium text-muted">Dias</span></h2>
                            <small class="text-success fw-bold mt-1" style="font-size: 0.7rem;"><i class="fa-solid fa-arrow-trend-up me-1"></i> Acima da média</small>
                        </div>
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-danger border-4">
                            <small class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.7rem;">Custos de Reparação</small>
                            <h2 class="fw-black text-dark mb-0">0 <span class="fs-6 fw-medium text-muted">€</span></h2>
                        </div>
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-warning bg-opacity-10 border border-warning-subtle flex-grow-1 d-flex flex-column justify-content-center text-center">
                            <i class="fa-solid fa-calendar-check fs-2 text-warning mb-2"></i>
                            <small class="text-dark fw-bold d-block mb-1">Próxima Calibração</small>
                            <span class="fw-black text-dark fs-5">
                                <?php echo !empty($eq['proxima_revisao']) ? date('d/m/Y', strtotime($eq['proxima_revisao'])) : 'A definir'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="manutencao" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold mb-4 text-dark fs-5"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Histórico de Intervenções</h6>

                <?php if (!empty($eq['proxima_revisao'])):
                    $hoje = strtotime(date('Y-m-d'));
                    $data_revisao = strtotime($eq['proxima_revisao']);
                    $dias = round(($data_revisao - $hoje) / (60 * 60 * 24));

                    $cor_alerta = 'success';
                    $icone_alerta = 'fa-calendar-check';
                    if ($dias < 0) {
                        $cor_alerta = 'danger';
                        $icone_alerta = 'fa-calendar-xmark';
                    } elseif ($dias <= 15) {
                        $cor_alerta = 'warning text-dark';
                        $icone_alerta = 'fa-clock';
                    }
                ?>
                    <div class="alert bg-<?php echo str_replace(' text-dark', '', $cor_alerta); ?> bg-opacity-10 border border-<?php echo str_replace(' text-dark', '', $cor_alerta); ?>-subtle rounded-4 d-flex align-items-center mb-4 p-3 shadow-sm">
                        <div class="bg-<?php echo $cor_alerta; ?> text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid <?php echo $icone_alerta; ?> fs-5" style="color: #ffffff !important;"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1 text-dark">Revisão Preventiva Agendada</h6>
                            <p class="mb-0 small text-dark">
                                A próxima intervenção está planeada para <strong><?php echo date('d/m/Y', strtotime($eq['proxima_revisao'])); ?></strong>
                                <?php
                                if ($dias < 0) echo "<span class='text-danger fw-bold'>(Atrasada há " . abs($dias) . " dias!)</span>";
                                elseif ($dias == 0) echo "<span class='text-warning fw-bold'>(É hoje!)</span>";
                                else echo "<span class='text-muted'>(Faltam " . $dias . " dias)</span>";
                                ?>.
                            </p>
                        </div>
                        <div class="ms-auto ps-3 border-start border-<?php echo str_replace(' text-dark', '', $cor_alerta); ?>-subtle">
                            <button type="button" class="btn btn-<?php echo str_replace(' text-dark', '', $cor_alerta); ?> btn-sm fw-bold rounded-3 shadow-sm text-white" style="color: #ffffff !important;" data-bs-toggle="modal" data-bs-target="#modalAbrirOT" data-idequip="<?php echo $eq['id']; ?>">
                                <i class="fa-solid fa-play me-1" style="color: #ffffff !important;"></i> Iniciar O.T.
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (count($historico_ots) === 0): ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-screwdriver-wrench text-muted fs-1 mb-3 opacity-50"></i>
                        <p class="text-muted">Excelente! Ainda não existem avarias ou manutenções registadas para este equipamento.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th>Nº O.T.</th>
                                    <th>Data / Hora</th>
                                    <th>Tipo de Avaria</th>
                                    <th>Relatório Técnico</th>
                                    <th>Tempo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historico_ots as $ot): ?>
                                    <tr>
                                        <td class="fw-bold text-primary fw-mono"><?php echo htmlspecialchars($ot['numero_ot']); ?></td>
                                        <td class="text-muted small">
                                            <?php echo date('d/m/Y', strtotime($ot['data_abertura'])); ?><br>
                                            <span style="font-size: 0.7rem;"><?php echo date('H:i', strtotime($ot['data_abertura'])); ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold small"><?php echo htmlspecialchars($ot['tipo_manutencao']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($ot['descricao_avaria']); ?></small>
                                        </td>
                                        <td class="small text-secondary">
                                            <?php echo !empty($ot['relatorio_tecnico']) ? htmlspecialchars($ot['relatorio_tecnico']) : '<em>Aguardando relatório...</em>'; ?>
                                        </td>
                                        <td class="fw-bold text-dark">
                                            <?php echo !empty($ot['tempo_gasto']) ? htmlspecialchars($ot['tempo_gasto']) . 'h' : '-'; ?>
                                        </td>
                                        <td>
                                            <?php if ($ot['estado'] == 'Concluída'): ?>
                                                <span class="badge bg-light text-muted border rounded-pill px-2">Fechada</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark rounded-pill px-2">Em Curso</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="documentos" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-dark fs-5 m-0"><i class="fa-solid fa-file-pdf text-danger me-2"></i>Documentação Técnica</h6>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill fw-bold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoDocumento" onclick="document.getElementById('doc_id_equipamento').value = '<?php echo $eq['id']; ?>';">
                        <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload Ficheiro
                    </button>
                </div>

                <?php if (count($lista_documentos) === 0): ?>
                    <div class="text-center py-5 bg-light rounded-3 border border-dashed">
                        <i class="fa-solid fa-folder-open text-muted fs-1 mb-3 opacity-50"></i>
                        <p class="text-muted m-0">Ainda não existem documentos anexados a este equipamento.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($lista_documentos as $doc): ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="card border border-light shadow-sm rounded-3 h-100">
                                    <div class="card-body p-3 d-flex align-items-start gap-3">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded-3 text-danger">
                                            <i class="fa-solid fa-file-pdf fs-3"></i>
                                        </div>
                                        <div class="overflow-hidden w-100">
                                            <h6 class="fw-bold mb-1 text-truncate" title="<?php echo htmlspecialchars($doc['nome_documento']); ?>">
                                                <?php echo htmlspecialchars($doc['nome_documento']); ?>
                                            </h6>
                                            <small class="text-muted d-block mb-2"><?php echo htmlspecialchars($doc['tipo_documento']); ?></small>
                                            <div class="d-flex gap-2">
                                                <a href="/sibdas/1241251/gira/private/<?php echo htmlspecialchars($doc['caminho_ficheiro']); ?>" target="_blank" class="btn btn-sm btn-light border rounded-2" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-eye me-1"></i>Abrir
                                                </a>
                                                <button type="button" class="btn btn-sm btn-light text-danger border rounded-2 ms-auto hover-danger" onclick="confirmarEliminacao('/sibdas/1241251/gira/private/documentos/eliminar_documento.php?id=<?php echo $doc['id']; ?>', 'Tem a certeza que deseja apagar este ficheiro?', 'Apagar Anexo')" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light border-top border-light py-2 px-3 small text-muted text-end" style="font-size: 0.7rem;">
                                        Adicionado a <?php echo date('d/m/Y', strtotime($doc['data_upload'])); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="comercial" role="tabpanel" tabindex="0">
            <div class="row g-4">
                <div class="col-sm-6">
                    <label class="text-muted d-block mb-1 small fw-bold">Fabricante Oficial</label>
                    <select class="form-select bg-white border border-secondary border-opacity-25 shadow-sm rounded-3 fw-bold" name="fabricante_id">
                        <option value="">Desconhecido</option>
                        <?php foreach ($lista_fornecedores as $forn): ?>
                            <option value="<?php echo $forn['id']; ?>" <?php echo ($eq['fabricante_id'] == $forn['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($forn['nome_empresa']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted d-block mb-1 small fw-bold">Fornecedor / Assistência</label>
                    <select class="form-select bg-white border border-secondary border-opacity-25 shadow-sm rounded-3 fw-bold" name="fornecedor_id">
                        <option value="">Desconhecido</option>
                        <?php foreach ($lista_fornecedores as $forn): ?>
                            <option value="<?php echo $forn['id']; ?>" <?php echo ($eq['fornecedor_id'] == $forn['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($forn['nome_empresa']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-6">
                    <label class="text-muted d-block mb-1 small fw-bold">Tipo de Entrada</label>
                    <select class="form-select bg-white border border-secondary border-opacity-25 shadow-sm rounded-3 fw-bold text-primary" name="tipo_entrada">
                        <option value="Compra" <?php echo (($eq['tipo_entrada'] ?? 'Compra') == 'Compra') ? 'selected' : ''; ?>>Compra</option>
                        <option value="Doação" <?php echo (($eq['tipo_entrada'] ?? '') == 'Doação') ? 'selected' : ''; ?>>Doação</option>
                        <option value="Aluguer" <?php echo (($eq['tipo_entrada'] ?? '') == 'Aluguer') ? 'selected' : ''; ?>>Aluguer</option>
                        <option value="Empréstimo" <?php echo (($eq['tipo_entrada'] ?? '') == 'Empréstimo') ? 'selected' : ''; ?>>Empréstimo</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted d-block mb-1 small fw-bold">Ano de Fabrico</label>
                    <input type="number" class="form-control bg-white border border-secondary border-opacity-25 shadow-sm rounded-3 fw-bold" name="ano_fabrico" value="<?php echo htmlspecialchars($eq['ano_fabrico'] ?? ''); ?>" min="1980" max="<?php echo date('Y'); ?>">
                </div>
                <div class="col-sm-6">
                    <label class="text-muted d-block mb-1 small fw-bold">Data de Aquisição</label>
                    <div class="fw-bold text-dark"><?php echo !empty($eq['data_aquisicao']) ? date('d/m/Y', strtotime($eq['data_aquisicao'])) : '-'; ?></div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted d-block mb-1 small fw-bold">Valor de Aquisição</label>
                    <div class="fw-bold text-dark fs-5"><?php echo !empty($eq['custo_aquisicao']) ? number_format($eq['custo_aquisicao'], 2, ',', ' ') . ' €' : '-'; ?></div>
                </div>
                <div class="col-sm-12">
                    <label class="text-muted d-block mb-1 small fw-bold">Contactos de Suporte (Assistência Técnica)</label>
                    <?php if (!empty($eq['assistencia_email']) || !empty($eq['assistencia_telefone'])): ?>
                        <div class="small bg-light p-2 rounded-3 border border-light d-inline-block">
                            <?php if (!empty($eq['assistencia_email'])) echo '<i class="fa-solid fa-envelope text-muted me-1"></i> ' . htmlspecialchars($eq['assistencia_email']) . '<br>'; ?>
                            <?php if (!empty($eq['assistencia_telefone'])) echo '<i class="fa-solid fa-phone text-muted me-1"></i> ' . htmlspecialchars($eq['assistencia_telefone']); ?>
                        </div>
                    <?php else: ?>
                        <em class="text-muted small">Sem contactos registados na ficha do fornecedor de assistência.</em>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="armazem" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-dark fs-5 m-0"><i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Peças e Consumíveis Compatíveis</h6>

                    <div style="width: 400px;">
                        <label class="small text-muted fw-bold mb-2">Selecione as peças (Clique para marcar/desmarcar)</label>
                        <div class="bg-white border border-secondary border-opacity-25 rounded-3 shadow-sm p-2" style="max-height: 160px; overflow-y: auto;">
                            <?php foreach ($lista_artigos as $artigo): ?>
                                <div class="form-check mb-1">
                                    <input class="form-check-input border-secondary shadow-none" type="checkbox" name="consumiveis[]"
                                        value="<?php echo $artigo['id']; ?>"
                                        id="peca_<?php echo $artigo['id']; ?>"
                                        <?php echo in_array($artigo['id'], $ids_consumiveis_selecionados) ? 'checked' : ''; ?>
                                        onchange="document.getElementById('avisoGuardarPeca').classList.remove('d-none');"
                                        style="cursor: pointer;">
                                    <label class="form-check-label fw-bold text-primary w-100" for="peca_<?php echo $artigo['id']; ?>" style="font-size: 0.85rem; cursor: pointer;">
                                        <?php echo htmlspecialchars($artigo['referencia'] . ' - ' . $artigo['nome']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div id="avisoGuardarPeca" class="alert alert-warning border-warning py-2 mb-4 d-none d-flex align-items-center rounded-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-warning"></i>
                    <div>
                        <strong class="d-block">Atenção! As peças associadas foram alteradas.</strong>
                        <span class="small">Para gravar e aplicar esta integração, clica no botão verde <b>"Guardar Alterações"</b> no topo da página.</span>
                    </div>
                </div>

                <?php if (count($consumiveis_associados) > 0): ?>
                    <div class="row g-4">
                        <?php foreach ($consumiveis_associados as $consumivel):
                            $em_rutura = ($consumivel['quantidade_atual'] < $consumivel['quantidade_minima']);
                            $cor_stock = $em_rutura ? 'danger' : 'success';
                        ?>
                            <div class="col-md-6">
                                <div class="row g-0 border rounded-4 overflow-hidden h-100 shadow-sm">
                                    <div class="col-7 p-3 bg-light d-flex flex-column justify-content-center">
                                        <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.65rem;">Designação no Armazém</small>
                                        <h6 class="fw-bold text-dark mb-1 lh-sm"><?php echo htmlspecialchars($consumivel['nome']); ?></h6>
                                        <span class="badge bg-secondary text-white fw-mono px-2 py-1 mb-2 align-self-start"><?php echo htmlspecialchars($consumivel['referencia']); ?></span>
                                        <small class="text-muted mt-auto" style="font-size: 0.75rem;"><i class="fa-solid fa-layer-group me-1"></i> Categoria: <?php echo htmlspecialchars($consumivel['categoria']); ?></small>
                                    </div>
                                    <div class="col-5 p-3 bg-<?php echo $cor_stock; ?> bg-opacity-10 d-flex flex-column justify-content-center align-items-center text-center border-start border-<?php echo $cor_stock; ?> border-opacity-25">
                                        <small class="text-<?php echo $cor_stock; ?> fw-bold text-uppercase mb-1" style="font-size: 0.65rem;">
                                            <?php echo $em_rutura ? '<i class="fa-solid fa-triangle-exclamation me-1"></i> Rutura' : '<i class="fa-solid fa-check-circle me-1"></i> Stock OK'; ?>
                                        </small>
                                        <h3 class="fw-black text-<?php echo $cor_stock; ?> m-0">
                                            <?php echo $consumivel['quantidade_atual']; ?>
                                        </h3>
                                        <small class="text-muted fw-medium" style="font-size: 0.65rem;">Mín: <?php echo $consumivel['quantidade_minima']; ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                        <div class="bg-white p-3 rounded-circle d-inline-block shadow-sm mb-3">
                            <i class="fa-solid fa-link-slash text-muted fs-3 opacity-50"></i>
                        </div>
                        <p class="fw-bold text-dark m-0">Nenhuma peça de armazém associada a este equipamento.</p>
                        <p class="text-muted small mt-2">Pode selecionar múltiplas peças na lista acima mantendo a tecla CTRL pressionada.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="auditoria" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h6 class="fw-bold mb-4 text-dark fs-5"><i class="fa-solid fa-user-shield text-primary me-2"></i>Registo de Auditoria do Equipamento</h6>

                <?php if (count($lista_logs) === 0): ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-clock-rotate-left text-muted fs-1 mb-3 opacity-50"></i>
                        <p class="text-muted">Ainda não existem registos de auditoria associados a este equipamento.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th>Data / Hora</th>
                                    <th>Ação Realizada</th>
                                    <th>Utilizador</th>
                                    <th>Endereço IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista_logs as $log): ?>
                                    <tr>
                                        <td class="text-muted small">
                                            <span class="fw-bold text-dark"><?php echo date('d/m/Y', strtotime($log['data_hora'])); ?></span><br>
                                            <span style="font-size: 0.75rem;"><?php echo date('H:i:s', strtotime($log['data_hora'])); ?></span>
                                        </td>
                                        <td>
                                            <span class="small fw-medium text-dark"><?php echo htmlspecialchars($log['acao']); ?></span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($log['nome_utilizador'] ?? 'Sistema'); ?>&background=random&color=fff&rounded=true&size=24" alt="Avatar" class="shadow-sm">
                                                <span class="small fw-bold text-secondary"><?php echo htmlspecialchars($log['nome_utilizador'] ?? 'Desconhecido'); ?></span>
                                            </div>
                                        </td>
                                        <td class="small text-muted fw-mono">
                                            <?php echo htmlspecialchars($log['ip_origem']); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1. Passar o ID para o Modal da Garantia
        const modalGarantia = document.getElementById('modalAdicionarGarantia');
        if (modalGarantia) {
            modalGarantia.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('garantia_id_equipamento').value = button.getAttribute('data-idequip');
            });
        }

        // 2. Passar o ID para o Modal de Documentos
        const modalDoc = document.getElementById('modalNovoDocumento');
        if (modalDoc) {
            modalDoc.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const idEquip = button.getAttribute('data-idequip');
                const formDoc = modalDoc.querySelector('form');
                formDoc.action = "/sibdas/1241251/gira/private/documentos/processar_documento.php?id=" + idEquip;
            });
        }

        // 3. Ler o URL e abrir a aba correta automaticamente
        const urlParams = new URLSearchParams(window.location.search);
        const abaAtiva = urlParams.get('tab');

        if (abaAtiva) {
            const botaoAba = document.getElementById(abaAtiva + '-tab');
            if (botaoAba) {
                botaoAba.click();
            }
        }

        // 4. MÁGICA: Preencher automaticamente o Modal de Abrir O.T. se viermos do Alerta
        const modalAbrirOT = document.getElementById('modalAbrirOT');
        if (modalAbrirOT) {
            modalAbrirOT.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const idEquip = button.getAttribute('data-idequip');

                // Se o botão tiver um ID de equipamento (ou seja, veio do botão do alerta)
                if (idEquip) {
                    // 4.1. Seleciona o equipamento correto na dropdown
                    const selectEquip = modalAbrirOT.querySelector('select[name="equipamento_id"]');
                    if (selectEquip) {
                        selectEquip.value = idEquip;
                        // Opcional de UX: bloqueia o clique para impedir o user de mudar sem querer
                        selectEquip.style.pointerEvents = 'none';
                    }

                    // 4.2. BÓNUS: Preenche logo o tipo como "Preventiva"
                    const selectTipo = modalAbrirOT.querySelector('select[name="tipo_manutencao"]');
                    if (selectTipo) {
                        selectTipo.value = 'Preventiva (Revisão/Calibração)';
                    }
                }
            });
        }
    });
</script>

<?php if (isset($_SESSION['dados_form'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Magia para repor os dados alterados pelo utilizador após falha de validação
            var dadosAntigos = <?php echo json_encode($_SESSION['dados_form']); ?>;
            var form = document.querySelector('form[action*="processar_edicao_equipamento.php"]');

            if (form) {
                for (var campo in dadosAntigos) {
                    var input = form.querySelector('[name="' + campo + '"]');
                    if (input) {
                        input.value = dadosAntigos[campo];
                    }
                }
            }
        });
    </script>
<?php unset($_SESSION['dados_form']);
endif; ?>

<?php render_footer(); ?>