<?php
include 'php/mysql.php';
include 'php/header.php';
include('../../conexion.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafica Producción</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="row my-3" id="grafica">
            <div class="col-md-12 text-center">
                <h2>Gráfica de Producción por Meses</h2>
                <canvas id="idGrafica" class="grafica"></canvas>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md-12 text-center">
                <div id="idContTabla"></div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/index.js"></script>
</body>
</html>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php 
            $SQL = "SELECT sum(cantidad) as cantidadT,(SELECT nombre FROM productos
            WHERE productos.id_productos=produccion.nombre_producto limit 1)as nombre FROM produccion GROUP BY nombre_producto ORDER BY cantidadT DESC LIMIT 5";
            $resultado = $con->query($SQL);

            while ($fila = $resultado->fetch_assoc()){
              echo "['" . $fila['nombre'] . "', " . $fila['cantidadT'] . "],";
            }
          ?>
        ]);

        var options = {
          title: 'Las 5 Arepas más producidas',
          titleTextStyle: {
            fontSize: 22, // Set the font size for the title
          },
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 90%; height: 600px;"></div>
  </body>
</html>