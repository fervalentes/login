<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylelogin.css">
    <link rel="stylesheet" href="./css/stylerecup.css">
    <title>Recuperação de Senha</title>
</head>
<body>
    <div class="container">
        <div class="form-image">
           <img src="assets/css/img/undraw_shopping_a55o.svg" alt="Recuperação de Senha">
        </div>
        <div class="form">
            <form action="../controller/emailController.php" method="POST">
                <div class="form-header">
                    <div class="title">
                        <h1>Recuperação de senha</h1>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">  
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="login-button">
                        <button type="submit">Enviar Código</button>
                    </div>
                </div>
            </form>
            <?php if (isset($_SESSION['status'])): ?>
                <div class="status-message"><?= htmlspecialchars($_SESSION['status']); unset($_SESSION['status']); ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>