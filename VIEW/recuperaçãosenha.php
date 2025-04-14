<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylelogin.css">
    <link rel="stylesheet" href="./css/stylerecup.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <div class="form-image">
           <img src="assets\css\img\undraw_shopping_a55o (1).svg">
        </div>
        <div class="form">
            <form action="#">
                <div class="form-header">
                    <div class="title">
                        <h1>Recuperação de senha!</h1>
 
                    </div>
                </div>
                <div class="input-group">
                   
                    <div class="input-box">  
                        <label for="email">Nova senha</label>
                       <input id="email" type="text" name="email" placeholder="Nova senha " required>
                       <label for="email">Confirme a senha</label>
                       <input id="email" type="text" name="email" placeholder="confirme senha  " required>
                    </div>

                    <div class="login-button">
                        <button type="button" onclick="redirect()">confirmar</button>
                    </div>

              
            </form>
        </div>
    </div>
    <script>
        function redirect() {
            window.location.href = "login.php";
        }
    </script>
</body>
</html>