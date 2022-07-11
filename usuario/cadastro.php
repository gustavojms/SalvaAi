<?php 
    include '../database/conexao.php';
    include './usuarioClass.php';
    if(Usuario::isLogged()) {
        header("Location: ../index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="../assets/css/main.min.css">
</head>
<body>

    <div class="container">
        <div class="row vh-100 align-items-center">
            <div class="col-md-4 offset-md-4">
                <h1 class="text-secondary text-center mb-5 pb-5">SalvaAi</h1>
        <form action="cadastrar.php" method="post" class="d-flex flex-column align-items-center">
            <h1 class="text-primary mb-5">Crie sua conta</h1>

        <label for="usuario" class="">
            <span class="fw-semibold">Usuario</span>
            <input type="text" name="username" id="username" placeholder="Digite aqui seu usuario" class="form-control border border-2 rounded-pill mb-4 text-center pe-5 ps-5">
        </label>

        <label for="email">
            <span class="fw-semibold">Email</span>
            <input type="email" name="email" id="email" placeholder="Digite aqui seu email" class="form-control border border-2 rounded-pill mb-4 text-center pe-5 ps-5">
        </label>

        <label for="senha">
            <span class="fw-semibold ">Senha</span>
            <input type="password" name="senha" id="senha" placeholder="Digite aqui sua senha" class="form-control border border-2 rounded-pill mb-4 text-center pe-5 ps-5">
        </label>

        <button type="submit" class="btn btn-secondary btn-block border rounded-pill pe-5 ps-5 mb-3">Cadastrar</button>
        <a class="text-decoration-none">Já possui cadastro?<a href="login.php" class="text-decoration-none fw-semibold">Clique aqui</a></a>
</form>
</div>
</div>
</body>
</html>