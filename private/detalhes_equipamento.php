<?php
// 1. Chamamos o molde
require_once 'layout.php';

// 2. Montamos o topo da página
render_header("Gira - Detalhes do Equipamento");
?>

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 fw-mono">#EQ-2026-001</span>
            <span class="badge bg-success rounded-pill px-2"><i class="fa-solid fa-check me-1"></i> Operacional</span>
            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2">Suporte de Vida</span>
        </div>
        <h2 class="fw-bold m-0 text-dark">Monitor Multiparamétrico - Philips IntelliVue</h2>
        <p class="text-muted m-0 mt-1"><i class="fa-solid fa-barcode me-2"></i>SN: <strong>MPS-2022-45873</strong></p>
    </div>
    
    <div class="d-flex gap-2">
        <a href="equipamentos.php" class="btn btn-light border rounded-3 fw-bold small px-3 py-2 shadow-sm text-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Voltar
        </a>
        <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm">
            <i class="fa-solid fa-pen me-2"></i>Editar Dados
        </button>
    </div>
</div>

<!-- ============================================================================== -->
<!-- ESTILOS CSS NATIVOS PARA AS ABAS (Substitui o antigo JavaScript)               -->
<!-- ============================================================================== -->
<style>
    /* Estilo base para todas as abas */
    #equipamentoTabs .nav-link {
        color: #6c757d; /* Cor neutra para abas inativas */
        border: none;
        border-bottom: 3px solid transparent; /* Espaço invisível para a borda */
        background-color: transparent;
        padding: 1rem 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }
    
    /* Efeito ao passar o rato (Hover) */
    #equipamentoTabs .nav-link:hover {
        border-bottom: 3px solid #dee2e6;
        color: #495057;
    }
    
    /* Estilo da aba ativa (A tal linha azul) */
    #equipamentoTabs .nav-link.active {
        color: #212529 !important; /* Texto escuro/forte */
        border-bottom: 3px solid #0d6efd !important; /* Linha azul primária */
        background-color: transparent;
    }
</style>

<!-- ============================================================================== -->
<!-- NAVEGAÇÃO EM ABAS (NAVS & TABS)                                                -->
<!-- ============================================================================== -->
<ul class="nav nav-tabs border-bottom mb-4 gap-4" id="equipamentoTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ficha-tab" data-bs-toggle="tab" data-bs-target="#ficha" type="button" role="tab">
            <i class="fa-solid fa-info-circle me-2"></i>Ficha Técnica
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="manutencao-tab" data-bs-toggle="tab" data-bs-target="#manutencao" type="button" role="tab">
            <i class="fa-solid fa-wrench me-2"></i>Manutenções e OTs
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="financeiro-tab" data-bs-toggle="tab" data-bs-target="#financeiro" type="button" role="tab">
            <i class="fa-solid fa-chart-line me-2"></i>Financeiro e Garantias
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab">
            <i class="fa-solid fa-folder-open me-2"></i>Documentos e Anexos
        </button>
    </li>
</ul>

<!-- ============================================================================== -->
<!-- CONTEÚDO DAS ABAS                                                              -->
<!-- ============================================================================== -->
<div class="tab-content" id="equipamentoTabsContent">

    <div class="tab-pane fade show active" id="ficha" role="tabpanel" tabindex="0">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                    <h6 class="fw-bold mb-4 border-bottom pb-2 text-dark">Informações Gerais e Rede</h6>
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.7rem;">FABRICANTE E MODELO</small>
                            <span class="fw-medium text-dark">Philips Healthcare · IntelliVue MX400</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.7rem;">ENDEREÇO MAC (IT)</small>
                            <span class="fw-mono text-dark">00:1A:2B:3C:4D:5E</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.7rem;">LOCALIZAÇÃO ATUAL</small>
                            <span class="fw-medium text-dark"><i class="fa-solid fa-location-dot text-primary me-1"></i> UCI - Sala 2 (Cama 4)</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.7rem;">METROLOGIA</small>
                            <span class="fw-medium text-dark">Próxima calibração a 15/07/2026</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white border-start border-success border-4">
                    <h6 class="fw-bold mb-3 text-dark">Estado Clínico Atual</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                            <i class="fa-solid fa-heart-pulse fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-success mb-0">Disponível</h5>
                            <small class="text-muted">Pronto para uso em paciente</small>
                        </div>
                    </div>
                    <div class="mt-auto pt-3 border-top border-light">
                        <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.7rem;">ÚLTIMA UTILIZAÇÃO / ALERTA</small>
                        <span class="text-secondary small">Nenhum evento adverso registado.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="manutencao" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0 text-dark">Histórico de Intervenções (OTs)</h6>
                <button class="btn btn-sm btn-outline-primary rounded-3 fw-bold"><i class="fa-solid fa-plus me-1"></i> Abrir OT</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>Nº O.T.</th>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Técnico Responsável</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-primary fw-mono">#OT-2026-042</td>
                            <td>12/03/2026</td>
                            <td><span class="badge bg-danger bg-opacity-10 text-danger border px-2">Corretiva</span></td>
                            <td>Eng. Maria Helena</td>
                            <td><span class="badge bg-light text-muted border rounded-pill px-2">Concluída</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-primary fw-mono">#OT-2026-011</td>
                            <td>10/01/2026</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success border px-2">Preventiva</span></td>
                            <td>Eng. João Martins</td>
                            <td><span class="badge bg-light text-muted border rounded-pill px-2">Concluída</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="financeiro" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h6 class="fw-bold mb-4 text-dark">Dados de Aquisição e Garantia</h6>
            <p class="text-muted">A preparar a integração do painel de TCO (Total Cost of Ownership)...</p>
        </div>
    </div>

    <div class="tab-pane fade" id="documentos" role="tabpanel" tabindex="0">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0 text-dark">Biblioteca de Anexos</h6>
                <button class="btn btn-sm btn-outline-primary rounded-3 fw-bold"><i class="fa-solid fa-upload me-1"></i> Anexar</button>
            </div>
            <div class="d-flex align-items-center p-3 border rounded-3 mb-2 bg-light bg-opacity-50">
                <div class="text-danger fs-3 me-3"><i class="fa-solid fa-file-pdf"></i></div>
                <div class="flex-grow-1">
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">Manual_Servico_IntelliVue_MX400.pdf</h6>
                    <small class="text-muted" style="font-size: 0.7rem;">Carregado a 15/01/2022 · 4.2 MB</small>
                </div>
                <button class="btn btn-light btn-sm border rounded-3 text-secondary"><i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>

</div>

<?php
render_footer();
?>