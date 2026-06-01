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
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Dados do Fornecedor">
                            <i class="fa-solid fa-pen text-muted"></i>
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
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Dados do Fornecedor">
                            <i class="fa-solid fa-pen text-muted"></i>
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
                        <button class="btn btn-light btn-sm rounded-3 me-1 border" data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Dados do Fornecedor">
                            <i class="fa-solid fa-pen text-muted"></i>
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

<div class="modal fade" id="modalRegistarFornecedor" tabindex="-1" aria-labelledby="modalRegistarFornecedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            
            <div class="modal-header border-bottom border-light p-3">
                <h5 class="modal-title fw-bold" id="modalRegistarFornecedorLabel">
                    <i class="fa-solid fa-truck-field text-primary me-2"></i>Registar Entidade Parceira / Fornecedor
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form id="formNovoFornecedor" action="processar_fornecedor.php" method="POST">
                    
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label for="fornNome" class="form-label small fw-bold text-secondary">Nome da Entidade / Empresa</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" id="fornNome" name="nome_empresa" placeholder="Ex: Siemens Healthcare Lda." required>
                        </div>
                        <div class="col-md-5">
                            <label for="fornNIF" class="form-label small fw-bold text-secondary">NIF (Número de Identificação Fiscal)</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0 fw-mono" id="fornNIF" name="nif" placeholder="Ex: 501234567" maxlength="9" required>
                        </div>

                        <div class="col-md-5">
                            <label for="fornContacto" class="form-label small fw-bold text-secondary">Contacto Telefónico Principal</label>
                            <input type="text" class="form-control rounded-3 bg-light border-0" id="fornContacto" name="contacto" placeholder="Ex: 210 000 000" required>
                        </div>
                        <div class="col-md-7">
                            <label for="fornEmail" class="form-label small fw-bold text-secondary">E-mail Oficial de Suporte Técnico</label>
                            <input type="email" class="form-control rounded-3 bg-light border-0" id="fornEmail" name="email" placeholder="Ex: suporte.pt@empresa.com" required>
                        </div>

                        <div class="col-md-6">
                            <label for="fornRep" class="form-label small fw-bold text-secondary">Representação / Especialidade Biomédica</label>
                            <select class="form-select rounded-3 bg-light border-0" id="fornRep" name="representacao" required>
                                <option value="" selected disabled>Escolha a especialidade...</option>
                                <option value="Monitores e Imagiologia">Monitores e Imagiologia Médica</option>
                                <option value="Ventilação e Anestesia">Ventilação, Blocos e Anestesia</option>
                                <option value="Bombas de Infusão">Sistemas de Infusão e Seringas</option>
                                <option value="Esterilização">Sistemas de Esterilização / Autoclaves</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fornEstado" class="form-label small fw-bold text-secondary">Estado Inicial do Vínculo</label>
                            <select class="form-select rounded-3 bg-light border-0" id="fornEstado" name="estado_contrato" required>
                                <option value="Ativo" selected>Ativo (Entidade Autorizada a Intervir)</option>
                                <option value="Expirado">Contrato Suspenso / Expirado</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top border-light p-3">
                <button type="button" class="btn btn-light rounded-3 fw-bold small text-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNovoFornecedor" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Registar Empresa
                </button>
            </div>

        </div>
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