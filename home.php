<?php 
    include './database/conexao.php';
    include './usuario/usuarioClass.php';
    if(!Usuario::isLogged()) {
        header("Location: ./usuario/login.php");
        exit();
    }
    $result = $pdo -> query("SELECT sum(valor * case when tipo = 'entrada' then 1 else -1 end) AS balanco FROM lancamentos WHERE fk_lan_user = ".$_SESSION['userId']);
    $data = $result -> fetchAll();
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
    <form action="./lancamentos/lancamento.php" method="POST">
        <input type="number" name="valor" id="valor" step=".01">
        <select name="tipo" id="tipo">
            <option value="entrada">Entrada</option>
            <option value="saida">Saida</option>
        </select>
        <input type="text" name="descricao" id="descricao">
        <button type="submit">Inserir</button>
    </form>
    <?php foreach($data as $row): ?>

      <tr>
        <th>Balanço:</th>
      </tr>
        <td><?= $row["balanco"]?></td>

    <?php endforeach ?>

    <a href="./usuario/logout.php">Sair</a>
</body>
</html>