<?php
// Se já iniciou session antes, não precisa chamar de novo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';
$erro = '';

function connectDB() {
    try {
        $host = '127.0.0.1';  // ou 'localhost'
        $dbName = 'login';    // nome do seu banco MySQL
        $user = 'root';       // padrão XAMPP é root sem senha
        $pass = '';           // geralmente vazio no XAMPP
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $nome = trim($firstname . ' ' . $lastname);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['password'] ?? '';
    $confSenha = $_POST['confirmpassword'] ?? '';

    if (!$nome || !$email) {
        $erro = "Nome ou email inválido!";
    } elseif (strlen($senha) < 6) {
        $erro = "Senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $confSenha) {
        $erro = "Senha e confirmação não conferem.";
    } else {
        try {
            $db = connectDB();

            $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $erro = "Este email já está cadastrado.";
            } else {
             
             $stmt = $db->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");

                $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt->execute([$nome, $email, $hashSenha]);

                $mensagem = "Cadastro realizado com sucesso!";
  
                $_POST = [];
            }
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/login/css/img/style.css" />
    <link rel="stylesheet" href="/login/css/stylelogin.css" />
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <div class="form-image">
           <img src="/login/assets/css/img/undraw_shopping_a55o (1).svg" alt="Form Image" />
        </div>
        <div class="form">
            <div class="form-header">
                <div class="title">
                    <h1>Cadastre-se</h1>
                </div>
            </div>

            <?php if ($mensagem): ?>
                <div style="color: green; font-weight: bold; margin-bottom: 1em;">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <?php if ($erro): ?>
                <div style="color: red; font-weight: bold; margin-bottom: 1em;">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <div class="input-box">  
                        <label for="firstname">Primeiro Nome</label>
                        <input id="firstname" type="text" name="firstname" placeholder="Digite seu primeiro nome" required value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" />
                    </div>

                    <div class="input-box">  
                        <label for="lastname">Sobrenome</label>
                        <input id="lastname" type="text" name="lastname" placeholder="Digite seu sobrenome" required value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" />
                    </div>

                    <div class="input-box">  
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
                    </div>

                    <div class="input-box">  
                        <label for="number">Telefone</label>
                        <input id="number" type="tel" name="number" placeholder="(xx) xxxx-xxxx" value="<?= htmlspecialchars($_POST['number'] ?? '') ?>" />
                    </div>

                    <div class="input-box">  
                        <label for="password">Senha</label>
                        <input id="password" type="password" name="password" placeholder="Digite sua senha" required />
                    </div>

                    <div class="input-box">  
                        <label for="confirmpassword">Confirme sua senha</label>
                        <input id="confirmpassword" type="password" name="confirmpassword" placeholder="Confirme sua senha" required />
                    </div>

                    <div class="login-button">
                        <button type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
