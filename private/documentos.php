<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Documentos Técnicos");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Repositório de Documentos</h2>
        <p class="text-muted m-0 small">Arquivo centralizado de manuais de utilizador, certificados de calibração e relatórios de conformidade.</p>
    </div>
    
    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoDocumento">
        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Enviar Documento
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
            
            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('id_doc')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Ref. Doc <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('nome')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Nome do Documento / Ficheiro <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('tipo')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Tipo <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('equipamento')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Dispositivo Associado <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('data_upload')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Data de Upload <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('tamanho')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Tamanho <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td class="fw-bold text-primary fw-mono">#DOC-9921</td>
                    <td>
                        <div class="fw-bold"><i class="fa-regular fa-file-pdf text-danger me-2 fs-5 align-middle"></i>Manual Técnico de Serviço - Evita V500</div>
                        <small class="text-muted">Evita_Infinity_V500_Service_EN.pdf</small>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Manual Técnico</span></td>
                    <td class="fw-mono text-secondary">#EQ-2026-001</td>
                    <td>28/05/2026</td>
                    <td>14.2 MB</td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar Ficheiro">
                            <i class="fa-solid fa-download text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Documento">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                
                <tr>
                    <td class="fw-bold text-primary fw-mono">#DOC-9922</td>
                    <td>
                        <div class="fw-bold"><i class="fa-regular fa-file-pdf text-danger me-2 fs-5 align-middle"></i>Certificado de Calibração Anual 2026</div>
                        <small class="text-muted">Certificado_Philips_Affiniti_70_Assinado.pdf</small>
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2">Metrologia / Calibração</span></td>
                    <td class="fw-mono text-secondary">#EQ-2026-002</td>
                    <td>14/04/2026</td>
                    <td>2.4 MB</td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar Ficheiro">
                            <i class="fa-solid fa-download text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Documento">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-primary fw-mono">#DOC-9923</td>
                    <td>
                        <div class="fw-bold"><i class="fa-regular fa-file-image text-primary me-2 fs-5 align-middle"></i>Fatura Pró-Forma de Aquisição</div>
                        <small class="text-muted">FT_BBraun_Infusao_2026.png</small>
                    </td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle px-2">Financeiro / Fatura</span></td>
                    <td class="fw-mono text-secondary">Nenhum</td>
                    <td>02/02/2026</td>
                    <td>845 KB</td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar Ficheiro">
                            <i class="fa-solid fa-download text-muted"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Documento">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNovoDocumento" tabindex="-1" aria-labelledby="modalNovoDocumentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold" id="modalNovoDocumentoLabel">
                    <i class="fa-solid fa-file-import text-primary me-2"></i>Upload de Documento Técnico
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formNovoDocumento" action="processar_documento.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="docNome" class="form-label small fw-bold text-secondary">Nome Identificativo do Documento</label>
                        <input type="text" class="form-control rounded-3 bg-light border-0" id="docNome" name="nome_doc" placeholder="Ex: Certificado de Calibração Anual 2026" required>
                    </div>

                    <div class="mb-3">
                        <label for="docTipo" class="form-label small fw-bold text-secondary">Tipo de Documento</label>
                        <select class="form-select rounded-3 bg-light border-0" id="docTipo" name="tipo_doc" required>
                            <option value="" selected disabled>Escolha uma opção...</option>
                            <option value="Manual Técnico">Manual Técnico / Serviço</option>
                            <option value="Metrologia / Calibração">Metrologia / Calibração</option>
                            <option value="Financeiro / Fatura">Financeiro / Fatura</option>
                            <option value="Relatório Técnico">Relatório Técnico de Instalação</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="docEquipamento" class="form-label small fw-bold text-secondary">Dispositivo Médico Associado</label>
                        <select class="form-select rounded-3 bg-light border-0 fw-mono" id="docEquipamento" name="equipamento_doc">
                            <option value="Nenhum" selected>Nenhum (Documento Geral)</option>
                            <option value="#EQ-2026-001">#EQ-2026-001 - Dräger Evita V500</option>
                            <option value="#EQ-2026-002">#EQ-2026-002 - Philips Affiniti 70</option>
                            <option value="#EQ-2026-003">#EQ-2026-003 - Mindray BeneVision N17</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="docFicheiro" class="form-label small fw-bold text-secondary">Selecionar Ficheiro (PDF, PNG, JPG)</label>
                        <input class="form-control rounded-3" type="file" id="docFicheiro" name="ficheiro_doc" required>
                        <div class="form-text opacity-75" style="font-size: 0.7rem;">Tamanho máximo permitido: 20MB.</div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoDocumento" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-upload me-2"></i>Submeter Arquivo
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    document.querySelector('a[href="documentos.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar documentos por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde
render_footer();
?>