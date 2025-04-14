<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/img/style.css">
    <link rel="stylesheet" href="./css/stylelogin.css">
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
                        <h1>Cadastre-se</h1>
 
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">  
                        <label for="firstname">Primeiro Nome</label>
                       <input id="firtsname" type="text" name="firstname" placeholder="Digite seu primeiro nome" required>
                    </div>

                    <div class="input-box">  
                        <label for="lastname">Sobrenome</label>
                       <input id="latsname" type="text" name="lastname" placeholder="Digite seu sobrenome" required>
                    </div>

                    <div class="input-box">  
                        <label for="email">Email</label>
                       <input id="email" type="email" name="email" placeholder="Digite seu email " required>
                    </div>

                    <div class="input-box">  
                        <label for="number">Telefone</label>
                       <input id="number" type="tel" name="number" placeholder="(xx) xxxx-xxxx" required>
                    </div>
                      
                    <div class="input-box">  
                        <label for="password">Senha</label>
                       <input id="password" type="password" name="password" placeholder="Digite sua senha" required>
                      
                    </div>

                    <div class="input-box">  
                        <label for="Confirmpassword">Confirme sua senha</label>
                        <input id="Confirmpassword" type="password" name="Confirmpassword" placeholder="Confirme sua senha" required>
                    </div>

                    <div class="login-button">
                        <button type="button" onclick="login()">Login</button>       
                        <button type="button" onclick="redirect()">Recuperar senha</button>
                       
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script>
    function login() {
        window.location.href = "login.php";
    }
    </script>
</body>
</html>