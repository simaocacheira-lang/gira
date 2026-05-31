// Tooltips
document.addEventListener("DOMContentLoaded", function () {
    // Inicializa todos os Tooltips (balões de ajuda) do Bootstrap automaticamente na página
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});