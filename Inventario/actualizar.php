<?php 
    include('conexion.php');

    $id= $_REQUEST['id'];
    $sel=$con -> query("SELECT * FROM inventario WHERE id=".$id);

    if($fila = $sel->fetch_assoc()){
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <br>
    <section class="d-flex justify-content-center align-items-center">
        <div class="card shadow col-xs-12 col-sm-6 col-md-6 col-lg-4   p-4"> 
            <div class="mb-4 d-flex justify-content-start align-items-center">
                <h4>  <i class="bi bi-chat-left-quote"></i> &nbsp; Ingrese la informacion</h4>
            </div>
            <div class="mb-1">
                <form action="update.php" method="POST">
                    <div class="mb-4 d-flex justify-content-between"></div>
                    <div class="mb-4">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $fila['id']?>" required>
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Ingrediente:</label>
                        <input type="text" class="form-control" name="nombre_ingrediente" value="<?php echo $fila['nombre_ingrediente'] ?>">
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Cantidad:</label>
                        <input type="text" class="form-control" name="cantidad" value="<?php echo $fila['cantidad'] ?>">
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-4 form-group">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Unidad Medida:</label>
                        <select class="form-control" name="unidad_medida">
                            <?php 
                            $sel2 = $con2->query("SELECT * FROM tbl_unidad_medida");
                            while($fila2=$sel2->fetch_assoc()){
                            ?>
                            <option value="<?php echo $fila2["id_unidad"]; ?>"><?php echo $fila2["nombre"]; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Cantidad Minima:</label>
                        <input type="text" class="form-control" name="cantidad_minima" value="<?php echo $fila['cantidad_minima'] ?>">
                        <div class="correo text-danger"></div>
                    </div>
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Proveedor:</label>
                        <input type="text" class="form-control" name="proveedor" value="<?php echo $fila['proveedor'] ?>">
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-2">
                        <button id ="botton" class="col-lg-12 btn btn-dark d-flex justify-content-between ">
                            <span>Modificar</span><i id="btn" class="bi bi-cursor-fill "></i>
                        </button>
                    </div> 
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>