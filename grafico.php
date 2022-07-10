<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">
        <title>Chart</title>
        

    </head>
    <body>

<?php

$con = new mysqli('localhost','root','12345678','ped1');
$con->query("
select  
tipo,valor,datas from lancamentos where tipo= 'entrada' order by 
datas asc
");
foreach($query as $data )
{
   $valor_entrada[]= $data['valor'];
   $tipo[]=$data['tipo'];
   $datas_entrada[]=$data['data'];
}

?>




<canvas id="myChart" class="line-chart"></canvas>




        <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js'></script>
        <script>
           
           
            var entrada= <?php echo json_encode($valor_entrada);?>
  var saida = [400,500];
           
           var ctx = document.getElementsByClassName("line-chart");

            var chartGraph = new Chart (ctx,{
                type: 'line',
                data: {
                    labels: <?php echo json_encode($datas_entrada);?>,
                datasets: [{
                    label: 'Entradas',
                    data: entrada,
                    borderWidth: 6,
                    borderColor: 'rgba(77,166,253,0.85)',
                    backgroundColor: 'transparent'
                },
               
            ]
                }, options: {
                    title: {
                        display: true,
                        fontSize: 20,
                        text: "Ultimas Entradas "

                    }
                }
               
            });



        </script>
   
   
    </body>
</html>
