<?php
// 1. Ligar à Base de Dados e iniciar sessão
require_once __DIR__ . '/../db.php';
session_start();

// 2. Verificar se recebemos um ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id_documento = (int) $_GET['id'];

    try {
        // 3. Ir buscar os dados do documento ANTES de o apagar
        // Precisamos do caminho para apagar o ficheiro físico e do nome para o Log
        $stmt_info = $pdo->prepare("SELECT nome_documento, caminho_ficheiro FROM documentos_equipamento WHERE id = :id");
        $stmt_info->execute([':id' => $id_documento]);
        $doc = $stmt_info->fetch();

        if ($doc) {
            // 4. ELIMINAÇÃO FÍSICA: Apagar o ficheiro da pasta "uploads"
            // Como o caminho na BD costuma ser "uploads/ficheiro.pdf", juntamos isso ao diretório atual
            $caminho_absoluto = __DIR__ . '/../' . $doc['caminho_ficheiro'];

            if (file_exists($caminho_absoluto) && is_file($caminho_absoluto)) {
                unlink($caminho_absoluto); // A função unlink() apaga o ficheiro do disco do servidor
            }

            // 5. ELIMINAÇÃO LÓGICA: Apagar o registo da Base de Dados
            $sql = "UPDATE documentos_equipamento SET apagado_em = NOW() WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id_documento]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Eliminou o documento técnico: " . $doc['nome_documento'], "Documentos", "documentos_equipamento", $id_documento);
            }

            // 7. Redirecionamento Inteligente (Volta para onde o utilizador estava)
            $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/documentos/documentos.php';

            // Limpa qualquer mensagem de 'sucesso' antiga do URL para não duplicar parâmetros
            $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
            $url_origem = rtrim($url_origem, '?&');

            // Adiciona a nova mensagem de sucesso e redireciona
            $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';
            header("Location: " . $url_origem . $separador . "sucesso=doc_eliminado");
            exit;
        } else {
            // O documento já não existia na base de dados
            header("Location: /sibdas/1241251/gira/private/documentos/documentos.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao eliminar o documento: " . $e->getMessage());
    }
} else {
    // Acesso inválido sem ID
    header("Location: /sibdas/1241251/gira/private/documentos/documentos.php");
    exit;
}
