<?php
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    // 1. APANHAR A ORIGEM (Redirecionamento Inteligente HTTP_REFERER)
    $url_origem = $_SERVER['HTTP_REFERER'] ?? '/sibdas/1241251/gira/private/documentos/documentos.php';

    // Apanhar o ID do equipamento (apenas para associar na Base de Dados e para o nome do ficheiro)
    $id_equipamento = 0;
    if (!empty($_POST['id_equipamento'])) {
        $id_equipamento = (int) $_POST['id_equipamento'];
    } elseif (!empty($_GET['id'])) {
        $id_equipamento = (int) $_GET['id'];
    }

    // 2. DETETOR DE FICHEIROS PESADOS (Proteção contra limite do servidor post_max_size)
    if (empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $_SESSION['erros'] = ["Ficheiro demasiado grande! O limite do servidor foi ultrapassado. Tente um PDF mais pequeno."];
        $_SESSION['modal_aberto'] = 'modalNovoDocumento';
        header("Location: " . $url_origem);
        exit;
    }

    // 3. Recolha de Dados
    $nome_doc = trim($_POST['nome_documento'] ?? '');
    $tipo_doc = $_POST['tipo_documento'] ?? '';

    // 4. Validações de Domínio e Ficheiro
    if ($e = validar_nome_documento($nome_doc)) $erros[] = $e;
    if ($e = validar_tipo_documento($tipo_doc)) $erros[] = $e;

    // Verificar se o ficheiro foi realmente enviado e se não há erros na transferência
    if (!isset($_FILES['ficheiro']) || $_FILES['ficheiro']['error'] !== UPLOAD_ERR_OK) {
        $erros[] = "Nenhum ficheiro recebido, ou o ficheiro anexado está corrompido.";
    } else {
        // Validar Extensão
        $extensao = strtolower(pathinfo($_FILES['ficheiro']['name'], PATHINFO_EXTENSION));
        $permitidos = ['pdf', 'jpg', 'jpeg', 'png'];
        if (!in_array($extensao, $permitidos)) {
            $erros[] = "Erro de Formato: Apenas ficheiros PDF, JPG ou PNG são permitidos.";
        }
    }

    // 5. DEVOLVER ERROS
    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['modal_aberto'] = 'modalNovoDocumento';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }

    // 6. PROCESSAMENTO SEGURO DO FICHEIRO
    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $novo_nome_ficheiro = 'EQ' . $id_equipamento . '_' . time() . '_' . rand(100, 999) . '.' . $extensao;
    $caminho_final = $upload_dir . $novo_nome_ficheiro;

    if (move_uploaded_file($_FILES['ficheiro']['tmp_name'], $caminho_final)) {
        $caminho_db = 'documentos/uploads/' . $novo_nome_ficheiro;

        try {
            $sql = "INSERT INTO documentos_equipamento (equipamento_id, nome_documento, tipo_documento, caminho_ficheiro) 
                    VALUES (:id_eq, :nome, :tipo, :caminho)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_eq'   => ($id_equipamento > 0) ? $id_equipamento : null,
                ':nome'    => $nome_doc,
                ':tipo'    => $tipo_doc,
                ':caminho' => $caminho_db
            ]);

            if (function_exists('registar_log')) {
                registar_log($pdo, $_SESSION['user_id'], "Fez upload do ficheiro '$nome_doc'", "Documentos");
            }

            // ====================================================================
            // MAGIA DE REDIRECIONAMENTO COM SUCESSO (Mantém o utilizador onde estava)
            // ====================================================================
            $url_origem = preg_replace('/([&?])sucesso=[^&]*(&|$)/', '$1', $url_origem);
            $url_origem = rtrim($url_origem, '?&');
            $separador = (strpos($url_origem, '?') !== false) ? '&' : '?';

            header("Location: " . $url_origem . $separador . "sucesso=doc_adicionado&tab=documentos");
            exit;
        } catch (PDOException $e) {
            $_SESSION['erros'] = ["Erro ao gravar na Base de Dados: " . $e->getMessage()];
            $_SESSION['modal_aberto'] = 'modalNovoDocumento';
            $_SESSION['dados_form'] = $_POST;
            header("Location: " . $url_origem);
            exit;
        }
    } else {
        $_SESSION['erros'] = ["Falha no Upload: O servidor não conseguiu guardar o ficheiro na pasta de destino."];
        $_SESSION['modal_aberto'] = 'modalNovoDocumento';
        $_SESSION['dados_form'] = $_POST;
        header("Location: " . $url_origem);
        exit;
    }
} else {
    header("Location: /sibdas/1241251/gira/private/documentos/documentos.php");
    exit;
}
