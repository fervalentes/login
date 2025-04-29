<?php
require '../MODEL/Model.php';
if($_POST){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = register($email, $password);
    if($result){
        echo "Cadastro realizado com sucesso!";
    }else{
 
        echo "Não foi possível realizar o cadastro.";
    }
}