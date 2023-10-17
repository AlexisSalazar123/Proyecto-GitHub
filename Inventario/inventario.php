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
                <th class="text-center" scope="col">Producto</th>
                <th class="text-center" scope="col">Stock</th>
                <th class="text-center" scope="col">Precio</th>
                <th class="text-center" scope="col">Editar</th>
                <th class="text-center" scope="col">Borrar</th>
            </tr>
            <?php
            $sel = $con->query("SELECT * FROM inventario");
            while($fila=$sel->fetch_assoc()){
            ?>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"><?php  echo $fila['id']?></td>
                <td class="text-center"><?php  echo $fila['producto']?></td>
                <td class="text-center"><?php  echo $fila['stock']?></td>
                <td class="text-center"><?php  echo $fila['precio']?></td>
                <td class="text-center"><a href="actualizar.php?id=<?php echo $fila['id'];?>" class="btn btn-warning">Actualizar</a></td>
                <td class="text-center"><a href="borrar.php?id=<?php echo $fila['id'];?>" class="btn btn-danger">Borrar</a></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</body>
</html>