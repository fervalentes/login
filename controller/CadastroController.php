<?php
require '../MODEL/cadastroModel.php';
if($_POST){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password'];
    $Confirmpassword = $_POST['Confirmpassword'];

    $result = register($firstname, $lastname, $email, $number, $password);
    if($result){
        echo "Cadastro realizado com sucesso!";
    }else{
        echo "Não foi possível realizar o cadastro.";
    }
}