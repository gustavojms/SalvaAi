<?php

if(isset($_POST['valor']) && !empty($_POST['valor']) && isset($_POST['tipo']) && !empty($_POST['tipo']) && isset($_POST['descricao']) && !empty($_POST['descricao'])) {
    require '../database/conexao.php';

    $valor = addslashes($_POST['valor']);
    $tipo = addslashes($_POST['tipo']);
    $descricao = addslashes($_POST['descricao']);
    $balanco = $pdo -> query("SELECT sum(valor * case when tipo = 'entrada' then 1 else -1 end) AS balanco FROM lancamentos WHERE fk_lan_user = " . $_SESSION['userId']);
    $data = $balanco->fetchAll();
    
} else {
    header("Location: ../home.php");
}

$result = $pdo -> prepare("INSERT INTO lancamentos (valor, tipo, descricao, fk_lan_user, data_lancamento) VALUES (?, ?, ?, ?, now())");
$result -> execute([$valor, $tipo, $descricao, $_SESSION['userId']]);

$resultado = $pdo -> prepare("INSERT INTO balanco (valor_balanco, data_balanco, tipo_balanco,fk_bal_user) VALUES (?, NOW(), ?, ?)");
$resultado -> execute([$data[0]['balanco'], $tipo, $_SESSION['userId']]);

header("Location: ../home.php");
?>