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
    $sql = "SELECT e.*, f.nome_empresa, f.email_suporte, f.telefone_suporte 
            FROM equipamentos e 
            LEFT JOIN fornecedores f ON e.fornecedor_id = f.id 
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

    // 7. A MAGIA DO ARMAZÉM: Se este equipamento tiver uma peça associada (um ID numérico), vamos ver o stock!
    $consumivel = null;
    if (!empty($eq['consumiveis']) && is_numeric($eq['consumiveis'])) {
        $sql_cons = "SELECT * FROM artigos_armazem WHERE id = :id_artigo";
        $stmt_cons = $pdo->prepare($sql_cons);
        $stmt_cons->execute([':id_artigo' => $eq['consumiveis']]);
        $consumivel = $stmt_cons->fetch();
    }
    // 8. NOVA PESQUISA: Buscar o catálogo do armazém para podermos associar peças
    $sql_art = "SELECT id, referencia, nome FROM artigos_armazem ORDER BY nome ASC";
    $stmt_art = $pdo->query($sql_art);
    $lista_artigos = $stmt_art->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}

render_header("Detalhes - " . htmlspecialchars($eq['codigo_ativo']));
?>

<form action="/sibdas/1241251/gira/private/equipamentos/processar_edicao_equipamento.php" method="POST">

    <input type="hidden" name="id_equipamento" value="<?php echo $eq['id']; ?>">
    <input type="hidden" name="fornecedor_id" value="<?php echo $eq['fornecedor_id']; ?>">

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
                    <li><a class="dropdown-item fw-medium py-2" href="#"><i class="fa-solid fa-qrcode text-muted me-2"></i> Imprimir Etiqueta QR</a></li>
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
                <button class="nav-link text-secondary rounded-pill px-4 py-2 text-nowrap" id="manutencao-tab" data-bs-toggle="tab" data-bs-target="#manutencao" type="button" role="tab">
                    <i class="fa-solid fa-screwdriver-wrench me-2"></i>Ordens de Trabalho
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary rounded-pill px-4 py-2 text-nowrap" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab">
                    <i class="fa-regular fa-file-pdf me-2"></i>Documentos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary rounded-pill px-4 py-2 text-nowrap" id="comercial-tab" data-bs-toggle="tab" data-bs-target="#comercial" type="button" role="tab">
                    <i class="fa-solid fa-handshake me-2"></i>Comercial e Garantias
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary rounded-pill px-4 py-2 text-nowrap" id="armazem-tab" data-bs-toggle="tab" data-bs-target="#armazem" type="button" role="tab">
                    <i class="fa-solid fa-boxes-stacked me-2"></i>Peças Compatíveis
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-secondary rounded-pill px-4 py-2 text-nowrap" id="auditoria-tab" data-bs-toggle="tab" data-bs-target="#auditoria" type="button" role="tab">
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

                            <div class="col-12 mt-4 pt-3 border-top">
                                <label class="text-muted d-block mb-2 small fw-bold">ID do Consumível / Peça Base (Oculto)</label>
                                <input type="text" class="form-control bg-light border-0 text-secondary small fw-mono" value="<?php echo htmlspecialchars($eq['consumiveis'] ?? 'Sem ID Associado'); ?>" readonly disabled>
                                <small class="text-muted mt-1 d-block">A gestão da peça associada é agora feita na aba "Peças Compatíveis".</small>
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
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                        <h6 class="fw-bold mb-4 text-dark fs-5"><i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>Processo de Aquisição</h6>

                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Fornecedor Oficial</label>
                                <div class="fw-bold text-dark"><?php echo !empty($eq['nome_empresa']) ? htmlspecialchars($eq['nome_empresa']) : '<em class="text-muted">Não definido</em>'; ?></div>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Data de Aquisição</label>
                                <div class="fw-bold text-dark"><?php echo !empty($eq['data_aquisicao']) ? date('d/m/Y', strtotime($eq['data_aquisicao'])) : '-'; ?></div>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Valor de Aquisição</label>
                                <div class="fw-bold text-dark fs-5"><?php echo !empty($eq['custo_aquisicao']) ? number_format($eq['custo_aquisicao'], 2, ',', ' ') . ' €' : '-'; ?></div>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted d-block mb-1 small fw-bold">Contactos de Suporte</label>
                                <?php if (!empty($eq['email_suporte']) || !empty($eq['telefone_suporte'])): ?>
                                    <div class="small">
                                        <?php if (!empty($eq['email_suporte'])) echo '<i class="fa-solid fa-envelope text-muted me-1"></i> ' . htmlspecialchars($eq['email_suporte']) . '<br>'; ?>
                                        <?php if (!empty($eq['telefone_suporte'])) echo '<i class="fa-solid fa-phone text-muted me-1"></i> ' . htmlspecialchars($eq['telefone_suporte']); ?>
                                    </div>
                                <?php else: ?>
                                    <em class="text-muted small">Sem contactos diretos</em>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-dark fs-5 m-0"><i class="fa-solid fa-shield-halved text-success me-2"></i>Cobertura</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill fw-bold" style="font-size: 0.7rem;" data-bs-toggle="modal" data-bs-target="#modalAdicionarGarantia" data-idequip="<?php echo $eq['id']; ?>">
                                <i class="fa-solid fa-pen me-1"></i> Atualizar
                            </button>
                        </div>

                        <?php
                        // Lógica de cálculo da garantia (Válida ou Expirada)
                        $tem_garantia = !empty($eq['fim_garantia']);
                        $garantia_expirada = false;
                        if ($tem_garantia) {
                            $data_fim = new DateTime($eq['fim_garantia']);
                            $hoje = new DateTime();
                            $hoje->setTime(0, 0, 0); // Limpar horas para comparar apenas os dias
                            $garantia_expirada = $data_fim < $hoje;
                        }
                        ?>

                        <?php if (!$tem_garantia): ?>
                            <div class="text-center py-4 bg-light rounded-3 border border-dashed">
                                <i class="fa-solid fa-file-shield text-muted fs-3 mb-2 opacity-50"></i>
                                <p class="text-muted small m-0">Sem data de garantia registada.</p>
                            </div>
                        <?php else: ?>
                            <div class="p-3 rounded-3 border <?php echo $garantia_expirada ? 'border-danger bg-danger bg-opacity-10' : 'border-success bg-success bg-opacity-10'; ?>">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid <?php echo $garantia_expirada ? 'fa-shield-virus text-danger' : 'fa-shield-check text-success'; ?> fs-1 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold m-0 <?php echo $garantia_expirada ? 'text-danger' : 'text-success'; ?>">Garantia de Fábrica</h6>
                                        <small class="<?php echo $garantia_expirada ? 'text-danger' : 'text-success'; ?> opacity-75">
                                            <?php echo $garantia_expirada ? 'Expirou a ' : 'Válida até '; ?>
                                            <strong><?php echo date('d/m/Y', strtotime($eq['fim_garantia'])); ?></strong>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 pt-3 border-top">
                            <label class="text-muted d-block mb-2 small fw-bold">Contratos de Manutenção (Extensões)</label>
                            <div class="text-center py-3 bg-light rounded-3 border border-dashed">
                                <span class="text-muted small">Funcionalidade de extensões em desenvolvimento.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="armazem" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-dark fs-5 m-0"><i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Peça / Consumível Compatível</h6>

                    <div style="width: 350px;">
                        <select class="form-select form-select-sm bg-light border border-secondary border-opacity-25 fw-bold text-primary shadow-sm" name="consumiveis" onchange="document.getElementById('avisoGuardarPeca').classList.remove('d-none');">
                            <option value="">Nenhuma (Remover Associação)</option>
                            <?php foreach ($lista_artigos as $artigo): ?>
                                <option value="<?php echo $artigo['id']; ?>" <?php echo ($eq['consumiveis'] == $artigo['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($artigo['referencia'] . ' - ' . $artigo['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div id="avisoGuardarPeca" class="alert alert-warning border-warning py-2 mb-4 d-none d-flex align-items-center rounded-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-warning"></i>
                    <div>
                        <strong class="d-block">Atenção! A peça associada foi alterada.</strong>
                        <span class="small">Para gravar e aplicar esta integração, clica no botão verde <b>"Guardar Alterações"</b> no topo da página.</span>
                    </div>
                </div>

                <?php if ($consumivel):
                    // Calcular se há rutura de stock para pintar de vermelho
                    $em_rutura = ($consumivel['quantidade_atual'] < $consumivel['quantidade_minima']);
                    $cor_stock = $em_rutura ? 'danger' : 'success';
                ?>
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="p-4 border rounded-4 bg-light h-100 position-relative overflow-hidden">
                                <small class="text-muted fw-bold text-uppercase d-block mb-2" style="font-size: 0.7rem;">Designação Oficial no Armazém</small>
                                <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($consumivel['nome']); ?></h5>
                                <span class="badge bg-secondary text-white fw-mono px-2 py-1"><?php echo htmlspecialchars($consumivel['referencia']); ?></span>

                                <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 small text-muted">
                                    <i class="fa-solid fa-layer-group me-2"></i> Categoria: <strong><?php echo htmlspecialchars($consumivel['categoria']); ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="p-4 border rounded-4 border-<?php echo $cor_stock; ?> bg-<?php echo $cor_stock; ?> bg-opacity-10 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                                <small class="text-<?php echo $cor_stock; ?> fw-bold text-uppercase mb-2" style="font-size: 0.75rem;">
                                    <?php echo $em_rutura ? '<i class="fa-solid fa-triangle-exclamation me-1"></i> Stock em Rutura' : '<i class="fa-solid fa-check-circle me-1"></i> Stock Saudável'; ?>
                                </small>

                                <h1 class="fw-black text-<?php echo $cor_stock; ?> m-0 mb-1" style="font-size: 3rem;">
                                    <?php echo $consumivel['quantidade_atual']; ?> <span class="fs-6 fw-medium">Unid.</span>
                                </h1>
                                <small class="text-muted fw-medium">Mínimo Exigido: <?php echo $consumivel['quantidade_minima']; ?></small>

                                <?php if ($em_rutura): ?>
                                    <div class="mt-4 w-100">
                                        <a href="/sibdas/1241251/gira/private/armazem/armazem.php" class="btn btn-danger btn-sm w-100 rounded-3 fw-bold py-2 shadow-sm hover-danger">
                                            <i class="fa-solid fa-cart-arrow-down me-2"></i> Ir para o Armazém
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                        <div class="bg-white p-3 rounded-circle d-inline-block shadow-sm mb-3">
                            <i class="fa-solid fa-link-slash text-muted fs-3 opacity-50"></i>
                        </div>
                        <p class="fw-bold text-dark m-0">Nenhuma peça de armazém associada.</p>
                        <p class="text-muted small mt-2">Para ter acompanhamento de stock em tempo real, edite a ficha técnica e selecione o consumível compatível.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="auditoria" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center py-5">
                <i class="fa-solid fa-clock-rotate-left text-muted fs-1 mb-3 opacity-50"></i>
                <p class="text-muted">Sistema de Logs em desenvolvimento.</p>
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
    });
</script>

<?php render_footer(); ?>