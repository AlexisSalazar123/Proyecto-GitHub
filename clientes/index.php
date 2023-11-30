<?php
include('../conexion.php');
include("../templates/header.php");

if(isset($_GET['txtID'])){ //Si se paso id como parámetro get
    $id = $_GET['txtID'];

    $ins = $con->query("SELECT COUNT(*) as TotalRe FROM ventas WHERE nombre_cliente = '$id'");
    $resulIns = $ins->fetch_assoc();
    $clientes_asociados = $resulIns['TotalRe'];

    if ($clientes_asociados > 0) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "No se puede eliminar",
                text: "El cliente está asociado a una venta",
                showConfirmButton: false,
                timer: 2000
             }).then(function() {
                window.location.href = "index.php";
             });
            </script>';

        exit();

    }

    //Se elimina el registro de clientes
    $sel = $con->query("DELETE FROM clientes WHERE id_cliente='$id'");
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

<title>Clientes</title>
<link rel="stylesheet" href="../Css/estilosProduccion.css">
<link rel="stylesheet" href="../Css/estilosClientes.css">
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

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
    <h4><strong>Clientes</strong></h4>
</div>

<!--Div que contendra la tabla -->
<div class="card" id="tabla_produccion">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="" role="button" data-bs-toggle="modal" data-bs-target="#RegistroModal" data-bs-whatever="@mdo">
    <img src="../img/icons/add.svg" alt="Logo" style="width:30px;">
        Agregar Cliente
    </a>
    </div>
    <div class="card-body">

    <div class="table-responsive-sm">
        <!--Tabla clientes -->
        <table class="table table-striped table-hover table-bordered" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col" class="table-dark">Número</th>
                    <th scope="col" class="table-dark">Nombre</th>
                    <th scope="col" class="table-dark">Correo</th>
                    <th scope="col" class="table-dark">Telefono</th>
                    <th scope="col" class="table-dark">Dirección</th>
                    <th scope="col" class="table-dark">Acciones</th>
                    
            </thead>
            <tbody>

            <?php 
            $sel = $con->query("SELECT * FROM clientes");
            while ($fila = $sel->fetch_assoc()) {
            ?>

  
                <tr class="">
                <td><?php echo $fila['id_cliente']?></td >
                <td><?php echo $fila['nombre']?></td>
                <td><?php echo $fila['correo']?></td>
                <td><?php echo $fila['telefono']?></td>
                <td><?php echo $fila['direccion']?></td>
                <td>
                    <button type="button" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar">
                        <img src="../img/icons/pencil2.svg" alt="Imagen de actualización" width="23" height="25">
                    </button>
                    | <a class="btn btn-danger" href="javascript:borrar(<?php echo $fila['id_cliente'];?>);" role="button">
                        <img src="../img/icons/delete.svg" alt="Imagen de eliminar" width="23" height="25">
                    </a>                   
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h1>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" onclick="closeModalAndRedirect(event)"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="id_cliente" id="update_id">
                        <input type="hidden" name="idCliente" id="idCliente" class="form-control" required readonly>
                    <div class="mb-3">
                    <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                        <img class="input-icon" id="icons01" src="../img/Icons/user2.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="col-form-label">Correo:</label>
                        <input type="email" id="correo" name="correo" class="form-control" required>
                        <img class="input-icon" id="icons02" src="../img/icons/email.svg" alt=""> 
                    </div>
                  
                    <div class="mb-3">
                        <label for="telefono" class="col-form-label">Teléfono:</label>
                        <input type="number" id="telefono" name="telefono" class="form-control" required>
                        <img class="input-icon" id="icons03" src="../img/icons/telefono.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="col-form-label">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" required>
                        <img class="input-icon" id="icons04" src="../img/icons/direction.svg" alt=""> 
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

<!--Modal Agregar clientes -->
<div class="modal fade" id="RegistroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="crear.php">
          <div class="mb-3">
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre" required>
            <img class="input-icon" id="icon1" src="../img/Icons/user2.svg" alt="">
          </div>
          <div class="mb-3">
            <input type="email" id="correo" name="correo" class="form-control" placeholder="Ingrese el correo" required>
            <img class="input-icon" id="icon2" src="../img/icons/email.svg" alt="">
          </div>
          <div class="mb-3">
            <input type="number" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el teléfono" required>
            <img class="input-icon" id="icon3" src="../img/icons/telefono.svg" alt="">
          </div>
          <div class="mb-3">
            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingrese la dirección" required>
            <img class="input-icon" id="icon4" src="../img/icons/direction.svg" alt="">
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
        $('#idCliente').val(datos[0]);
        $('#nombre').val(datos[1]);
        $('#correo').val(datos[2]);

        $('#telefono').val(datos[3]);
        $('#direccion').val(datos[4]);
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









