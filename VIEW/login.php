<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php if (isset($_SESSION['msg'])): ?>
    <div><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
<?php endif; ?>

<form method="POST" action="../controller/LoginController.php">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
    <div class="container">
        <div class="form-image">
           <img src="assets\css\img\undraw_shopping_a55o (1).svg" alt="Form Image">
        </div>
        <div class="form">
            <form action="#">
                <div class="form-header">
                    <div class="title">
                        <h1>Faça seu login!</h1>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">  
                        <label for="email">Email</label>
                       <input id="email" type="email" name="email" placeholder="Digite seu email" required>
                    </div>

                 

                    <div class="input-box">  
                        <label for="password">Senha</label>
                       <input id="password" type="password" name="password" placeholder="Digite sua senha" required>
                    </div>

                    <div class="login-button">
                        <button type="button" onclick="login()">Login</button>
                        <button type="button" onclick="redirect()">Esqueci a senha</button>
                    </div>
            </form>
        </div>
    </div>
    <script>
        function redirect() {
            window.location.href = "usuario.php";
        }
        function login() {
            window.location.href = "login.php";
        }

    </script>
</body>
</html>
