<?php 

    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
        require '../database/conexao.php';
        require './usuarioClass.php';

        $username = addslashes($_POST['username']);
        $senha = addslashes($_POST['senha']);

        if(Usuario::login ($username, $senha) === true) {
            if(isset($_SESSION['userL'])) {
                header("Location: ../home.php");
            }
            header("Location: ../home.php");
        } else {
            header("Location: login.php");
        }

} else {
    header("Location: login.php");
}

?>