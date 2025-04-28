<?php

require '../service/conexao.php';

function register($firstname, $lastname, $email, $number, $password){
    $conn = new usePDO();
    $instance = $conn->getInstanse();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO pessoa(nome, sobrenome, email, telefone, senha) VALUES (?,?,?,?,?)";
    $stmt = $instance->prepare($sql);
    $stmt->execute([$firstname, $lastname, $email, $number, $hashed_password]);

    $idpessoa = $instance->lastInsertId();
    
    $sql = "INSERT INTO usuario(email, senha, id_pessoa) VALUES (?,?,?)";
    $stmt = $instance->prepare($sql);
    $stmt->execute([$email, $hashed_password, $idpessoa]);

    $result = $stmt->rowCount();
    return $result;
}