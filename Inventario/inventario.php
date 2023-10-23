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
    <div class="py-1"></div>
    <button type="button" class="btn-mio btn btn-warning ms-1 " data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar ingrediente</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="guardar.php" method="POST">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar ingrediente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-warning">Guardar</button>
            </div>
        </form>
    </div>
    </div>

    <div class="">
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
                $sel = $con->query("SELECT * FROM inventario i 
                                    INNER JOIN tbl_unidad_medida u ON i.unidad_medida = u.id_unidad
                                    INNER JOIN proveedor p ON i.proveedor = p.id_proveedor");
                while($fila=$sel->fetch_assoc()){
                    
                ?>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><?php  echo $fila['id']?></td>
                    <td class="text-center"><?php  echo $fila['nombre_ingrediente']?></td>
                    <td class="text-center"><?php  echo $fila['cantidad']?></td>
                    <td class="text-center"><?php  echo $fila['nombre']?></td>
                    <td class="text-center"><?php  echo $fila['cantidad_minima']?></td>
                    <td class="text-center"><?php  echo $fila['nombre_proveedor']?></td>
                    <td class="text-center"><a href="actualizar.php?id=<?php echo $fila['id'];?>" class="btn btn-warning">Actualizar</a></td>
                    <td class="text-center"><a href="borrar.php?id=<?php echo $fila['id'];?>" class="btn btn-danger">Borrar</a></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>