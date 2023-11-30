<?php
include("../templates/header.php");
include('../conexion.php');

if(isset($_GET['txtID'])){ //Si se paso id como parámetro get
    $id = $_GET['txtID'];

    $ins = $con->query("SELECT COUNT(*) as TotalRe FROM produccion WHERE nombre_producto = '$id'");
    $resulIns = $ins->fetch_assoc();
    $productos_asociados = $resulIns['TotalRe'];

    if ($productos_asociados > 0) {
        // Cuando el producto esta asociado muestra la alerta
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "No se puede eliminar",
                text: "El producto está asociado a una producción",
                showConfirmButton: false,
                timer: 2000
             }).then(function() {
                window.location.href = "index.php";
             });
            </script>';

        exit();

    }else{
    $query = $con->query("SELECT foto FROM productos WHERE id_productos = '$id'");
    $resultado = $query->fetch_assoc();
    $nombre_imagen_actual = $resultado['foto'];

    // elimina la imagen de la carpeta
    if (!empty($nombre_imagen_actual)) {
        $ruta_imagen_actual = "Img/" . $nombre_imagen_actual;
        if (file_exists($ruta_imagen_actual)) {
            unlink($ruta_imagen_actual);
        }
    }

    // eliminar el registro de productos
    $del = $con->query("DELETE FROM productos WHERE id_productos=".$id);

    if($del) {//Modal de exito al eliminar
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
    } else {
        echo "Error al eliminar el registro: " . $con->error;
    }
    }



}
?>

<title>Productos</title>
<link rel="stylesheet" href="../Css/estilosProduccion.css">
<link rel="stylesheet" href="../Css/estilosProductos.css">
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $("#tabla_id").DataTable({
      "dom": '<"top"flBri>t<"bottom"ip>',
        "pageLength": 3,
        lengthMenu:[//como se va a mostrar el paginado 
    [3,10,25,50],
    [3,10,25,50]
  ],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        }
    });
});
</script>

<div class="alert alert-info">
    <h4><strong>Productos</strong></h4>
</div>

<!--Div que contendra la tabla -->
<div class="card" id="tabla_produccion">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="" role="button" data-bs-toggle="modal" data-bs-target="#RegistroModal" data-bs-whatever="@mdo">
    <img src="../img/icons/add.svg" alt="Logo" style="width:30px;">
        Agregar Producto
    </a>
    </div>
    <div class="card-body">

    <div class="table-responsive-sm">
        <!--Tabla productos -->
        <table class="table table-striped table-hover table-bordered" id="tabla_id">
            <thead>
                <tr>
                    <th scope="col" class="table-dark">Número</th>
                    <th scope="col" class="table-dark">Foto</th>
                    <th scope="col" class="table-dark">Nombre</th>
                    <th scope="col" class="table-dark">Precio</th>
                    <th scope="col" class="table-dark">Acciones</th>
            </thead>
            <tbody>

            <?php 
            $sel = $con->query("SELECT * FROM productos");
            while ($fila = $sel->fetch_assoc()) {
            ?>

                <tr class="">
                <td><?php echo $fila['id_productos']?></td>
                <td><img src="Img/<?php  echo $fila['foto']?>" alt="imagen" class="imagen-producto img-fluid rounded" style="width: 80px; height: 100px;"></td>
                <td><?php echo $fila['nombre']?></td>
                <td><?php echo $fila['precio']?></td>
                <td>
                    <button type="button" class="btn btn-warning editbtn" data-toggle="modal" data-target="#editar">
                        <img src="../img/icons/pencil2.svg" alt="Imagen de actualización" width="23" height="25">
                    </button>
                    | <a class="btn btn-danger" href="javascript:borrar(<?php echo $fila['id_productos'];?>);" role="button">
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


<!--Modal Editar Registro -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h1>
                <button type="button" class="btn-close btn-secondary" data-bs-dismiss="modal" onclick="closeModalAndRedirect(event)"></button>
            </div>
            <div class="modal-body">
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="update_id">
                    <div class="mb-3">
                    <label for="numero" class="col-form-label">Número:</label>
                        <input type="number" readonly name="id_productos" id="id_productos" class="form-control" required>
                        <img class="input-icon" id="icon1" src="../img/Icons/hashtag.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="col-form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                        <img class="input-icon" id="icon2" src="../img/Icons/selarepa.svg" alt=""> 
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="col-form-label">Imagen:</label>
                        <img id="imagen_previa" style="width: 120px; height: 120px;" class="img-preview img-fluid rounded" alt="Imagen previa">
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="col-form-label">Nueva Imagen:</label>
                        <input type="file" class="form-control" name="imagen">
                        <img class="input-icon" id="icon3" src="../img/Icons/photo.svg" alt=""> 
                        <div class="imagen text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="col-form-label">Precio:</label>
                        <img class="icon2" id="icon4" src="../img/Icons/money.svg" alt="">
                        <input type="number" id="precio" name="precio" class="form-control" required>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="guardar.php" enctype="multipart/form-data">
          <div class="mb-3">
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el Nombre" required>
            <img class="input-icon" id="img1" src="../img/Icons/selarepa.svg" alt="">
          </div>
          <div class="mb-3">
            <label for="cantidad"><i class="bi bi-envelope-fill"></i> Foto:</label>
            <input type="file" class="form-control" style="" name="imagen" id="imagen" required>
            <img class="input-icon" id="img2" src="../img/Icons/photo.svg" alt="">
            <div class="text-danger"></div>
          </div> 
          <div class="mb-3">
            <input type="number" class="form-control" id="precio" name="precio" placeholder="Ingrese el Precio" required>
            <img class="input-icon" id="img3" src="../img/Icons/money.svg" alt="">
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
        // Obtener la URL de la imagen directamente desde la etiqueta img
        var imagenURL = $tr.find("img").attr('src');

        // Log de la URL de la imagen
        console.log(imagenURL);

        $('#update_id').val(datos[0]);
        $('#id_productos').val(datos[0]);
        $('#imagen_previa').attr('src', imagenURL);
        $('#nombre').val(datos[2]);
        $('#precio').val(datos[3]);
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






