<?php
include('../conexion.php');
include("../templates/header.php");

?>
<title>Inventario</title>
<link rel="stylesheet" href="../Css/estilosProduccion.css">
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $("#tabla_id").DataTable({
      "dom": '<"top"flBri>t<"bottom"ip>',
        "pageLength": 8,
        lengthMenu:[//como se va a mostrar el paginado
    [8]
  ],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });
});
</script>

<div class="alert alert-info">
    <h4><strong>Inventario</strong></h4>
</div>
<!--Div que contendra la tabla -->
<div class="card" id="tabla_produccion">
    <div class="card-body">

    <div class="table-responsive-sm">
        <!--Tabla inventario -->
        <table class="table table-striped table-hover table-bordered" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col" class="table-dark">Número</th>
                    <th scope="col" class="table-dark">Nombre</th>
                    <th scope="col" class="table-dark">Cantidad</th>
                    <th scope="col" class="table-dark">Unidad Medida</th>
                    <th scope="col" class="table-dark">Cantidad mínima</th>
                    <th scope="col" class="table-dark">Proveedor</th>
                    <th scope="col" class="table-dark">Acciones</th>
            </thead>
            <tbody>

            <?php 
            $sel = $con->query("SELECT *,
            (SELECT nombre FROM tbl_unidad_medida
            WHERE inventario.unidad_medida=tbl_unidad_medida.id_unidad_medida limit 1)as Umedida,
            (SELECT nombre FROM proveedor
            WHERE inventario.nombre_proveedor=proveedor.id_proveedor limit 1)as Nproveedor
            FROM inventario");
            while ($fila = $sel->fetch_assoc()) {
            ?>

                <tr class="">
                <td><?php echo $fila['id_inventario']?></td>
                <td><?php echo $fila['nombre_ingrediente']?></td>
                <td><?php echo $fila['cantidad']?></td>
                <td><?php echo $fila['Umedida']?></td>
                <td><?php echo $fila['cantidad_minima']?></td>
                <td><?php echo $fila['Nproveedor']?></td>
                <td>
                    <button type="button" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar">
                        <img src="../img/icons/pencil2.svg" alt="Imagen de actualización" width="23" height="25">
                    </button>                 
                </td>
                </tr>

            <?php } ?>
                
            </tbody>
        </table>
    </div>
    
        
    </div>

</div>

<?php
include('../conexion.php');

?>
<!--Modal Editar Registro -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalLabel">Editar inventario</h1>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" onclick="closeModalAndRedirect(event)"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" id="update_id">
                    <input type="hidden" name="numero" id="numero" class="form-control"> 
                    <div class="mb-3">
                    <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required readonly>
                        <img class="input-icon" id="icons1" src="../img/Icons/ingredient.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="col-form-label">Existencia:</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control" step="any" required>
                        <img class="input-icon" id="icons2" src="../img/Icons/amount.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="Umedida" class="col-form-label">Unidad Medida:</label>
                        <img class="input-icon" id="icons3" src="../img/Icons/measure.svg" alt=""> 
                        <select class="form-select form-select-sm" name="Umedida" id="Umedida" required>
                        <option value="" disabled selected>Seleccione una Unidad de Medida</option>
                            <?php
                             $pro = $con->query("SELECT * FROM tbl_unidad_medida");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_unidad_medida'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Cminima" class="col-form-label">Cantidad Minima:</label>
                        <img class="icon2" id="icons4" src="../img/Icons/amount2.svg" alt="">
                        <input type="number" id="Cminima" name="Cminima" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="proveedor" class="col-form-label">Proveedor:</label>
                        <img class="input-icon" id="icons5" src="../img/Icons/delivering.svg" alt=""> 
                        <select class="form-select form-select-sm" name="proveedor" id="proveedor" required>
                        <option value="" disabled selected>Seleccione un proveedor</option>
                            <?php
                             $pro = $con->query("SELECT * FROM proveedor");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_proveedor'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"   onclick="closeModalAndRedirect(event)">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    //Valores que se mostrara en la tabla editar
    $('.editbtn').on('click', function(){
        $tr=$(this).closest('tr');
        var datos=$tr.children("td").map(function (){
            return $(this).text();
        });
        $('#update_id').val(datos[0]);
        $('#numero').val(datos[0]);
        $('#nombre').val(datos[1]);
        $('#cantidad').val(datos[2]);
        $('#Cminima').val(datos[4]);
    });
</script>

<script>
function closeModalAndRedirect() {
  // Cierra el modal
  var modal = new bootstrap.Modal(document.getElementById('editar'));
  modal.hide();

  // Redirige a index.php sin recargar la página
  window.location.replace('index.php');
}
</script>