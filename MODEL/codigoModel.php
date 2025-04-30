<?php

class codigo{
public static function codigo($pdo, $email, $numero_de_codigo);
{
    $consulta = $pdo->prepare('INSERT INTO codigo(email, codigo)'VALUES(?,?));
    return $consulta->execute([$email, $numero_de_codigo]);
}

    public static function verificarCodigo($pdo, $email, $codigo)
{
    $consulta = $pdo->prepare("SELECT * FROM codigo WHERE email = ? AND codigo = ?");
    $consulta->execute([$email, $codigo]);
    return $consulta->fetch(PDO::FETCH_ASSOC);
}
}