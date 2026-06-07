<?php
// 1. Ligar à Base de Dados e carregar o Layout
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout.php';

// 2. Verificar se recebemos um ID válido pelo URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /gira/private/equipamentos.php");
    exit;
}

$id_equipamento = (int) $_GET['id'];

try {
    // 3. Ir à base de dados buscar os dados do equipamento
    $sql = "SELECT * FROM equipamentos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_equipamento]);
    $eq = $stmt->fetch();

    if (!$eq) {
        die("<h3>Erro 404: Equipamento não encontrado no parque tecnológico.</h3><a href='/gira/private/equipamentos.php'>Voltar à lista</a>");
    }
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}

// Montamos o topo da página com o nome dinâmico
render_header("Detalhes - " . htmlspecialchars($eq['codigo_ativo']));
?>

<form action="/gira/private/processar_edicao_equipamento.php" method="POST">

    <input type="hidden" name="id_equipamento" value="<?php echo $eq['id']; ?>">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small fw-bold">
                <li class="breadcrumb-item"><a href="/gira/private/equipamentos.php" class="text-decoration-none text-muted">Equipamentos</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Ficha Técnica e Edição</li>
            </ol>
        </nav>
        <div class="d-flex gap-2">
            <a href="/gira/private/equipamentos.php" class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Voltar
            </a>
            <div class="dropdown">
                <button class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary" type="button" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 small">
                    <li><a class="dropdown-item fw-medium py-2" href="#"><i class="fa-solid fa-qrcode text-muted me-2"></i> Imprimir Etiqueta QR</a></li>
                    <li><a class="dropdown-item fw-medium py-2" href="#"><i class="fa-solid fa-ban text-warning me-2"></i> Suspender Equipamento</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item fw-bold text-danger py-2" href="/gira/private/eliminar_equipamento.php?id=<?php echo $eq['id']; ?>" onclick="return confirm('Tem a certeza que deseja abater este equipamento?');"><i class="fa-solid fa-trash-can me-2"></i> Abater Inventário</a></li>
                </ul>
            </div>
            <button type="submit" class="btn btn-success rounded-3 fw-bold small px-3 py-2 shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 border-top border-primary border-4">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            <input type="text" class="form-control form-control-lg fw-bold bg-light border-0 w-auto" name="nome" value="<?php echo htmlspecialchars($eq['nome']); ?>" style="min-width: 350px;">

            <select class="form-select form-select-sm bg-success bg-opacity-10 text-success fw-bold border-success-subtle w-auto rounded-3" name="estado_operacional">
                <option value="Operacional" <?php echo ($eq['estado'] == 'Operacional') ? 'selected' : ''; ?>>Operacional</option>
                <option value="Avariado" <?php echo ($eq['estado'] == 'Inoperacional') ? 'selected' : ''; ?>>Avariado / Em Reparação</option>
                <option value="Aguardar Calibração" <?php echo ($eq['estado'] == 'Manutenção' || $eq['estado'] == 'Aguardar Calibração') ? 'selected' : ''; ?>>Aguardar Calibração</option>
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
                <input type="text" class="form-control form-control-sm bg-light border-0 fw-medium" name="marca" value="<?php echo htmlspecialchars($eq['modelo']); ?>">
            </div>
            <div class="col-6 col-md-4">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-solid fa-location-dot me-1"></i>Localização ID</label>
                <select class="form-select form-select-sm bg-light border-0 fw-bold text-primary" name="localizacao_id">
                    <option value="1" <?php echo ($eq['localizacao_id'] == 1) ? 'selected' : ''; ?>>#LOC-URG01 · Urgências (Reanimação)</option>
                    <option value="2" <?php echo ($eq['localizacao_id'] == 2) ? 'selected' : ''; ?>>#LOC-UCI04 · UCI (Isolamento)</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="text-muted d-block fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><i class="fa-regular fa-calendar me-1"></i>Data Aquisição</label>
                <input type="date" class="form-control form-control-sm bg-light border-0 fw-medium" name="data_aquisicao" value="<?php echo $eq['data_aquisicao']; ?>">
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white px-3 pt-3">
        <ul class="nav nav-underline flex-nowrap overflow-x-auto border-bottom-0 gap-3 fw-bold" id="equipamentoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-nowrap text-secondary pb-3" id="visao-tab" data-bs-toggle="tab" data-bs-target="#visao" type="button" role="tab"><i class="fa-solid fa-cube me-2"></i>Visão Geral</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="manutencao-tab" data-bs-toggle="tab" data-bs-target="#manutencao" type="button" role="tab"><i class="fa-solid fa-screwdriver-wrench me-2"></i>Ordens Trabalho</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab"><i class="fa-regular fa-file-pdf me-2"></i>Documentos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="comercial-tab" data-bs-toggle="tab" data-bs-target="#comercial" type="button" role="tab"><i class="fa-solid fa-handshake me-2"></i>Comercial & Garantias</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="armazem-tab" data-bs-toggle="tab" data-bs-target="#armazem" type="button" role="tab"><i class="fa-solid fa-boxes-stacked me-2"></i>Peças Compativeis</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-nowrap text-secondary pb-3" id="auditoria-tab" data-bs-toggle="tab" data-bs-target="#auditoria" type="button" role="tab"><i class="fa-solid fa-clock-rotate-left me-2"></i>Logs</button>
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
                                <label class="text-muted d-block mb-2 small fw-bold">Consumíveis / Notas</label>
                                <textarea class="form-control bg-light border-0 text-secondary small" name="consumiveis" rows="3"><?php echo htmlspecialchars($eq['consumiveis'] ?? ''); ?></textarea>
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
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center py-5">
                <i class="fa-solid fa-screwdriver-wrench text-muted fs-1 mb-3 opacity-50"></i>
                <p class="text-muted">Ainda não existem ordens de trabalho para este equipamento.</p>
            </div>
        </div>

        <div class="tab-pane fade" id="documentos" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center py-5">
                <i class="fa-solid fa-file-pdf text-muted fs-1 mb-3 opacity-50"></i>
                <p class="text-muted">Gestão de Documentos em desenvolvimento.</p>
            </div>
        </div>

        <div class="tab-pane fade" id="comercial" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center py-5">
                <i class="fa-solid fa-handshake text-muted fs-1 mb-3 opacity-50"></i>
                <p class="text-muted">Gestor Comercial em desenvolvimento.</p>
            </div>
        </div>

        <div class="tab-pane fade" id="armazem" role="tabpanel" tabindex="0">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white text-center py-5">
                <i class="fa-solid fa-boxes-stacked text-muted fs-1 mb-3 opacity-50"></i>
                <p class="text-muted">Integração com Armazém em desenvolvimento.</p>
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

<?php render_footer(); ?>