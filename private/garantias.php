<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Garantias e Contratos de Manutenção");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Garantias e Contratos</h2>
        <p class="text-muted m-0 small">Controlo de coberturas de fábrica, contratos de assistência técnica externa e SLAs de fornecedores.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarGarantia">
        <i class="fa-solid fa-file-shield me-2"></i> Adicionar Contrato / Cobertura
    </button>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Cód. Contrato', 'sort' => 'id_contrato'],
    ['label' => 'Equipamento / Sistema', 'sort' => 'equipamento'],
    ['label' => 'Fornecedor Oficial', 'sort' => 'fornecedor'],
    ['label' => 'Tipo de Cobertura', 'sort' => 'tipo'],
    ['label' => 'Fim da Garantia', 'sort' => 'data_fim'],
    ['label' => 'Estado', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

<tr>
    <td class="fw-bold text-primary fw-mono">#GAR-2026-088</td>
    <td>
        <div class="fw-bold">Monitor Multiparamétrico de Sinais Vitais</div>
        <small class="text-muted">Mindray · BeneVision N17</small>
    </td>
    <td>Mindray Medical Portugal</td>
    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Garantia de Fábrica (3 Anos)</span></td>
    <td>15/10/2028</td>
    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
    <td class="text-end">
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Termos do Contrato">
            <button class="btn btn-light btn-sm rounded-3 me-1 border">
                <i class="fa-solid fa-eye text-primary"></i>
            </button>
        </span>
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Terminar Cobertura">
            <button class="btn btn-light btn-sm rounded-3 text-danger border">
                <i class="fa-solid fa-ban"></i>
            </button>
        </span>
    </td>
</tr>

<tr>
    <td class="fw-bold text-primary fw-mono">#GAR-2023-012</td>
    <td>
        <div class="fw-bold">Bomba de Infusão Volumétrica</div>
        <small class="text-muted">Lote Geral Volumétricas</small>
    </td>
    <td>B. Braun Medical S.A.</td>
    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Suporte Técnico Básico</span></td>
    <td>01/01/2026</td>
    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Expirado</span></td>
    <td class="text-end">
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Termos do Contrato">
            <button class="btn btn-light btn-sm rounded-3 me-1 border">
                <i class="fa-solid fa-eye text-primary"></i>
            </button>
        </span>
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Terminar Cobertura">
            <button class="btn btn-light btn-sm rounded-3 text-danger border">
                <i class="fa-solid fa-ban"></i>
            </button>
        </span>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamente
render_table_end();

// 4. Fechamos a página e injetamos os scripts centrais
render_footer();
?>