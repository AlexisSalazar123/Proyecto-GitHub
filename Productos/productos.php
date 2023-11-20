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
    <button type="button" class="btn-mio btn btn-primary ms-1 " data-bs-toggle="modal" data-bs-target="#modal">Agregar producto</button>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="">Agregar producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="guardar.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="ingrediente"><i class="bi bi-envelope-fill"></i> Nombre:</label>
                        <input type="text" class="form-control" name="nombre">
                        <div class="text-danger"></div>
                    </div> 
                    <div class="mb-4">
                        <label for="cantidad"><i class="bi bi-envelope-fill"></i> Foto:</label>
                        <input type="file" class="form-control" name="imagen">
                        <div class="text-danger"></div>
                    </div> 
                    <div class="mb-4">
                        <label for="cantidadMinima"><i class="bi bi-envelope-fill"></i> Precio:</label>
                        <input type="text" class="form-control" name="precio">
                        <div class="text-danger"></div>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div class="">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="text-center" scope="col">Nombre</th>
                    <th class="text-center" scope="col">Foto</th>
                    <th class="text-center" scope="col">Precio</th>
                    <th class="text-center" scope="col">Acciones</th>
                </tr>
                <?php
                $sel = $con->query("SELECT * FROM productos");
                while($fila=$sel->fetch_assoc()){
                    
                ?>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><?php  echo $fila['nombre']?></td>
                    <td class="text-center"><img src="Img/<?php  echo $fila['foto']?>" alt="imagen" class="imagen-producto"></td>
                    <td class="text-center"><?php  echo $fila['precio']?></td>
                    <td class="text-center">
                        <a href="actualizar.php?id_productos=<?php echo $fila['id_productos'];?>" class="btn btn-warning"><img src="edit-alt-regular-24 (1).png" alt="editar">Editar</a>
                        <a href="borrar.php?id_productos=<?php echo $fila['id_productos'];?>" class="btn btn-danger"><img  class="" src="x-regular-24.png" alt="borrar">Borrar</a>
                    </td>
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