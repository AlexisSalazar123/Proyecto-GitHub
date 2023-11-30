<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar Reporte Excel</title>
    <style>
    .color{
        background-color: #9BB;  
    }
</style>
</head>
<body>
    
<?php
include('../conexion.php');
$fecha = date("d-m-Y");


/*Forzar la descarga excel */
header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
$filename = "ReporteProduccionExcel_" .$fecha. ".xls";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");


/*Se recibe el rango de fecha*/
$fechaInit = date("Y-m-d", strtotime($_POST['fecha_ingreso']));
$fechaFin  = date("Y-m-d", strtotime($_POST['fechaFin']));

//Consulta que trae todos los registros de la produccion en el rango establecido
$sqlProduccion = ("SELECT *,
            (SELECT nombre FROM productos
            WHERE productos.id_productos=produccion.nombre_producto limit 1)as producto 
            FROM produccion WHERE `fecha` BETWEEN '$fechaInit 00:00:00' AND '$fechaFin 23:59:59' ORDER BY fecha ASC");
$query = mysqli_query($con, $sqlProduccion);

?>


<table style="text-align: center;" border='1' cellpadding=1 cellspacing=1>
<thead>
    <tr style="background: #D0CDCD;">
    <th class="color">NÚMERO</th>
    <th class="color">CÓDIGO</th>
    <th class="color">PRODUCTO</th>
    <th class="color">CANTIDAD</th>
    <th class="color">FECHA</th>
    </tr>
</thead>
<?php
    while ($dataRow = mysqli_fetch_array($query)) { ?>
    <tbody>
        <tr>
            <td><?php echo $dataRow['id_produccion']?></td>
            <td><?php echo $dataRow['codigo_produccion']?></td>
            <td><?php echo $dataRow['producto']?></td>
            <td><?php echo $dataRow['cantidad']?></td>
            <td><?php echo date('m-d-Y', strtotime($dataRow['fecha'])); ?></td>
        </tr>
    </tbody>
    
<?php } ?>
</table>

</body>
</html>