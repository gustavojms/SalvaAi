<?php

    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
        require '../database/conexao.php';

        $username = addslashes($_POST['username']);
        $email = addslashes($_POST['email']);  
        $senha = md5(addslashes($_POST['senha']));
}
    else {
        header("Location: cadastro.php");
    }

$result = $pdo -> prepare("INSERT INTO usuarios (username, email, senha) VALUES (?, ?, ?)");
$result -> execute([$username, $email, $senha]);

header("Location: login.php");
?>