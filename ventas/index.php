<?php
include('../conexion.php');
include("../templates/header.php");


if(isset($_GET['txtID'])){ //Si se paso id como parámetro get
    $id = $_GET['txtID'];

    $sel = $con->query("DELETE FROM ventas WHERE id_ventas='$id'");
    if($sel) {//Modal de exito al eliminar
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Registro eliminado",
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "index.php";
            });
        </script>';
    }

}

?>

<title>Ventas</title>
<link rel="stylesheet" href="../Css/estilosProduccion.css">
<link rel="stylesheet" href="../Css/estilosVentas.css">

<script src="../produccion/js/popper.min.js"></script>
<script src="../produccion/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $("#tabla_id").DataTable({
      "dom": '<"top"flBri>t<"bottom"ip>',
        "pageLength": 7,
        lengthMenu:[//como se va a mostrar el paginado 
    [3,10,25,50,100],
    [3,10,25,50,100]
  ],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });
});
</script>

<div class="alert alert-info">
    <h4><strong>Ventas</strong></h4>
</div>

<!--Div que contendra la tabla -->
<div class="card" id="tabla_produccion">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="" role="button" data-bs-toggle="modal" data-bs-target="#RegistroModal" data-bs-whatever="@mdo">
    <img src="../img/icons/add.svg" alt="Logo" style="width:30px;">
        Agregar Venta
    </a>
    <a name="" id="buttonBusqueda" class="btn btn-secondary" href="busqueda.php">
        Busqueda por fecha
      <img src="../img/icons/calendar.svg" alt="Logo" style="width:25px;">
    </a>
    </div>
    <div class="card-body">

    <div class="table-responsive-sm">
        <!--Tabla ventas -->
        <table class="table table-striped table-hover table-bordered" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col" class="table-dark">Número</th>
                    <th scope="col" class="table-dark">Código</th>
                    <th scope="col" class="table-dark">Nombre Cliente</th>
                    <th scope="col" class="table-dark">Producto</th>
                    <th scope="col" class="table-dark">Cantidad</th>
                    <th scope="col" class="table-dark">Fecha</th>
                    <th scope="col" class="table-dark">Editar | Eliminar | Ticket </th>
            </thead>
            <tbody>

            <?php 
            $sel = $con->query("SELECT *,
            (SELECT nombre FROM clientes
            WHERE id_cliente=nombre_cliente)as Ncliente,
            (SELECT nombre FROM productos
            WHERE id_productos=nombre_producto)as Nproducto
            FROM ventas");
            while ($fila = $sel->fetch_assoc()) {
            ?>

                <tr class="">
                <td><?php echo $fila['id_ventas']?></td>
                <td><?php echo $fila['codigo_venta']?></td>
                <td><?php echo $fila['Ncliente']?></td>
                <td><?php echo $fila['Nproducto']?></td>
                <td><?php echo $fila['cantidad']?></td>
                <td><?php echo $fila['fecha']?></td>
                <td>
                    
                    <button type="button" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar">
                     <img src="../img/icons/pencil2.svg" alt="Imagen de actualización" width="23" height="25">
                    </button>
                    
                    -
                    
                    <a class="btn btn-danger" href="javascript:borrar(<?php echo $fila['id_ventas'];?>);" role="button">
                        <img src="../img/icons/delete.svg" alt="Imagen de eliminar" width="23" height="25">
                    </a> 

                    -
                    <a style="height: 30px;" href="RECEIPT-main/ticket.php?id=<?php echo $fila['id_ventas'] ?>" >
                    <button type="button" class="btn btn-success">
                            <img src="../img/icons/ticket.svg" alt="Imagen de ticket" width="23" height="25">
                    </button>
                    </a>
                    
                </td>
                </tr>

            <?php } ?>
                
            </tbody>
        </table>
    </div>
    
        
    </div>

</div>

<script>
    document.getElementById("redirectButton").addEventListener("click", function() {
       window.location.href = "busqueda.php";
  });
</script> 

<script>
    document.getElementById("buttonBusqueda").addEventListener("click", function() {
        // Elimina cualquier valor existente en localStorage al hacer click en el botón
        localStorage.clear();
    });
</script>

<?php
include('../conexion.php');


if (isset($_REQUEST['id_ventas'])) {
    $id = $_REQUEST['id_ventas'];
    $sel = $con->query("SELECT * FROM ventas WHERE id_ventas=". $id);
    
    if ($fila = $sel->fetch_assoc()) {
        $fecha = $fila['fecha'];
    }
}
else{
    echo "No dio";
}



?>

<!--Modal Editar Registro -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalLabel">Editar Venta</h1>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" onclick="closeModalAndRedirect(event)"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                    <label for="numero" class="col-form-label">Número:</label>
                        <input type="number" readonly name="numero" id="numero" class="form-control" required>
                        <img class="input-icon" id="icons1" src="../img/Icons/hashtag.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="col-form-label">Código:</label>
                        <input type="number" id="codigo" name="codigo" class="form-control" required>
                        <img class="input-icon" id="icons2" src="../img/Icons/code.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                    <label for="numero" class="col-form-label">Cliente:</label>
                        <img class="input-icon" id="icons3" src="../img/Icons/customerM.svg" alt=""> 
                        <select class="form-select form-select-sm" name="cliente" id="cliente" required>
                        <option value="" disabled selected>Seleccione un cliente</option>
                            <?php
                             $pro = $con->query("SELECT * FROM clientes");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_cliente'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                    <label for="numero" class="col-form-label">Producto:</label>
                        <img class="icon3" id="icons4" src="../img/Icons/selarepa.svg" alt="">
                        <select class="form-select form-select-sm" name="producto2" id="producto2" required>
                        <option value="" disabled selected>Seleccione un Producto</option>
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
                        <label for="numero" class="col-form-label">Cantidad:</label>
                        <img class="icon2" id="icons5" src="../img/Icons/amount.svg" alt="">
                        <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="col-form-label">Fecha:</label>
                        <img class="icon2" id="icons6" src="../img/Icons/calendar2.svg" alt="">
                        <input type="text" id="fecha" name="fecha" class="form-control" required>
                    </div class="mb-3">
                      <label for="numero" class="col-form-label">Forma de Pago</label>
                      <img class="icon2" id="icons7" src="../img/Icons/card.svg" alt="">
                        <select class="form-select form-select-sm" name="pago" id="pago" required>
                        <option value="" disabled selected>Seleccione una forma de Pago</option>
                            <?php
                             $pro = $con->query("SELECT * FROM forma_pago");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_forma_pago'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"   onclick="closeModalAndRedirect(event)">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Agregar Venta -->
<div class="modal fade" id="RegistroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Venta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="crear.php">
          <div class="mb-3">
            <input type="number" id="codigo" name="codigo" class="form-control" placeholder="Ingrese el código venta" required>
            <img class="input-icon" id="icon1" src="../img/Icons/code.svg" alt="">
          </div>
          <div class="mb-3">
          <img class="icon2" id="icon2" src="../img/Icons/customerM.svg" alt="">
                        <select class="form-select form-select-sm" name="cliente" id="cliente" required>
                        <option value="" disabled selected>Seleccione un cliente</option>
                            <?php
                             $pro = $con->query("SELECT * FROM clientes");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_cliente'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

            <div class="mb-3">
               <img class="icon3" id="icon3" src="../img/Icons/selarepa.svg" alt="">
                        <select class="form-select form-select-sm" name="producto" id="producto" required>
                        <option value="" disabled selected>Seleccione un Producto</option>
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
            <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad de arepas" required>
            <img class="icon2" id="icon4" src="../img/Icons/amount.svg" alt="">
          </div>
          <div class="mb-3">
          <img class="icon2" id="icon5" src="../img/Icons/card.svg" alt="">
                        <select class="form-select form-select-sm" name="pago" id="pago" required>
                        <option value="" disabled selected>Seleccione una forma de Pago</option>
                            <?php
                             $pro = $con->query("SELECT * FROM forma_pago");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option value="<?php echo $registro['id_forma_pago'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <input type="submit" value="Agregar" class="btn btn-success"></input>
          </div>
        </form>
      </div>
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
        $('#codigo').val(datos[1]);

        $('#cantidad').val(datos[4]);
        $('#fecha').val(datos[5]);
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