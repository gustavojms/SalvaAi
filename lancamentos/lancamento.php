<?php

if(isset($_POST['valor']) && !empty($_POST['valor']) && isset($_POST['tipo']) && !empty($_POST['tipo']) && isset($_POST['descricao']) && !empty($_POST['descricao']) && isset($_POST['data']) && !empty($_POST['data'])) {
    require '../database/conexao.php';

    $valor = addslashes($_POST['valor']);
    $tipo = addslashes($_POST['tipo']);
    $descricao = addslashes($_POST['descricao']);
    $data = addslashes($_POST['data']);

    
} else {
    header("Location: ../home.php");
}

$result = $pdo -> prepare("INSERT INTO lancamentos (valor, tipo, descricao, fk_lan_user,data) VALUES (?, ?, ?, ?, ?)");
$result -> execute([$valor, $tipo, $descricao, $_SESSION['userId'],$data]);

header("Location: ../home.php");
?>