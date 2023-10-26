<?php 
    include("../templates/header.php");
    include('../conexion.php');

    $id=$_REQUEST['id_produccion'];
    $sel=$con -> query("SELECT * FROM produccion WHERE id_produccion=".$id);

    if($fila = $sel->fetch_assoc()){
        $fecha = $fila['fecha'];
    }
?>

<section class="d-flex justify-content-center align-items-center">
        <div class="card shadow col-xs-12 col-sm-6 col-md-6 col-lg-4   p-4"> 
            <div class="mb-4 d-flex justify-content-start align-items-center">
                <h4>  <i class="bi bi-chat-left-quote"></i> &nbsp; Ingrese la informacion</h4>
            </div>
            <div class="mb-1">
                <form action="update.php" method="POST">
                    <div class="mb-4 d-flex justify-content-between"></div>
                    <div class="mb-4">
                        <input type="hidden" class="form-control" name="id" value="<?php echo $fila['id_produccion']?>" required>
                        <div class="correo text-danger"></div>
                    </div>
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i>Número</label>
                        <input type="text" class="form-control" name="numero" value="<?php echo $fila['id_produccion'] ?>">
                        <div class="correo text-danger"></div>
                    </div>  
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Codigo</label>
                        <input type="text" class="form-control" name="codigo" value="<?php echo $fila['codigo_produccion'] ?>">
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-3 form-group">
                        <label for="producto" class="bi bi-envelope-fill">Producto:</label>
                        <select class="form-select" name="producto" id="producto">
                            <?php
                             $pro = $con->query("SELECT * FROM productos");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_productos'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="correo text-danger"></div>
                    </div> 
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i>Cantidad</label>
                        <input type="text" class="form-control" name="cantidad" value="<?php echo $fila['cantidad'] ?>">
                        <div class="correo text-danger"></div>
                    </div>
                    <div class="mb-4">
                        <label for="correo"><i class="bi bi-envelope-fill"></i> Fecha:</label>
                        <input type="text" class="form-control" name="fecha" value="<?php echo $fecha ?>">
                        <div class="correo text-danger"></div>
                    </div>
                    <div class="mb-2">
                        <button id ="botton" class="col-lg-12 btn btn-dark d-flex justify-content-between ">
                            <span>Modificar</span><i id="btn" class="bi bi-cursor-fill "></i>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </button>
                    </div> 
                </form>
            </div>
        </div>
    </section>