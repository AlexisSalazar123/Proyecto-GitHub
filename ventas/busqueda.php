<?php 
    include('../conexion.php');
    include("../templates/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Shadows+Into+Light&family=Sometype+Mono&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="assets/img/logo-mywebsite-urian-viera.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../Css/estilosBusqueda.css">
</head>
    <body>

     <!--Section que contendra los input de fecha y los botones de reporte-->
      <section>
          <div class="container" id="">
            <div class="row">
              <div class="container" id="ConBuscador">
                <form id="reportForm" method="post" accept-charset="utf-8">
                  <div class="row">
                    <div class="col" id="fecha1">Desde:
                       <input type="date" name="fecha_ingreso" class="form-control" style="width:220px;"  placeholder="Fecha de Inicio" required>
                    </div>
                    <div class="col" id="fecha2">Hasta:
                       <input type="date" name="fechaFin" class="form-control" style="width:220px;" placeholder="Fecha Final" required>
                    </div>
                    <div class="col" id="filtrar">
                        <button type="submit" name="reportType" value="filtrar" class="btn btn-warning">Filtrar Reporte</button>
                    </div>
                    <div class="col" id="Descargar">
                    <button type="submit" id="button1" style="width: 220px;" style="height: 30px;" class="btn btn-light mb-2" name="reportType" value="pdf">
                    <img src="../img/icons/pdf2.svg" alt="" style="vertical-align: middle; margin-right: 5px;">
                    <p>Descargar PDF</p></button>
                    <button type="submit" id="button2" style="width: 220px;" class="btn btn-light mb-2" name="reportType" target="_blank" value="excel">
                            <img src="../img/icons/excel.svg" alt="" style="vertical-align: middle; margin-right: 5px;">
                            <p>Descargar Excel</p>
                        </button>
                    </div>
                  </div>
                </form>
              </div>
       </section>


<script>
document.getElementById("reportForm").addEventListener("submit", function (e) {
    e.preventDefault(); 

    //Obtener el valor del botón presionado
    const reportType = this.querySelector('button[name="reportType"]:focus').value;

    //Guardar las fechas seleccionadas en variables
    const fechaIngreso = document.querySelector('input[name="fecha_ingreso"]').value;
    const fechaFin = document.querySelector('input[name="fechaFin"]').value;

    //Se le asigna al action el valor del boton
    if (reportType === "pdf") {
        const url = `DescargarReporte.php?fechaIngreso=${fechaIngreso}&fechaFin=${fechaFin}`;
        window.open(url, "_blank");
    } else if (reportType === "excel") {
        this.action = "DescargarReporteExcel.php";
    } else if (reportType === "filtrar") {
        this.action = "busqueda.php";

        //Guarda las fechas cuando se presiona "Filtrar"
        localStorage.setItem('fechaIngreso', fechaIngreso);
        localStorage.setItem('fechaFin', fechaFin);
    } else {
        localStorage.removeItem('fechaIngreso');
        localStorage.removeItem('fechaFin');
    }

    //Se hace envio de las fechas al action
    this.submit();
});

//Mostrar las fechas almacenadas después de refrescarse la página
document.addEventListener("DOMContentLoaded", function () {
    const fechaIngresoLocal = localStorage.getItem('fechaIngreso');
    const fechaFinLocal = localStorage.getItem('fechaFin');

    if (fechaIngresoLocal) {
        document.querySelector('input[name="fecha_ingreso"]').value = fechaIngresoLocal;
    }

    if (fechaFinLocal) {
        document.querySelector('input[name="fechaFin"]').value = fechaFinLocal;
    }
});

</script>

<?php

if (isset($_REQUEST['fecha_ingreso'])){

    echo '<div class="spinner-border text-muted" id="spinner"></div>';
    echo '<script>
            setTimeout(function() {
                var spinner = document.getElementById("spinner");
                if (spinner) {
                    spinner.style.display = "none";
                }
            }, 1000); 
          </script>';
}

if (isset($_REQUEST['fecha_ingreso'])){

$fechaInit = date("Y-m-d", strtotime($_POST['fecha_ingreso']));
$fechaFin  = date("Y-m-d", strtotime($_POST['fechaFin']));

//sentencia que mostrara los registros de la produccion en el rango de fechas establecido
$sqlProduccion = ("SELECT *,
            (SELECT nombre FROM productos
            WHERE productos.id_productos=ventas.nombre_producto limit 1)as producto,
            (SELECT nombre FROM clientes
            WHERE clientes.id_cliente=ventas.nombre_cliente limit 1)as Ncliente 
            FROM ventas WHERE `fecha` BETWEEN '$fechaInit 00:00:00' AND '$fechaFin 23:59:59' ORDER BY fecha ASC");
$query = mysqli_query($con, $sqlProduccion);

//Muestra el total de regisros
$total = mysqli_num_rows($query);
echo '<div class="mensaje-container mostrar-total">';
echo '<h3 class="total">Total: ('. $total .')</h3>';

//Sino se encuentra muestra el h1
if($total < 1){
    echo '<h1 class="total">¡No se encontró ningún registro!</h1>';
}

echo '</div>';

?>

<table class="table table-striped table-hover table-bordered mostrar-table" id="tabla_busqueda">
    <thead id="thead">
        <tr>    
            <th scope="col">Número</th>
            <th scope="col">Código</th>
            <th scope="col">Nombre Cliente</th>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Total</th>
            <th scope="col">Fecha</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    while ($dataRow = mysqli_fetch_array($query)) {
        $rowClass = ($i % 2 == 0) ? 'even' : 'odd';
    ?>
        <tr class="<?php echo $rowClass; ?>">
            <td><?php echo $dataRow['id_ventas']?></td>
            <td><?php echo $dataRow['codigo_venta']?></td>
            <td><?php echo $dataRow['Ncliente']?></td>
            <td><?php echo $dataRow['producto']?></td>
            <td><?php echo $dataRow['cantidad']?></td>
            <td><?php echo $dataRow['total']?></td>
            <td><?php echo date('d-m-Y', strtotime($dataRow['fecha'])); ?></td>
        </tr>
    <?php
        $i++;
    }
    }?>
    </tbody>
</table>

<script>
    // Espera 2 segundos antes de mostrar la tabla
    setTimeout(function () {
        document.getElementById('tabla_busqueda').classList.remove('mostrar-table');
        document.querySelector('.mensaje-container').classList.remove('mostrar-total');
    }, 1100);
</script>






