<?php
include './database/conexao.php';
include './usuario/usuarioClass.php';
if (!Usuario::isLogged()) {
    header("Location: ./usuario/login.php");
    exit();
}
$result = $pdo->query("SELECT sum(valor * case when tipo = 'entrada' then 1 else -1 end) AS balanco FROM lancamentos WHERE fk_usuario = " . $_SESSION['userId']);
if ($result) {
    $data = $result->fetchAll();

    foreach ($data as $balanco) {
        $balancoAtual[] = $balanco['balanco'];
    }
}

$resultado = $pdo->query("SELECT date_format(data_balanco, '%d-%M-%Y') as data, valor_balanco AS balanco FROM balanco WHERE fk_usuario = " . $_SESSION['userId']);

if ($resultado) {
    $data2 = $resultado->fetchAll();

    foreach ($data2 as $query) {
        $dataBalanco[] = $query['data'];
        $valorBalanco[] = $query['balanco'];
    }
}

$lancamentos = $pdo->query("SELECT valor, tipo, date_format(data_lancamento, '%d-%M-%Y') as data_lancamento FROM lancamentos WHERE fk_usuario = " . $_SESSION['userId']);
if ($lancamentos) {
    $data3 = $lancamentos->fetchAll();

    foreach ($data3 as $lancamento) {
        if ($lancamento['tipo'] == 'entrada') {
            $entradas[] = $lancamento['valor'];
        } else {
            $saidas[] = $lancamento['valor'];
        }

        $dataLancamento[] = $lancamento['data_lancamento'];
    }
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
            <?php include './componentes/sidemenu.php' ?>
            <main class="col-md-9 ml-sm-auto col-lg-10 pt-2" style="max-height: 100vh; overflow-y: auto;">

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