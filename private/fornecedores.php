<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/layout.php';

// 2. Montamos o topo da página com o título correto para a aba do browser
render_header("Gira - Gestão de Fornecedores");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Gestão de Fornecedores</h2>
        <p class="text-muted m-0 small">Controlo de contratos, contactos e assistência técnica oficial das marcas parceiras.</p>
    </div>

    <button class="btn btn-primary rounded-3 fw-bold small px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRegistarFornecedor">
        <i class="fa-solid fa-truck-field text-white me-2"></i> Registar Fornecedor
    </button>
</div>

<?php
// 1. Definimos as colunas da tabela
$colunas = [
    ['label' => 'Fornecedor / NIF', 'sort' => 'nif_empresa'],
    ['label' => 'Contacto Técnico'],
    ['label' => 'Categoria Principal'],
    ['label' => 'Estado da Parceria', 'sort' => 'estado'],
    ['label' => 'Ações', 'align' => 'end']
];

// 2. Desenhamos a caixa exterior e os cabeçalhos automaticamente!
render_table_start($colunas);
?>

<tr>
    <td>
        <div class="fw-bold text-primary">Mindray Medical Portugal</div>
        <small class="text-muted fw-mono">NIF: 512987654</small>
    </td>
    <td><a href="mailto:suporte@mindray.pt" class="text-decoration-none">suporte@mindray.pt</a></td>
    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Monitores de Sinais Vitais</span></td>
    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
    <td class="text-end">
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Dados do Fornecedor">
            <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>
        </span>
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
            <button class="btn btn-light btn-sm rounded-3 text-danger border">
                <i class="fa-solid fa-trash"></i>
            </button>
        </span>
    </td>
</tr>

<tr>
    <td>
        <div class="fw-bold text-primary">B. Braun Medical S.A.</div>
        <small class="text-muted fw-mono">NIF: 500123456</small>
    </td>
    <td><a href="mailto:apoio.tecnico@bbraun.com" class="text-decoration-none">apoio.tecnico@bbraun.com</a></td>
    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Bombas de Infusão</span></td>
    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Expirado</span></td>
    <td class="text-end">
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Dados do Fornecedor">
            <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor">
                <i class="fa-solid fa-pen text-primary"></i>
            </button>
        </span>
        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
            <button class="btn btn-light btn-sm rounded-3 text-danger border">
                <i class="fa-solid fa-trash"></i>
            </button>
        </span>
    </td>
</tr>

<?php
// 3. Fechamos as tags da tabela automaticamentegit config user.name "Simão Cacheira"
render_table_end();

// 4. Fechamos a página e injetamos os scripts centrais!
render_footer();
?>