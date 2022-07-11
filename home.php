<?php
include './database/conexao.php';
include './usuario/usuarioClass.php';
if (!Usuario::isLogged()) {
    header("Location: ./usuario/login.php");
    exit();
}
$result = $pdo->query("SELECT sum(valor * case when tipo = 'entrada' then 1 else -1 end) AS balanco FROM lancamentos WHERE fk_lan_user = " . $_SESSION['userId']);
$data = $result->fetchAll();

//
$resultado = $pdo->query("SELECT distinct monthname(data) from lancamentos");
$dados = $resultado->fetchAll();

$results = $pdo->query("SELECT sum(valor) from lancamentos group by data ");
$datas = $results->fetchAll();

foreach ($dados as $itens){
    $meses[] = $itens["monthname(data)"];
  
} 

foreach ($datas as $item){
    
    $valores[] = $item["sum(valor)"];
}

//


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="./assets/css/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar">
            <ul class="nav nav-pills d-flex flex-column align-items-center bg-light vh-100 p-5">
                <li class="nav-item mb-4">
                    <a href="./home.php" class="text-decoration-none"><i class="bi bi-house" style="font-size: 1.5rem; margin-right: 1rem;"></i>Inicio</a>
                </li>
                <li class="nav-item dropdown mb-auto">
                    <a class="nav-link dropdown-toggle text-primary mb-auto" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="finDrop"><i class="bi bi-credit-card" style="font-size: 1.5rem; margin-right: 1rem;"></i>Finanças</a>
                    <ul class="dropdown-menu ms-4" aria-labelledby="finDrop">
                        <li>
                            <div class="d-flex flex-column align-items-start dropdown-item">
                                <button name="tipo" id="tipo" value="entrada" class="btn mb-4 p-2 bg-transparent text-primary" data-bs-toggle="modal" data-bs-target="#entradaModal"><i class="bi bi-plus-circle" style="font-size: 1.5rem; margin-right: 10px;"></i>Nova entrada</button>
                                <button name="tipo" id="tipo" value="saida" class="btn mb-4 p-2 bg-transparent text-primary" data-bs-toggle="modal" data-bs-target="#saidaModal"><i class="bi bi-download" style="font-size: 1.5rem; margin-right: 10px;"></i>Saida</button>
                                <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#balancoModal"><i class="bi bi-bank" style="font-size: 1.5rem; margin-right: 10px;"></i>Balanço</button>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="btn-group dropup">
                    <a class="nav-link dropdown-toggle text-primary" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="userDrop"><i class="bi bi-person" style="font-size: 1.5rem; margin-right: 1rem;"></i><?= ucfirst($_SESSION['userL'])?></a>
                    <ul class="dropdown-menu ms-4" aria-labelledby="userDrop">
                        <li>
                            <div class="dropdown-item">
                            <a href="./usuario/logout.php" class="btn border-0 bg-transparent text-primary">Sair</a>
                            </div>
                        </li>
                </li>
            </ul>
    </div>
        </nav>
    </header>
    <div class="modal fade" id="balancoModal" tabindex="-1" aria-labelledby="balancoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="balancoModalLabel">Balanço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($data as $row) : ?>
                        <p class="text-center m-0 p-2">Seu balanço atual é de: <?= $row['balanco'] ?></p>
                    <?php endforeach ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="entradaModal" tabindex="-1" aria-labelledby="entradaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="entradaModalLabel">Nova entrada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./lancamentos/lancamento.php" method="POST">
                        <input type="hidden" name="tipo" id="tipo" value="entrada">
                        <input type="number" class="border rounded p-1" name="valor" id="valor" step=".05" placeholder="Digite o valor" min="0">
                        <input type="text" class="border rounded p-1" name="descricao" id="descricao" placeholder="Descrição">
                        <input type="date" class="border rounded p-1" name="data" id="data">
                        <button type="submit" class="border rounded p-1 text-white bg-secondary">Inserir</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="saidaModal" tabindex="-1" aria-labelledby="saidaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saidaModalLabel">Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./lancamentos/lancamento.php" method="POST">
                        <input type="hidden" name="tipo" id="tipo" value="saida">
                        <input type="number" class="border rounded p-1" name="valor" id="valor" step=".05" placeholder="Digite o valor">
                        <input type="text" class="border rounded p-1" name="descricao" id="descricao" placeholder="Descrição">
                        <input type="date" class="border rounded p-1" name="data" id="data">
                        <button type="submit" class="border rounded p-1 text-white bg-secondary">Inserir</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

    
    <div class="chart-container" style="position: relative; height:40vh; width:80vw; margin: 0 auto";>
    <canvas id="myChart"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($meses)?>,
            datasets: [{
                label: '# of Votes',
                data: <?php echo json_encode($valores)?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>


</html>