<?php
// 1. Iniciar a "Sessão" (para o servidor se lembrar de quem entrou)
session_start();

// Se o utilizador já estiver logado, redireciona logo para o dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$erro = ""; // Variável para guardar mensagens de erro

// 2. Verificar se o formulário foi submetido (se clicaram no botão "Entrar")
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db.php'; // Chamar a nossa ponte

    // Apanhar o que foi escrito nos campos (com proteção contra espaços vazios)
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (!empty($user) && !empty($pass)) {
        // 3. Procurar o utilizador na base de dados
        $sql = "SELECT id, username, password_hash, nome FROM utilizadores WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $user]);
        $utilizador = $stmt->fetch();

        // 4. Se o utilizador existir, testar se a password bate certo com o Hash!
        if ($utilizador && password_verify($pass, $utilizador['password_hash'])) {
            // SUCESSO! Guardar os dados do utilizador na memória da sessão
            $_SESSION['user_id'] = $utilizador['id'];
            $_SESSION['username'] = $utilizador['username'];
            $_SESSION['nome'] = $utilizador['nome'];

            // Redirecionar para o Dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $erro = "Utilizador ou palavra-passe incorretos.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechMed Inventory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/1241251.css">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .login-card {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">

    <div class="login-card p-3">
        <div class="text-center mb-4">
            <a href="../public/index.html" class="text-decoration-none">
                <h1 class="fw-bold text-primary mb-1">
                    <i class="fa-solid fa-notes-medical me-2"></i>TechMed
                </h1>
            </a>
            <p class="text-secondary small">Gestão de Inventário Hospitalar</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold text-dark mb-4 text-center">Acesso Restrito</h4>

                <form action="" method="POST">
                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger text-center small mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="username" class="form-label small fw-bold text-secondary">Utilizador *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-start-0" id="username" name="username" placeholder="Seu username" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold text-secondary">Palavra-passe *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" class="form-control bg-light border-start-0" id="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 mb-3 shadow-sm">
                        Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i>
                    </button>

                    <div class="text-center">
                        <a href="../public/index.html" class="text-decoration-none small text-muted">
                            <i class="fa-solid fa-arrow-left me-1"></i> Voltar à página inicial
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="small text-muted">&copy; 2026 TechMed Solutions. <br>Sistema de Apoio ao Inventário Hospitalar.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/1241251.js"></script>
</body>

</html>