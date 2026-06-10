<?php
// 1. Ligar à Base de Dados
require_once __DIR__ . '/../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. DETETOR DE FICHEIROS PESADOS
    if (empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        die("<div style='font-family: sans-serif; padding: 20px;'><h3>Ficheiro Demasiado Grande! 🐘</h3><p>O ficheiro ultrapassa o limite do servidor. Tenta um PDF mais pequeno.</p><a href='javascript:history.back()'>Voltar atrás</a></div>");
    }

    // 2. APANHAR O ID (Sabe ler tanto do GET como do POST)
    $id_equipamento = 0;
    if (!empty($_POST['id_equipamento'])) {
        $id_equipamento = (int) $_POST['id_equipamento'];
    } elseif (!empty($_GET['id'])) {
        $id_equipamento = (int) $_GET['id'];
    }

    $nome_doc = trim($_POST['nome_documento']);
    $tipo_doc = $_POST['tipo_documento'];

    // 3. GARANTIR QUE A PASTA FÍSICA EXISTE
    // A pasta será criada dentro de private/documentos/uploads/
    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 4. PROCESSAR O FICHEIRO
    if (isset($_FILES['ficheiro']) && $_FILES['ficheiro']['error'] === UPLOAD_ERR_OK) {

        $extensao = strtolower(pathinfo($_FILES['ficheiro']['name'], PATHINFO_EXTENSION));
        $permitidos = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array($extensao, $permitidos)) {
            die("<div style='padding: 20px;'><h3>Erro de Formato</h3><p>Apenas PDF, JPG ou PNG.</p><a href='javascript:history.back()'>Voltar</a></div>");
        }

        // Renomear o ficheiro para nunca haver nomes duplicados no servidor
        $novo_nome_ficheiro = 'EQ' . $id_equipamento . '_' . time() . '_' . rand(100, 999) . '.' . $extensao;
        $caminho_final = $upload_dir . $novo_nome_ficheiro;

        // 5. MOVER E GRAVAR NA BASE DE DADOS
        if (move_uploaded_file($_FILES['ficheiro']['tmp_name'], $caminho_final)) {

            // Caminho que a base de dados vai decorar (relativo à pasta private)
            $caminho_db = 'documentos/uploads/' . $novo_nome_ficheiro;

            try {
                $sql = "INSERT INTO documentos_equipamento (equipamento_id, nome_documento, tipo_documento, caminho_ficheiro) 
                        VALUES (:id_eq, :nome, :tipo, :caminho)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_eq'   => ($id_equipamento > 0) ? $id_equipamento : null, // Permite documentos gerais se não houver ID
                    ':nome'    => $nome_doc,
                    ':tipo'    => $tipo_doc,
                    ':caminho' => $caminho_db
                ]);

                // Transmissor de Log
                if (function_exists('registar_log')) {
                    registar_log($pdo, $_SESSION['user_id'], "Fez upload do ficheiro '$nome_doc'", "Documentos");
                }

                // 6. REDIRECIONAMENTO INTELIGENTE
                if ($id_equipamento > 0) {
                    header("Location: /sibdas/1241251/gira/private/equipamentos/detalhes_equipamento.php?id=" . $id_equipamento . "&sucesso=doc_adicionado&tab=documentos");
                } else {
                    header("Location: /sibdas/1241251/gira/private/documentos/documentos.php?sucesso=upload");
                }
                exit;
            } catch (PDOException $e) {
                die("Erro ao gravar na Base de Dados: " . $e->getMessage());
            }
        } else {
            die("<div style='padding: 20px;'><h3>Falha no Upload</h3><p>O servidor não conseguiu guardar o ficheiro na pasta de destino.</p></div>");
        }
    } else {
        die("<div style='padding: 20px;'><h3>Erro no Ficheiro</h3><p>Nenhum ficheiro recebido ou ficheiro corrompido.</p></div>");
    }
} else {
    header("Location: /sibdas/1241251/gira/private/documentos/documentos.php");
    exit;
}
