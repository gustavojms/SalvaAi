<?php
include './database/conexao.php';
include './usuario/usuarioClass.php';
if (!Usuario::isLogged()) {
    header("Location: ./usuario/login.php");
    exit();
}
$result = $pdo->query("SELECT sum(valor * case when tipo = 'entrada' then 1 else -1 end) AS balanco FROM lancamentos WHERE fk_lan_user = " . $_SESSION['userId']);
$data = $result->fetchAll();

$resultado = $pdo->query("SELECT date_format(data_balanco, '%d-%M-%Y') as data, valor_balanco AS balanco FROM balanco WHERE fk_bal_user = " . $_SESSION['userId']);
$data2 = $resultado->fetchAll();

$lancamentos = $pdo->query("SELECT valor, tipo, date_format(data_lancamento, '%d-%M-%Y') as data_lancamento FROM lancamentos WHERE fk_lan_user = " . $_SESSION['userId']);
$data3 = $lancamentos->fetchAll();

foreach ($data as $balanco) {
    $balancoAtual[] = $balanco['balanco'];
}

foreach ($data2 as $query) {
    $dataBalanco[] = $query['data'];
    $valorBalanco[] = $query['balanco'];
}

foreach ($data3 as $lancamento) {
    if ($lancamento['tipo'] == 'entrada') {
        $entradas[] = $lancamento['valor'];
    } else {
        $saidas[] = $lancamento['valor'];
    }

    $dataLancamento[] = $lancamento['data_lancamento'];
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="./assets/css/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar col-md-2 d-none d-md-block bg-light">
                <ul class="nav nav-pills d-flex flex-column align-items-center bg-light vh-100 p-5">
                    <li class="nav-item mb-4">
                        <h1 class="text-secondary fs-2">
                            SalvaAi
                        </h1>
                    </li>
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
                        <a class="nav-link dropdown-toggle text-primary" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="userDrop"><i class="bi bi-person" style="font-size: 1.5rem; margin-right: 1rem;"></i><?= ucfirst($_SESSION['userL']) ?></a>
                        <ul class="dropdown-menu ms-4" aria-labelledby="userDrop">
                            <li>
                                <div class="dropdown-item">
                                    <a href="./usuario/logout.php" class="btn border-0 bg-transparent text-primary">Sair</a>
                                </div>
                            </li>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-3">

                <div class="mx-auto border rounded-5 p-4 mb-4" width="800" height="467" style="display: block; width: 800px; height: 467px;">
                    <canvas id="myChart"></canvas>
                    <p class="text-center fs-5 mt-3">
                        <?php
                        if (isset($balancoAtual)) {
                            echo "Seu balanço atual é de: R$ " . $balancoAtual[0];
                        }
                        ?>
                </p>
                </div>
                <div class="mx-auto border rounded-5 p-4" width="800" height="467" style="display: block; width: 800px; height: 467px;">
                    <canvas id="myChart2"></canvas>
                </div>

            </main>
        </div>
    </div>
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
                        <button type="submit" class="border rounded p-1 text-white bg-secondary">Inserir</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        const labels = <?= json_encode($dataBalanco) ?>;
        const labels2 = <?php echo json_encode($dataLancamento); ?>;

        
        const data = {
            labels: labels,
            datasets: [{
                label: 'Balanço',
                backgroundColor: 'rgb(34, 44, 101)',
                borderColor: 'rgb(34, 44, 101)',
                data: <?php echo json_encode($valorBalanco); ?>,
                borderRadius: 10,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        min: 0,
                        beginAtZero: true
                    }
                }
            },
        };

       const data2 = {
            labels: labels2,
            datasets: [{
                label: 'Entradas',
                backgroundColor: 'rgb(34, 144, 50)',
                borderColor: 'rgb(34, 144, 50)',
                data: <?php echo json_encode($entradas); ?>,
                borderRadius: 10,
            },
            {
                label: 'Saídas',
                backgroundColor: 'rgb(180, 4, 20)',
                borderColor: 'rgb(180, 4, 20)',
                data: <?php echo json_encode($saidas); ?>,
                borderRadius: 10,
            }
        ]
        };

        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                scales: {
                    y: {
                        min: 0,
                        beginAtZero: true
                    }
                }
            },
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        const myChart2 = new Chart(
            document.getElementById('myChart2'),
            config2
        );
    </script>
</body>

</html>