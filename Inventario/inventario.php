<?php
    include('conexion.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <table class="table align-middle">
        <thead>
            <tr>
                <th class="text-center" scope="col">Id</th>
                <th class="text-center" scope="col">Ingrediente</th>
                <th class="text-center" scope="col">Cantidad</th>
                <th class="text-center" scope="col">Unidad Medida</th>
                <th class="text-center" scope="col">Cantidad minima</th>
                <th class="text-center" scope="col">Proveedor</th>
                <th class="text-center" scope="col">Editar</th>
                <th class="text-center" scope="col">Borrar</th>
            </tr>
            <?php
            $sel = $con->query("SELECT * FROM inventario i INNER JOIN tbl_unidad_medida u 
                                ON i.unidad_medida = u.id");
            // $sel2 = $con->query("SELECT * FROM inventario i INNER JOIN proveedor p 
            //                     ON i.proveedor = p.id");
            $sel2 = $con->query("SELECT * FROM proveedor");
            while($fila=$sel->fetch_assoc()){
                while($fila2=$sel2->fetch_assoc()){
            ?>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"><?php  echo $fila['id']?></td>
                <td class="text-center"><?php  echo $fila['nombre_ingrediente']?></td>
                <td class="text-center"><?php  echo $fila['cantidad']?></td>
                <!-- se debe hacer inner join -->
                <td class="text-center"><?php  echo $fila['nombre']?></td>
                <!--  -->
                <td class="text-center"><?php  echo $fila['cantidad_minima']?></td>
                <!-- se debe hacer inner join -->
                <td class="text-center"><?php  echo $fila2['nombre']?></td>
                <!--  -->
                <td class="text-center"><a href="actualizar.php?id=<?php echo $fila['id'];?>" class="btn btn-warning">Actualizar</a></td>
                <td class="text-center"><a href="borrar.php?id=<?php echo $fila['id'];?>" class="btn btn-danger">Borrar</a></td>
            </tr>
            <?php
                }}
            ?>
        </tbody>
    </table>
</body>
</html>