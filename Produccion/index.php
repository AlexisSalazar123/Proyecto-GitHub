<?php
include('../conexion.php');
include("../templates/header.php");

if(isset($_GET['txtID'])){ //si se paso id como parámetro get
    $id = $_GET['txtID'];

    $sel = $con->query("DELETE FROM produccion WHERE id_produccion='$id'");
    $mensaje="Registro eliminado";
    header("location:index.php?mensaje=".$mensaje);
}
?>

<link rel="stylesheet" href="../Css/estilosProduccion.css">

<div class="card" id="tabla_produccion">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="" role="button" data-bs-toggle="modal" data-bs-target="#RegistroModal" data-bs-whatever="@mdo">Agregar registro</a>
    </div>
    <div class="card-body">

    <div class="table-responsive-sm">
        <table class="table" id="tabla_id">
            <thead>
                <tr>
                <th scope="col">Número</th>
                    <th scope="col">Código</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php 
            $sel = $con->query("SELECT *,
            (SELECT nombre FROM productos
            WHERE productos.id_productos=produccion.nombre_producto limit 1)as producto
            FROM produccion");
            while ($fila = $sel->fetch_assoc()) {
            ?>

                <tr class="">
                <td><?php echo $fila['id_produccion']?></td>
                <td><?php echo $fila['codigo_produccion']?></td>
                <td><?php echo $fila['producto']?></td>
                <td><?php echo $fila['cantidad']?></td>
                <td><?php echo $fila['fecha']?></td>
                    <td>
                    <a href="actualizar.php?id_produccion=<?php echo $fila['id_produccion'];?>" class="btn btn-warning">Actualizar</a>
                    | <a class="btn btn-danger" href="javascript:borrar(<?php echo $fila['id_produccion'];?>);" role="button">Eliminar</a>                    </td>
                </tr>

            <?php } ?>
                
            </tbody>
        </table>
    </div>
    
        
    </div>

</div>

<?php
include('../conexion.php');


if (isset($_REQUEST['id_produccion'])) {
    $id = $_REQUEST['id_produccion'];
    $sel = $con->query("SELECT * FROM produccion WHERE id_produccion=". $id);
    
    if ($fila = $sel->fetch_assoc()) {
        $fecha = $fila['fecha'];
    }
}
else{
    echo "No dio";
}



?>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="update.php">
                    <div class="mb-3">
                        <label for="numero" class="col-form-label">Número</label>
                        <input type="number" name="numero" value="<?php echo $fila['id_produccion'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="codigo" class="col-form-label">Código</label>
                        <input type="number" name="codigo" value="<?php echo $fila['codigo_produccion'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="codigo" class="col-form-label">Producto</label>
                        <select class="form-select form-select-sm" name="producto" id="producto">
                            <?php
                             $pro = $con->query("SELECT * FROM productos");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_productos'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="col-form-label">Cantidad</label>
                        <input type="number" name="cantidad" value="<?php echo $fila['cantidad'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="col-form-label">Fecha</label>
                        <input type="text" name="fecha" value="<?php echo $fecha ?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <input type="submit" value="Agregar" class="btn btn-primary"></input>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Esto es html -->
<div class="modal fade" id="RegistroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Produccion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="crear.php">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Código</label>
            <input type="number" id="codigo" name="codigo">
          </div>
          <div class="mb-3">
                        <label for="codigo" class="col-form-label">Producto</label>
                        <select class="form-select form-select-sm" name="producto" id="producto">
                            <?php
                             $pro = $con->query("SELECT * FROM productos");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_productos'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Cantidad</label>
            <input type="number" id="cantidad" name="cantidad">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <input type="submit" value="Agregar" class="btn btn-primary"></input>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>