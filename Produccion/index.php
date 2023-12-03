<?php
include('../conexion.php');
include("../templates/header.php");


if(isset($_GET['txtID'])){ //Si se paso id como parámetro get
    $id = $_GET['txtID'];
    $cantidad = $_POST['cantidad'];

    $sel = $con->query("SELECT cantidad FROM produccion WHERE id_produccion=". $id);
    $fila = $sel->fetch_assoc();

    $cantidad_anterior = $fila['cantidad'];
    //se calcula los ingredientes
    $cantidad_arepas = $cantidad_anterior * 5;
    $cantidad_harina = ($cantidad_arepas / 5) * 0.5;
    $cantidad_mozarella = ($cantidad_arepas / 5) * 0.25;
    $cantidad_fresco = ($cantidad_arepas / 5) * 0.150;
    $cantidad_azucar = ($cantidad_arepas / 5) * 0.02;
    $cantidad_sal = ($cantidad_arepas / 5) * 0.01;
    $cantidad_mantequilla = ($cantidad_arepas / 5) * 0.03;
    $cantidad_agua = ($cantidad_arepas / 5) * 0.35;
    $cantidad_leche = ($cantidad_arepas / 5) * 0.35;

     //Se devuelve la materia al inventario ya que se elimino el registro
    $ins_harina = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_harina WHERE nombre_ingrediente = 'Harina'");
    $ins_mozarrella = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_mozarella WHERE nombre_ingrediente = 'Queso mozarella'");
    $ins_fresco = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_fresco WHERE nombre_ingrediente = 'Queso fresco'");
    $ins_azucar = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_azucar WHERE nombre_ingrediente = 'Azucar'");
    $ins_sal = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_sal WHERE nombre_ingrediente = 'Sal'");
    $ins_mantequilla = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_mantequilla WHERE nombre_ingrediente = 'Mantequilla'");
    $ins_agua = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_agua WHERE nombre_ingrediente = 'Agua'");
    $ins_leche = $con->query("UPDATE inventario SET cantidad = cantidad + $cantidad_leche WHERE nombre_ingrediente = 'Leche'");

    //Se elimina el registro de la producción
    $sel = $con->query("DELETE FROM produccion WHERE id_produccion='$id'");
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

<title>Producción</title>
<link rel="stylesheet" href="../Css/estilosProduccion.css">
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $("#tabla_id").DataTable({
      "dom": '<"top"flBri>t<"bottom"ip>',
        "pageLength": 7,
        lengthMenu:[//como se va a mostrar el paginado o el numero de registros por datos
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
    <h4><strong>Producción</strong></h4>
</div>

<!--Div que contendra la tabla -->
<div class="card" id="tabla_produccion">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="" role="button" data-bs-toggle="modal" data-bs-target="#RegistroModal" data-bs-whatever="@mdo">
    <img src="../img/icons/add.svg" alt="Logo" style="width:30px;">
        Agregar Producción
    </a>
    <a name="" id="buttonGrafica" class="btn btn-warning" href="Grafica/index.php">
        Gráfica
      <img src="../img/icons/graphic2.svg" alt="Logo" style="width:25px;">
    </a>
    <a name="" id="buttonBusqueda" class="btn btn-secondary" href="busqueda.php">
        Busqueda por fecha
      <img src="../img/icons/calendar.svg" alt="Logo" style="width:25px;">
    </a>
    </div>
    <div class="card-body">

    <div class="table-responsive-sm">
        <!--Tabla producción -->
        <table class="table table-striped table-hover table-bordered" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col" class="table-dark">Número</th>
                    <th scope="col" class="table-dark">Código</th>
                    <th scope="col" class="table-dark">Producto</th>
                    <th scope="col" class="table-dark">Cantidad</th>
                    <th scope="col" class="table-dark">Fecha</th>
                    <th scope="col" class="table-dark">Acciones</th>
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
                    <button type="button" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar">
                        <img src="../img/icons/pencil2.svg" alt="Imagen de actualización" width="23" height="25">
                    </button>
                    | <a class="btn btn-danger" href="javascript:borrar(<?php echo $fila['id_produccion'];?>);" role="button">
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

<script>
document.getElementById("buttonGrafica").addEventListener("click", function() {
  // Mostrar el formulario al hacer clic en el botón
  document.getElementById("formularioGrafica").style.display = "block";
});

// Puedes agregar más lógica aquí para cerrar el formulario si es necesario
</script>

<script>
    document.getElementById("buttonBusqueda").addEventListener("click", function() {
        // Elimina cualquier valor existente en localStorage al hacer click en el botón
        localStorage.clear();
    });
</script>


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
<!--Modal Editar Registro -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producción</h1>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" onclick="closeModalAndRedirect(event)"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" id="update_id">
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
                        <label for="numero" class="col-form-label">Producto:</label>
                        <img class="input-icon" id="icons3" src="../img/Icons/selarepa.svg" alt=""> 
                        <select class="form-select form-select-sm" name="producto" id="producto" required>
                        <option value="" disabled selected>Seleccione un producto</option>
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
                        <img class="icon2" id="icons4" src="../img/Icons/amount.svg" alt="">
                        <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="col-form-label">Fecha:</label>
                        <img class="icon2" id="icons5" src="../img/Icons/calendar2.svg" alt="">
                        <input type="text" id="fecha" name="fecha" class="form-control" required>
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

<!--Modal Agregar Producción -->
<div class="modal fade" id="RegistroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producción</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="crear.php">
          <div class="mb-3">
            <input type="number" id="codigo" name="codigo" class="form-control" placeholder="Ingrese el Código" required>
            <img class="input-icon" id="icon1" src="../img/Icons/code.svg" alt="">
          </div>
          <div class="mb-3">
          <img class="icon2" id="icon2" src="../img/Icons/selarepa.svg" alt="">
                        <select class="form-select form-select-sm" name="producto" id="producto" required>
                        <option value="" disabled selected>Seleccione un producto</option>
                            <?php
                             $pro = $con->query("SELECT * FROM productos");
                             while ($registro = $pro->fetch_assoc()){
                            ?>
                                <option height="50px" value="<?php echo $registro['id_productos'] ?>">
                                   <?php echo $registro['nombre']?>
                                </option>
                            <?php } ?>
                            
                        </select>
                    </div>
          <div class="mb-3">
            <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad de arepas" required>
            <img class="icon3" src="../img/Icons/amount.svg" alt="">
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

        $('#cantidad').val(datos[3]);
        $('#fecha').val(datos[4]);
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









