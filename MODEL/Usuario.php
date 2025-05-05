
<?php
class Usuario {
    public static function buscarPorEmail($email) {
        // Exemplo de conexão e consulta
        $conn = new PDO("mysql:host=localhost;dbname=seu_banco", "usuario", "senha");
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html> 

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylelogin.css">
    <link rel="stylesheet" href="./css/styleusu.css">
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
                        <label for="email">Email</label>
                       <input id="email" type="email" name="email" placeholder="Digite seu email " required>
                       
                    </div>
                    <div class="login-button">
                        <button type="button" onclick="redirect()">confirmar</button>
                    </div>

            </form>
        </div>
    </div>
    <script>
        function redirect() {
            window.location.href = "codigo.php";
        }
    </script>
</body>
</html>
