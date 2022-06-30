<?php 
    include './database/conexao.php';
    include './usuario/usuarioClass.php';
    if(!Usuario::isLogged()) {
        header("Location: ./usuario/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
</head>
<body>
    Autenticado!
</body>
</html>