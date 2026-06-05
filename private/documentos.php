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

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Ref. Doc', 'sort' => 'id_doc'],
    ['label' => 'Nome do Documento / Ficheiro', 'sort' => 'nome'],
    ['label' => 'Tipo', 'sort' => 'tipo'],
    ['label' => 'Dispositivo Associado', 'sort' => 'equipamento'],
    ['label' => 'Data de Upload', 'sort' => 'data_upload'],
    ['label' => 'Tamanho', 'sort' => 'tamanho'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

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
            <i class="fa-solid fa-download text-primary"></i>
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
            <i class="fa-solid fa-download text-primary"></i>
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
            <i class="fa-solid fa-download text-primary"></i>
        </button>
        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar Documento">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamente!
render_table_end();

// 4. Fechamos a página e injetamos os scripts centrais
render_footer();
?>