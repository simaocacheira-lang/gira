<?php
// 1. Chamamos o molde para trazer a Sidebar e a Topbar automáticas
require_once 'layout.php';

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

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">

            <thead class="table-light">
                <tr class="text-muted fw-bold unselectable">
                    <th class="th-sortable" onclick="simularOrdenacao('nif_empresa')">
                        <div class="d-inline-flex align-items-center gap-1">
                            NIF / Empresa <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('contacto')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Contacto Principal <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('email')">
                        <div class="d-inline-flex align-items-center gap-1">
                            E-mail de Suporte <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('representacao')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Representação Oficial <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="th-sortable" onclick="simularOrdenacao('estado_contrato')">
                        <div class="d-inline-flex align-items-center gap-1">
                            Estado do Contrato <i class="fa-solid fa-sort th-sort-icon"></i>
                        </div>
                    </th>
                    <th class="text-end">Ações Técnicas</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td class="text-muted fw-mono">
                        501234567<br>
                        <strong class="text-dark fs-6 d-block mt-1">Philips Healthcare Portugal</strong>
                    </td>
                    <td>210 000 000</td>
                    <td><a href="mailto:suporte.pt@philips.com" class="text-decoration-none">suporte.pt@philips.com</a></td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">Monitores e Imagiologia</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor" title="Alterar Dados do Fornecedor">
                            <i class="fa-solid fa-pen text-primary"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="text-muted fw-mono">
                        502987654<br>
                        <strong class="text-dark fs-6 d-block mt-1">Dräger Portugal Lda.</strong>
                    </td>
                    <td>219 999 999</td>
                    <td><a href="mailto:service.pt@draeger.com" class="text-decoration-none">service.pt@draeger.com</a></td>
                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-2">Ventilação e Anestesia</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Ativo</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor" title="Alterar Dados do Fornecedor">
                            <i class="fa-solid fa-pen text-primary"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="text-muted fw-mono">
                        503444555<br>
                        <strong class="text-dark fs-6 d-block mt-1">B. Braun Medical S.A.</strong>
                    </td>
                    <td>214 444 444</td>
                    <td><a href="mailto:apoio.tecnico@bbraun.com" class="text-decoration-none">apoio.tecnico@bbraun.com</a></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2">Bombas de Infusão</span></td>
                    <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Expirado</span></td>
                    <td class="text-end">
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor" title="Alterar Dados do Fornecedor">
                            <i class="fa-solid fa-pen text-primary"></i>
                        </button>
                        <button class="btn btn-light btn-sm rounded-3 text-danger border" data-bs-toggle="tooltip" data-bs-placement="top" title="Revogar Contrato/Fornecedor">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
    document.querySelector('a[href="fornecedores.php"]').classList.add('active');

    function simularOrdenacao(coluna) {
        console.log("Pronto para ordenar fornecedores por: " + coluna);
    }
</script>

<?php
// 3. Chamamos o fim do molde para renderizar os scripts finais
render_footer();
?>