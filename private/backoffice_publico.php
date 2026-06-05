<?php
// Chama o molde para trazer a Sidebar e a Topbar automáticas
require_once __DIR__ . '/layout.php';

// Monta o topo da página com o título correto para a aba
render_header("Gira - Backoffice da Área Pública");
?>

<div class="mb-4">
    <h2 class="fw-bold m-0">Gerir Área Pública</h2>
    <p class="text-muted m-0 small">Altere os conteúdos visíveis na página inicial sem mexer no código HTML.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-5">

    <ul class="nav nav-tabs mb-4 border-bottom-0" id="backofficeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold small rounded-3 me-2" id="Hero-tab" data-bs-toggle="tab" data-bs-target="#Hero" type="button" role="tab">Secção Inicial</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold small rounded-3 me-2 text-muted" id="sobre-tab" data-bs-toggle="tab" data-bs-target="#sobre" type="button" role="tab">Sobre Nós</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold small rounded-3 text-muted" id="contacto-tab" data-bs-toggle="tab" data-bs-target="#contacto" type="button" role="tab">Contactos & Rodapé</button>
        </li>
    </ul>

    <div class="tab-content" id="backofficeTabsContent">

        <div class="tab-pane fade show active" id="Hero" role="tabpanel">
            <form>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="heroTitle" class="form-label small fw-bold text-secondary">Título Principal (H1)</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" id="heroTitle" value="Tecnologia que transforma a gestão hospitalar.">
                    </div>

                    <div class="col-12">
                        <label for="heroSub" class="form-label small fw-bold text-secondary">Texto de Apoio (Lead)</label>
                        <textarea class="form-control bg-light border-0 p-2.5" id="heroSub" rows="3">Solução completa para inventário de equipamentos médicos, gestão de fornecedores, documentação técnica e muito mais. Mais controlo, menos tempo perdido.</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="heroMetricVal" class="form-label small fw-bold text-secondary">Valor da Métrica</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" id="heroMetricVal" value="+1.500">
                    </div>
                    <div class="col-md-6">
                        <label for="heroMetricLabel" class="form-label small fw-bold text-secondary">Legenda da Métrica</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" id="heroMetricLabel" value="Equipamentos Geridos">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="button" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações</button>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="sobre" role="tabpanel">
            <form>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="sobreTitle" class="form-label small fw-bold text-secondary">Título da Secção</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" id="sobreTitle" value="Tecnologia ao serviço da excelência hospitalar.">
                    </div>
                    <div class="col-12">
                        <label for="sobreText1" class="form-label small fw-bold text-secondary">Parágrafo 1</label>
                        <textarea class="form-control bg-light border-0 p-2.5" id="sobreText1" rows="3">A Gira nasceu com um propósito claro: eliminar o caos administrativo e garantir que as equipas médicas têm sempre os equipamentos certos, prontos a usar e com as manutenções em dia.</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="button" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações</button>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="contacto" role="tabpanel">
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="contEmail" class="form-label small fw-bold text-secondary">E-mail Institucional</label>
                        <input type="email" class="form-control bg-light border-0 p-2.5" id="contEmail" value="geral@gira.pt">
                    </div>
                    <div class="col-md-6">
                        <label for="contPhone" class="form-label small fw-bold text-secondary">Telefone / Contacto</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" id="contPhone" value="+351 912 345 678">
                    </div>
                    <div class="col-12">
                        <label for="contMorada" class="form-label small fw-bold text-secondary">Morada Física</label>
                        <input type="text" class="form-control bg-light border-0 p-2.5" id="contMorada" value="Rua Dr. António Bernardino de Almeida, 431, Porto, Portugal">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="button" class="btn btn-primary rounded-3 fw-bold small px-4"><i class="fa-solid fa-floppy-disk me-2"></i>Guardar Alterações</button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php
render_footer();
?>