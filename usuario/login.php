<?php
include '../database/conexao.php';
include './usuarioClass.php';
if (Usuario::isLogged()) {
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
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/main.min.css">
</head>

<body>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <h1 class="text-secondary text-center mb-4">SalvaAi</h1>

                <form action="auth.php" method="post" class="p-3 d-flex flex-column border shadow">
                    <h3 class="text-primary text-center mb-4">Entrar com sua conta</h3>

                    <label class="mb-2 fw-semibold" for="usuario">
                        Usuario
                    </label>
                    <input type="text" name="username" id="username" placeholder="Digite seu usuario" class="form-control border border-2 rounded-pill mb-4 text-center pe-5 ps-5">

                    <label class="mb-2 fw-semibold" for="senha">
                        Senha
                    </label>
                    <input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="form-control border border-2 rounded-pill mb-4 text-center pe-5 ps-5">

                    <button type="submit" class="btn btn-secondary btn-block border rounded-pill pe-5 ps-5 mb-3">
                        Entrar
                    </button>

                    <span class="text-decoration-none">
                        Não é cadastrado? <a href="cadastro.php" class="text-decoration-none fw-semibold">Crie sua conta</a>
                    </span>
                    <!-- <div class="text-center">
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</body>

</html>