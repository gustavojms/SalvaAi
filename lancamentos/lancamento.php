<?php

if(isset($_POST['valor']) && !empty($_POST['valor']) && isset($_POST['tipo']) && !empty($_POST['tipo']) && isset($_POST['descricao']) && !empty($_POST['descricao'])) {
    require '../database/conexao.php';

    $valor = addslashes($_POST['valor']);
    $tipo = addslashes($_POST['tipo']);
    $descricao = addslashes($_POST['descricao']);

    
} else {
    header("Location: ../home.php");
}

$result = $pdo -> prepare("INSERT INTO lancamentos (valor, tipo, descricao, fk_lan_user) VALUES (?, ?, ?, ?)");
$result -> execute([$valor, $tipo, $descricao, $_SESSION['userId']]);

header("Location: ../home.php");
?>