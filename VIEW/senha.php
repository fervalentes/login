<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/img/style.css">
    <link rel="stylesheet" href="./css/stylelogin.css">
    <link rel="stylesheet" href="./css/stylerecup.css">
    <title>Recuperação de senha!</title>
</head>
<body>
    <div class="container">
        <div class="form-image">
           <img src="assets\css\img\undraw_shopping_a55o (1).svg">
        </div>
        <div class="form">
            <form action="../controller/PasswordResetController.php" method="POST">
                <div class="form-header">
                    <div class="title">
                        <h1>Recuperação de senha!</h1>
 
                    </div>
          
                    </div>

                    <div class="input-box">  
                        <label for="password">Insira sua nova senha</label>
                       <input id="password" type="password" name="password" placeholder="Digite sua senha" required>

                    </div>

                    <div class="input-box">  
                        <label for="Confirmpassword">Confirme sua nova senha</label>
                        <input id="Confirmpassword" type="password" name="password-confirm" placeholder="Confirme sua senha" required>
                    </div>
                    <div class="login-button">
                        <button type="submit">Confirmar</button>
                    </div>
              

            </form>
        </div>
    </div>
    <script>
        function redirect() {
            window.location.href = "usuario.php";
        }
    </script>
</body>
</html>